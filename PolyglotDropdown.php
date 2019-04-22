<?php
/**
 * MIT licence
 * Version 1.0
 * Sjaak Priester, Amsterdam 17-04-2019.
 *
 * yii2-polyglot
 *
 * Ultralight language chooser for the Yii 2.0 PHP Framework.
 */

namespace sjaakp\polyglot;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Class PolyglotDropdown
 * @package sjaakp\polyglot
 */
class PolyglotDropdown extends PolyglotBase
{
    /**
     * @var array HTML options for the surrounding element
     * @tip if you put PolyglotDropdown in a Bootstrap NavBar, set this to the NavBar's color defining classes,
     * f.i. [ 'class' => 'navbar-dark bg-primary' ]
     */
    public $options = [];

    /**
     * @var array HTML options for the toggler element
     * Default sets the colors like those of other NavBar links.
     */
    public $toggleOptions = [ 'class' => 'nav-link' ];

    public function run()
    {
        $actLang = Yii::$app->language;
        $actLabel = $this->_languages[$actLang];

        Html::addCssClass($this->toggleOptions, 'dropdown-toggle');

        $r = $this->renderButton($actLang, $actLabel, '#', ArrayHelper::merge($this->toggleOptions, [
            'data-toggle' => 'dropdown',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false',
            'role' => 'button'
        ]));

        $r .= $this->renderButtons([ 'class' => 'dropdown-menu' ]);

        Html::addCssClass($this->options, 'polyglot polyglot-dd dropdown');
        $this->options['aria-expanded'] = 'false';
        return Html::tag('div', $r, $this->options);
    }
}
