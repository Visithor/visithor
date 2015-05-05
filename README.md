Visithor
========

[![Build Status](https://travis-ci.org/Visithor/visithor.png?branch=master)](https://travis-ci.org/Visithor/visithor)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/visithor/visithor/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/visithor/visithor/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/visithor/visithor/v/stable.png)](https://packagist.org/packages/visithor/visithor)
[![Latest Unstable Version](https://poser.pugx.org/visithor/visithor/v/unstable.png)](https://packagist.org/packages/visithor/visithor)


Visithor is a PHP library that provides you a simple and painless way of testing 
your application routes with expected HTTP Codes.

Of course this project not pretends to avoid the need of unit, functional or
behavioral tests, it is only a fast and easy way of ensuring that your routes
are still available over the time.

## Frameworks

You can find some packages that will provide you some integration between
Visithor and them. Check these repositories in order to use specific features.

* [VisithorBundle for Symfony](http://github.com/visithor/VisithorBundle)

## Tags

* Use last unstable version ( alias of `dev-master` ) to stay in last commit
* Use last stable version tag to stay in a stable release.
* [![Latest Unstable Version](https://poser.pugx.org/visithor/visithor/v/unstable.png)](https://packagist.org/packages/visithor/visithor)
[![Latest Stable Version](https://poser.pugx.org/visithor/visithor/v/stable.png)](https://packagist.org/packages/visithor/visithor)

## Install

Install Visithor in this way:

``` bash
$ composer global require visithor/visithor=dev-master
```

If it is the first time you globally install a dependency then make sure
you include `~/.composer/vendor/bin` in $PATH as shown [here](http://getcomposer.org/doc/03-cli.md#global).

### Always keep your Visithor installation up to date:

``` bash
$ composer global update visithor/visithor
```

### .phar file

You can also use already last built `.phar`.

``` bash
$ git clone git@github.com:visithor/visithor.git
$ cd visithor
$ php build/visithor.phar
```

You can copy the `.phar` file as a global script

``` bash
$ cp build/visithor.phar /usr/local/bin/visithor
```

### Compile

Finally you can also compile your own version of the package. ( You need set `phar.readonly = Off` in your php.ini ).

``` bash
$ git clone git@github.com:visithor/visithor.git
$ cd visithor
$ composer update
$ php bin/compile
$ sudo chmod +x build/visithor.phar
$ build/visithor.phar
```

You can copy the `.phar` file as a global script

``` bash
$ cp build/visithor.phar /usr/local/bin/visithor
```

## Config

Visithor uses the yml configuration format for your url definitions. This is the
master document with all possible configurations.

``` yml
defaults:
    #
    # This value can be a simple HTTP Code or an array of acceptable HTTP Codes
    # - 200
    # - [200, 301]
    #
    http_codes: [200, 302]
    options:
        verb: GET

urls:
    #
    # By default, is there is no specified HTTP Code, then default one is used
    # as the valid one
    #
    - http://google.es
    - http://elcodi.io
    
    #
    # There are some other formats available as well
    #
    - [http://shopery.com, 200]
    - [http://shopery.com, 200, {verb: POST}]
    - [http://shopery.com, [200, 302]]
```

Your config file can be named `visithor.yml` or `visithor.yml.dist`, being this 
last one the preferred one.

## Options

You can define a set of options per each url. Each option will be usable for the
implementations on top of this library

``` yaml
urls:
    - [http://shopery.com, 200, {option1: value1, option2: value2}]
```

You can define these options as well in a global way using the default:options
path

``` yaml
defaults:
    options:
        option3: value3
urls:
    - [http://shopery.com, 200, {option1: value1, option2: value2}]
```

In this example, Visithor will use the default options array as the base set of
options for the url, and finally will merge with them the specific set of 
options defined in each url.

> Merge means that if an option is defined in both places, then the one 
specifically defined in the url will overwrite the one defined globally

## Profiles

You can group a set of options just creating profiles. A profile is a set of 
options to be used in a set of urls.

``` yaml
profiles:
    admin:
        option1: value1
        option2: value2
urls:
    - [http://shopery.com, 200, {profile: admin}]
    - [http://elcodi.io, 200, {profile: admin}]
```

In this example, Visithor will add all every option inside given profile and 
will append it in the url definition. So, last example is equivalent to this one

``` yaml
urls:
    - [http://shopery.com, 200, {option1: value1, option2: value2}]
    - [http://elcodi.io, 200, {option1: value1, option2: value2}]
```

You can assign by default a profile as well, adding it as a global option. Last
example is equivalent to this one

``` yaml
defaults:
    options:
        profile: admin
profiles:
    admin:
        option1: value1
        option2: value2
urls:
    - [http://shopery.com, 200]
    - [http://elcodi.io, 200]
```

## Verbs

You can define the preferred verb in the default options block. This value will
be used as the default verb in all your urls, but you can overwrite this value
just adding the new verb in the specific url line,

``` yml
defaults:
    options:
        verb: GET

urls:
    - [http://shopery.com, 200, {verb: POST}]
```

## Command

To execute the visithor you need to use a pre-built command called 
`visithor:go`.

``` bash
visithor.phar visithor:go [--format|-f] [--config|-c]
```

Executing it you will receive this output (with last example) and `0` as the 
final result of the execution.

```
Visithor by Marc Morera and contributors.

Configuration read from /var/www/visithor/visithor


[200] http://google.es --  OK 
[200] http://elcodi.io --  OK 
[200] http://shopery.com --  OK 
[200] http://shopery.com --  OK 

Time: 1221 ms, Memory: 4Mb
```

### Dots

You can use a non-explicit format called `dots` using the `--format|-f` option.
This format is useful for non-debug environments like travis or similars.

``` bash
visithor.phar visithor:go --format=dots
```

Executing it you will receive this output (with last example) and `0` as the 
final result of the execution.

```
Visithor by Marc Morera and contributors.

Configuration read from /var/www/visithor/visithor


....
Time: 1118 ms, Memory: 4Mb
```

### Config

You can choose where your visithor config is located with the `--config|-c` 
option.

``` bash
visithor.phar visithor:go --config=/var/www/another/folder
```
