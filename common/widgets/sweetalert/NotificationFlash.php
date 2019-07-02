<?php
/**
 * Created by Manop Kongoon.
 * kongoon@hotmail.com
 * Date: 28/10/2560
 * Time: 23:06
 */

namespace common\widgets\sweetalert;
use yii\web\View;
use yii\helpers\Json;


use yii\helpers\Html;

class NotificationFlash extends NotificationBase
{
    /** @var object $session */
    private $session;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->session = \Yii::$app->session;

        $flashes = $this->session->getAllFlashes();

        foreach ($flashes as $type => $data) {
            $data = (array) $data;

            foreach ($data as $i => $message) {
                Notification::widget([
                    'type' => Html::encode($type),
                    'title' => Html::encode($this->title),
                    'message' => Html::encode($message),
                    'options' => Json::decode((string) $this->options),
                    
                ]);
            }

            $this->session->removeFlash($type);
        }
    }
}
