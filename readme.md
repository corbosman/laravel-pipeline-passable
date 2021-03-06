# Passable

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

Laravel's Pipeline class only takes a single input parameter. This unfortunately limits how you can use that class to your advantage. This is an opinionated solution using a Passable class that extends [Spatie's Data Transfer Object](https://github.com/spatie/data-transfer-object). It's just something I needed myself in several projects, so I extracted it to a package.  

## Installation

Via Composer

``` bash
$ composer require corbosman/laravel-pipeline-passable
```

## Usage

You should be familiar on how Laravel Pipelines work. They're used in the Router and Middleware. It lets you pass a variable through a set of classes, and return the result. Sort of like array_reduce. Since you can't pass in multiple variables, it's not possible to send in some kind of input and output that are separate. That's where this package comes in. It allows you to create a class with multiple properties, and in the end return one of the properties as the result of the pipeline. By default, it just returns the class itself as the result, but you can implement a _return_ method that returns whatever you want. 

This package extends Spatie's DataTransferObject, so you can check their docs on how you can instantiate this class. It helps to understand what a DTO is and how you can use it. There is two common patterns, you either pass your class properties through the constructor, or you create a static method. 

### Constructor

```php
use CorBosman\Pipeline\Passable;

class MyPipeline extends Passable
{
    public string $username;
    public array $output;

    public function return() : array
    {
        return $this->output;
    }
}
```

To use this pipeline, construct it using the properties as parameters, then give it some classes to pipe through. 

```php
$output = (new MyPipeline(['username' => $foo, 'output' => []])->pipeline([
    PipeClass1::class,
    PipeClass2::class
    ...
]);
```

### Factory

Sometimes it's easier to use a factory method. For example, you can use it to initialise a response DataTransferObject.

```php
use CorBosman\Pipeline\Passable;

class MyPipeline extends Passable
{
    public string $username;
    public Output $output;
    
    public static function factory($username) : self
    {
        return new self([
            'username' => $username,
            'output'   => new Output
        ]);
    }

    public function return() : array
    {
        return $this->output->toArray();
    }
}
```

```php
$output = MyPipeline::factory($username)->pipeline([
    PipeClass1::class,
    PipeClass2::class
    ...
]);
```

## Pipeline classes

To send this Passable through Laravel's Pipeline, you call the _pipeline_ method with an array of classes. Just like with middleware classes, you have to make sure that your class calls the next class, as shown in the examples below. The Pipeline class allows several different options. 

* Normal class with a handle method

```php
class Uppercase
{
    public function handle(MyPipeline $passable, $next)
    {
        $passable->output = strtoupper($passable->username);

        return $next($passable);
    }
}
```

* An invokable class

```php
class Uppercase
{
    public function __invoke(MyPipeline $passable, $next)
    {
        $passable->output = strtoupper($passable->username);

        return $next($passable);
    }
}
```

* An object, note that the object should have the handle method on it

```php
$uppercase = new Uppercase;
$result = MyPipeline::factory($input)->pipeline([$uppercase]);
```

### Changing the called method

By default the __handle()__ method is called on each pipeline class. If you want to override that, you can set the method name as the second parameter of the __pipeline()__ method.

```php
$result = MyPipeline::factory($input)->pipeline([...], 'filter');
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email cor@in.ter.net instead of using the issue tracker.

## Credits

- [Cor Bosman][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/corbosman/laravel-pipeline-passable.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/corbosman/laravel-pipeline-passable.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/corbosman/laravel-pipeline-passable
[link-downloads]: https://packagist.org/packages/corbosman/laravel-pipeline-passable
[link-author]: https://github.com/corbosman
[link-contributors]: ../../contributors
