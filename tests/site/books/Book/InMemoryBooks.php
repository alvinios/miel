<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Books\Book;

use Alvinios\Miel\Http\HttpException;

class InMemoryBooks implements Books
{
    public function __construct(
        private array $books,
    ) {
    }

    public function withBook(Book $book): Books
    {
        $this->books[] = $book;

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
        return $this->books;
    }
}
