<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Books\Book;

interface Books
{
    public function withBook(Book $book): Books;

    public function book(string $index): Book;

    public function lastBook(): Book;

    public function books(): array;
}
