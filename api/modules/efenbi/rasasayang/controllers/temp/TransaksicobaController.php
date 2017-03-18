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
use yii\web\Request;

use api\modules\efenbi\rasasayang\models\Transaksi;
use api\modules\efenbi\rasasayang\models\TransaksiSearch;

/**
 * TransaksiController implements the CRUD actions for Transaksi model.
 */
class TransaksicobaController extends ActiveController
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
                    'application/xml' => Response::FORMAT_XML,'charset' => 'UTF-8',
                ],
                'languages' => [
                    'en',
                    'de',
                ],
            ],          
			// 'request' => [
				// 'parsers' => [
					// 'application/json' => 'yii\web\JsonParser',
				// ]
			// ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                     // Allow only POST and PUT methods
                     'Access-Control-Request-Headers' => ['X-Wsse'],
                    //'Access-Control-Request-Headers' => ['X-Requested-With', 'Content-Type', 'accept', 'Authorization'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    //'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],  

                ]       
            ],
        ]);
        
    }
    
    public function actions()
    {       
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => function () {                    
                    $param=["TransaksiSearch"=>Yii::$app->request->queryParams];
                    //return $param["TransaksiSearch"]["TRANS_TYPE"];
                    $searchModel = new TransaksiSearch();
					return $searchModel->search($param);
                },
            ],
        ];
    } 

    /**
     * Lists all Transaksi models.
     * @return mixed
     */
    // public function actionIndex()
    // {
        // $searchModel = new TransaksiSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
        // ]);
    // }

    /**
     * Displays a single Transaksi model.
     * @param integer $id
     * @return mixed
     */
    // public function actionView($id)
    // {
        // return $this->render('view', [
            // 'model' => $this->findModel($id),
        // ]);
    // }
     // public function actions()
    // {
        // $actions = parent::actions();
        // unset($actions['create']);
        // return $actions;
    // } 
    /**
     * Creates a new Transaksi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //README -ptr.nov-
		//Header Form 	: 	Content-Type application/json
		//get request	:	Yii::$app->request->post();   
		//return $params;
		//return $params[0];
		//return $params[0]['name'];
		//order json object...
		//return $params['data'];
		//=====================================================
       	//$model      = new Transaksi();
		
		$params    = Yii::$app->request->post();  
		parse_str($params, $output);
		/* foreach($params as $key => $val){
			$model      = new Transaksi(); 
			$model->attributes=$val;
			//$model->TRANS_ID =$code;
			$model->save();
		} */
		//$code='';
		//$rsltMsg="no-Action";
		/* if($params){
			if($params['TYPE']!=4){ 
				//if($params['TRANS_DATE']!=date("Y-m-d")){ 
				if($params['TGL']!=date("Y-m-d")){ 
					$rsltMsg="date not mactch";
				}else{
					//POST BOOKING=1|BUY=2|RECEVED=3
					$code=$params['TYPE'].".".$params['STORE_ID'].".".str_replace("-","",$params['TGL']);
					//Delete All
					$models = Transaksi::find()->where(['TRANS_ID'=>$code])->All();
					foreach($models as $model) {
						$model->delete();
					}
					//Save & replace All.				
					if(is_array($params['data'])){
						foreach($params['data'] as $key => $val){
							$model      = new Transaksi(); 
							//$xxs[]=$val['ITEM_QTY'];
							$model->attributes=$val;
							$model->TRANS_ID =$code;
							$model->save();
						}
					}
					$rsltMsg="successful";				
				}
			}elseif($params['TYPE']==4){
				//POST Data SELL=4.
				if(is_array($params['data'])){
					foreach($params['data'] as $key1 => $val1){
						$model      = new Transaksi();
						$model->attributes=$val1;
						$model->save();
					}
					$rsltMsg="successful";	
				}	
			}
		}  */
		//return $model->attributes;
		//return ["handling"=>$rsltMsg];
		return $output;
	}	
}
