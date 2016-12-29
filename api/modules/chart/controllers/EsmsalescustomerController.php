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

class EsmsalescustomerController extends ActiveController
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

	public function actions()
	{
		$actions = parent::actions();
		unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		return $actions;
	}
	 
	public function actionIndex()
	{
		return array(
						'Total_Layer'		=> $this->TotalLayer(),
						'Total_Geo' 		=> $this->TotalGeo(),
						'CombLayerGeo' 		=> $this->CombGeoLayer(),
                        'CustomerParent'    => $this->CustomerParent(),
                        'CustomerGeoParent' => $this->CombGeoParent()
					);
	} 

	public function TotalGeo()
	{
		$commandgeo    = Yii::$app->db3
                                ->createCommand('SELECT geo.GEO_ID,geo.GEO_NM FROM dbc002.c0002scdl_geo geo WHERE geo.GEO_ID IS NOT NULL AND geo.GEO_ID != 1 AND geo.GEO_ID != 7')
                                ->queryAll();
        foreach ($commandgeo as $key => $valuegeo) 
        {
        	$GEO_ID 		= $valuegeo['GEO_ID'];
        	$GEO_NM 		= $valuegeo['GEO_NM'];
        	$commandgeo    	= Yii::$app->db3
                                ->createCommand('SELECT cust.CUST_KD FROM dbc002.c0001 cust WHERE cust.STATUS <> 3 AND cust.GEO != 7 AND cust.GEO != 1 AND cust.GEO =' .$GEO_ID. ' ')
                                ->queryAll();
            $jumlahgeo		= count($commandgeo);
        	$data[] 	    = array('label' => $GEO_NM,'value'=>$jumlahgeo);
        }

        $FS = new FusionChart();
        $FS->setCaption('Customer Per Geolocation');
        $FS->setXAxisName('Geolocation');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

		$result = array('chart'=>$chart,'data'=>$data);
		return $result;
	}

	public function TotalLayer()
	{
		$commandlayer    = Yii::$app->db3
                                ->createCommand('SELECT layer.LAYER_ID,layer.LAYER_NM FROM dbc002.c0002scdl_layer layer')
                                ->queryAll();
        foreach ($commandlayer as $key => $valuelayer) 
        {
        	$LAYER_ID 		= $valuelayer['LAYER_ID'];
        	$LAYER_NM 		= $valuelayer['LAYER_NM'];
        	$commandcust    = Yii::$app->db3
                                ->createCommand('SELECT cust.CUST_KD FROM dbc002.c0001 cust WHERE cust.STATUS <> 3 AND cust.LAYER =' .$LAYER_ID.' AND cust.GEO != 7 AND cust.GEO != 1')
                                ->queryAll();
            $jumlahlayer	= count($commandcust);
        	$data[] 		= array('label' => $LAYER_NM,'value'=>$jumlahlayer);
        }

        $FS = new FusionChart();
        $FS->setCaption('Customer Per Layer');
        $FS->setXAxisName('Layer');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

		$result = array('chart'=>$chart,'data'=>$data);
		return $result;
	}

	public function CombGeoLayer()
	{
		
		$commandgeo    = Yii::$app->db3
                                ->createCommand('SELECT geo.GEO_ID,geo.GEO_NM FROM dbc002.c0002scdl_geo geo WHERE geo.GEO_ID != 1 AND geo.GEO_ID != 7')
                                ->queryAll();
        
        $commandlayer    = Yii::$app->db3
                                ->createCommand('SELECT layer.LAYER_ID,layer.LAYER_NM FROM dbc002.c0002scdl_layer layer')
                                ->queryAll();

        foreach ($commandgeo as $key => $valuegeo) 
        {
        	$GEO_NM 		= $valuegeo['GEO_NM'];
        	$category[] 	= array('label' => $GEO_NM);
        }

        foreach ($commandlayer as $key => $valuelayer) 
        {
        	$ID_LAYER 		= $valuelayer['LAYER_ID'];
        	$data 			= array();
        	foreach ($commandgeo as $key => $valuegeo) 
	        {
	        	$ID_GEO 	= $valuegeo['GEO_ID'];
	        	$commandcust    = Yii::$app->db3
                                ->createCommand('SELECT cust.CUST_KD FROM dbc002.c0001 cust WHERE  cust.STATUS <> 3 AND cust.GEO != 7 AND cust.GEO != 1 AND cust.GEO =' .$ID_GEO. ' AND cust.LAYER='.$ID_LAYER)
                                ->queryAll();
                $jumlah		= count($commandcust);
                $data[]     = array('value'=>$jumlah);
	        }
        	$dataset[]  = array('seriesname'=>$valuelayer['LAYER_NM'],'data'=>$data);
        }
        $categories[] 	= array('category'=>$category);

        $FS = new FusionChart();
        $FS->setCaption('Customer Geolocation Per Layer');
        $FS->setXAxisName('Geolocation');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

		$result = array('chart'=>$chart,'categories'=>$categories,'dataset'=>$dataset);
		return $result;
	}

    public function CustomerParent()
    {
        
        $customerparent    = Yii::$app->db3
                                ->createCommand('SELECT master.CUST_NM as label,C.value as value FROM dbc002.c0001 master 
                                    INNER JOIN 
                                    (SELECT a.CUST_GRP,SUM(a.STATUS)-1 as VALUE FROM dbc002.c0001 a  
                                        WHERE a.STATUS <> 3  AND a.GEO != 7 AND a.GEO != 1 GROUP BY a.CUST_GRP ORDER BY VALUE ASC
                                    )C 
                                    ON master.CUST_KD = C.CUST_GRP WHERE master.CUST_GRP = master.CUST_KD')
                                ->queryAll();
        $data = $customerparent;

        $FS = new FusionChart();
        $FS->setCaption('Customer Parent');
        $FS->setXAxisName('Parent');
        $FS->setLabelDisplay('rotate');
        $FS->setSlantLabels(1);
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

        $result = array('chart'=>$chart,'data'=>$data);
        return $result;
    }

    public function CombGeoParent()
    {
        
        $commandgeo    = Yii::$app->db3
                                ->createCommand('SELECT geo.GEO_ID,geo.GEO_NM FROM dbc002.c0002scdl_geo geo WHERE geo.GEO_ID != 1 AND geo.GEO_ID != 7')
                                ->queryAll();
        
        $commandparent    = Yii::$app->db3
                                ->createCommand('
                                                    SELECT a.CUST_KD,a.CUST_GRP,a.CUST_NM FROM dbc002.c0001 a
                                                    INNER JOIN 
                                                    (
                                                        SELECT B.CUST_KD,SUM(B.status)- 1 as value FROM dbc002.c0001 B  
                                                        WHERE B.STATUS <> 3 GROUP BY B.CUST_GRP 
                                                        ORDER BY value ASC
                                                    )C
                                                    ON a.CUST_KD = C.CUST_KD WHERE a.CUST_KD = a.CUST_GRP AND a.STATUS <> 3
                                                ')
                                ->queryAll();

        foreach ($commandparent as $key => $valueparent) 
        {
            $PARENT         = $valueparent['CUST_NM'];
            $category[]     = array('label' => $PARENT);
        }

        foreach ($commandgeo as $key => $valuegeo) 
        {
            $ID_GEO         = $valuegeo['GEO_ID'];
            $data           = array();
            foreach ($commandparent as $key => $valueparent) 
            {
                $ID_GROUP       = $valueparent['CUST_GRP'];
                $commandcust    = Yii::$app->db3
                                ->createCommand('
                                                    SELECT cust.CUST_KD FROM dbc002.c0001 cust 
                                                    WHERE  cust.STATUS <> 3 
                                                    AND cust.GEO != 7 
                                                    AND cust.GEO != 1 
                                                    AND cust.GEO ='.$ID_GEO.' 
                                                    AND cust.CUST_GRP= "'.$ID_GROUP.'"
                                                ')
                                ->queryAll();
                $jumlah     = count($commandcust);
                $data[]     = array('value'=>$jumlah);
            }
            $dataset[]  = array('seriesname'=>$valuegeo['GEO_NM'],'data'=>$data);
        }
        $categories[]   = array('category'=>$category);

        $FS = new FusionChart();
        $FS->setCaption('Customer Geolocation Parent');
        $FS->setXAxisName('Geolocation');
        $FS->setLabelDisplay('rotate');
        $FS->setSlantLabels(1);
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

        $result = array('chart'=>$chart,'categories'=>$categories,'dataset'=>$dataset);
        return $result;
    }

}

