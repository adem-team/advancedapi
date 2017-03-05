<?php

namespace api\modules\efenbi;
use Yii;
use yii\helpers\Inflector;
/**
 * 
 * @author -ptr.nov- 
 * @since 1.0
 */
class Modul extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\efenbi\controllers';

    public function init()
    {
        parent::init();        
		\Yii::$app->user->enableSession = false;
    }
}
