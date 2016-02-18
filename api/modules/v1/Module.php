<?php
namespace api\modules\v1;

/**
 * 
 * @author -ptr.nov- 
 * @since 1.0
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function init()
    {
        parent::init();        
		//\Yii::$app->user->enableSession = false;
    }
	
}
