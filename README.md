# CRUDy

![CRUDy preview](preview.png)

CRUDy is a proof-of-concept PHP framework with no dependencies.

## But why?

For fun, of course! In this case, "fun" and "education" are pretty closely tied. CRUDy is helping me hone my PHP skills and understand more about the concepts larger PHP frameworks are built on.

CRUDy is _not_ meant to be used in production. I'm not doing anything here that hasn't been done a million times (and a million times better) by other engineers. If you're looking for a lightweight PHP framework to use in the real world, check out [Slim](https://www.slimframework.com/) or [Lumen](https://lumen.laravel.com/).

Feedback is still welcome! You can even open up a Pull Request if you'd like. :smile:

## Features
- Autoloading
- Custom environment variables (.env)
- Database connection abstraction
- MVC architecture
- Routing
- Templates and Caching
- Testing

## Getting Started

1. Clone the repo: `git clone git@github.com:totallyquiche/CRUDy.git`
1. Create your config file: `cp .env.example .env`
1. Start your PHP server: `php -S localhost:80`
1. Open `http://localhost` in your browser

Technically, that's it! CRUDy is up and running! But you probably want to do more than that...

### Create a New Page

Add a new route to the `$routes` array in `index.php`. You can either specify a controller and method or an anonymous function. The method/function you define should return a string (this is what gets rendered).

```php
$router->register('/', 'HomeController::index');
```

```php
$router->register('/', function () {
    return 'Hello, World!';
});
```

### Create a Controller

Create a new class in `App/Controllers` that extends `App\Controller\BaseController`. The class name should end with `Controller` (e.g. `HomeController`). The file name should be the class name plus `.php` (e.g. `HomeController.php`).

The controller should contain methods matching any register routes you have. For example, if I have registerd a route referencing `HomeController::index`, then I should have a controller named `HomeController` with a method named `index()` which returns a string.

### Create a View

Create a new `.php` file in `App/Views`. Load the view from your controller by calling `$this->loadView()` in the controller method.

The first parameter is the name of the view (without `.php`). The second parameter is an optional array of data to be passed to the view. The key/value pairs in the array are turned into variables with assigned values.

For example, calling the below method call will result in the the `show_object` view (`App/Views/show_object.php`) being loaded. The view will have access to a variable called `$object_name` with the value `Object Name`;

```php
$this->loadView(string $view_name, array $args = [
    'object_name' => 'Object Name';
]);
```

## Testing

### Writing Tests

Create a new class in `App/Tests` that extends `App\Tests\BaseTest`. The class name should end with `Test` (e.g. `HomeControllerTest`). The file name should be the class name plus `.php` (e.g. `HomeControllerTest.php`).

Your test methods should be `public`, should start with `test_`, and should return a `boolean` indicating whether the test passed.

```php
public function test_that_true_is_true()
{
    return true === true;
}
```

### Running Tests

As long as you follow the above naming conventions, your tests will be run automatically through the following command:

```
php App/Tests/run_tests.php
```

You can run an individual test by passing in the test name as an argument:

```
php App/Tests/run_tests.php "App\Tests\RouterTest"
```

### Test results

After running your tests, you will see the results printed to the screen. If every test in a class passes, you'll see the class name and the word "Passed". If a test fails, then you'll see the class name, the word "Failed", and the name of the test method that failed (returned `false`).
