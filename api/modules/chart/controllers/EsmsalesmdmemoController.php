<?php

namespace api\modules\chart\controllers;

use yii;
use kartik\datecontrol\Module;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\HttpException;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;

//use common\models\User;

use api\modules\chart\models\Esmsalesmdmemo;


/**
  * Controller HRM Personalia Class  
  *
  * @author ptrnov  <piter@lukison.com>
  * @since 1.1
  * @link http://api.lukisongroup.int/chart/hrmpersonalias
  * @see https://github.com/C12D/advanced/blob/master/api/modules/chart/controllers/PilotpController.php
 */
class EsmsalesmdmemoController extends ActiveController
{	
	/**
	  * Source Database declaration 
	 */
    public $modelClass = 'api\modules\chart\models\Esmsalesmdmemo';
	 public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'Salesmemo',
	]; 
	
	/**
     * @inheritdoc
     */
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            /* 'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                 ['class' => HttpBearerAuth::className()],
                 ['class' => QueryParamAuth::className()],//, 'tokenParam' => 'access-token'],
                ]
            ], */
			'bootstrap'=> [
				'class' => ContentNegotiator::className(),
				'formats' => [
					'application/json' => Response::FORMAT_JSON,'charset' => 'UTF-8',
				], 
				'languages' => [
					'en',
					'de',
				],
			],			
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
				'cors' => [
					/**
					  * Block/Allow Origin | Autorization Network Scope Coverage
					  * @author ptrnov  <piter@lukison.com>
					  * @since 1.1
					 */
					// restrict access to
					//'Origin' => ['http://lukisongroup.com','http://www.lukisongroup.com', 'http://lukisongroup.int'],
					'Origin' => ['*'],
					'Access-Control-Request-Method' => ['POST', 'PUT','GET'],
					// Allow only POST and PUT methods
					'Access-Control-Request-Headers' => ['X-Wsse'],
					// Allow only headers 'X-Wsse'
					'Access-Control-Allow-Credentials' => true,
					// Allow OPTIONS caching
					'Access-Control-Max-Age' => 3600,
					// Allow the X-Pagination-Current-Page header to be exposed to the browser.
					'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
				]		
			],
        ]);
		
    }
    public function actionSearch()
    {
        $query_date = $_GET['TGL'];
        $f_date     = date('Y-m-01', strtotime($query_date));
        $l_date     = date('Y-m-t', strtotime($query_date));
        $data_view=Yii::$app->db3
                                ->createCommand("SELECT ba.NM_USER,users.NM_FIRST,ba.NM_CUSTOMER,ba.CREATE_AT,ba.ISI_MESSAGES,users.IMG_BASE64
                                FROM dbc002.c0014 ba  
                                INNER JOIN dbm_086.user_profile users on ba.CREATE_BY = users.ID_USER WHERE ba.TGL >=:TGL_FIRST and ba.TGL <=:TGL_LAST ORDER BY ba.ID ASC")
                                ->bindValue(':TGL_FIRST', $f_date)
                                ->bindValue(':TGL_LAST', $l_date)
                                ->queryAll();  
        $provider= new ArrayDataProvider(['allModels'=>$data_view,'pagination' => ['pageSize' => 1000,]]);

        return $provider;
    }
}

