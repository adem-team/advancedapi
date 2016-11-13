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

class EsmsalesstockcustomerController extends ActiveController
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
		return array(
						'StockPerGeo'		       => $this->StockPerGeo(),
                        'StockPerLayer'             => $this->StockPerLayer(),
                        'StockTotalPerProducts'     => $this->StockTotalPerProducts()
					);
	} 

	

	public function StockPerGeo()
	{
		$commandgeo             = Yii::$app->db3
                                ->createCommand('SELECT geo.GEO_ID,geo.GEO_NM FROM dbc002.c0002scdl_geo geo WHERE geo.GEO_ID IS NOT NULL AND geo.GEO_ID != 1 AND geo.GEO_ID != 7')
                                ->queryAll();
        $commandproduct         = Yii::$app->db3
                                ->createCommand('SELECT prod.KD_BARANG,prod.NM_BARANG,prod.KD_TYPE FROM dbc002.b0001 prod WHERE prod.KD_TYPE=01 AND prod.KD_KATEGORI=01')
                                ->queryAll();
        $tanggalsekarang = date("Y/m/01");
        foreach ($commandgeo as $key => $valuegeo) 
        {
            $GEO_NM         = $valuegeo['GEO_NM'];
            $category[]     = array('label' => $GEO_NM);
        }

        foreach ($commandproduct as $key => $valueproduct) 
        {
        	$KD_BARANG 		= $valueproduct['KD_BARANG'];
        	$NM_BARANG 		= $valueproduct['NM_BARANG'];

            $data           = array();
            foreach ($commandgeo as $key => $valuegeo) 
            {
                $GEO_NM         = $valuegeo['GEO_NM'];
                $GEO_ID         = $valuegeo['GEO_ID'];

                $commandstock   = Yii::$app->db3
                                ->createCommand('SELECT s.TGL,s.SO_QTY FROM dbc002.so_t2 s INNER JOIN (SELECT MAX(stock.ID)AS MAX_ID FROM so_t2 stock 
                    INNER JOIN dbc002.c0001 cust on stock.CUST_KD = cust.CUST_KD 
                    WHERE stock.KD_BARANG = "'. $KD_BARANG. '" AND cust.GEO = '.$GEO_ID.' AND stock.SO_TYPE = 5 AND stock.TGL >= "2016-10-01" GROUP BY cust.CUST_NM ORDER BY cust.CUST_NM 
                    )as R on s.ID = R.MAX_ID')
                                ->queryAll();

                $total = 0;
                foreach ($commandstock as $key => $value) 
                {
                    if($value['SO_QTY'] < 0)
                    {
                      $total = $total + 0;  
                    }
                    else
                    {
                      $total = $total + $value['SO_QTY'];  
                    }
                }
                
                $data[]     = array('value'=>$total);
            }
            $dataset[]  = array('seriesname'=>$NM_BARANG,'data'=>$data);
        }

        $categories[]   = array('category'=>$category);

        $FS = new FusionChart();
        $FS->setCaption('Stock Per Geo');
        $FS->setXAxisName('Geo');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

        $result = array('chart'=>$chart,'categories'=>$categories,'dataset'=>$dataset);
        return $result;
	}

    public function StockPerLayer()
    {
        $commandlayer    = Yii::$app->db3
                                ->createCommand('SELECT layer.LAYER_ID,layer.LAYER_NM FROM dbc002.c0002scdl_layer layer WHERE layer.LAYER_ID != 5')
                                ->queryAll();

        $commandproduct         = Yii::$app->db3
                                ->createCommand('SELECT prod.KD_BARANG,prod.NM_BARANG,prod.KD_TYPE FROM dbc002.b0001 prod WHERE prod.KD_TYPE=01 AND prod.KD_KATEGORI=01')
                                ->queryAll();
        $tanggalsekarang = date("Y/m/01");
        foreach ($commandlayer as $key => $valuelayer) 
        {
            $LAYER_NM       = $valuelayer['LAYER_NM'];
            $category[]     = array('label' => $LAYER_NM);
        }

        foreach ($commandproduct as $key => $valueproduct) 
        {
            $KD_BARANG      = $valueproduct['KD_BARANG'];
            $NM_BARANG      = $valueproduct['NM_BARANG'];

            $data           = array();
            foreach ($commandlayer as $key => $valuelayer) 
            {
                $LAYER_ID         = $valuelayer['LAYER_ID'];

                $commandstock   = Yii::$app->db3
                                ->createCommand('SELECT s.TGL,s.SO_QTY FROM dbc002.so_t2 s INNER JOIN (SELECT MAX(stock.ID)AS MAX_ID FROM so_t2 stock 
                                    INNER JOIN dbc002.c0001 cust on stock.CUST_KD = cust.CUST_KD 
                                    WHERE stock.KD_BARANG = "'. $KD_BARANG. '" AND cust.LAYER = '.$LAYER_ID.' AND stock.SO_TYPE = 5 AND stock.TGL >= "2016-10-01" GROUP BY cust.CUST_NM ORDER BY cust.CUST_NM 
                    )as R on s.ID = R.MAX_ID')

                                ->queryAll();
                $total = 0;
                foreach ($commandstock as $key => $value) 
                {
                    if($value['SO_QTY'] < 0)
                    {
                      $total = $total + 0;  
                    }
                    else
                    {
                      $total = $total + $value['SO_QTY'];  
                    }
                    
                }

                $data[]     = array('value'=>$total);
            }
            $dataset[]  = array('seriesname'=>$NM_BARANG,'data'=>$data);
        }

        $categories[]   = array('category'=>$category);
        $FS = new FusionChart();
        $FS->setCaption('Stock Per Layer');
        $FS->setXAxisName('Layer');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);
        $result = array('chart'=>$chart,'categories'=>$categories,'dataset'=>$dataset);
        return $result;
    }

    public function StockTotalPerProducts()
    {

        $commandproduct         = Yii::$app->db3
                                ->createCommand('SELECT prod.KD_BARANG,prod.NM_BARANG,prod.KD_TYPE FROM dbc002.b0001 prod WHERE prod.KD_TYPE=01 AND prod.KD_KATEGORI=01')
                                ->queryAll();

        foreach ($commandproduct as $key => $valueproduct) 
        {
            $KD_BARANG      = $valueproduct['KD_BARANG'];
            $NM_BARANG      = $valueproduct['NM_BARANG'];

                $commandstock   = Yii::$app->db3
                                ->createCommand('SELECT SUM(s.SO_QTY)AS TOTAL FROM dbc002.so_t2 s INNER JOIN (SELECT MAX(stock.ID)AS MAX_ID FROM so_t2 stock 
                                    INNER JOIN dbc002.c0001 cust on stock.CUST_KD = cust.CUST_KD 
                                    WHERE stock.KD_BARANG = "'. $KD_BARANG. '" AND stock.SO_TYPE = 5 AND stock.TGL >= "2016-10-01" GROUP BY cust.CUST_NM ORDER BY cust.CUST_NM 
                    )as R on s.ID = R.MAX_ID')
                                ->queryAll();
            $data[]         = array('label' => $NM_BARANG,'value'=>$commandstock[0]['TOTAL']);

        }

        $FS = new FusionChart();
        $FS->setCaption('Total Stock Per Products');
        $FS->setXAxisName('Products');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);
        $result = array('chart'=>$chart,'data'=>$data);
        return $result;
    }
}

