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
    /**
     * @var array supported languages
     *   - key      locale in ICU-format
     *   - value    one of:
     *              - string    human readable language name
     *              - [
     *                  'label' => <language name>
     *                  'flag' => <flag name, without '.png' (optional)>
     *                ]
     * One of the keys must be the same as the value of the application's 'language' property
     */
    public $languages = [];

    /**
     * @var bool whether to store the preferred language in a cookie
     * If false, the language is stored in the session
     */
    public $useCookie = true;

    /**
     * @var string name of cookie
     */
    public $cookieName = 'polyglot';

    /**
     * @var int cookie expiration period in seconds
     */
    public $cookieStamina = 31536000;   // 365 * 24 * 3600, one year

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
        $request = Yii::$app->request;

        $post = $request->post('polyglot');
        if ($post)  {
            Yii::$app->language = $post;

            if ($this->useCookie)   {
                $respCookies = Yii::$app->response->cookies;
                // set new cookie
                $respCookies->add(new Cookie([
                    'name' => $this->cookieName,
                    'value' => $post,
                    'expire' => time() + $this->cookieStamina
                ]));
            }
            else    {
                Yii::$app->session->set($this->cookieName, $post);
            }
        }
        else    {
            $lang = null;
            if ($this->useCookie)   {
                // check cookie
                $lang = $request->cookies->getValue($this->cookieName);
            }
            else    {
                $lang = Yii::$app->session->get($this->cookieName);
            }

            // if no cookie or session, see if any of the request's acceptable languages is supported by us
            if (! $lang)    {
                foreach ($request->acceptableLanguages as $accept)  {
                    if (array_key_exists($accept, $this->languages))    {
                        $lang = $accept;
                        break;
                    }
                }
            }

            if ($lang) Yii::$app->language = $lang;
        }
    }
}
