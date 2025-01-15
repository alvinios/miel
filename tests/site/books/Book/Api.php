<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Books\Book;

use Alvinios\Miel\Endpoint\Base;
use Alvinios\Miel\Fork\ContentType;
use Alvinios\Miel\Fork\Methods;
use Alvinios\Miel\Fork\Regex;
use Alvinios\Miel\Request\WithRegex;
use Alvinios\Miel\Response\Json;
use Alvinios\Miel\Response\Response;
use Alvinios\Miel\Response\Text;
use Psr\Http\Message\ServerRequestInterface;

class Api
{
    public function __construct(
        private Books $books,
    ) {
    }

    /**
     * Books App.
     */
    public function __invoke(): \Iterator
    {
        yield new Regex(
            '/api/books',
            new Methods(['get'], new Json($this->books->books())),
            new Methods(['delete'], new Text('This endpoint does not do anything')),
            new Methods(
                ['post'],
                new ContentType(
                    'application/json',
                    new class($this->books) extends Base {
                        public function __construct(private Books $books)
                        {
                        }

                        public function act(ServerRequestInterface $request): Response
                        {
                            $book = Book::fromJson($request->getBody()->getContents());

                            return new Json($this->books->withBook($book)->lastBook());
                        }
                    }
                ),
                new ContentType(
                    'application/x-www-form-urlencoded',
                    new class($this->books) extends Base {
                        public function __construct(private Books $books)
                        {
                        }

                        public function act(ServerRequestInterface $request): Response
                        {
                            $book = Book::fromArray($request->getParsedBody());

                            return new Json($this->books->withBook($book)->lastBook());
                        }
                    }
                )
            )
        );
        yield new Regex(
            '/api/books/(?P<id>[\d]+)',
            new class($this->books) extends Base {
                public function __construct(private Books $books)
                {
                }

                public function act(ServerRequestInterface|WithRegex $request): Response
                {
                    return new Json($this->books->book($request->regex()->group('id')));
                }
            }
        );
    }
}
