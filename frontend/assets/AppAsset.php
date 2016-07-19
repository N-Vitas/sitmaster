<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@themes/material';    
    public $baseUrl = '@web';
    public $css = [
        '//fonts.googleapis.com/css?family=Roboto:300,400,500,700',
        '//fonts.googleapis.com/icon?family=Material+Icons',
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
        'css/bootstrap-material-design.min.css',
        'css/ripples.min.css',
        'css/style.css',
    ];
    public $js = [
        'js/material.min.js',
        'js/ripples.min.js',
        'js/react.min.js',
        'js/react-dom.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.24/browser.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    // public $css = [
    //     'css/site.css',
    // ];
    // public $js = [
    // ];
    // public $depends = [
    //     'yii\web\YiiAsset',
    //     'yii\bootstrap\BootstrapAsset',
    // ];
}
