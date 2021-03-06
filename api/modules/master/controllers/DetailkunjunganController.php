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
use api\modules\master\models\Detailkunjunganx;
use yii\web\HttpException;

//use yii\data\ActiveDataProvider;
/**
 * Country Controller API
 *
 * @author -ptr.nov-
 */
class DetailkunjunganController extends ActiveController
{
    public $modelClass = 'api\modules\master\models\Detailkunjunganx';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'DetailKunjungan',
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
                    'Access-Control-Max-Age' => 0,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],

            ],
        ]);
    }

    public function actionSearch()
    {
		
        $tgl        = $_GET['TGL'];
        $userid     = $_GET['USER_ID'];
        $schlgroup  = $_GET['SCDL_GROUP'];

        if (!empty($_GET)) 
        {
            $model = new $this->modelClass;
            foreach ($_GET as $key => $value) 
            {

                if (!$model->hasAttribute($key)) 
                {
                    return new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
                }
            }
            try 
            {
               $data_view=Yii::$app->db3->createCommand("CALL MOBILE_CUSTOMER_VISIT_inventory_list('".$tgl."','".$userid."','".$schlgroup."')")->queryAll(); 
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
                return new \yii\web\HttpException(500, 'Internal server error');
            }

            if ($provider->getCount() <= 0) 
            {
                return new \yii\web\HttpException(404, 'No entries found with this query string');
            } 
            else 
            {
                return $provider;
            }
        } 
        else 
        {
            return new \yii\web\HttpException(400, 'There are no query string');
        }
    }
}


