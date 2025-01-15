<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Books\Book;

use Alvinios\Miel\Http\Exception\HttpException;

class FilesystemBooks implements Books
{
    public function __construct(
        private string $filename,
    ) {
    }

    public function withBook(Book $book): Books
    {
        $books = $this->books();
        $books[] = $book;

        $this->persistBooks($books);

        return $this;
    }

    public function book(string $id): Book
    {
        $found = array_values(array_filter(
            $this->books(),
            function (Book $book) use ($id) {
                return $book->hasId($id);
            }
        ));

        if (0 === count($found)) {
            throw new HttpException(sprintf('No book with id %s', $id));
        }

        /* @todo exception if not found */
        return $found[0];
    }

    public function lastBook(): Book
    {
        $books = $this->books();

        return end($books);
    }

    public function books(): array
    {
        return array_map(
            function (\stdClass $obj) {
                return Book::fromStdClass($obj);
            },
            json_decode(file_get_contents($this->filename))
        );
    }

    private function persistBooks(array $books)
    {
        file_put_contents($this->filename, json_encode($books));
    }
}
