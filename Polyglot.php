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
use yii\base\Application;
use yii\base\Component;
use yii\base\BootstrapInterface;
use yii\base\ActionEvent;
use yii\base\InvalidConfigException;
use yii\web\Application as WebApplication;
use yii\web\Cookie;

/**
 * Class Polyglot
 * @package sjaakp\polyglot
 */
class Polyglot extends Component implements BootstrapInterface
{
    public $languages = [];

    public $cookieName = 'polyglot';

    public $cookieExpire = 31536000;   // 365 * 24 * 3600, one year

    /**
     * @param Application $app
     * @throws InvalidConfigException
     */
    public function bootstrap($app)
    {
        if ($app instanceof WebApplication) {
            if (! in_array($app->language, array_keys($this->languages)))  {
                throw new InvalidConfigException('Site default language is not in ' . __CLASS__ . '::language');
            }
            $app->on($app::EVENT_BEFORE_ACTION, [$this, 'beforeAction']);
        }
    }

    /**
     * @param $event ActionEvent
     */
    public function beforeAction($event)
    {
/*        $session = Yii::$app->session;
        $post = Yii::$app->request->post('polyglot');
        if ($post)  {
            Yii::$app->language = $post;
            $session->set($this->cookieName, $post);
        }
        else    {
            $lang = $session->get($this->cookieName);
            if ($lang) Yii::$app->language = $lang;
        }*/

        $request = Yii::$app->request;
        $post = $request->post('polyglot');
        if ($post)  {
            Yii::$app->language = $post;

            $respCookies = Yii::$app->response->cookies;
            // set new cookie
            $respCookies->add(new Cookie([
                'name' => $this->cookieName,
                'value' => $post,
                'expire' => time() + $this->cookieExpire
            ]));
        }
        else    {
            $lang = $request->cookies->getValue($this->cookieName);
            if ($lang) Yii::$app->language = $lang;
        }
    }
}
