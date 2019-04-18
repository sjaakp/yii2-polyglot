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
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class PolyglotBase
 * @package sjaakp\polyglot
 */
class PolyglotBase extends Widget
{
    public $buttonOptions = [];

    protected $_languages;
    protected $_flagUrl;


    public function init()
    {
        parent::init();
        $this->_languages = Yii::$app->polyglot->languages;
        if (count($this->_languages) > 1)  {
            $asset = new PolyglotAsset();
            $asset->register($this->view);
            $asset->publish(Yii::$app->assetManager);
            $this->_flagUrl = $asset->baseUrl . '/flags/';
        }
    }


    public function renderButtons($listOptions)
    {
        if (count($this->_languages) <= 1) return '';
        $current = Url::current();
        $buttons = [];
        foreach ($this->_languages as $lang => $label)   {
            $buttons[] = $this->renderButton($lang, $label, $current, array_merge ($this->buttonOptions, [
                'data' => [
                    'method' => 'post',
                    'params' => [
                        'polyglot' => $lang
                    ]
                ],
            ]));
        }
        return Html::tag('div', implode("\n", $buttons), $listOptions);
    }

    public function renderButton($lang, $label, $url, $opts)
    {
        if (! is_array($label)) $label = [ 'name' => $label ];
        $flag = $label['flag'] ?? strtolower(substr($lang, -2));
        $opts['title'] = $label['name'];
        $img = Html::img($this->_flagUrl . $flag . '.png')/* . $label['name']*/;
        if ($lang == Yii::$app->language) Html::addCssClass($opts, 'act');

        return Html::a($img, $url, $opts);
    }
}
