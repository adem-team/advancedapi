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

class EsmsalesnewcustomerController extends ActiveController
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
        	$query_date = $_GET['MONTH'];
        }
        else
        {
        	$query_date = date('Y-m-d');
        }
		return array(
						'NewCustCombGeoLayer'		=> $this->NewCustCombGeoLayer($query_date),
					);
	} 

	public function NewCustCombGeoLayer($query_date)
	{
		

        $f_date     = date('Y-m-01', strtotime($query_date));
        $l_date     = date('Y-m-t', strtotime($query_date));

        $namabulan  = date('F Y', strtotime($query_date));

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
                                ->createCommand('SELECT cust.CUST_KD FROM dbc002.c0001 cust WHERE cust.JOIN_DATE BETWEEN "'.$f_date.'" AND "'.$l_date.'" AND cust.GEO =' .$ID_GEO. ' AND cust.LAYER='.$ID_LAYER)
                                ->queryAll();
                $jumlah		= count($commandcust);
                $data[]     = array('value'=>$jumlah);
	        }
        	$dataset[]  = array('seriesname'=>$valuelayer['LAYER_NM'],'data'=>$data);
        }
        $categories[] 	= array('category'=>$category);

        $FS = new FusionChart();
        $FS->setCaption('New Customer ');
        $FS->setSubCaption('On '.$namabulan);
        $FS->setXAxisName('Geolocation');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

		$result = array('chart'=>$chart,'categories'=>$categories,'dataset'=>$dataset);
		return $result;
	}



}

