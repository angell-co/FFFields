<?php
/**
 * FFFields plugin for Craft CMS 3.x
 *
 * Fantastical front-end fields for Craft CMS.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2019 Angell & Co
 */

namespace angellco\fffields;

use angellco\fffields\services\Config as ConfigService;
use angellco\fffields\variables\FFFieldsVariable;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class FFFields
 *
 * @author    Angell & Co
 * @package   FFFields
 * @since     0.0.1
 *
 * @property  ConfigService $config
 */
class FFFields extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var FFFields
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '0.0.1';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('fFFields', FFFieldsVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'fffields',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
