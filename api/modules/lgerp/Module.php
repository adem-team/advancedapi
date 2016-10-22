<?php

namespace api\modules\lgerp;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\lgerp\controllers';

    public function init()
    {
    	parent::init();
       	parent::init();
		\Yii::$app->user->enableSession = false;
    }
}
