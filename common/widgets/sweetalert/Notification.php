<?php
/**
 * Created by Manop Kongoon.
 * kongoon@hotmail.com
 * Date: 28/10/2560
 * Time: 22:51
 */

namespace common\widgets\sweetalert;

class Notification extends NotificationBase
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        if (in_array($this->type, $this->types)){
            return $this->view->registerJs("swal ( \"{$this->title}\" ,  \"{$this->message}\" ,  \"{$this->type}\"  );");
        }

        return $this->view->registerJs("swal ( \"{$this->title}\" ,  \"{$this->message}\" ,  \"{$this->typeDefault}\" );");
    }
}
