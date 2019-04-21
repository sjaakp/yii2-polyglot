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

/**
 * Class PolyglotButtons
 * @package sjaakp\polyglot
 */
class PolyglotButtons extends PolyglotBase
{
    public function run()
    {
        return $this->renderButtons([ 'class' => 'polyglot polyglot-bl' ]);
    }
}
