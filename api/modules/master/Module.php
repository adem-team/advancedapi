<?php
namespace api\modules\master;

/**
 * 
 * @author -ptr.nov- 
 * @since 1.0
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\master\controllers';

    public function init()
    {
        parent::init();        
		//\Yii::$app->user->enableSession = false;
    }
	
}
