<?php

namespace api\modules\master\controllers;

use yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use common\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use api\modules\master\models\Productinventory;
use yii\web\HttpException;

//use yii\data\ActiveDataProvider;
/**
 * Country Controller API
 *
 * @author -ptr.nov-
 */
class InventorysummaryController extends ActiveController
{
    public $modelClass = 'api\modules\master\models\Productinventory';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'InventorySummary',
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
        $custid     = $_GET['CUST_KD'];
        $idsalesman = $_GET['USER_ID'];
        
        #'SUMMARY_CUST','2016-04-03','CUS.2016.000001','30',''
        if (!empty($_GET)) 
        {
            $model = new $this->modelClass;
            foreach ($_GET as $key => $value) 
            {

                if (!$model->hasAttribute($key)) 
                {
                    throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
                }
            }
            try 
            {
               //'SUMMARY_CUST','2016-04-03','CUS.2016.000001','30','1'
               //$data_view=Yii::$app->db3->createCommand("CALL MOBILE_CUSTOMER_VISIT_inventory_summary('".$iddetail."',)")->queryAll();
               $data_view=Yii::$app->db3->createCommand("CALL MOBILE_CUSTOMER_VISIT_inventory_summary('SUMMARY_CUST','".$tgl."','".$custid."','".$idsalesman."','')")->queryAll();  
                // $provider = new ActiveDataProvider([
                    // 'query' => $model->find()->where($_GET),
                    // 'pagination' => false
                // ]);
				
				$provider= new ArrayDataProvider([
				'allModels'=>$data_view,
				 'pagination' => [
					'pageSize' => 1000,
					]
				]);
		
            } 
            catch (Exception $ex) 
            {
                throw new \yii\web\HttpException(500, 'Internal server error');
            }

            if ($provider->getCount() <= 0) 
            {
                throw new \yii\web\HttpException(404, 'No entries found with this query string');
            } 
            else 
            {
                return $provider;
            }
        } 
        else 
        {
            throw new \yii\web\HttpException(400, 'There are no query string');
        }
    }
}


