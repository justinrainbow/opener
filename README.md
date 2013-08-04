# It Opens Stuff, with PHP

A cross-platform way to open stuff.  You can use it programmatically, or via the
provided cli utility.

## Installable via Composer

``` bash
composer require "rainbow/opener *"
```

Composer will install the cli script into `vendor/bin` by default.  If you would
like this to be different, just use the [`config.bin-dir`](http://getcomposer.org/doc/articles/vendor-binaries.md#can-vendor-binaries-be-installed-somewhere-other-than-vendor-bin-) param.

``` json
{
    "config": {
        "bin-dir": "bin"
    }
}
```

## CLI Usage

``` bash
bin/opener http://google.com
bin/opener ./my-file.txt
```


## Programmatic usage

If you want to use it programmatically you can do that like:

```js
$opener = new Rainbow\Opener();

$opener->open("http://google.com");
$opener->open("./my-file.txt");
```

## Why

Same reasons as this [opener](https://github.com/domenic/opener#why), but for PHP stuff.
