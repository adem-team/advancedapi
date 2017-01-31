<?php

namespace api\modules\chart\controllers;

use yii;
use kartik\datecontrol\Module;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
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
use api\modules\sistem\models\UserloginSearch;
use api\modules\master\models\Salesmanabsensi;
use yii\data\ArrayDataProvider;

/**
  * Controller HRM Personalia Class  
  *
  * @author ptrnov  <piter@lukison.com>
  * @since 1.1
  * @link http://api.lukisongroup.int/chart/hrmpersonalias
  * @see https://github.com/C12D/advanced/blob/master/api/modules/chart/controllers/PilotpController.php
 */
class EsmsalescontrolabsensiController extends ActiveController
{	
	/**
	  * Source Database declaration 
	 */
    public $modelClass = 'api\modules\master\models\Salesmanabsensi';
    public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'Salesmanabsensi',
	];
    public function behaviors()    
    {
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
        if (!empty($_GET)) 
        {
            $TGL 	= $_GET['TGL'];
            $data_view    = Yii::$app->db3
                            ->createCommand('SELECT users.id AS USER_ID,users.username as USERNAME,sales_profile.NM_FIRST,ab.WAKTU_MASUK,ab.WAKTU_KELUAR 
                            				 FROM dbm001.user users 
											 INNER JOIN dbm_086.user_profile sales_profile
											 ON users.id = sales_profile.ID_USER
											 INNER JOIN dbc002.c0015 ab
											 ON users.id = ab.USER_ID
											 WHERE users.POSITION_LOGIN = 1 AND ab.TGL = "'.$TGL.'" AND users.USER_ALIAS IS NOT NULL AND users.ID NOT IN(61,62)
                                            ')
                            ->queryAll();
        	$provider= new ArrayDataProvider(['allModels'=>$data_view,'pagination' => ['pageSize' => 1000,]]);
        	return $provider;
    	}
    }

}

