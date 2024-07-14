<?php

use Alvinios\Miel\Http\Emit;
use Alvinios\Miel\Tests\Books\Book\FilesystemBooks;
use Alvinios\Miel\Endpoint\{Json, Text, Base, Endpoint};
use Alvinios\Miel\In\In;
use Alvinios\Miel\Fork\{Fork, Routes, Fork};
use Alvinios\Miel\Fork\Match\{Regex, QueryParam, Methods, Parsed};
use Alvinios\Miel\Tests\Books\App;
use GuzzleHttp\Psr7\{HttpFactory, ServerRequest};
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\ErrorHandler\Debug;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// The Logger instance

require_once dirname(__DIR__).'/../../../vendor/autoload.php';

Debug::enable();



(new Emit())(
    (new App(
        new Environment(
            new FilesystemLoader(dirname(__DIR__).'/resources/templates'),
            []
        ),
        new FilesystemBooks('../resources/import/books.json')
    ))->response(ServerRequest::fromGlobals(), new HttpFactory())
);
