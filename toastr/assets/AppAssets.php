<?php
namespace app\widgets\toastr\assets;

use yii\web\AssetBundle;

class AppAssets extends AssetBundle
{
    public $sourcePath = '@app/widgets/toastr/resources';
    public $css = [
        'toastr.min.css',
    ];
    public $js = [
        'toastr.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}