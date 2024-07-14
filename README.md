<a name="readme-top"></a>

<!-- ABOUT THE PROJECT -->
## About The Project
**Miel**  is an object-oriented PHP web development micro-framework (MIEL stands for Micro + Elegant, it also means "honey" in French). It' intend is to be designed based on _elegant objects_ principles of [Yegor Bugayenko](https://yegor256.com). It means :
* No mutable classes
* No `null`s
* No type-checking or reflexion
* No `public` `static` methods or `constants`
* No configuration files
* No DI container

It was inspired by the framework [Takes](https://github.com/yegor256/takes)
For being operational it requires [PSR-7](https://www.php-fig.org/psr/psr-7/) and [PSR-17](https://www.php-fig.org/psr/psr-17/) implementations/libraries of your choice. For example [Guzzle PSR-7](https://github.com/guzzle/psr7)



 <!-- GETTING STARTED -->
## Getting Started

```
composer require ..
```

## Quick Start

Create this `index.php` file:

```php

use Alvinios\Miel\Http\Emit;
use Alvinios\Miel\Response\Text;
use Alvinios\Miel\Fork\{Regex, Routes};
use GuzzleHttp\Psr7\{HttpFactory,ServerRequest};

(new Emit())(
    (new Routes(
        new Regex('/', new Text('Hello world!'))
    ))->response(ServerRequest::fromGlobals(), new HttpFactory())
);
```
Cd to your index.php folder and run php local server
```
php -S localhost:8000
```


## A Bigger Example

```php
use Alvinios\Miel\Http\Emit;
use Alvinios\Miel\Endpoint\Base;
use Alvinios\Miel\Request\WithRegex;
use Alvinios\Miel\Response\{Json, Response, Text, Twig}; 
use Alvinios\Miel\Fork\{Routes, Regex, Methods};
use GuzzleHttp\Psr7\{HttpFactory, ServerRequest};
use Psr\Http\Message\ServerRequestInterface;

(new Emit())(
  (new Routes(
        new Regex('/', new Text('Hello world!')),
        new Regex(
            '/users/(?P<id>[\d]+)',
            new Methods(
                ['post'],
                new class() extends Base {
                    public function act(ServerRequestInterface $request): Response {
                        return new Json(
                            json_decode($request->getBody()->getContents())
                        );
                    }
                }         
            ),
            new Methods(
                ['get'],
                new class() extends Base {
                    public function act(ServerRequestInterface|WithRegex $request): Response {
                        return new Text(sprintf(
                            '<html><body>User %s</body></html>',
                            $request->regex()->group('id')
                        ));
                    }
                }      
            )
        )
  ))->response(ServerRequest::fromGlobals(), new HttpFactory())
);
```

## Generators

Routes can be composed as variadic argument of _Routes_ or with [Generators](https://www.php.net/manual/en/language.generators.overview.php) using _Append_ wrapper.

```php
use Alvinios\Miel\Response\{Text, Twig}; 
use Alvinios\Miel\Fork\{Append, Routes, Regex};

 new Routes(
     new Append(
         call_user_func(function() : \Iterator {
             yield new Regex('^(/|/home)$', new Twig($this->twig, 'index.html.twig', []));
         }),
         call_user_func(function() : \Iterator {
             yield new Regex('/foo', new Text('Foo'));
             yield new Regex('/bar', new Text('Bar'));
         })
     )
)
```

## Middleware Support

You can shield a route/routes behind [PSR-15](https://www.php-fig.org/psr/psr-15/) Middleware(s).
This is how it can be done:

```php
use Alvinios\Miel\Response\Text; 
use Alvinios\Miel\Fork\{Fork, Shield};
use Psr\Http\Server\MiddlewareInterface;

new Shield(
    new Regex('/foo', new Text('Behind middleware')),
    new class() implements MiddlewareInterface {
       ...
    },
    new class() implements MiddlewareInterface {
       ...
    }
)
```
_Shields_ can be nested.

## Note
 Today it is in a conceptual state and has not been tested in production environment.

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

<p align="right">(<a href="#readme-top">back to top</a>)</p>
