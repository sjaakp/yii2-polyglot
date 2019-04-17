yii2-polyglot
=============

#### Ultralight language chooser for Yii2 ####

**yii2-polyglot** is an application component plus a widget with flag buttons to choose the application 
language. It can be used in the [Yii 2.0](https://www.yiiframework.com/ "Yii") PHP Framework.

**yii2-polyglot** was developed as an alternative to other language choosers,
which in my view are often overly complex.

**yii2-polyglot** lets the user choose her favourite language by clicking on a
flag button. The chosen language becomes the site's main language and is stored in a cookie.

A demonstration of **Yii2-polyglot** is [here](http://www.sjaakpriester.nl/software/polyglot).

## Installation ##

Install **yii2-polyglot** in the usual way with [Composer](https://getcomposer.org/). 
Add the following to the require section of your `composer.json` file:

`"sjaakp/yii2-polyglot": "*"` 

or run:

`composer require sjaakp/yii2-polyglot` 

You can manually install **yii2-polyglot** by [downloading the source in ZIP-format](https://github.com/sjaakp/yii2-polyglot/archive/master.zip).

## Using yii2-polyglot ##

First of all, Polyglot should be installed as an [application component](https://www.yiiframework.com/doc/guide/2.0/en/structure-application-components). This is done
in the main configuration file, usually called `web.php` or `main.php` in the `config`
directory. Add the following to the configuration array:

	<?php
	
	'components' => [
        // ... other components, like 'cache' and 'errorHandler'
        'polyglot' => [
            'class' => 'common\extensions\polyglot\Polyglot',
            'languages' => [
                'en-US' => 'English',
                'de-DE' => 'Deutsch',
                'fr-FR' => 'Français',
                // ... more languages
            ]
        ],
        // ... even more components
        
The `language` property is an array of the languages (or more correctly the _locale_)
the web site should support. The keys of this array are the names of the locales in 
the ICU-format, just like [Yii recommends](https://www.yiiframework.com/doc/guide/2.0/en/tutorial-i18n#locale).
**One of the keys should be the same as the `language`-property of the application.**

The values of the array should be one of the following:

- `string` Human-readable name of the language. It appears as popup tooltip.

- `array` with two keys:
    - `"label"` the human-readable language name;
    - `"flag"` the name of the flag that will be displayed, without the `.png`-part.

So, to show the Dutch language with the Belgian flag, we would use:

    <php 
	
	'components' => [
        // ... other components, like 'cache' and 'errorHandler'
        'polyglot' => [
            'class' => 'common\extensions\polyglot\Polyglot',
            'languages' => [
                'en-US' => 'English',
                // ... more languages
                'nl-NL' => [
                    'label' => 'Nederlands',
                    'flag' => 'be'
                ]
            ]
        ],
        // ... even more components

If the array value is just a `string`, **Polyglot** tries to devise the flag name itself.

A bunch of flags (247 of them) can be found in **yii2-polyglot**'s `assets` directory.
They are made by [famfamfam](http://www.famfamfam.com/lab/icons/flags/), by the way.

## Bootstrap ##

**Polyglot** has to bee bootstrapped. Do this by adding the following to the
application configuration array:

    <php
    
    'bootstrap' => [
        'polyglot',
    ]

There probably already is a `bootstrap` property in your configuration file; just
add `'bootstrap'` to it.

## Widget ## 

Rendering the **yii2-polyglot** widget anywhere in a `View` is just a matter of:

	<?php
	use sjaakp\polyglot\PolyglotWidget;
	?>
	...
    <?= PolyglotWidget::widget() ?>;
	...

As you will most likely have the **Polyglot** widget on all of your pages, the 
preferable place the widget would be the layout viewfile.

The **Polyglot** widget has no options.
