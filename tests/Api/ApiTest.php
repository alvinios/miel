<?php

declare(strict_types=1);

use Alvinios\Miel\Fork\Append;
use Alvinios\Miel\Fork\Routes;
use Alvinios\Miel\Tests\Books\Book\Api;
use Alvinios\Miel\Tests\Books\Book\Book;
use Alvinios\Miel\Tests\Books\Book\InMemoryBooks;
use GuzzleHttp\Psr7\HttpFactory;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

/**
 * ./vendor/bin/phpunit --verbose tests.
 */
class ApiTest extends TestCase
{
    private $app;

    public function setUp(): void
    {
        $this->app = new Routes(
            new Append(
                (new Api(
                    new InMemoryBooks([
                        new Book(name: 'War and peace', author: 'Leon Tolstoi', id: '1'),
                        new Book(name: 'Tom Sawyer', author: 'Mark Twayne', id: '2'),
                        new Book(name: 'Le rouge et le noir', author: 'Stendhal', id: '3'),
                    ])
                ))()
            )
        );
    }

    /**
     * One of books name is present.
     *
     *  @group books
     */
    public function testGetBooksRequest(): void
    {
        $this->assertStringContainsString(
            'War and peace',
            $this->app->response(new ServerRequest('GET', '/api/books'), new HttpFactory())->getBody()->getContents()
        );
    }

    /**
     * Content-type header is as expected.
     */
    public function testGetResponseHasHeaderSet(): void
    {
        $this->assertContains(
            'application/json',
            $this->app->response(new ServerRequest('GET', '/api/books'), new HttpFactory())->getHeader('Content-type')
        );
    }

    /**
     * Posted book name is present in Response.
     */
    public function testPostBooksRequest(): void
    {
        $this->assertStringContainsString(
            'Odyssey',
            $this->app->response(
                new ServerRequest(
                    'POST',
                    '/api/books',
                    ['content-type' => 'application/json'],
                    '{"name":"The Odyssey","author":"Homer", "id" : "4"}'
                ),
                new HttpFactory()
            )->getBody()->getContents()
        );
    }

    public function testPostBooksFormRequest(): void
    {
        $data = ['name' => 'The Odyssey', 'author' => 'Homer', 'id' => '4'];

        $this->assertStringContainsString(
            'Odyssey',
            $this->app->response(
                (new ServerRequest(
                    'POST',
                    '/api/books',
                    ['content-type' => 'application/x-www-form-urlencoded'],
                    http_build_query($data, '', '&', PHP_QUERY_RFC3986)
                ))->withParsedBody($data),
                new HttpFactory()
            )->getBody()->getContents()
        );
    }

    /**
     * @group failing
     */
    public function testThirdBookAuthor(): void
    {
        $obj = json_decode(
            $this->app->response(new ServerRequest('GET', '/api/books/3'), new HttpFactory())->getBody()->getContents()
        );

        $this->assertSame('Stendhal', $obj->author);
    }
}
