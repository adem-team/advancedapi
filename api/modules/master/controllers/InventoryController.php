<?php

namespace api\modules\master\controllers;

use yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use api\modules\master\models\Gambarkunjungan;
use yii\web\HttpException;
use yii\data\ArrayDataProvider;
use yii\db\Query;

//use yii\data\ActiveDataProvider;
/**
 * Country Controller API
 *
 * @author -ptr.nov-
 */
class InventoryController extends ActiveController
{
    public $modelClass = 'api\modules\master\models\Gambarkunjungan';
	//public $serializer = [
		// 'class' => 'yii\rest\Serializer',
		//'collectionEnvelope' => 'Gambarkunjungan',
	// ];
	  
    public function behaviors()    
    {
        return ArrayHelper::merge(parent::behaviors(), 
        [
            'authenticator' => 
            [
                'class' => CompositeAuth::className(),
                'authMethods' => 
                [
                    #Hapus Tanda Komentar Untuk Autentifikasi Dengan Token               
                   // ['class' => HttpBearerAuth::className()],
                   // ['class' => QueryParamAuth::className(), 'tokenParam' => 'access-token'],
                ]
            ],

			'bootstrap'=> 
            [
				'class' => ContentNegotiator::className(),
				'formats' => 
                [
					'application/json' => Response::FORMAT_JSON,
				],
			],
            //'exceptionFilter' => [
            //    'class' => ErrorToExceptionFilter::className()            ],
            'corsFilter' => [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                    // restrict access to
                    'Origin' =>['*'],// ['http://ptrnov-erp.dev', 'https://ptrnov-erp.dev'],
                    'Access-Control-Request-Method' => ['GET','POST', 'PUT'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],

            ],
        ]);
    }

	public function actions()
	 {
		 $actions = parent::actions();
		unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 //unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 return $actions;
	 }
	
    public function actionIndex(){
		
		$request = Yii::$app->request;
		$cus_id=$request->get("cus_id");
		/*#'STOCK','2016-01-23','O041','EF001','5','ANDROID_LAY','admin'*/
		//$cmd=Yii::$app->db3->createCommand("CALL ESM_SALES_IMPORT_LIVE_create('STOCK','2016-01-23','O041','EF001','5','ANDROID LAY','admin')")->queryAll(); 
		$cmd=Yii::$app->db3->createCommand("CALL ESM_SALES_IMPORT_LIVE_create('STOCK','2016-01-23','".$cus_id."','EF001','5','ANDROID LAY','admin')")->queryAll(); 
		$cmd->execute();		
	}
    
}


