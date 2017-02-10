<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic',
        "css/popuo-box.css",
    ];
    public $js = [
        "js/move-top.js",
        "js/easing.js",
        "js/circles.js",
        "js/modernizr.custom.min.js",
        "js/jquery.magnific-popup.js",
        "js/jquery.mixitup.min.js",
        "js/responsiveslides.min.js",
        
        "js/myscript.js",

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
// <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
//     <!--fonts-->
//         <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
//     <!--//fonts-->
//         <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />

//         <script type="text/javascript" src="js/jquery.min.js"></script>
//     <!-- js -->
//     <!-- start-smoth-scrolling -->
//         <script type="text/javascript" src="js/move-top.js"></script>
//         <script type="text/javascript" src="js/easing.js"></script>