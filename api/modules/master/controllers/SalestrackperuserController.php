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
use api\modules\master\models\Detailkunjungan;
use yii\web\HttpException;
use yii\data\ArrayDataProvider;
use yii\db\Query;

//use yii\data\ActiveDataProvider;
/**
 * Country Controller API
 *
 * @author -ptr.nov-
 */
class SalestrackperuserController extends ActiveController
{
    public $modelClass = 'api\modules\master\models\Detailkunjungan';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'SalesTrackPerUser',
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
                    'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
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

    public function actionSearch()
    {
        

        $tgl        = $_GET['TGL'];
        $sales      = $_GET['USER_ID'];

       // $data_view=Yii::$app->db3->createCommand("CALL MOBILE_CUSTOMER_VISIT_sales_track_per_user('".$tgl."','".$sales."')")->queryAll();  

        $data_view    = Yii::$app->db3
                                ->createCommand('SELECT A.ID AS ID_SCDLDETAIL,A.USER_ID,x3.NM_FIRST,x2.CUST_KD,x2.CUST_NM,A.CHECKIN_TIME,A.CHECKOUT_TIME FROM c0002scdl_detail A
                                                    INNER JOIN c0001 x2 on A.CUST_ID = x2.CUST_KD
                                                    INNER JOIN dbm_086.user_profile x3 on A.USER_ID = x3.ID_USER
                                                    WHERE A.TGL= "'.$tgl.'" AND A.USER_ID = '.$sales.' AND A.STATUS <> 3')
                                ->queryAll();

        $provider= new ArrayDataProvider([
        'allModels'=>$data_view,
         'pagination' => [
            'pageSize' => 1000,
            ]
        ]);

        return $provider;

    }
}


