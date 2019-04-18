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

/**
 * Class PolyglotDropdown
 * @package sjaakp\polyglot
 */
class PolyglotDropdown extends PolyglotBase
{
    public $options;
    public $toggleOptions;

    public function run()
    {
        $actLang = Yii::$app->language;
        $actLabel = $this->_languages[$actLang];

        Html::addCssClass($this->toggleOptions, 'dropdown-toggle');

        $r = $this->renderButton($actLang, $actLabel, '#', array_merge($this->toggleOptions, [
            'data-toggle' => 'dropdown',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false',
            'role' => 'button'
        ]));

        $r .= $this->renderButtons([ 'class' => 'dropdown-menu' ]);

        Html::addCssClass($this->options, 'polyglot polyglot-dd dropdown navbar-dark bg-primary');
        $this->options['aria-expanded'] = 'false';
        return Html::tag('div', $r, $this->options);
    }
}
