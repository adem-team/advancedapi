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
use api\modules\master\models\Customer;
use api\modules\master\models\Customkategori;
use yii\web\HttpException;

//use yii\data\ActiveDataProvider;
/**
 * Country Controller API
 *
 * @author -ptr.nov-
 */
class CustomerController extends ActiveController
{
    public $modelClass = 'api\modules\master\models\Customer';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Customer',
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

            'corsFilter' => [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                    'Origin' =>['*'],// ['http://ptrnov-erp.dev', 'https://ptrnov-erp.dev'],
                    'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],

            ],
        ]);
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //http://stackoverflow.com/questions/25522462/yii2-rest-query
    public function actionSearch()
    {
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
                $provider = new ActiveDataProvider([
                    'query' => $model->find()->where($_GET),
                    'pagination' => false,'sort'=> ['defaultOrder' => ['CUST_KD'=>SORT_DESC]]
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
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }
    
    public function actionCreate()
    {
        $params = $_REQUEST;

        $lastcustomer       = Yii::$app->db3
                              ->createCommand('SELECT CUST_KD FROM dbc002.c0001 ORDER BY CUST_KD DESC LIMIT 1')
                              ->queryOne();

        $CUST_KD = Yii::$app->ambilkonci->getCustomerKode($lastcustomer['CUST_KD']);

        $model              = new Customer();
        $model->attributes  = $params;
        $model->CUST_KD     = $CUST_KD;
        
        if ($model->save()) 
        {
            $response   = Yii::$app->ambilkonci->sendMessage('NOO',$model->attributes);
            return $model->attributes;
        } 
        else
        {
            return array('errors'=>$model->errors);
        }
    }

    
         
}
