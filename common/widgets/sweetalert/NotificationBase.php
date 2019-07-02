<?php
namespace common\widgets\sweetalert;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;


class NotificationBase extends Widget
{
    /** @var string $title */
    public $title;

    /** @var string $message */
    public $message;

    /** @var string $message */
    public $messageDefault = 'This is the message';

    /** @var string $type */
    public $type;

    /** @var array $types */
    public $types = ['info', 'error', 'success', 'warning'];

    /** @var string $typeDefault */
    public $typeDefault = self::TYPE_INFO;

    /** @var array $options */
    public $options = [];

    const TYPE_INFO = 'info';
    const TYPE_ERROR = 'error';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->view->registerAssetBundle(SweetAlertAsset::className());

        $this->title = is_string($this->title) ? Html::encode($this->title) : null;

        $this->message = ($this->message) ?
            Html::encode($this->message) : Html::encode($this->messageDefault);

        $this->options = is_array($this->options) ?
            Json::encode($this->options) : Json::encode([]);
    }

}
