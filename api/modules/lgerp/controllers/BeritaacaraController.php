<?php

namespace api\modules\lgerp\controllers;
use yii;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use api\modules\lgerp\models\BeritaAcara;
/**
 * Country Controller API
 *
 * @author -ptr.nov-
 */
class BeritaacaraController extends ActiveController
{
    public $modelClass = 'api\modules\lgerp\models\BeritaAcara';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'BeritaAcara',
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
                    // restrict access to
                    'Origin' =>['*','http://localhost:8100'],// ['http://ptrnov-erp.dev', 'https://ptrnov-erp.dev'],
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
                $provider = new ActiveDataProvider(array('query' => $model->find()->where($_GET),'pagination' => false));

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
    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }
    public function actionIndex()
    {
        $command    = Yii::$app->dev_db_widget
                                ->createCommand('SELECT ba.KD_BERITA,ba.JUDUL,ba.ISI,CONCAT( users.EMP_NM,users.EMP_NM_BLK)AS CREATE_NM,users.IMG_BASE64 FROM dev_dbm005.bt0001 ba 
                                                INNER JOIN dbm002.a0001 users on ba.CREATED_BY = users.EMP_ID')
                                ->queryAll();
        return (array('BeritaAcara' =>$command));
        // $model                          = new $this->modelClass;
        // $provider                       = new ActiveDataProvider(array('query' => $model->find(),'pagination' => array('pageSize' => 20)));
        // $posts                          = $provider->getModels();

        // $querywithoutar                 = new Query();
        // $providerwithoutActiveRecord    = new ActiveDataProvider(['query' => $querywithoutar->from('dev_dbm005.bt0001'),'pagination' => ['pageSize' => 20]]);
        // $resultwithoutar                = $providerwithoutActiveRecord->getModels();

        // $queryarrayprovider             = new Query;
        // $arrayprovider                  = new ArrayDataProvider(['allModels' => $queryarrayprovider->from('dev_dbm005.bt0001')->all(),'sort' => ['attributes' => ['id', 'username', 'email']],'pagination' => ['pageSize' => 10]]);
        // $resultarrayprovider            = $arrayprovider->getModels();

        // return (array('BeritaAcara' =>$command,'dataprovider'=>$posts,'dataproviderwithoutar' => $resultwithoutar,'resultarrayprovider' => $resultarrayprovider)); 
         
    }
}


