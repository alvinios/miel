<?php

use Alvinios\Miel\Http\Emit;
use Alvinios\Miel\Tests\Books\Book\FilesystemBooks;
use Alvinios\Miel\Fork\Match\{Regex, QueryParam, Methods, Parsed};
use Alvinios\Miel\Tests\Books\Site;
use GuzzleHttp\Psr7\{HttpFactory, ServerRequest};
use Symfony\Component\ErrorHandler\Debug;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once dirname(__DIR__).'/../../../vendor/autoload.php';

Debug::enable();

(new Emit())(
    (new Site(
        new Environment(
            new FilesystemLoader(dirname(__DIR__).'/resources/templates'),
            []
        ),
        new FilesystemBooks('../resources/import/books.json')
    ))->response(ServerRequest::fromGlobals(), new HttpFactory(), new HttpFactory())
);
