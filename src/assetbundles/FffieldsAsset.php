<?php
/**
 * FFFields plugin for Craft CMS 3.x
 *
 * Fabulous front-end fields for Craft CMS.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2019 Angell & Co
 */

namespace angellco\fffields\assetbundles;

use Craft;
use craft\web\AssetBundle;
use craft\web\View;

/**
 * FffieldsAsset AssetBundle
 *
 * @author    Angell & Co
 * @package   FFFields
 * @since     0.0.1
 */
class FffieldsAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * Initializes the bundle.
     */
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = "@angellco/fffields/web/dist";

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'js/fffields.js',
        ];

        $this->css = [
            'css/fffields.css',
        ];

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);

        // TODO add translations
    }
}
