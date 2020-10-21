# Navigation generator

## Installation

Via Composer

``` bash
$ composer require awema-pl/module-navigation.php
```

The package will automatically register itself.

You can publish the config file with:

```bash
php artisan vendor:publish --provider="AwemaPL\Navigation\NavigationServiceProvider" --tag="config"
```

## Menu structure

Default generator gets navs from `navigation` config `navs` array. Every item have to contain name and link or children.
Additionally it can contain icon.

Read more about nav structure you can in [Frame Navigation](https://www.awema.pl/documentation/components/indigo-layout/1.0/frame-nav)

## Active link binding

By default link is set as active if a current url contains it.

You can add an `exact` param to the nav item if you want it active only if the current url equal to nav link.

To exclude nav item from active binding add an `'active' => false` param to it. 
