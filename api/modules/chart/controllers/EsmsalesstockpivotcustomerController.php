<?php

namespace api\modules\chart\controllers;


use yii;
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
use api\modules\chart\models\FusionChart;

class EsmsalesstockpivotcustomerController extends ActiveController
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
	 
	public function actionIndex()
	{
		if (!empty($_GET)) 
        {
        	$bulan = $_GET['MONTH'];
        }
        else
        {
        	$bulan = 10;
        }
		$results            = $this->StockPerGeo();
        $array              = array();
        $i = 0;
        foreach($results as $result)
        {
            
            $is_on_array = Yii::$app->ambilkonci->findOnArrayAssociativeByKeyAndValue($array, 'CUST_NM', $result['CUST_NM']);
            if($is_on_array)
            {
                $key            = array_search($result['CUST_NM'], array_column($array, 'CUST_NM'));
                $product        = $array[$key]['PRODUCT'];
                $pro_in_array   = Yii::$app->ambilkonci->findOnArrayAssociativeByKeyAndValue($product, 'NM_BARANG', $result['NM_BARANG']);
                if($pro_in_array)
                {
                    $keys            = array_search($result['NM_BARANG'], array_column($product, 'NM_BARANG'));
                    array_push($array[$key]['PRODUCT'][$keys]['VALUE'],array('QTY'=>$result['SO_QTY'],'TGL'=>$result['TGL']));
                }
                else
                {
                    array_push($array[$key]['PRODUCT'],array('NM_BARANG'=>$result['NM_BARANG'],'VALUE'=>array(array('QTY'=>$result['SO_QTY'],'TGL'=>$result['TGL']))));
                }

            }
            else
            {
                $array[] = array(
                					'CUST_NM'=>$result['CUST_NM'],
                					'PRODUCT'=>array(
                										array(
                												'NM_BARANG'=>$result['NM_BARANG'],
                                                                'VALUE'=>array(
                                                                                array(
                                                                                        'QTY'=>$result['SO_QTY'],
                                                                                        'TGL'=>$result['TGL']
                                                                                     )
                                                                                )
                										    )
                									)
                				);
            }  
        }

        return array('Pivot'=>$array);
        

	} 
	public function StockPerGeo()
	{


        $commandstock   = Yii::$app->db3
                        ->createCommand('
                                            SELECT stock.TGL,stock.CUST_NM,stock.NM_BARANG,stock.SO_QTY FROM so_t2 stock 
                                            INNER JOIN dbc002.c0001 cust on stock.CUST_KD = cust.CUST_KD 
                                            WHERE stock.SO_TYPE = 5 AND stock.TGL >= "2016-10-01" AND stock.TGL <= "2016-12-31"
                                            ORDER BY stock.TGL
                                        ')
                        ->queryAll();

        return $commandstock;
	}

}

