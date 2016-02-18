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
class HrmPersonaliaController extends ActiveController
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
     * attrs_chart, Header Chart Json Object, foreach object pertama
	 * Chart Type column2d - bisnis_header_attrs
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function bisnis_header_attrs(){
		$attrs_bisnis='
			"bisnis_attrs": 
				{
					"caption": "Employee Turnover : Bisnis ",
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
		return $attrs_bisnis;
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
     * Categoies, Header Chart Json Object, foreach object pertama
	 * Chart Type column2d - bisnis_header_category
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function bisnis_header_category(){
		$ctg_bisnis='
			"bisnis_catg":[{
				"category": [{"label": "jan"},{"label": "feb"},{"label": "mar"},{"label": "apr"},{"label": "mei"},{"label": "jun"},{"label": "jul"},{"label": "ags"},{"label": "sep"},{"label": "okt"},{"label": "nov"},{"label": "Des"}]
			}]
		';
		return $ctg_bisnis;
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
     * Vaues chart,from database
	 * Chart Type column2d - bisnis_dataset
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function bisnis_dataset(){
		/**
		   * MODUL_NM ='HRM_PERSONALIA_TURNOVER_BISNIS'
		   * Group [1 = HRM_PERSONALIA]
		 */
		 return Rpt001::find()->where("MODUL_NM='HRM_PERSONALIA_TURNOVER_BISNIS'")->one()->VAL_VALUE;
	}
	
	
	/**
	 * Chart Type PIE - PT.Effembi Sukses Makmur
	 * ESM data
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function sss_date_pie(){		
		return Rpt001::find()->where("MODUL_NM='HRM_PERSONALIA_SSS_ALL_SUPPORT_BISNIS'")->one()->VAL_VALUE;
	}
	/*SSS PIE HEADER*/
	protected function sss_header_pie(){
		$myHeaderSourcePie_sss = '
			"SourcePie_sss":{
				"chart": {
					"caption": "PT.Sarana Sinar Surya [Suport & Bisnis] ", 
					"subcaption": "Employee 2015/2016",
					"startingangle": "120",
					"showlabels": "0",
					"showlegend": "1",
					"enablemultislicing": "0",
					"slicingdistance": "15",
					"showpercentvalues": "1",
					"showpercentintooltip": "0",
					"plottooltext": "Age group : $label Total visit : $datavalue",
					"theme": "fint"
				},			
				"data": ' . $this->sss_date_pie() .'
			}
		';		
		return $myHeaderSourcePie_sss; 
	}
	
	/**
	 * Chart Type PIE - PT.Arhta Lipat Ganda
	 * lipat data
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function lipat_date_pie(){		
		return Rpt001::find()->where("MODUL_NM='HRM_PERSONALIA_ALG_ALL_SUPPORT_BISNIS'")->one()->VAL_VALUE;
	}
	/*LIPAT PIE HEADER*/
	protected function lipat_header_pie(){
		$myHeaderSourcePie_lipat = '
			"SourcePie_lipat":{
				"chart": {
					"caption": "PT.Arhta Lipat Ganda [Suport & Bisnis] ",
					"subcaption": "Employee 2015/2016",
					"startingangle": "120",
					"showlabels": "0",
					"showlegend": "1",
					"enablemultislicing": "0",
					"slicingdistance": "15",
					"showpercentvalues": "1",
					"showpercentintooltip": "0",
					"plottooltext": "Age group : $label Total visit : $datavalue",
					"theme": "fint"
				},			
				"data": '. $this->lipat_date_pie() .'
			}
		';		
		return $myHeaderSourcePie_lipat; 
	}	
		
	/**
	 * Chart Type PIE - PT. Sarana Sinar Surya
	 * esm data
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function esm_date_pie(){		
		return Rpt001::find()->where("MODUL_NM='HRM_PERSONALIA_ESM_ALL_SUPPORT_BISNIS'")->one()->VAL_VALUE;
	}
	/*ESM PIE HEADER*/
	protected function esm_header_pie(){
		$myHeaderSourcePie_esm = '
			"SourcePie_esm":{
				"chart": {
					"caption": "PT.Effembi Sukses Makmur [Suport & Bisnis] ",
					"subcaption": "Employee 2015/2016",
					"startingangle": "120",
					"showlabels": "0",
					"showlegend": "1",
					"enablemultislicing": "0",
					"slicingdistance": "15",
					"showpercentvalues": "1",
					"showpercentintooltip": "0",
					"plottooltext": "Age group : $label Total visit : $datavalue",
					"theme": "fint"
				},			
				"data": '.$this->esm_date_pie() .'
			}
		';		
		return $myHeaderSourcePie_esm; 
	}
	
	
	
	/**
 	 * Employee Summary
	 * @type GET
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	protected function emp_summay(){
		/* $emp_summary='
			"Employe_Summary":[
				{"emp_total":"120"},
				{"emp_probation":"110"},
				{"emp_contract":"110"},
				{"emp_tetap":"110"}
			]			
		';
		return $emp_summary; */
		return Rpt001::find()->where("MODUL_NM='HRM_PERSONALIA_SUMMARY'")->one()->VAL_VALUE;
	}
	
	/**
	 * hrm_personalia - COMBINASI FUNCTION BUILD JSON
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	 */
	protected function hrm_personalia() 
	{
		 $json_personalia='{'
			.$this->support_header_attrs().
			','.$this->support_header_category().
			','.$this->support_dataset(). 
			','.$this->bisnis_header_attrs(). 
			','.$this->bisnis_header_category(). 
			','.$this->bisnis_dataset(). 
			','.$this->sss_header_pie(). 
			','.$this->lipat_header_pie(). 	
			','.$this->esm_header_pie().
			','.$this->emp_summay().			
		'}';	 
		return Json::decode($json_personalia);
	}

	/**
	  * getUrl: http://api.lukisongroup.int/chart/hrmpersonalias
	  * index - COMBINASI FUNCTION BUILD JSON
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
	public function actionIndex()
     {		
		return $this->hrm_personalia();	
     }
	 
	 /**
	  * Maping String Manipulation
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
	protected function parseString($string) {
           /*  $string = str_replace("\\", "\\\\", $string);
            $string = str_replace('/', "\\/", $string);
            $string = str_replace('"', "\\".'"', $string);
            $string = str_replace("\b", "\\b", $string);
            $string = str_replace("\t", "\\t", $string);
            $string = str_replace("\n", "\\n", $string);
            $string = str_replace("\f", "\\f", $string);
            $string = str_replace("\r", "\\r", $string);
            $string = str_replace("\u", "\\u", $string);
            */
		    /* $string = str_replace("\\", "", $string);
            $string = str_replace('/', "", $string);
            $string = str_replace('"', "", $string);
            $string = str_replace("\b", "", $string);
            $string = str_replace("\t", "", $string);
            $string = str_replace("\n","", $string);
            $string = str_replace("\f", "", $string);
            $string = str_replace("\r", "", $string);
            $string = str_replace("\u", "", $string);
			
			$string = str_replace("\\\\","", $string);
            $string = str_replace("\\/","", $string);
            $string = str_replace("\\".'"',"", $string);
            $string = str_replace("\\b","", $string);
            $string = str_replace("\\t","", $string);
            $string = str_replace( "\\n","", $string);
            $string = str_replace("\\f","", $string);
            $string = str_replace("\\r","", $string);
            $string = str_replace("\\u","", $string); */

    	    return '"'.$string.'"';
    }
}

