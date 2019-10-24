# Laravel Widget

[![Latest Version on Packagist](https://img.shields.io/packagist/v/chargefield/laravel-widget.svg?style=flat-square)](https://packagist.org/packages/chargefield/laravel-widget)
[![Total Downloads](https://img.shields.io/packagist/dt/chargefield/laravel-widget.svg?style=flat-square)](https://packagist.org/packages/chargefield/laravel-widget)
[![MIT License](https://img.shields.io/packagist/l/chargefield/laravel-widget.svg?style=flat-square)](https://packagist.org/packages/chargefield/laravel-widget)

Laravel Widget is a class based approach for structuring portions of your views.

## Installation

You can install the package via composer:

```bash
composer require chargefield/laravel-widget
```

## Usage

### Artisan Command

```bash
php artisan make:widget ExampleWidget
```

or

```bash
php artisan widget:make ExampleWidget
```

This will generate the following files:

_app/Http/Widgets/ExampleWidget.php_

_resources/views/widgets/example-widget.blade.php_

### Blade Directive

Including a widget is as easy as using the `@widget` blade directive:

```php
@widget('ExampleWidget')
```

You can pass external data to the widget as an array to the second argument. It will be available in both the class and view:

```php
@widget('ExampleWidget', ['four' => 'Four'])
```

### Widget Data

All public properties and public methods are passed down to the view as their respected names.

**Example**

Widget Class:

```php
namespace App\Http\Widgets;

use Chargefield\LaravelWidget\BaseWidget;

class ExampleWidget extends BaseWidget
{
    public $title = 'Hello World';

    public function numbers()
    {
        return [
            'One', 'Two', 'Three', $this->four,
        ];
    }
}
```

Widget Blade View:

```html
<h1>{{ $title }}</h1>
@foreach($numbers as $number)
<p>{{ $number }}</p>
@endforeach
```

Output:

```html
<h1>Hello World</h1>
<p>One</p>
<p>Two</p>
<p>Three</p>
<p>Four</p>
```

### Testing

You can run the tests with:

```bash
vendor/bin/phpunit
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email support@chargefield.com instead of using the issue tracker.

## Credits

-   [Clayton D'Mello](https://github.com/chargefield)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
