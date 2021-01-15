<?php
namespace app\widgets\toastr;

use app\widgets\toastr\assets\AppAssets;
use \yii\bootstrap\Widget;
use Yii;

/**
 * jquery 通知提示插件
 *
 * Class Toastr
 * @package app\widgets
 */
class Toastr extends Widget
{

    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - key: the name of the session flash variable
     * - value: the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'error' => 'alert-danger',
        'danger' => 'alert-danger',
        'success' => 'alert-success',
        'info' => 'alert-info',
        'warning' => 'alert-warning'
    ];
    /**
     * @var array the options for rendering the close button tag.
     * Array will be passed to [[\yii\bootstrap\Alert::closeButton]].
     */
    public $closeButton = [];


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $appendClass = isset($this->options['class']) ? ' ' . $this->options['class'] : '';
        foreach ($flashes as $type => $flash) {
            if (!isset($this->alertTypes[$type])) {
                continue;
            }

            foreach ((array)$flash as $i => $message) {
                /* initialize css class for each alert box */
                $this->options['class'] = $this->alertTypes[$type] . $appendClass;

                /* assign unique id to each alert box */
                $this->options['id'] = $this->getId() . '-' . $type . '-' . $i;

                //注册 toastr css js
                AppAssets::register($this->view);

                // 调用函数
                $this->view->registerJs(<<<Js
/* 提示报错弹出框配置 */
toastr.options = {
    "closeButton": true,
    "debug": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
    toastr.{$type}('{$message}')
Js
                );
            }

            $session->removeFlash($type);
        }
    }

}