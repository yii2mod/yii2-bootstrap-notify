<?php

namespace yii2mod\notify;

use yii\web\AssetBundle;

/**
 * Class AnimateAsset
 *
 * @package yii2mod\notify
 */
class AnimateAsset extends AssetBundle
{
    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     */
    public $sourcePath = '@bower/animate.css';

    /**
     * @var array
     */
    public $css = [
        'animate.min.css',
    ];
}
