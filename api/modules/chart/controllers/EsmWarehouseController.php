<?php

namespace api\modules\chart\controllers;

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
use api\modules\chart\models\Rpt001;


/**
  * Controller HRM Personalia Class  
  *
  * @author ptrnov  <piter@lukison.com>
  * @since 1.1
  * @link http://api.lukisongroup.int/chart/hrmpersonalias
  * @see https://github.com/C12D/advanced/blob/master/api/modules/chart/controllers/PilotpController.php
 */
class EsmWarehouseController extends ActiveController
{	
	/**
	  * Source Database declaration 
	 */
    public $modelClass = 'api\modules\chart\models\Cnfweek';
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
 	 * ESM Warehouse Summary
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function wh_summay()
	{		
		return Rpt001::find()->where("MODUL_NM='ESM_WAREHOUSE_SUMMARY' and MODUL_GRP=7")->one()->VAL_VALUE;
	}		
	
	/**
	 * Chart Type column2d - FACTORY_PER_ITEM
	 * DAILY - All Stock Factory per Item
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function wh_factory_item()
	{		
		return Rpt001::find()->where("MODUL_NM='ESM_WAREHOUSE_FACTORY_PER_ITEM' and MODUL_GRP=7")->one()->VAL_VALUE;
	}
	/*ESM PIE HEADER*/
	protected function wh_header_column2d_factory()
	{
		$myHeaderColumn2d_factory = '
			"WhFactoryItem":{
				"chart": {
					"caption": "Factory Warehouse",
					"subcaption": "Daily Actual Total Stock Items",
					"numberPrefix": "",
					"yaxismaxvalue": "900000",
					"theme": "ocean"
				},							
				"data": '.$this->wh_factory_item() .'
			}
		';		
		return $myHeaderColumn2d_factory; 
	}
	
	/**
	 * Chart Type column2d - DISTRIBUTOR_PER_ITEM
	 * DAILY - All Stock Distributor per Item
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function wh_distributor_item()
	{		
		return Rpt001::find()->where("MODUL_NM='ESM_WAREHOUSE_DISTRIBUTOR_PER_ITEM' and MODUL_GRP=7")->one()->VAL_VALUE;
	}
	
	/*ESM PIE HEADER*/
	protected function wh_header_column2d_distributor()
	{
		$myHeaderColumn2d_distributor= '
			"WhDistributorItem":{
				"chart": {
					"caption": "Distributor Warehouse",
					"subcaption": "Daily Actual Total Stock Items",
					"numberPrefix": "",
					"yaxismaxvalue": "900000",
					"theme": "ocean"
				},							
				"data": '.$this->wh_distributor_item() .'
			}
		';		
		return $myHeaderColumn2d_distributor; 
	}
	
	/**
	 * Chart Type column2d - SUBDIST_PER_ITEM
	 * DAILY - All Stock subdist per Item
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function wh_subdist_item()
	{		
		return Rpt001::find()->where("MODUL_NM='ESM_WAREHOUSE_SUBDIST_PER_ITEM' and MODUL_GRP=7")->one()->VAL_VALUE;
	}

	/*ESM PIE HEADER*/
	protected function wh_header_column2d_subdist()
	{
		$myHeaderColumn2d_subdist= '
			"WhSubdistItem":{
				"chart": {
					"caption": "Subdisk Warehouse",
					"subcaption": "Daily Actual Total Stock Items",
					"numberPrefix": "",
					"yaxismaxvalue": "900000",
					"theme": "ocean"
				},							
				"data": '.$this->wh_subdist_item() .'
			}
		';		
		return $myHeaderColumn2d_subdist; 
	}
	
	/**
	 * Chart Type column2d - CUSTOMER_PER_ITEM
	 * DAILY - All Stock customer per Item
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function wh_customer_item()
	{		
		return Rpt001::find()->where("MODUL_NM='ESM_WAREHOUSE_CUSTOMER_PER_ITEM' and MODUL_GRP=7")->one()->VAL_VALUE;
	}

	/*ESM PIE HEADER*/
	protected function wh_header_column2d_customer()
	{
		$myHeaderColumn2d_subdist= '
			"WhCustomerItem":{
				"chart": {
					"caption": "Customer Warehouse",
					"subcaption": "Daily Actual Total Stock Items",
					"numberPrefix": "",
					"yaxismaxvalue": "900000",
					"theme": "ocean"
				},							
				"data": '.$this->wh_customer_item() .'
			}
		';		
		return $myHeaderColumn2d_subdist; 
	}

	/**
	 * ESM Warehouse - COMBINASI FUNCTION BUILD JSON
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	 */
	protected function esm_warehouse() 
	{
		 $json_esmwarehouse='{'
			.$this->wh_header_column2d_factory().
			','.$this->wh_header_column2d_distributor().
			','.$this->wh_header_column2d_subdist().	
			','.$this->wh_header_column2d_customer().				
			','.$this->wh_summay().			
		'}';	 
		return Json::decode($json_esmwarehouse);
	}

	/**
	  * getUrl: http://api.lukisongroup.int/chart/hrmpersonalias
	  * index - COMBINASI FUNCTION BUILD JSON
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
	public function actionIndex()
     {		
		return $this->esm_warehouse();	
     }
	 
}

