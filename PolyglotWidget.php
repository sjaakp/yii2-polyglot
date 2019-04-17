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
use yii\web\JsExpression;

/**
 * Class PolyglotWidget
 * @package sjaakp\polyglot
 */
class PolyglotWidget extends Widget
{
    protected $baseUrl;
    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $languages = Yii::$app->polyglot->languages;
        if (count($languages) <= 1) return '';

        $asset = new PolyglotAsset();
        $asset->register($this->view);
        $asset->publish(Yii::$app->assetManager);
        $this->baseUrl = $asset->baseUrl;

        $r = Html::beginForm( '', 'post', [ 'class' => 'polyglot' ]);
        $r .= Html::radioList('polyglot', Yii::$app->language, $languages, [
            'item' => [$this, 'renderButton'],
            'onchange' => new JsExpression('this.closest("form").submit()'),
            'class' => 'flags',
        ]);
/*        $r .= Html::dropDownList('polyglot', Yii::$app->language, $languages, [
            'onchange' => new JsExpression('this.closest("form").submit()')
        ]);*/
        $r .= Html::endForm();
        return $r;
    }

    public function renderButton($index, $label, $name, $checked, $value)
    {
        if (! is_array($label)) $label = ['label' => $label];
        if (! isset($label['flag'])) $label['flag'] = strtolower(substr($value, -2));
        $img = Html::img($this->baseUrl . '/' . $label['flag'] . '.png');
        $id = 'p' . $index;
        $r = Html::radio($name, $checked, [ 'id' => $id, 'value' => $value ] );
        $r .= Html::tag('label', $img, [ 'for' => $id, 'title' => $label['label']]);
        return $r;
    }
}