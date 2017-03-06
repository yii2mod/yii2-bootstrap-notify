<?php

namespace yii2mod\notify;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('success', 'Your message');
 * Yii::$app->session->setFlash('info', 'Your message');
 * Yii::$app->session->setFlash('warning', 'Your message');
 * Yii::$app->session->setFlash('error', 'Your message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * You can set the icon and another options as following:
 *
 * ```php
 *  Yii::$app->session->setFlash('info', [
 *      'icon' => 'glyphicon glyphicon-user',
 *      'title' => '<b>RBAC Manager for Yii 2</b>',
 *      'message' => '<p>Yii2-rbac provides a web interface for advanced access control</p>',
 *      'url' => 'https://github.com/yii2mod/yii2-rbac',
 *      'target' => '_blank'
 *  ]);
 * ```
 *
 * You can render your own message without the session flash as following:
 *
 * ```php
 * echo \yii2mod\notify\BootstrapNotify::widget([
 *      'useSessionFlash' => false,
 *      'options' => [
 *           'message' => 'Your message',
 *      ],
 *      'clientOptions' => [
 *           'type' => \yii2mod\notify\BootstrapNotify::TYPE_SUCCESS
 *      ]
 *  ]);
 * ```
 */
class BootstrapNotify extends Widget
{
    /**
     * Info type of the alert
     */
    const TYPE_INFO = 'info';

    /**
     * Danger type of the alert
     */
    const TYPE_DANGER = 'danger';

    /**
     * Success type of the alert
     */
    const TYPE_SUCCESS = 'success';

    /**
     * Warning type of the alert
     */
    const TYPE_WARNING = 'warning';

    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'error' => self::TYPE_DANGER,
        'danger' => self::TYPE_DANGER,
        'success' => self::TYPE_SUCCESS,
        'info' => self::TYPE_INFO,
        'warning' => self::TYPE_WARNING,
    ];

    /**
     * @var bool All the flash messages stored for the session are displayed and removed from the session
     * Defaults to true.
     */
    public $useSessionFlash = true;

    /**
     * @var bool render the AnimateAsset
     * Defaults to true.
     */
    public $useAnimation = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();

        if ($this->useSessionFlash) {
            $session = Yii::$app->getSession();
            $flashes = $session->getAllFlashes();
            foreach ($flashes as $type => $data) {
                if (isset($this->alertTypes[$type])) {
                    if (ArrayHelper::isAssociative($data)) {
                        $this->options = ArrayHelper::merge($this->options, $data);
                        $this->clientOptions['type'] = $this->alertTypes[$type];
                        $this->renderMessage();
                    } else {
                        $data = (array)$data;
                        foreach ($data as $i => $message) {
                            $this->options['message'] = $message;
                            $this->clientOptions['type'] = $this->alertTypes[$type];
                            $this->renderMessage();
                        }
                    }

                    $this->options = [];
                    $session->removeFlash($type);
                }
            }
        } else {
            $this->renderMessage();
        }
    }

    /**
     * Render the message
     */
    protected function renderMessage()
    {
        $view = $this->getView();
        BootstrapNotifyAsset::register($view);
        if ($this->useAnimation) {
            AnimateAsset::register($view);
        }
        $js = "$.notify({$this->getOptions()},{$this->getClientOptions()});";
        $view->registerJs($js, $view::POS_END);
    }

    /**
     * Get options in the json format
     *
     * @return string
     */
    protected function getOptions()
    {
        return Json::encode($this->options);
    }

    /**
     * Get client options in the json format
     *
     * @return string
     */
    protected function getClientOptions()
    {
        return Json::encode($this->clientOptions);
    }
}
