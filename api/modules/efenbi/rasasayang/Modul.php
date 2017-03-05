<?php

namespace api\modules\efenbi\rasasayang;

class Modul extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\efenbi\rasasayang\controllers';

    public function init()
    {
        parent::init();        
		\Yii::$app->user->enableSession = false;
    }
}
