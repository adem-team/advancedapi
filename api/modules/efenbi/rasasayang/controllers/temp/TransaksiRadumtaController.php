<?php

namespace api\modules\efenbi\rasasayang\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\helpers\ArrayHelper;

use api\modules\efenbi\rasasayang\models\Transaksi;
use api\modules\efenbi\rasasayang\models\TransaksiSearch;

/**
 * TransaksiController implements the CRUD actions for Transaksi model.
 */
class TransaksiController extends ActiveController
{
    /**
	  * Source Database declaration 
	 */
    public $modelClass = 'api\modules\efenbi\rasasayang\models\TransaksiSearch';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'transaksi',
	]; 
	
	/**
     * @inheritdoc
     */
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                 // ['class' => HttpBearerAuth::className()],
                 // ['class' => QueryParamAuth::className()],//, 'tokenParam' => 'access-token'],
                ]
            ], 
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
					// restrict access to
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
	

    public function actions()
     {
         $actions = parent::actions();
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
         //unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
         return $actions;
     }

    public function actionIndex()
    {
        // $data = '[{"nama":"Radumta"},{"nama":"Indonesia"}]';
        $data = "[{'nama':'Radumta'},{'nama':'Indonesia'}]";
        $datas = json_decode($data,true);
        foreach ($datas as $key => $value) 
        {
            print_r($value['nama']);echo ' ';
        }
    }
    public function actionCreate()
    {
        $post = Yii::$app->request->post();
        return $post['rara'];
    }
}
