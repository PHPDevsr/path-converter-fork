# Path converter (Fork)

[![Build status](https://img.shields.io/github/actions/workflow/status/PHPDevsr/path-converter-fork/test.yml?branch=master&style=flat-square)](https://github.com/PHPDevsr/path-converter-fork/actions/workflows/test.yml)
[![Latest version](http://img.shields.io/packagist/v/phpdevsr/path-converter-fork?style=flat-square)](https://packagist.org/packages/phpdevsr/path-converter-fork)
[![License](http://img.shields.io/packagist/l/phpdevsr/path-converter-fork?style=flat-square)](https://github.com/PHPDevsr/path-converter-fork/blob/master/LICENSE)

> **Fork of [matthiasmullie/path-converter](https://github.com/matthiasmullie/path-converter)** — original library by [Matthias Mullie](https://www.mullie.eu).


## Usage

```php
use PHPDevsr\PathConverter\Converter;

$from = '/css/imports/icons.css';
$to = '/css/minified.css';

$converter = new Converter($from, $to);
$result = $converter->convert('../../images/icon.jpg');
// $result is now '../images/icon.jpg'
```


## Methods

### __construct($from, $to)

The object constructor accepts 2 paths: the source path your file(s) is/are
currently relative to, and the target path to convert to.

### convert($path): string

$path is the relative file, which is currently relative to $from (in
constructor). The return value will be the relative path of this same file, but
now relative to $to (in constructor)


## Installation

Simply add a dependency on `phpdevsr/path-converter-fork` to your composer.json file if you use [Composer](https://getcomposer.org/) to manage the dependencies of your project:

```sh
composer require phpdevsr/path-converter-fork
```

Although it's recommended to use Composer, you can actually include these files anyway you want.


## License

PathConverter is [MIT](http://opensource.org/licenses/MIT) licensed.
