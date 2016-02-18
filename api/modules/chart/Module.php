<?php
namespace api\modules\chart;
use Yii;
use yii\helpers\Inflector;
/**
 * 
 * @author -ptr.nov- 
 * @since 1.0
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\chart\controllers';

    public function init()
    {
        parent::init();        
		\Yii::$app->user->enableSession = false;
    }
	
}
