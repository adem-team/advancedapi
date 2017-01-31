<?php

namespace api\modules\master\controllers;

use yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use common\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use api\modules\master\models\Roadsalesheader;
use yii\web\HttpException;

//use yii\data\ActiveDataProvider;
/**
 * Country Controller API
 *
 * @author -ptr.nov-
 */
class RoadsalesheaderController extends ActiveController
{
    public $modelClass = 'api\modules\master\models\Roadsalesheader';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'Roadsalesheader',
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

    #http://stackoverflow.com/questions/25522462/yii2-rest-query
    public function actionSearch()
    {
        if (!empty($_GET)) 
        {
            $TGLSTART   = $_GET['TGLSTART'];
            $TGLEND     = $_GET['TGLEND'];
            $f_date     = date('Y-m-d H:i:s', strtotime($TGLSTART));
            $l_date     = date('Y-m-d 23:59:59', strtotime($TGLEND));

            if(isset($_GET['USER_ID']))
            {
                $USERID     = $_GET['USER_ID'];
                $data_view=Yii::$app->db3
                                ->createCommand("SELECT * FROM c0022Header header WHERE header.CREATED_AT >=:TGL_FIRST AND header.CREATED_AT <=:TGL_LAST AND header.USER_ID =:USER_ID ORDER BY header.CREATED_AT DESC")
                                ->bindValue(':TGL_FIRST', $f_date)
                                ->bindValue(':TGL_LAST', $l_date)
                                ->bindValue(':USER_ID', $USERID)
                                ->queryAll();  
                $provider= new ArrayDataProvider(['allModels'=>$data_view,'pagination' => ['pageSize' => 1000,]]); 
            }
            else
            {
                $data_view=Yii::$app->db3
                                ->createCommand("   SELECT header.*,users.username FROM c0022Header header
                                                    INNER JOIN dbm001.user users
                                                    ON header.USER_ID = users.id 
                                                    WHERE header.CREATED_AT >=:TGL_FIRST AND 
                                                    header.CREATED_AT <=:TGL_LAST ORDER BY header.CREATED_AT DESC
                                                ")
                                ->bindValue(':TGL_FIRST', $f_date)
                                ->bindValue(':TGL_LAST', $l_date)
                                ->queryAll();  
                $provider= new ArrayDataProvider(['allModels'=>$data_view,'pagination' => ['pageSize' => 1000,]]);   
            }
            

            return $provider;

        } 
        else 
        {
            return new \yii\web\HttpException(400, 'There are no query string');
        }
    }
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }
    
    public function actionCreate()
    {
        $params = $_REQUEST;
        $tanggal = new \Datetime('now');
        $model              = new Roadsalesheader();
        $model->attributes  = $params;
        $model->TGL         = $tanggal->format('Y-m-d');
        
        if ($model->save()) 
        {
            return $model->attributes;
        } 
        else
        {
            return array('errors'=>$model->errors);
        }
    }
}


