<?php

namespace api\sistem\controllers;

use Yii;
use api\sistem\models\Employe;
use api\sistem\models\EmployeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Country Controller API
 *
 * @author -ptr.nov- 
 */
class EmployeController extends ActiveController
{
    public $modelClass = 'api\modules\sistem\models\Employe'; 
    
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
