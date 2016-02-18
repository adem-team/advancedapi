<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Country Controller API
 *
 * @author -ptr.nov- 
 */
class CityController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Country'; 
	
	/*Author by  -ptr.nov-  Output Json, disable XML*/

	public function behaviors()
    {
        $behaviors = parent::behaviors();
       
        $behaviors['bootstrap'] = [
            'class' => ContentNegotiator::className(),
			'formats' => [
				'application/json' => Response::FORMAT_JSON,
			],
		];  
        return $behaviors;  
    }

}


