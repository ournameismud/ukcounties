<?php
/**
 * UK Counties plugin for Craft CMS 3.x
 *
 * Simple plugin to import UK counties into Craft Commerce
 *
 * @link      ournameismud.co.uk
 * @copyright Copyright (c) 2020 @cole007
 */

namespace ournameismud\ukcounties;


use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;

use yii\base\Event;
// use craft\commerce\migrations\Install;

/**
 * Class UkCounties
 *
 * @author    @cole007
 * @package   UkCounties
 * @since     1.0.0.
 *
 */
class UkCounties extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var UkCounties
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0.';

    /**
     * @var bool
     */
    public $hasCpSettings = false;

    /**
     * @var bool
     */
    public $hasCpSection = false;

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
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'ukcounties',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
