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

use yii\helpers\Html;

/**
 * Class PolyglotButtons
 * @package sjaakp\polyglot
 */
class PolyglotButtons extends PolyglotBase
{
    /**
     * @var array HTML options for the surrounding element
     */
    public $options = [];

    public function run()
    {
        Html::addCssClass($this->options, 'polyglot polyglot-bl');
        return $this->renderButtons($this->options);
    }
}
