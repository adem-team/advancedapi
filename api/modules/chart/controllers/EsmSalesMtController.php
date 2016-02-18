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
class EsmSalesMtController extends ActiveController
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
 	 * ESM Sales Summary
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function sales_summay(){		
		return Rpt001::find()->where("MODUL_NM='ESM_SALES_SUMMARY' and MODUL_GRP=8")->one()->VAL_VALUE;
	}		
	
	/**
	 * Chart Type column2d - ESM_SALES_MT_PER_ITEM
	 * DAILY - All Sell-Out per Item
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function sales_mt_item(){		
		return Rpt001::find()->where("MODUL_NM='ESM_SALES_MT_PER_ITEM' and MODUL_GRP=8")->one()->VAL_VALUE;
	}
	/*ESM column2d HEADER*/
	protected function sales_header_column2d_mt(){
		$myHeaderColumn2d_mt = '
			"SalesItem_Mt":{
				"chart": {
					"caption": "MT Customer",
					"subcaption": "Daily Actual Total Stock sell-out",
					"subcaptionFontSize": "14",
					"subcaptionFontBold": "0",
					"numberPrefix": "",
					"yaxismaxvalue": "900000",
					"placeValuesInside": "1",
					"valueFontColor": "#ffffff",
					"usePlotGradientColor": "0",
					"showAxisLines": "1",
					"axisLineAlpha": "25",
					"divLineAlpha": "10",
					"bgColor": "#ffffff",
					"showBorder": "1",					
					"showCanvasBorder": "0",
					"alignCaptionWithCanvas": "0",
					"showAlternateVGridColor": "0",
					"toolTipColor": "#ffffff",
					"toolTipBorderThickness": "0",
					"toolTipBgColor": "#000000",
					"toolTipBgAlpha": "80",
					"toolTipBorderRadius": "2",
					"toolTipPadding": "5"
					
				},							
				"data": '.$this->sales_mt_item() .'
			}
		';		
		return $myHeaderColumn2d_mt; 
	}
	
	/**
	 * Chart Type column2d - ESM_SALES_GT_PER_ITEM
	 * DAILY - All Sell-Out per Item
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function sales_gt_item(){		
		return Rpt001::find()->where("MODUL_NM='ESM_SALES_GT_PER_ITEM' and MODUL_GRP=8")->one()->VAL_VALUE;
	}
	/*ESM column2d HEADER*/
	protected function sales_header_column2d_gt(){
		$myHeaderColumn2d_gt = '
			"SalesItem_Gt":{
				"chart": {
					"caption": "GT Customer",
					"subcaption": "Daily Actual Total Stock sell-out",
					"numberPrefix": "",
					"yaxismaxvalue": "900000",
					"placeValuesInside": "1",
					"valueFontColor": "#ffffff",
					"usePlotGradientColor": "0",
					"showAxisLines": "1",
					"axisLineAlpha": "25",
					"divLineAlpha": "10",
					"bgColor": "#ffffff",
					"showBorder": "1",					
					"showCanvasBorder": "0",
					"alignCaptionWithCanvas": "0",
					"showAlternateVGridColor": "0",
					"toolTipColor": "#ffffff",
					"toolTipBorderThickness": "0",
					"toolTipBgColor": "#000000",
					"toolTipBgAlpha": "80",
					"toolTipBorderRadius": "2",
					"toolTipPadding": "5"
				},							
				"data": '.$this->sales_gt_item() .'
			}
		';		
		return $myHeaderColumn2d_gt; 
	}
	
	/**
	 * Chart Type column2d - ESM_SALES_HORECA_PER_ITEM
	 * DAILY - All Sell-Out per Item
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function sales_horeca_item(){		
		return Rpt001::find()->where("MODUL_NM='ESM_SALES_HORECA_PER_ITEM' and MODUL_GRP=8")->one()->VAL_VALUE;
	}
	/*ESM column2d HEADER*/
	protected function sales_header_column2d_horeca(){
		$myHeaderColumn2d_horeca = '
			"SalesItem_Horeca":{
				"chart": {
					"caption": "Horeca Customer",
					"subcaption": "Daily Actual Total Stock sell-out",
					"numberPrefix": "",
					"yaxismaxvalue": "900000",
					"placeValuesInside": "1",
					"valueFontColor": "#ffffff",
					"usePlotGradientColor": "0",
					"showAxisLines": "1",
					"axisLineAlpha": "25",
					"divLineAlpha": "10",
					"bgColor": "#ffffff",
					"showBorder": "1",					
					"showCanvasBorder": "0",
					"alignCaptionWithCanvas": "0",
					"showAlternateVGridColor": "0",
					"toolTipColor": "#ffffff",
					"toolTipBorderThickness": "0",
					"toolTipBgColor": "#000000",
					"toolTipBgAlpha": "80",
					"toolTipBorderRadius": "2",
					"toolTipPadding": "5"
				},							
				"data": '.$this->sales_horeca_item() .'
			}
		';		
		return $myHeaderColumn2d_horeca; 
	}
	
	/**
	 * Chart Type column2d - ESM_SALES_OTHERS_PER_ITEM
	 * DAILY - All Sell-Out per Item
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function sales_others_item(){		
		return Rpt001::find()->where("MODUL_NM='ESM_SALES_OTHER_PER_ITEM' and MODUL_GRP=8")->one()->VAL_VALUE;
	}
	/*ESM column2d HEADER*/
	protected function sales_header_column2d_others(){
		$myHeaderColumn2d_others = '
			"SalesItem_Others":{
				"chart": {
					"caption": "Others Customer",
					"subcaption": "Daily Actual Total Stock sell-out",
					"numberPrefix": "",
					"yaxismaxvalue": "900000",
					"placeValuesInside": "1",
					"valueFontColor": "#ffffff",
					"usePlotGradientColor": "0",
					"showAxisLines": "1",
					"axisLineAlpha": "25",
					"divLineAlpha": "10",
					"bgColor": "#ffffff",
					"showBorder": "1",					
					"showCanvasBorder": "0",
					"alignCaptionWithCanvas": "0",
					"showAlternateVGridColor": "0",
					"toolTipColor": "#ffffff",
					"toolTipBorderThickness": "0",
					"toolTipBgColor": "#000000",
					"toolTipBgAlpha": "80",
					"toolTipBorderRadius": "2",
					"toolTipPadding": "5"
				},							
				"data": '.$this->sales_others_item() .'
			}
		';		
		return $myHeaderColumn2d_others; 
	}
	
	/**
     * attrs_chart, Header Chart Json Object, foreach object pertama
	 * Chart Type column2d - support_header_attrs
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function support_header_attrs(){
		$attrs_support='
			"support_attrs": 
				{
					"caption": "Employee Turnover : Support ",
					"numberprefix": "",
					"plotgradientcolor": "",
					"bgcolor": "FFFFFF",
					"showalternatehgridcolor": "0",
					"divlinecolor": "CCCCCC",
					"showvalues": "0",
					"showcanvasborder": "0",
					"canvasborderalpha": "0",
					"canvasbordercolor": "CCCCCC",
					"canvasborderthickness": "1",
					"yaxismaxvalue": "200",
					"captionpadding": "30",
					"linethickness": "3",
					"yaxisvaluespadding": "15",
					"legendshadow": "0",
					"legendborderalpha": "0",
					"palettecolors": "#6baa01,#33bdda,#e44a00,#6baa01,#583e78",
					"showborder": "1"
				}
			
		';
		return $attrs_support;
	}
	
	/**
     * Categoies, Header Chart Json Object, foreach object pertama
	 * Chart Type column2d - support_header_category
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function support_header_category(){
		$ctg_support='
			"support_catg":[{
				"category": [{"label": "jan"},{"label": "feb"},{"label": "mar"},{"label": "apr"},{"label": "mei"},{"label": "jun"},{"label": "jul"},{"label": "ags"},{"label": "sep"},{"label": "okt"},{"label": "nov"},{"label": "Des"}]
			}]
		';
		return $ctg_support;
	}
	
	/**
     * Vaues chart,from database
	 * Chart Type column2d - support_dataset
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function support_dataset(){
		/**
		   * MODUL_NM ='HRM_PERSONALIA_TURNOVER_SUPPORT'
		   * Group [1 = HRM_PERSONALIA]
		 */
		 return Rpt001::find()->where("MODUL_NM='HRM_PERSONALIA_TURNOVER_SUPPORT' and MODUL_GRP=1")->one()->VAL_VALUE;
	}
	
	/**
	 * ESM Warehouse - COMBINASI FUNCTION BUILD JSON
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	 */
	protected function esm_sales() 
	{
		 $json_esmsales='{'
			.$this->sales_header_column2d_mt().
			','.$this->sales_header_column2d_gt().			
			','.$this->sales_header_column2d_horeca().			
			','.$this->sales_header_column2d_others().			
			','.$this->sales_summay().
			','.$this->support_header_attrs().
			','.$this->support_header_category().
			','.$this->support_dataset().					
		'}';	 
		return Json::decode($json_esmsales);
	}

	/**
	  * getUrl: http://api.lukisongroup.int/chart/hrmpersonalias
	  * index - COMBINASI FUNCTION BUILD JSON
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
	public function actionIndex()
     {		
		return $this->esm_sales();	
     }
	 
}

