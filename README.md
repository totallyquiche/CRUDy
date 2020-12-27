# CRUDy

CRUDy is a PHP framework for classic CRUD sites.

There are no dependencies since everything is built from scratch -- you won't find a `composer.json` file here!

Since CRUDy is focused on easy CRUD scaffolding, there's optional support for connecting to a MySQL database.

## But why?

For fun, of course! In this case, "fun" and "education" are pretty closely tied. CRUDy is helping me hone my PHP skills and understand more about the concepts larger PHP frameworks are built on.

CRUDy is _not_ meant to be used in production. I'm not doing anything here that hasn't been done a million times (and a million times better) by other engineers. If you're looking for a lightweight PHP framework to use in the real world, check out [Slim](https://www.slimframework.com/) or [Lumen](https://lumen.laravel.com/).

Feedback is still welcome! You can even open up a Pull Request if you'd like. :smile:

## Features
- Routing
- Templating
- Testing
- PSR-4 autoloading
- MVC architecture
- Custom environment variables (.env)
- Database abstraction

## Getting Started

1. Clone the repo: `git clone git@github.com:totallyquiche/CRUDy.git`
1. Create your config file: `cp .env.example .env`
1. Setup autoloader: `composer install`
1. Start your PHP server: `php -S localhost:80`
