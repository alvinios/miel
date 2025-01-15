<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Books\Book;

class Book implements \JsonSerializable
{
    public function __construct(
        private string $id,
        private string $name,
        private string $author,
    ) {
    }

    public static function fromJson(
        string $json,
    ): self {
        return self::fromStdClass(json_decode($json));
    }

    public static function fromStdClass(
        \stdClass $obj,
    ): self {
        return new self(id: $obj->id, name : $obj->name, author: $obj->author);
    }

    public static function fromArray(array $obj): self
    {
        return new self(id: $obj['id'], name : $obj['name'], author: $obj['author']);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'name' => $this->name,
        ];
    }

    public function hasId(string $id): bool
    {
        return $this->id === $id;
    }
}
