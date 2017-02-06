<?php

namespace api\modules\chart\controllers;


use Yii;
use kartik\datecontrol\Module;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\User;
use api\modules\sistem\models\UserloginSearch;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use api\modules\chart\models\Cnfweek; 
use api\modules\chart\models\Cnfmonth;

use yii\filters\AccessControl;
use app\models\dashboard\RptEsm;
use app\models\dashboard\RptEsmSearch;

use yii\web\NotFoundHttpException;
use lukisongroup\dashboard\models\RptesmGraph;

class SalespoController extends ActiveController
{
	public $modelClass = 'api\modules\chart\models\Cnfweek';
	  
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

	
	/**
     * @inheritdoc
     */
	public function actions()
	{
		$actions = parent::actions();
		unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		//unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		//set($actions['visit']);
		return $actions;
	}
	 
	/**
     * DISTRIBUTOR, SALES PO MONTH OF YEAR.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * STATUS	: FIX, 
	 * ISSUE	: Online PO/ input Manual.
	 * STATE	: DISTRIBUTOR PO
	 * UPDATE	: 24/01/2017
	 * @since 1.2
     */
	public function actionIndex(){
		$_distributorStockGudang= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
					SELECT x2.TGL,month(x2.TGL) AS bulan,DATE_FORMAT(x2.TGL,'%d') as TGL_NO,LEFT(COMPONEN_hari(x2.TGL),2) as hari, 
						x2.KD_BARANG ,x4.NM_BARANG,x2.SO_QTY #, 
						#TRUNCATE(SUM(CASE WHEN  x2.SO_TYPE=1 AND x2.SO_QTY>=0 THEN (x2.SO_QTY / x2.UNIT_QTY) ELSE 0 END),2) as STCK_GUDANG
						,sum(CASE WHEN  x2.SO_TYPE=3 AND x2.SO_QTY>=0 THEN (x2.SO_QTY/ 24) ELSE 0 END) as TOTAL_PO
					FROM so_t2 x2 
					LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG
					WHERE x2.SO_TYPE=3 #AND (x2.TGL) IN ('2017-01-21','2016-03-20','2016-08-31','2016-10-22','2016-11-19','2016-12-24')

					GROUP BY MONTH(x2.TGL) #x2.TGL
					ORDER BY x2.TGL
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelDistributorStockGudang=ArrayHelper::toArray($_distributorStockGudang->getModels());		
		$lineColor = ArrayHelper::toArray(Yii::$app->arrayBantuan->ArrayRowPaletteColors());
		foreach($_modelDistributorStockGudang as $row => $value){			
			$dateValue = strtotime($value['TGL']);
			$yr = date("Y", $dateValue);
			$mon = date("m", $dateValue); 
			$date = date("d", $dateValue); 
			if ($yr=='2016'){
				$distStockGudangChip2016[]=["Bln"=>$mon,"value"=>str_replace('.',',',$value['TOTAL_PO']),"Thn"=>$yr,"anchorBgColor"=> $lineColor[0]];
			};
			if ($yr=='2017'){
				$distStockGudangChip2017[]=["Bln"=>$mon,"value"=>str_replace('.',',',$value['TOTAL_PO']),"Thn"=>$yr,"anchorBgColor"=> $lineColor[1]];
			};
								
		};
		
		//STOCK GUDANG - TAHUN 2016
		$keybulan2016 = array_column($distStockGudangChip2016, 'Bln');
		$bulan    = array('1','2','3','4','5','6','7','8','9','10','11','12');
		foreach($bulan as $bul)
		{
			if(!in_array($bul,$keybulan2016))
			{
				$aryStockGudangChip2016[] = array('Bln'=>$bul,'value'=>'',"anchorBgColor"=> $lineColor[0]);
			}
		}
		$aryStokGudangDist2016 = ArrayHelper::merge($distStockGudangChip2016,$aryStockGudangChip2016);
		$rsltStokGudangDist2016=Yii::$app->arrayBantuan->sort_multi_array($aryStokGudangDist2016,'Bln'); 
		//return $rsltStokGudangDist2016;
		
		//STOCK GUDANG - TAHUN 2017
		$keybulan2017 = array_column($distStockGudangChip2017, 'Bln');
		foreach($bulan as $bul)
		{
			if(!in_array($bul,$keybulan2017))
			{
				$aryStockGudangChip2017[] = array('Bln'=>$bul,'value'=>'',"anchorBgColor"=> $lineColor[1]);
			}
		}
		$aryStokGudangDist2017 = ArrayHelper::merge($distStockGudangChip2017,$aryStockGudangChip2017);
		$rsltStokGudangDist2017=Yii::$app->arrayBantuan->sort_multi_array($aryStokGudangDist2017,'Bln'); 
		//return $rsltStokGudangDist2016;
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": "SALES PO",
				"subCaption": "Total Sales PO",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": '.'"'.Yii::$app->arrayBantuan->ArrayPaletteColors().'"'.',
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",				
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "1",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "0",				
				"divLineDashLen": "1",				
				"divLineGapLen": "1",
				"vDivLineDashed": "0",
				"numVDivLines": "11",
				"vDivLineThickness": "1",
				"xAxisName": "Month of Year",
				"yAxisName": "Carton",				
				"anchorradius": "6",
				"plotHighlightEffect": "fadeout|color=#f6f5fd, alpha=60",
				"showValues": "0",
				"rotateValues": "0",
				"placeValuesInside": "0",
				"formatNumberScale": "0",
				"decimalSeparator": ",",
				"thousandSeparator": ".",
				"numberPrefix": "",
				"ValuePadding": "0",
				"yAxisValuesStep":"1",
				"xAxisValuesStep":"0",
				"yAxisMaxvalue": "2500",
				"yAxisMinValue": "0",
				"numDivLines": "8",
				"xAxisNamePadding": "30",
				"showHoverEffect":"1",
				"animation": "1" ,
				"exportEnabled": "1",
				"exportFileName":"SALES-PO",
				"exportAtClientSide":"1",
				"showValues":"1"				
			},
			"categories": [
				{
					"category": [
						{
							"label": "January"
						},
						{
							"label": "February"
						},
						{
							"label": "March"
						},
						{
							"label": "April"
						},
						{
							"label": "Mey"
						},
						{
							"label": "June"
						},
						{
							"label": "July"
						},
						{
							"label": "Agustus"
						},
						{
							"label": "September"
						},
						{
							"label": "Oktober"
						},
						{
							"label": "November"
						},
						{
							"label": "Desember"
						}						
					]
				}
			],
			"dataset": [
				{
					"seriesname": "PO-CIP-2016",
					"data":'.Json::encode($rsltStokGudangDist2016).'
				},
				{
					"seriesname": "PO-CIP-2017",
					"data":'.Json::encode($rsltStokGudangDist2017).'
				}
			]			
		}'; 
		
		return json::decode($rsltSrc);
		//return $_distributorStockGudang;
	}		
}
