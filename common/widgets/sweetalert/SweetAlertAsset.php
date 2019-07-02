<?php
/**
 * Created by Manop Kongoon.
 * kongoon@hotmail.com
 * Date: 28/10/2560
 * Time: 22:56
 */

namespace common\widgets\sweetalert;


use yii\web\AssetBundle;

class SweetAlertAsset extends AssetBundle
{
    /** @var string $sourcePath  */
    public $sourcePath = '@bower/sweetalert2';

    /** @var array $css */
    public $css = [
        'dist/sweetalert2.css',
    ];

    /** @var array $js */
    public $js = [
        'dist/sweetalert2.js',
    ];

    /** @var array $depends */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    // /** @var string $sourcePath  */
    // public $sourcePath = '@bower/sweetalert2';
    //
    // /** @var array $css */
    // public $css = [
    //     'dist/sweetalert2.css',
    // ];
    //
    // /** @var array $js */
    // public $js = [
    //     'dist/sweetalert2.js',
    // ];
    //
    // /** @var array $depends */
    // public $depends = [
    //     'yii\web\YiiAsset',
    //     'yii\bootstrap\BootstrapAsset',
    // ];
}
