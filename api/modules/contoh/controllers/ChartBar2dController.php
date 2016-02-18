<?php

namespace api\modules\contoh\controllers;

use yii;
use kartik\datecontrol\Module;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;

//use common\models\User;
use api\modules\sistem\models\UserloginSearch;
use api\modules\contoh\models\Rpt001;


/**
  * Controller HRM Personalia Class  
  *
  * @author ptrnov  <piter@lukison.com>
  * @since 1.1
  * @link http://api.lukisongroup.int/contoh/hrmpersonalias
  * @see https://github.com/C12D/advanced/blob/master/api/modules/contoh/controllers/PilotpController.php
 */
class ChartBar2dController extends ActiveController
{	
	/**
	  * Source Database declaration 
	 */
    public $modelClass = 'api\modules\contoh\models\Rpt001';
	/* public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'Personalia',
	]; */
	
	/**
     * @inheritdoc
     */
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            /* 'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                 ['class' => HttpBearerAuth::className()],
                 ['class' => QueryParamAuth::className()],//, 'tokenParam' => 'access-token'],
                ]
            ], */
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
					/**
					  * Block/Allow Origin | Autorization Network Scope Coverage
					  * @author ptrnov  <piter@lukison.com>
					  * @since 1.1
					 */
					// restrict access to
					//'Origin' => ['http://lukisongroup.com','http://www.lukisongroup.com', 'http://lukisongroup.int'],
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
	
	/**
     * @inheritdoc
     */
	public function actions()
	 {
		 $actions = parent::actions();
		unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 //unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 return $actions;
	 }
		
	
	/**
	 * contoh Type column2d - ESM_SALES_OTHERS_PER_ITEM
	 * DAILY - All Sell-Out per Item
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function data_bar2d(){		
		return Rpt001::find()->where("MODUL_NM='EX-BAR2D' and MODUL_GRP=10")->one()->VAL_VALUE;
	}
	/*ESM column2d HEADER*/
	protected function chart_bar2d(){
		$mybar2d = '
			"bar2d":['.$this->data_bar2d() .'
			]
		';		
		return $mybar2d; 
	}
	
	/**
	 * ESM Warehouse - COMBINASI FUNCTION BUILD JSON
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	 */
	protected function kombinasi_chart() 
	{
		 $json_esmsales='{'
			.$this->chart_bar2d().		
		'}';	 
		return Json::decode($json_esmsales);
	}

	/**
	  * getUrl: http://api.lukisongroup.int/contoh/hrmpersonalias
	  * index - COMBINASI FUNCTION BUILD JSON
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
	public function actionIndex()
     {		
		return $this->kombinasi_chart();	
     }
	 
}

