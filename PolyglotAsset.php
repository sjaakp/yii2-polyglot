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

use yii\web\AssetBundle;

/**
 * Class PolyglotAsset
 * @package sjaakp\polyglot
 */
class PolyglotAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'assets';

    public $css = [
        'polyglot.css'
    ];
    public $depends = [
    ];
}
