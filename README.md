[![Latest Stable Version](https://poser.pugx.org/ed9/php-indicators/v/stable)](https://packagist.org/packages/ed9/php-indicators)
[![Total Downloads](https://poser.pugx.org/ed9/php-indicators/downloads)](https://packagist.org/packages/ed9/php-indicators)
[![Travis CLI](https://travis-ci.org/ed9/php-indicators.svg?branch=master)](https://travis-ci.org/ed9/php-indicators)
[![License](https://poser.pugx.org/ed9/php-indicators/license)](https://packagist.org/packages/ed9/php-indicators)

# Indicator library
PHP Indicators for command line interface (CLI)

### Dependency notice

To run this library you must have php 7.1 or greater.

### Installation

This library can be found on [packagist](https://packagist.org/packages/ed9/php-indicators) and installed using composer:

`composer require ed9/php-indicators`

## Loading indicator

Enable loading indicator for your CLI application. 
View the full example usage code at: [example](https://github.com/ed9/php-indicators/blob/master/examples/loading.php).

![loading preview](https://s3.eu-west-2.amazonaws.com/ed9/github/php-indicators/loading-example-preview.png)

#### Indicator methods:

Initiate new loading instance by overwriting the total row count, the bar length and auto step increment straight from the constructor.

`$loading = new \Edward\Indicator\Loading(100, 30, true);`

Overwrite the bar length on demand

`$loading->setBarLength(30);`

Overwrite the total row count on demand

`$loading->setTotal(100);`

Overwrite the necessity for steps to be incremented on every ping automatically. If set to false, the script will not increment when ping is called but will rely on you to update via setCurrent()

`$loading->setAutoIncrement(true);`

You can change the current step even if auto increment is enabled, it will follow your input.

`$loading->setCurrent(0);`

Run ping on every row you are processing and it will output the string into your console if no argument is provided.

`$loading->ping();`

Alternatively you can provide a callable argument to process the output yourself.

* The variables you will receive in the argument:
* `string` - A formatted string that can be outputted
* `process.current` - Integer representing current step
* `process.total` - Integer representing total row count
* `percentageCompleted` - Float represented completion percentage
* `elapsed.value` - Time unit elapsed since initial ping
* `elapsed.format` - Time format elapsed since initial ping (seconds,minutes,hours)
* `eta.value` - Estimated time unit until completion
* `eta.format` - Estimated time format until completion (seconds,minutes,hours)

```
$loading->ping(function ($info) use ($loading) {
    print $info['string'];
});
```