<?php

namespace api\modules\chart\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\dashboard\RptEsm;
use app\models\dashboard\RptEsmSearch;
use yii\web\Controller;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\filters\ContentNegotiator;
use yii\web\Response;

use lukisongroup\dashboard\models\RptesmGraph;

use yii\data\ActiveDataProvider;
use common\models\User;
use api\modules\sistem\models\UserloginSearch;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;

/**
 * DashboardController implements the CRUD actions for Dashboard model.
 */
class EsmsuplierspoController extends ActiveController
{
    public $modelClass = 'api\modules\chart\models\RptesmGraph';
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
		//set($actions['visit']);
		return $actions;
	}
	public function actionIndex()
	{

		return array(
						'PO_PriceYear' 					=> $this->actionSupplierPopriceYear(),
						'PO_StockYear' 					=> $this->actionSupplierPoqtyYear(),
						'PO_Stock' 						=> $this->actionSupplierPoStock(),
						'PO_Price' 						=> $this->actionSupplierPoPrice()
					);
	}
	/**
     * DAILY CUSTOMER VISIT.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
     */
	public function actionVisit(){
		//***get count data visiting
		$_visiting= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT 	x1.TGL, month(x1.TGL) AS bulan,DATE_FORMAT(x1.TGL,'%d') as TGL_NO,LEFT(COMPONEN_hari(x1.TGL),2) as hari, 
						x1.CCval,x1.ACval,x2.ECval,x1.CASEval,x2.ACval_COMPARE			
				FROM
				(	SELECT 
					sum(CASE WHEN  a1.CUST_ID <> '' AND a1.STATUS_CASE<>1 THEN  1 ELSE 0 END) AS CCval,
					sum(CASE WHEN a1.CUST_ID <> '' AND a1.STATUS= 1 THEN  1 ELSE 0 END) AS ACval,
					sum(CASE WHEN a1.CUST_ID <> '' AND a1.STATUS_CASE=1 THEN  1 ELSE 0 END) AS CASEval,a1.TGL
					FROM c0002scdl_detail a1 LEFT JOIN c0001 a2 ON a2.CUST_KD=a1.CUST_ID
					WHERE a1.STATUS<>3 AND a2.CUST_NM not LIKE 'customer demo%'
					GROUP BY  a1.TGL
				) x1 LEFT JOIN
				(	SELECT sum(CASE WHEN  ID IS NOT NULL THEN  1 ELSE 0 END) AS ACval_COMPARE,
							sum(CASE WHEN STATUS_EC IS NOT NULL THEN  1 ELSE 0 END) AS ECval,TGL
					FROM c0002rpt_cc_time x1
					WHERE CUST_NM not LIKE 'customer demo%'	
					GROUP BY TGL
				) x2 on x2.TGL=x1.TGL
				WHERE MONTH(x1.TGL)=10 AND x1.TGL <= CURDATE()
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisiting=ArrayHelper::toArray($_visiting->getModels());		
		foreach($_modelVisiting as $row => $value){			
			$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];					
			$cc[]=["value"=> strval($value['CCval'])];					
			$ac[]=["value"=>strval($value['ACval'])];					
			$ec[]=["value"=> strval($value['ECval'])];					
			$case[]=["value"=> strval($value['CASEval'])];
			$acSum[] =$value['ACval'];
			$ecSum[] =$value['ECval'];
		};
		//***get AVG AC FROM data visiting
		$cntAC=count($acSum);
		$sumAC =array_sum($acSum);
		$avgAC=($sumAC/$cntAC);
		$avgACnm="AvgAC (".number_format($avgAC,2).")";
		//***get AVG EC FROM data visiting
		$cntEC=count($ecSum);
		$sumEC =array_sum($ecSum);
		$avgEC=($sumEC/$cntEC);
		$avgECnm="AvgEC (".number_format($avgEC,2).")";
		
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Daily Customers Visits",
				"subCaption": "Custommer Call, Active Customer, Efictif Customer",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#cc0000,#1e86e5,#16ce87,#b7843d",
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"xAxisName": "Day",
				"showValues": "0"               
			},
			"categories": [
				{
					"category": '.Json::encode($hari).'
				}
			],
			"dataset": [
				{
					"seriesname": "CC",
					"data":'.Json::encode($cc).'
				}, 
				{
					"seriesname": "AC",
					"data":'.Json::encode($ac).'
				},
				{
					"seriesname": "EC",
					"data":'.Json::encode($ec).'
				},
				{
					"seriesname": "CASE",
					"data":'.Json::encode($case).'
				}
			],
			"trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "'.$avgAC.'",
                            "color": "#0b0d0f",
                            "valueOnRight": "1",
                            "displayvalue":"'.$avgACnm.'"
                        },
						{
                            "startvalue": "'.$avgEC.'",
                            "color": "#0b0d0f",
                            "valueOnRight": "1",
                            "displayvalue": "'.$avgECnm.'"
                        }
                    ]
                }
            ]
			
		}';
		
		return json::decode($rsltSrc);
		//return $avgAc;
	}
	
	/**
     * DAILY STOCK VISIT.
	 * STATUS	: FIX, waiting selin/po distributor.
	 * STATE	: SALES_MD
     * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
     */
	public function actionVisitStock(){
		//***get count data visiting
		$_visitingStock= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT x1.TGL,month(x1.TGL) AS bulan,DATE_FORMAT(x1.TGL,'%d') as TGL_NO,LEFT(COMPONEN_hari(x1.TGL),2) as hari, 
					x2.KD_BARANG ,x4.NM_BARANG, 
					SUM(CASE WHEN x2.SO_TYPE=5 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as STOCK,
					SUM(CASE WHEN x2.SO_TYPE=6 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as SELL_IN,
					SUM(CASE WHEN x2.SO_TYPE=7 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as SELL_OUT,
					SUM(CASE WHEN x2.SO_TYPE=8 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as RETURN_INV,
					SUM(CASE WHEN x2.SO_TYPE=9 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as REQUEST_INV
				FROM c0002scdl_detail x1 INNER JOIN so_t2 x2 ON  x2.TGL=x1.TGL AND x2.CUST_KD=x1.CUST_ID LEFT JOIN c0001 x3 on x3.CUST_KD=x1.CUST_ID
				LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG
				WHERE  month(x1.TGL)=10  
				AND x1.CUST_ID NOT IN('
					CUS.2016.000618,CUS.2016.000619,CUS.2016.000620,CUS.2016.000621,CUS.2016.000622,CUS.2016.000623,
					CUS.2016.000624,CUS.2016.000625,CUS.2016.000626,CUS.2016.000627,CUS.2016.000628,CUS.2016.000629,
					CUS.2016.000630'
				)
				GROUP BY x1.TGL,x2.KD_BARANG
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisitingStock=ArrayHelper::toArray($_visitingStock->getModels());
		//
		foreach($_modelVisitingStock as $row => $value){			
			$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];	
			if ($value['KD_BARANG']=='BRG.ESM.2016.01.0001'){
				$stockProdak1[]=["value"=>$value['STOCK']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0003'){
				$stockProdak2[]=["value"=>$value['STOCK']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0004'){
				$stockProdak3[]=["value"=>$value['STOCK']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0005'){
				$stockProdak4[]=["value"=>$value['STOCK']];	
			};		
		};
		//Grouping Array for CATEGORY CHART
		$a='';
		foreach($hari as $key => $value){
			if($a!=$value['label']){
				$hariCtg[]=["label"=>$value['label']];
				$a=$value['label'];
			}
		};	
			
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Daily Stock Update",
				"subCaption": "Maxi Product/Pcs",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#cc0000,#e7ff1f,#16ce87,#1e86e5",
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"yAxisName": "Pcs",
				"xAxisName": "Day",
				"showValues": "0"               
			},
			"categories": [
				{
					"category": '.Json::encode($hariCtg).'
				}
			],
			"dataset": [
				{
					"seriesname": "Cassava Chips Balado",
					"data":'.Json::encode($stockProdak1).'
				}, 
				{
					"seriesname": "Talos Roasted Corn",
					"data":'.Json::encode($stockProdak2).'
				},
				{
					"seriesname": "Cassava Crackers Hot Spicy",
					"data":'.Json::encode($stockProdak3).'
				},
				{
					"seriesname": "mixed Roots",
					"data":'.Json::encode($stockProdak4).'
				}
			]			
		}';
		
		return json::decode($rsltSrc);
		//return $keyHari;
	}
	
	/**
     * DAILY REQUEST VISIT.
	 * STATUS	: FIX.
	 * STATE	: SALES_MD
     * @author ptr.nov [ptr.nov@gmail.com]
	 * @since 1.2
     */
	public function actionVisitRequest(){
		//***get count data visiting
		$_visitingRequest= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT x1.TGL,month(x1.TGL) AS bulan,DATE_FORMAT(x1.TGL,'%d') as TGL_NO,LEFT(COMPONEN_hari(x1.TGL),2) as hari, 
					x2.KD_BARANG ,x4.NM_BARANG, 
					SUM(CASE WHEN x2.SO_TYPE=9 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as REQUEST_INV
				FROM c0002scdl_detail x1 INNER JOIN so_t2 x2 ON  x2.TGL=x1.TGL AND x2.CUST_KD=x1.CUST_ID LEFT JOIN c0001 x3 on x3.CUST_KD=x1.CUST_ID
				LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG
				WHERE  month(x1.TGL)=10  
				AND x1.CUST_ID NOT IN('
					CUS.2016.000618,CUS.2016.000619,CUS.2016.000620,CUS.2016.000621,CUS.2016.000622,CUS.2016.000623,
					CUS.2016.000624,CUS.2016.000625,CUS.2016.000626,CUS.2016.000627,CUS.2016.000628,CUS.2016.000629,
					CUS.2016.000630'
				)
				GROUP BY x1.TGL,x2.KD_BARANG
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisitingRequest=ArrayHelper::toArray($_visitingRequest->getModels());
		//
		foreach($_modelVisitingRequest as $row => $value){			
			$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];	
			if ($value['KD_BARANG']=='BRG.ESM.2016.01.0001'){
				$RequestProdak1[]=["value"=>$value['REQUEST_INV']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0003'){
				$RequestProdak2[]=["value"=>$value['REQUEST_INV']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0004'){
				$RequestProdak3[]=["value"=>$value['REQUEST_INV']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0005'){
				$RequestProdak4[]=["value"=>$value['REQUEST_INV']];	
			};		
		};
		//Grouping Array for CATEGORY CHART
		$a='';
		foreach($hari as $key => $value){
			if($a!=$value['label']){
				$hariCtg[]=["label"=>$value['label']];
				$a=$value['label'];
			}
		};	
			
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Daily Request Update",
				"subCaption": "Maxi Product/pcs",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#cc0000,#e7ff1f,#16ce87,#1e86e5",
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"xAxisName": "Day",
				"yAxisName": "Pcs",	
				"showValues": "0"               
			},
			"categories": [
				{
					"category": '.Json::encode($hariCtg).'
				}
			],
			"dataset": [
				{
					"seriesname": "Cassava Chips Balado",
					"data":'.Json::encode($RequestProdak1).'
				}, 
				{
					"seriesname": "Talos Roasted Corn",
					"data":'.Json::encode($RequestProdak2).'
				},
				{
					"seriesname": "Cassava Crackers Hot Spicy",
					"data":'.Json::encode($RequestProdak3).'
				},
				{
					"seriesname": "mixed Roots",
					"data":'.Json::encode($RequestProdak4).'
				}
			]			
		}';
		
		return json::decode($rsltSrc);
		//return $keyHari;
	}
	
	/**
     * DAILY SELL-OUT VISIT.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * STATUS	: FIX, ESTIMATE. waiting selin/po distributor.
	 * STATE	: SALES_MD
	 * @since 1.2
     */
	public function actionVisitSellout(){
		//***get count data visiting
		$_visitingSellout= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT x1.TGL,month(x1.TGL) AS bulan,DATE_FORMAT(x1.TGL,'%d') as TGL_NO,LEFT(COMPONEN_hari(x1.TGL),2) as hari, 
					x2.KD_BARANG ,x4.NM_BARANG, 
					SUM(CASE WHEN x2.SO_TYPE=7 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as SELL_OUT
				FROM c0002scdl_detail x1 INNER JOIN so_t2 x2 ON  x2.TGL=x1.TGL AND x2.CUST_KD=x1.CUST_ID LEFT JOIN c0001 x3 on x3.CUST_KD=x1.CUST_ID
				LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG
				WHERE  month(x1.TGL)=10  
				AND x1.CUST_ID NOT IN('
					CUS.2016.000618,CUS.2016.000619,CUS.2016.000620,CUS.2016.000621,CUS.2016.000622,CUS.2016.000623,
					CUS.2016.000624,CUS.2016.000625,CUS.2016.000626,CUS.2016.000627,CUS.2016.000628,CUS.2016.000629,
					CUS.2016.000630'
				)
				GROUP BY x1.TGL,x2.KD_BARANG
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisitingSellout=ArrayHelper::toArray($_visitingSellout->getModels());
		//
		foreach($_modelVisitingSellout as $row => $value){			
			$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];	
			if ($value['KD_BARANG']=='BRG.ESM.2016.01.0001'){
				$SelloutProdak1[]=["value"=>$value['SELL_OUT']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0003'){
				$SelloutProdak2[]=["value"=>$value['SELL_OUT']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0004'){
				$SelloutProdak3[]=["value"=>$value['SELL_OUT']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0005'){
				$SelloutProdak4[]=["value"=>$value['SELL_OUT']];	
			};		
		};
		//Grouping Array for CATEGORY CHART
		$a='';
		foreach($hari as $key => $value){
			if($a!=$value['label']){
				$hariCtg[]=["label"=>$value['label']];
				$a=$value['label'];
			}
		};	
			
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Daily Update Estimate Sell-Out",
				"subCaption": "Maxi Product/Pcs",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#cc0000,#e7ff1f,#16ce87,#1e86e5",
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"yAxisName": "Pcs",
				"xAxisName": "Day",
				"showValues": "0"               
			},
			"categories": [
				{
					"category": '.Json::encode($hariCtg).'
				}
			],
			"dataset": [
				{
					"seriesname": "Cassava Chips Balado",
					"data":'.Json::encode($SelloutProdak1).'
				}, 
				{
					"seriesname": "Talos Roasted Corn",
					"data":'.Json::encode($SelloutProdak2).'
				},
				{
					"seriesname": "Cassava Crackers Hot Spicy",
					"data":'.Json::encode($SelloutProdak3).'
				},
				{
					"seriesname": "mixed Roots",
					"data":'.Json::encode($SelloutProdak4).'
				}
			]			
		}';
		
		return json::decode($rsltSrc);
		//return $_modelVisitingSellout;
	}
	
	/**
     * DAILY DISTRIBUTOR PO CUSTOMER.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * STATUS	: FIX, 
	 * ISSUE	: Online PO/ input Manual.
	 * STATE	: DISTRIBUTOR PO
	 * @since 1.2
     */
	public function actionVisitDistributorPo(){
		//***get count data visiting
		$_visitingDistPo= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT x1.TGL,month(x1.TGL) AS bulan,DATE_FORMAT(x1.TGL,'%d') as TGL_NO,LEFT(COMPONEN_hari(x1.TGL),2) as hari, 
					x2.KD_BARANG ,x4.NM_BARANG, 
					SUM(CASE WHEN x2.SO_TYPE=7 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as DIST_PO
				FROM c0002scdl_detail x1 INNER JOIN so_t2 x2 ON  x2.TGL=x1.TGL AND x2.CUST_KD=x1.CUST_ID LEFT JOIN c0001 x3 on x3.CUST_KD=x1.CUST_ID
				LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG
				WHERE  month(x1.TGL)=10  
				AND x1.CUST_ID NOT IN('
					CUS.2016.000618,CUS.2016.000619,CUS.2016.000620,CUS.2016.000621,CUS.2016.000622,CUS.2016.000623,
					CUS.2016.000624,CUS.2016.000625,CUS.2016.000626,CUS.2016.000627,CUS.2016.000628,CUS.2016.000629,
					CUS.2016.000630'
				)
				GROUP BY x1.TGL,x2.KD_BARANG
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisitingDistPo=ArrayHelper::toArray($_visitingDistPo->getModels());
		//
		foreach($_modelVisitingDistPo as $row => $value){			
			$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];	
			if ($value['KD_BARANG']=='BRG.ESM.2016.01.0001'){
				$distpoProduct1[]=["value"=>$value['DIST_PO']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0003'){
				$distpoProduct2[]=["value"=>$value['DIST_PO']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0004'){
				$distpoProduct3[]=["value"=>$value['DIST_PO']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0005'){
				$distpoProduct4[]=["value"=>$value['DIST_PO']];	
			};		
		};
		//Grouping Array for CATEGORY CHART
		$a='';
		foreach($hari as $key => $value){
			if($a!=$value['label']){
				$hariCtg[]=["label"=>$value['label']];
				$a=$value['label'];
			}
		};	
			
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Distributor PO Update",
				"subCaption": "Maxi Product/Pcs",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#cc0000,#e7ff1f,#16ce87,#1e86e5",
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"yAxisName": "Pcs",
				"xAxisName": "Day",
				"showValues": "0"               
			},
			"categories": [
				{
					"category": '.Json::encode($hariCtg).'
				}
			],
			"dataset": [
				{
					"seriesname": "Cassava Chips Balado",
					"data":'.Json::encode($distpoProduct1).'
				}, 
				{
					"seriesname": "Talos Roasted Corn",
					"data":'.Json::encode($distpoProduct2).'
				},
				{
					"seriesname": "Cassava Crackers Hot Spicy",
					"data":'.Json::encode($distpoProduct3).'
				},
				{
					"seriesname": "mixed Roots",
					"data":'.Json::encode($distpoProduct4).'
				}
			]			
		}';
		
		return json::decode($rsltSrc);
		//return $_modelVisitingSellout;
	}
	
	/**
     * DAILY NKA PO CUSTOMER.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * STATUS	: FIX.
	 * ISSUE	: Online PO/ input Manual, mendapatkan PO Detail.
	 * STATE	: NKA PO
	 * @since 1.2
     */
	public function actionVisitNkaPo(){
		//***get count data visiting
		$_visitingNkaPo= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT x1.TGL,month(x1.TGL) AS bulan,DATE_FORMAT(x1.TGL,'%d') as TGL_NO,LEFT(COMPONEN_hari(x1.TGL),2) as hari, 
					x2.KD_BARANG ,x4.NM_BARANG, 
					SUM(CASE WHEN x2.SO_TYPE=7 AND x2.SO_QTY>=0 THEN x2.SO_QTY ELSE 0 END) as NKA_PO
				FROM c0002scdl_detail x1 INNER JOIN so_t2 x2 ON  x2.TGL=x1.TGL AND x2.CUST_KD=x1.CUST_ID LEFT JOIN c0001 x3 on x3.CUST_KD=x1.CUST_ID
				LEFT JOIN b0001 x4 on x4.KD_BARANG=x2.KD_BARANG
				WHERE  month(x1.TGL)=10  
				AND x1.CUST_ID NOT IN('
					CUS.2016.000618,CUS.2016.000619,CUS.2016.000620,CUS.2016.000621,CUS.2016.000622,CUS.2016.000623,
					CUS.2016.000624,CUS.2016.000625,CUS.2016.000626,CUS.2016.000627,CUS.2016.000628,CUS.2016.000629,
					CUS.2016.000630'
				)
				GROUP BY x1.TGL,x2.KD_BARANG
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisitingNkaPo=ArrayHelper::toArray($_visitingNkaPo->getModels());
		//
		foreach($_modelVisitingNkaPo as $row => $value){			
			$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];	
			if ($value['KD_BARANG']=='BRG.ESM.2016.01.0001'){
				$NkaPoProduct1[]=["value"=>$value['NKA_PO']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0003'){
				$NkaPoProduct2[]=["value"=>$value['NKA_PO']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0004'){
				$NkaPoProduct3[]=["value"=>$value['NKA_PO']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0005'){
				$NkaPoProduct4[]=["value"=>$value['NKA_PO']];	
			};		
		};
		//Grouping Array for CATEGORY CHART
		$a='';
		foreach($hari as $key => $value){
			if($a!=$value['label']){
				$hariCtg[]=["label"=>$value['label']];
				$a=$value['label'];
			}
		};	
			
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Distributor PO Update",
				"subCaption": "Maxi Product/Pcs",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#cc0000,#e7ff1f,#16ce87,#1e86e5",
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"yAxisName": "Pcs",
				"xAxisName": "Day",
				"showValues": "0"               
			},
			"categories": [
				{
					"category": '.Json::encode($hariCtg).'
				}
			],
			"dataset": [
				{
					"seriesname": "Cassava Chips Balado",
					"data":'.Json::encode($NkaPoProduct1).'
				}, 
				{
					"seriesname": "Talos Roasted Corn",
					"data":'.Json::encode($NkaPoProduct2).'
				},
				{
					"seriesname": "Cassava Crackers Hot Spicy",
					"data":'.Json::encode($NkaPoProduct3).'
				},
				{
					"seriesname": "mixed Roots",
					"data":'.Json::encode($NkaPoProduct4).'
				}
			]			
		}';
		
		return json::decode($rsltSrc);
		//return $_modelVisitingSellout;
	}
	
	
	/**
     * MONTHS OF YEAR, SUPPLIER PO PRICE.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * STATUS	: FIX.
	 * ISSUE	: Online PO/ input Manual, mendapatkan PO Detail.
	 * STATE	: Maxindo PO
	 * @since 1.2
     */
	public function actionSupplierPopriceYear(){
		//***get Supplier PO
		$_visitingSplPoYear= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT 	a1.TGL,a1.NmBulan,a1.bulan,a1.TGL_NO,
						sum(a1.QTY) as QTY,
						sum(a1.TTL) as Price
				FROM
					(SELECT  DATE_FORMAT(x1.CREATE_AT,'%d-%m-%Y') as TGL, DATE_FORMAT(x1.CREATE_AT,'%d') as TGL_NO,
									 month(x1.CREATE_AT) AS bulan,monthname(x1.CREATE_AT) as NmBulan,
									x1.KD_PO,x2.KD_BARANG,x2.NM_BARANG,x2.NM_UNIT,
									x2.QTY,x2.HARGA,(x2.QTY * (24 * x2.HARGA)) as TTL
					FROM p0001 x1 INNER JOIN p0002 x2 on x2.KD_PO=x1.KD_PO
					WHERE x1.KD_CORP='ESM' AND x1.KD_SUPPLIER='SPL.ESM.00001' AND x1.STATUS='102' 
					ORDER BY x1.CREATE_AT) a1
				GROUP BY a1.bulan
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisitingSplPoYear=ArrayHelper::toArray($_visitingSplPoYear->getModels());
		//
		foreach($_modelVisitingSplPoYear as $row => $value){			
			//$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];	
			$NmBulan[]=["label"=>$value['NmBulan']];	
			//$SplPoProductQty[]=["value"=>strval($value['QTY'])];	
			$SplPoProductPrc[]=["value"=>strval($value['Price'])];	
	
		};
					
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Maxindo Price List PO",
				"subCaption":"List Months of Year",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#e7ff1f",
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"yAxisName": "IDR(Rp,Jt,M)",
				"xAxisName": "Days",
				"numberscalevalue":"1000,1000,1000",
				"numberscaleunit":"Rp,Jt,M",
				"showValues": "1"              
			},
			"categories": [
				{
					"category": '.Json::encode($NmBulan).'
				}
			],
			"dataset": [ 
				{
					"seriesname": "Prices",
					"data":'.Json::encode($SplPoProductPrc).'
				}
			]			
		}';
		
		return json::decode($rsltSrc);
		//return $_modelVisitingSellout;
	}
	
	/**
     * MONTHS OF YEAR, PO QTY.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * STATUS	: FIX.
	 * ISSUE	: Online PO/ input Manual, mendapatkan PO Detail.
	 * STATE	: Maxindo PO
	 * @since 1.2
     */
	public function actionSupplierPoqtyYear(){
		//***get Supplier PO
		$_visitingSplPoqtyYear= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT 	a1.TGL,a1.NmBulan,a1.bulan,a1.TGL_NO,
						sum(a1.QTY) as QTY,
						sum(a1.TTL) as Price
				FROM
					(SELECT  DATE_FORMAT(x1.CREATE_AT,'%d-%m-%Y') as TGL, DATE_FORMAT(x1.CREATE_AT,'%d') as TGL_NO,
									 month(x1.CREATE_AT) AS bulan,monthname(x1.CREATE_AT) as NmBulan,
									x1.KD_PO,x2.KD_BARANG,x2.NM_BARANG,x2.NM_UNIT,
									x2.QTY,x2.HARGA,(x2.QTY * x2.HARGA) as TTL
					FROM p0001 x1 INNER JOIN p0002 x2 on x2.KD_PO=x1.KD_PO
					WHERE x1.KD_CORP='ESM' AND x1.KD_SUPPLIER='SPL.ESM.00001' AND x1.STATUS='102' 
					ORDER BY x1.CREATE_AT) a1
				GROUP BY a1.bulan
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisitingSplPoqtyYear=ArrayHelper::toArray($_visitingSplPoqtyYear->getModels());
		//
		foreach($_modelVisitingSplPoqtyYear as $row => $value){			
			$NmBulan[]=["label"=>$value['NmBulan']];	
			$SplPoProductQty[]=["value"=>strval($value['QTY'])];	
			//$SplPoProductPrc[]=["value"=>strval($value['Price'])];
		};
					
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Maxindo Qty PO, Months of Year",
				"subCaption": "Qty/Carton",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#1e86e5",
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"yAxisName": "Crt",
				"xAxisName": "Days",
				"showValues": "1"              
			},
			"categories": [
				{
					"category": '.Json::encode($NmBulan).'
				}
			],
			"dataset": [ 
				{
					"seriesname": "Qty/Carton",
					"data":'.Json::encode($SplPoProductQty).'
				}
			]			
		}';
		
		return json::decode($rsltSrc);
		//return $_modelVisitingSellout;
	}
	
	/**
     * DAILY OF MONTHS SUPPLIER PO BY QTY.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * STATUS	: FIX.
	 * ISSUE	: Online PO/ input Manual, mendapatkan PO Detail.
	 * STATE	: Maxindo PO
	 * @since 1.2
     */
	public function actionSupplierPoStock(){
		//***get Supplier PO
		$_visitingSplPo= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT  DATE_FORMAT(x1.CREATE_AT,'%d-%m-%Y') as TGL, month(x1.CREATE_AT) AS bulan,DATE_FORMAT(x1.CREATE_AT,'%d') as TGL_NO,LEFT(COMPONEN_hari(x1.CREATE_AT),2) as hari,
						x1.KD_PO,x2.KD_BARANG,x2.NM_BARANG,x2.NM_UNIT,x2.QTY
				FROM p0001 x1 INNER JOIN p0002 x2 on x2.KD_PO=x1.KD_PO
				WHERE x1.KD_CORP='ESM' AND x1.KD_SUPPLIER='SPL.ESM.00001' #AND x1.STATUS='102' 
				ORDER BY x1.CREATE_AT
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisitingSplPo=ArrayHelper::toArray($_visitingSplPo->getModels());
		//
		foreach($_modelVisitingSplPo as $row => $value){			
			//$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];	
			$hari[]=["label"=>$value['TGL']];	
			if ($value['KD_BARANG']=='BRG.ESM.2016.01.0001'){
				$SplPoProduct1[]=["value"=>$value['QTY']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0003'){
				$SplPoProduct2[]=["value"=>$value['QTY']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0004'){
				$SplPoProduct3[]=["value"=>$value['QTY']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0005'){
				$SplPoProduct4[]=["value"=>$value['QTY']];	
			};		
		};
		//Grouping Array for CATEGORY CHART
		$a='';
		foreach($hari as $key => $value){
			if($a!=$value['label']){
				$hariCtg[]=["label"=>$value['label']];
				$a=$value['label'];
			}
		};	
			
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Maxindo PO by Qty/Carton",
				"subCaption": "List product, days of month",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#cc0000,#e7ff1f,#16ce87,#1e86e5",
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"yAxisName": "Crt",
				"xAxisName": "Days",
				"showValues": "1"
			},
			"categories": [
				{
					"category": '.Json::encode($hariCtg).'
				}
			],
			"dataset": [
				{
					"seriesname": "Cassava Chips Balado",
					"data":'.Json::encode($SplPoProduct1).'
				}, 
				{
					"seriesname": "Talos Roasted Corn",
					"data":'.Json::encode($SplPoProduct2).'
				},
				{
					"seriesname": "Cassava Crackers Hot Spicy",
					"data":'.Json::encode($SplPoProduct3).'
				},
				{
					"seriesname": "mixed Roots",
					"data":'.Json::encode($SplPoProduct4).'
				}
			]			
		}';
		
		return json::decode($rsltSrc);
		//return $_modelVisitingSellout;
	}
	
	/**
     * DAILY OF MONTHS SUPPLIER PO BY PRICE.
     * @author ptr.nov [ptr.nov@gmail.com]
	 * STATUS	: FIX.
	 * ISSUE	: Online PO/ input Manual, mendapatkan PO Detail.
	 * STATE	: Maxindo PO
	 * @since 1.2
     */
	public function actionSupplierPoPrice(){
		//***get Supplier PO
		$_visitingSplPo= new ArrayDataProvider([
			'allModels'=>Yii::$app->db_esm->createCommand("	
				SELECT  DATE_FORMAT(x1.CREATE_AT,'%d-%m-%Y') as TGL, month(x1.CREATE_AT) AS bulan,DATE_FORMAT(x1.CREATE_AT,'%d') as TGL_NO,LEFT(COMPONEN_hari(x1.CREATE_AT),2) as hari,
						x1.KD_PO,x2.KD_BARANG,x2.NM_BARANG,x2.NM_UNIT,x2.QTY,x2.HARGA,(x2.QTY * (24 * x2.HARGA)) as TTL
				FROM p0001 x1 INNER JOIN p0002 x2 on x2.KD_PO=x1.KD_PO
				WHERE x1.KD_CORP='ESM' AND x1.KD_SUPPLIER='SPL.ESM.00001' #AND x1.STATUS='102' 
				ORDER BY x1.CREATE_AT
			")->queryAll(), 
			'pagination' => [
					'pageSize' => 200,
			],				 
		]);
		$_modelVisitingSplPo=ArrayHelper::toArray($_visitingSplPo->getModels());
		//
		foreach($_modelVisitingSplPo as $row => $value){			
			//$hari[]=["label"=>$value['hari']."-".$value['TGL_NO']."-".$value['bulan']];	
			$hari[]=["label"=>$value['TGL']];	
			if ($value['KD_BARANG']=='BRG.ESM.2016.01.0001'){
				$SplPoProduct1[]=["value"=>$value['TTL']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0003'){
				$SplPoProduct2[]=["value"=>$value['TTL']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0004'){
				$SplPoProduct3[]=["value"=>$value['TTL']];	
			}elseif($value['KD_BARANG']=='BRG.ESM.2016.01.0005'){
				$SplPoProduct4[]=["value"=>$value['TTL']];	
			};		
		};
		//Grouping Array for CATEGORY CHART
		$a='';
		foreach($hari as $key => $value){
			if($a!=$value['label']){
				$hariCtg[]=["label"=>$value['label']];
				$a=$value['label'];
			}
		};	
			
		/**
		 * Maping Chart 
		 * Type : msline
		 * 
		*/
		$rsltSrc='{
			"chart": {
				"caption": " Maxindo PO Update By Price/Carton",
				"subCaption": "List days of month",
				"captionFontSize": "12",
				"subcaptionFontSize": "10",
				"subcaptionFontBold": "0",
				"paletteColors": "#cc0000,#e7ff1f,#16ce87,#1e86e5",
				"bgcolor": "#ffffff",
				"showBorder": "0",
				"showShadow": "0",
				"showCanvasBorder": "0",
				"usePlotGradientColor": "0",
				"legendBorderAlpha": "0",
				"legendShadow": "0",
				"showAxisLines": "0",
				"showAlternateHGridColor": "0",
				"divlineThickness": "1",
				"divLineIsDashed": "1",
				"divLineDashLen": "1",
				"divLineGapLen": "1",
				"yAxisName": "IDR(Rp,Jt,M)",
				"xAxisName": "Day",
				"numberscalevalue":"1000,1000,1000",
				"numberscaleunit":"Rp,Jt,M",
				"showValues": "1"               
			},
			"categories": [
				{
					"category": '.Json::encode($hariCtg).'
				}
			],
			"dataset": [
				{
					"seriesname": "Cassava Chips Balado",
					"data":'.Json::encode($SplPoProduct1).'
				}, 
				{
					"seriesname": "Talos Roasted Corn",
					"data":'.Json::encode($SplPoProduct2).'
				},
				{
					"seriesname": "Cassava Crackers Hot Spicy",
					"data":'.Json::encode($SplPoProduct3).'
				},
				{
					"seriesname": "mixed Roots",
					"data":'.Json::encode($SplPoProduct4).'
				}
			]			
		}';
		
		return json::decode($rsltSrc);
		//return $_modelVisitingSellout;
	}
	
	
	
	public function actionVisitTest(){
		$rsltSrc='{
            "chart": {
                "caption": " Daily visits to customers",
                "subCaption": "Custommer Call, Active Customer, Efictif Customer",
                "captionFontSize": "12",
                "subcaptionFontSize": "10",
                "subcaptionFontBold": "0",
                "paletteColors": "#cc0000,#e7ff1f,#16ce87,#1e86e5",
                "bgcolor": "#ffffff",
                "showBorder": "0",
                "showShadow": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "legendBorderAlpha": "0",
                "legendShadow": "0",
                "showAxisLines": "0",
                "showAlternateHGridColor": "0",
                "divlineThickness": "1",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "xAxisName": "Day",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "Mon" }, 
                        { "label": "Tue" }, 
                        { "label": "Wed" },                    
                        { "label": "Thu" }, 
                        { "label": "Fri" }, 
                        { "label": "Sat" }, 
                        { "label": "Sun" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "Bakersfield Central",
                    "data": [
                        { "value": "15123" }, 
                        { "value": "14233" }, 
                        { "value": "25507" }, 
                        { "value": "9110" }, 
                        { "value": "15529" }, 
                        { "value": "20803" }, 
                        { "value": "19202" }
                    ]
                }, 
                {
                    "seriesname": "Los Angeles Topanga",
                    "data": [
                        { "value": "13400" }, 
                        { "value": "12800" }, 
                        { "value": "22800" }, 
                        { "value": "12400" }, 
                        { "value": "15800" }, 
                        { "value": "19800" }, 
                        { "value": "21800" }
                    ]
                }
            ], 
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "17022",
                            "color": "#6baa01",
                            "valueOnRight": "1",
                            "displayvalue": "Average"
                        }
                    ]
                }
            ]
        }';
		
		return json::decode($rsltSrc);
		
	}
	
	
	public function actionVisitStockTest(){
		$rsltSrc='{
			"chart": {
				"palette": "3",
				"caption": "Worldwide sales report of mobile devices",
				"subcaption": "Samsung & Nokia",
				"yaxisname": "Sales in million units",
				"plotgradientcolor": " ",
				"numbersuffix": "M",
				"showvalues": "0",
				"divlinealpha": "30",
				"labelpadding": "10",
				"plottooltext": "
					$seriesname
					Year :  $label 
					Sales : $datavalue
				",
				"legendborderalpha": "0",
				"showborder": "0"
			},
			"categories": [
				{
					"category": [
						{
							"label": "2010"
						},
						{
							"label": "2011"
						},
						{
							"label": "2012"
						},
						{
							"label": "2013"
						},
						{
							"label": "2014"
						},
						{
							"label": "2015"
						},
						{
							"label": "2016
		(Project
		ed)"
						}
					]
				}
			],
			"dataset": [
				{
					"seriesname": "Samsung",
					"color": "A66EDD",
					"data": [
						{
							"value": "281.07"
						},
						{
							"value": "315.05"
						},
						{
							"value": "384.63"
						},
						{
							"value": "444.45"
						},
						{
							"value": "405.94"
						},
						{
							"value": "401.37"
						},
						{
							"value": "390.76",
							"dashed": "1"
						}
					]
				},
				{
					"seriesname": "Nokia/Microsoft",
					"color": "F6BD0F",
					"data": [
						{
							"value": "461.32"
						},
						{
							"value": "422.48"
						},
						{
							"value": "333.93"
						},
						{
							"value": "250.81"
						},
						{
							"value": "179.38"
						},
						{
							"value": "126.61"
						},
						{
							"value": "95.85",
							"dashed": "1"
						}
					]
				}
			]
		}
		
		';
	}
	
	
	
	/**
	 * ARRAY GROUPING Serialize
	 * @author Piter Novian [ptr.nov@gmail.com] 
	*/	
	private static function array_group_by($arr, $key)
	{
		if (!is_array($arr)) {
			trigger_error('array_group_by(): The first argument should be an array', E_USER_ERROR);
		}
		if (!is_string($key) && !is_int($key) && !is_float($key)) {
			trigger_error('array_group_by(): The key should be a string or an integer', E_USER_ERROR);
		}
		// Load the new array, splitting by the target key
		$grouped = [];
		foreach ($arr as $value) {
			$grouped[$value[$key]][] = $value;
		}
		// Recursively build a nested grouping if more parameters are supplied
		// Each grouped array value is grouped according to the next sequential key
		if (func_num_args() > 2) {
			$args = func_get_args();
			foreach ($grouped as $key => $value) {
				$parms = array_merge([$value], array_slice($args, 2, func_num_args()));
				$grouped[$key] = call_user_func_array('array_group_by', $parms);
			}
		}
		return $grouped;
	}
	
	
	
}
