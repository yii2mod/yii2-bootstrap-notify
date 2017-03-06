<?php

namespace yii2mod\notify;

use yii\web\AssetBundle;

/**
 * Class BootstrapNotifyAsset
 *
 * @package yii2mod\notify
 */
class BootstrapNotifyAsset extends AssetBundle
{
    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     */
    public $sourcePath = '@bower/remarkable-bootstrap-notify';

    /**
     * @var array
     */
    public $js = [
        'bootstrap-notify.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
