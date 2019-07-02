<?php

/**
 * @package yii2-sticky-footer
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.0
 */

namespace pavlinter\stickyFooter;

/**
 * Class StickyFooterAsset
 * @link https://github.com/miWebb/jQuery.stickyFooter
 */
class StickyFooterAsset extends \yii\web\AssetBundle
{
    public $sourcePath = "@vendor/pavlinter/yii2-sticky-footer/stickyFooter/assets";

    public $css = [
        'css/jquery.stickyfooter.min.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        $min = YII_DEBUG ? '' : '.min';
        $this->js[] = 'js/jquery.stickyfooter' . $min .'.js';
        parent::init();
    }
}
