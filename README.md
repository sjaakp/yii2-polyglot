yii2-polyglot
=============

#### Ultralight language chooser for Yii2 ####

**yii2-polyglot** is an application component plus two widgets with flag buttons to
 choose the application language.
  It can be used in the [Yii 2.0](https://www.yiiframework.com/ "Yii") PHP Framework.

**yii2-polyglot** was developed as an alternative to other language choosers,
which in my opinion are often overly complex.

**yii2-polyglot** lets the user choose her favourite language by clicking on a
flag button. The chosen language becomes the site's main language and is stored in a cookie.

A demonstration of **Yii2-polyglot** is [here](http://demo.sjaakpriester.nl/polyglot).

## Installation ##

Install **yii2-polyglot** in the usual way with [Composer](https://getcomposer.org/). 
Add the following to the require section of your `composer.json` file:

`"sjaakp/yii2-polyglot": "*"` 

or run:

`composer require sjaakp/yii2-polyglot` 

You can manually install **yii2-polyglot** by [downloading the source in ZIP-format](https://github.com/sjaakp/yii2-polyglot/archive/master.zip).

## Using yii2-polyglot ##

First of all, Polyglot should be installed as an [application component](https://www.yiiframework.com/doc/guide/2.0/en/structure-application-components "Yii"). 
This is done
in the main configuration file, usually called `web.php` or `main.php` in the `config`
directory. Add the following to the configuration array:

	<?php
	
	'components' => [
        // ... other components, like 'cache' and 'errorHandler'
        'polyglot' => [
            'class' => 'sjaakp\polyglot\Polyglot',
            'languages' => [
                'en-US' => 'English',
                'de-DE' => 'Deutsch',
                'fr-FR' => 'Français',
                // ... more languages
            ]
        ],
        // ... even more components
        
The `language` property is an array of the languages (or more correctly the *locale*s)
the web site supports. The keys of this array are the names of the locales in 
the ICU-format, just like [Yii recommends](https://www.yiiframework.com/doc/guide/2.0/en/tutorial-i18n#locale "Yii").
**One of the keys should be the same as the
 [`language`-property](https://www.yiiframework.com/doc/api/2.0/yii-base-application#$language-detail "Yii") of the application.**

The values of the array should be one of the following:

- `string` human-readable name of the language. It appears as popup tooltip.

- `array` with two keys:
    - `"label"` the human-readable language name;
    - `"flag"` the name of the flag that will be displayed, without the `.png`-part.

So, to show the Dutch language with the Belgian flag, we would use:

    <php 
	
	'components' => [
        // ... other components, like 'cache' and 'errorHandler'
        'polyglot' => [
            'class' => 'sjaakp\polyglot\Polyglot',
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

A bunch of flags (247 of them) can be found in **yii2-polyglot**'s `assets/flags` directory.
They are made by [famfamfam](http://www.famfamfam.com/lab/icons/flags/), by the way.

## Bootstrap ##

**Polyglot** has to be bootstrapped. Do this by adding the following to the
application configuration array:

    <php
    
    'bootstrap' => [
        'polyglot',
    ]

There probably already is a `bootstrap` property in your configuration file; just
add `'polyglot'` to it.

#### Polyglot options ####

Apart from the **languages**-settings, **Polyglot** has three more options:

 - **useCookie** `bool` If set to `false`, **Polyglot** will *not* store the preferred
 language in a cookie, but in the PHP session. As a consequence, the language choice
 will only persist for one session. Default: `true`.
 - **cookieName** `string` Also used as the session key if **useCookie** is `false`.
 Default: `"polyglot"`.
 - **cookieStamina** `integer` Cookie expiration time in seconds. Default: `31536000` (one year). 

## Widgets ## 

There are two widgets in the **yii2-polyglot** package. **PolyglotButtons** displays the
language options as a row of flag buttons. **PolyglotDropdown** is a dropdown menu.
Rendering a **yii2-polyglot** widget anywhere in a `View` is just a matter of:

	<?php
	use sjaakp\polyglot\PolyglotButtons;
	?>
	...
    <?= PolyglotButtons::widget() ?>;
	...

Or:

	<?php
	use sjaakp\polyglot\PolyglotDropdown;
	?>
	...
    <?= PolyglotDropdown::widget() ?>;
	...

As you will most likely want to have the **Polyglot** widget on all of your pages, the 
preferable place for a widget would be the layout viewfile (or one of the layout viewfiles).

#### Widget options ####

**PolyglotButtons** and **PolyglotDropdown** have the following options:

 - **options** `array` HTML options for the surrounding element. Default: `[]`.
 - **buttonOptions** `array` HTML options for the individual flag buttons.
 Default: `[]`.
 - **toggleOptions** `array` (**PolyglotDropdown** only) HTML options for the
 toggle button. Default: `['class' => 'nav-link']`.
 