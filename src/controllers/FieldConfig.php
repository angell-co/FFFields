<?php
/**
 * FFFields plugin for Craft CMS 3.x
 *
 * Fabulous front-end fields for Craft.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2019 Angell & Co
 */

namespace angellco\fffields\controllers;

use angellco\fffields\FFFields;

use Craft;
use craft\web\Controller;

/**
 * @author    Angell & Co
 * @package   FFFields
 * @since     0.0.1
 */
class FieldConfig extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['get'];

    // Public Methods
    // =========================================================================

    /**
     * @return \yii\web\Response
     */
    public function actionGet()
    {
        $configModel = FFFields::$plugin->fieldConfig->get();
        return $this->asJson($configModel);
    }

}
