# CRUDy

![CRUDy preview](preview.png)

CRUDy is a proof-of-concept PHP framework with no dependencies.

## But why?

For fun, of course! In this case, "fun" and "education" are pretty closely tied. CRUDy is helping me hone my PHP skills and understand more about the concepts larger PHP frameworks are built on.

CRUDy is _not_ meant to be used in production. CRUDy development starts with the naive approach instead of with existing standards (e.g. PSR). I then develop these implementations over time as I learn the pros and cons of different patterns. Compatibility, performance, and even security are not priorities and are not guaranteed.

Feedback is still welcome! You can even open up a Pull Request if you'd like. :smile:

## Features

- Autoloading
- Page caching
- Environment variables (.env)
- Database Abstraction Layer (DBAL)
- Headless execution
- MVC architecture
- Routing
- Templates
- Testing

## Getting Started

1. Clone the repo: `git clone git@github.com:totallyquiche/CRUDy.git`
1. Create your config file: `cp .env.example .env`
1. Start your PHP server: `php -S localhost:80`
1. Open `http://localhost` in your browser

Technically, that's it! CRUDy is up and running! But you probably want to do more than that...

### Create a New Page

Add a new route to the `$routes` array in `./App/Http/routes.php`. You can either specify a controller and method or an anonymous function. The method/function you define should return a string (this is what gets rendered).

```php
$routes = [
    '/' => 'HomeController::index'
];
```

```php
$routes = [
    '/' => fn() => 'Hello, World!'
);
```

### Create a Controller

Create a new class in `App/Controllers/Http` that extends `App\Http\Controllers\HttpController`. The class name should end with `Controller` (e.g. `HomeController`). The file name should be the class name plus `.php` (e.g. `HomeController.php`).

The controller should contain methods matching any register routes you have. For example, if I have registerd a route referencing `HomeController::index`, then I should have a controller named `HomeController` with a method named `index()` which returns a string.

### Create a View

Create a new `.php` file in `App/Views/Templates`. Load the view from your controller by calling `$this->renderView($view_name, $args)` in the controller method.

The first parameter is the name of the view (without `.php`). The second parameter is an optional array of data to be passed to the view. The key/value pairs in the array are turned into variables with assigned values.

For example, calling the below method call will result in the the `show_object` view (`App/Views/Templates/show_object.php`) being loaded. The view will have access to a variable called `$object_name` with the value `Object Name`;

```php
$this->renderView('show_object', [
    'object_name' => 'Object Name';
]);
```

A values in `$args` can also be a `Callable`. For example, calling the method below will give the view access to a variable called `$message` with the value `Hello, World!`:

```php
$this->renderView('view_name', [
    'message' => fn() => return 'Hello, World!',
]);
```

## Templates

Templates may be used to support a type of single-inheritance View in which the string `{{ 💩 }}` in the Template is replaced with the contents of the View. For example, given the following Template:

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_title ?></title>
</head>
<body>
    {{ 💩 }}
</body>
</html>
```

and the following View:

```php
<h1>Hello, World!</h1>
```

the following will be rendered:

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_title ?></title>
</head>
<body>
    <h1>Hello, World!</h1>
</body>
</html>
```

### Creating a Template

Templates are files with names matching `[a-zA-Z]+\.php` (e.g. `page.php`) and live in `App\Views\Templates`. The should contain a single placeholder, `{{ 💩 }}` for embedding Views within them.

### Using a Template

To use a Template, ensure that the first line of your View file contains a string like `{{ TEMPLATE_NAME }}`, wherein `TEMPLATE_NAME` is the file name of the Template without `.php`. For example, the following View would utilize a template located at `App\Views\Templates\page.php`:

```php
{{ page }}
<h1>Hello, World!</h1>
```

## View Caching

After a View has been fully compiled, it is written to a cache located at `./App/Views/Templates/Cache`. That cached file is used each time the corresponding page is requested until the cache period expires (the number of seconds the `VIEW_CACHE_SECONDS_TO_EXPIRY` environment variable is set to).

## Testing

### Writing Tests

Create a new class in `./App/Tests` that extends `App\Tests\Test`. The class name should end with `Test` (e.g. `HomeControllerTest`). The file name should be the class name plus `.php` (e.g. `HomeControllerTest.php`).

Your test methods should be `public`, should start with `test_`, and should return a `boolean` indicating whether the test passed.

```php
public function test_that_true_is_true() : bool
{
    return true === true;
}
```

### Running Tests

As long as you follow the above naming conventions, your tests will be run automatically through the following command:

```sh
php index.php tests:run
```

You can run specific tests by passing in their name as arguments:

```sh
php index.php tests:run "App\Tests\ModelTest" "App\Tests\RouterTest"
```

### Test results

After running your tests, you will see the results printed to the screen.

Each test cass will be displayed starting with `Passed` or `Failed`. The total
pass/fail counts will be displayed at the end.

![Test results example](test-results-example.png)
