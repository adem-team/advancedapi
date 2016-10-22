<?php

namespace api\modules\lgerp\controllers;
use yii;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth;

use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use api\modules\lgerp\models\PurchaseOrder;

use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\data\SqlDataProvider;

use common\models\User;
use yii\filters\VerbFilter;

/**
 * Country Controller API
 *
 * @author -ptr.nov-
 */
class PurchaseorderController extends ActiveController
{
    public $modelClass = 'api\modules\lgerp\models\PurchaseOrder';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'PurchaseOrder',
	];
	  
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
                    // 'Origin' =>['*','http://10.10.99.3:80','http://localhost:8000','http://localhost:8080','http://localhost:80','http://localhost'],// ['http://ptrnov-erp.dev', 'https://ptrnov-erp.dev'],
                    'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    // Allow only POST and PUT methods
                    // 'Access-Control-Request-Headers' => ['X-Wsse'],
                    'Access-Control-Request-Headers' => ['*'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => null,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],
            ],
        ]);
    }
    /**
     * @inheritdoc
     */
    // public function actions()
    // {
    //     $actions = parent::actions();
    //     unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
    //     return $actions;
    // }
    // public function actionIndex()
    // {
    //     $request = Yii::$app->request->get('nama');
    //     $usersid = Yii::$app->user->getId();
    //     $users = Yii::$app->user->id;
    //     $hasil = '{"PurchaseOrder":{"id":"1","user":"'. $request .'"}}';
    //     return Json::decode($hasil);
        
    // }
    // public function updateIndex()
    // {
    //     $hasil = '{"PurchaseOrder":{"id":"1"}}';
    //     return Json::decode($hasil); 
    // }
    public function actionSearch()
    {
		//if (Yii::$app->user->isGuest or !Yii::$app->user->isGuest ) {
			$data_view=Yii::$app->dev_db3
									->createCommand("SELECT po.KD_PO,po.KD_CORP,corp.NM_ALAMAT as NM_CORP,po.PARENT_PO,po.KD_SUPPLIER,
									sup.NM_SUPPLIER,po.ETD,po.ETA,po.DISCOUNT,
									po.PAJAK,po.BILLING,billing.NM_ALAMAT as BILLING_ADD,po.SHIPPING,
									shipping.NM_ALAMAT as SHIPPING_ADD,
									po.DELIVERY_COST,po.TOP_TYPE,po.TOP_DURATION,po.NOTE,po.STATUS,
									po.CREATE_AT,po.CREATE_BY,CONCAT( users.EMP_NM,users.EMP_NM_BLK)AS CREATE_NM,users.IMG_BASE64, 
									po.SIG1_ID,po.SIG1_NM,po.SIG1_TGL,po.SIG2_ID,po.SIG2_NM,po.SIG2_TGL,
									po.SIG3_ID,po.SIG3_NM,po.SIG3_TGL,po.SIG4_ID,po.SIG4_NM,po.SIG4_TGL 
                                    FROM dev_dbc002.p0001 po  
									INNER JOIN dev_dbc002.lg1001 corp on po.KD_CORP = corp.CORP 
									INNER JOIN dev_dbc002.s1000 sup on po.KD_SUPPLIER = sup.KD_SUPPLIER
									INNER JOIN dev_dbc002.lg1001 billing on po.BILLING = billing.ID
									INNER JOIN dev_dbc002.lg1001 shipping on po.SHIPPING = shipping.ID
									INNER JOIN dbm002.a0001 users on po.CREATE_BY = users.EMP_ID WHERE po.STATUS=:STATUS ORDER BY po.CREATE_AT DESC")
									->bindValue(':STATUS', $_GET['STATUS'])
									->queryAll();  
			$provider= new ArrayDataProvider(['allModels'=>$data_view,'pagination' => ['pageSize' => 1000,]]);

			return $provider;
		//}
	}
}


