# Passable

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]

Laravel Pipeline class only takes a single input parameter. This unfortunately limits how you can use that class to your advantage. This is an extremely opinionated solution using a Passable class that extends [Spatie's Data Transfer Object](https://github.com/spatie/data-transfer-object). It's just something I needed myself in several projects, so I extracted it to a package.  

## Installation

Via Composer

``` bash
$ composer require corbosman/laravel-pipeline-passable
```

## Usage

You should be familiar on how Laravel Pipelines work. They're used in the Router and Middleware. It lets you pass a variable through a set of classes, and return the result. Sort of like array_reduce. Since you can't pass in multiple variables, it's not possible to send in some kind of input and output that are separate. That's where this package comes in. It allows you to create a class with multiple properties, and in the end return one of the properties as the result of the pipeline. By default, it just returns the class itself as the result, but you can implement a _return_ method that returns whatever you want. 

This package extends Spatie's DataTransferObject, so you can check their docs on how you can instantiate this class. It helps to understand what a DTO is and how you can use it. There is two common patterns, you either pass your class properties through the constructor, or you create a factory methods. 

### Constructor methods

```php
use CorBosman\Pipeline\Passable;

class MyPipeline extends Passable
{
    public string $username;
    public array $output;

    /**
     * This pipeline should return the settings
     *
     * @return array
     */
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

    /**
     * This pipeline should return the settings
     *
     * @return array
     */
    public function return() : array
    {
        return $this->output;
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
[ico-travis]: https://img.shields.io/travis/corbosman/laravel-pipeline-passable/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/corbosman/laravel-pipeline-passable
[link-downloads]: https://packagist.org/packages/corbosman/laravel-pipeline-passable
[link-travis]: https://travis-ci.org/corbosman/laravel-pipeline-passable
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/corbosman
[link-contributors]: ../../contributors
