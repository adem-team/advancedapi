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
        	$TGLSTART   = $_GET['TGLSTART'];
            $TGLEND     = $_GET['TGLEND'];

        	$f_date     = date('Y-m-d', strtotime($TGLSTART));
	        $l_date     = date('Y-m-d', strtotime($TGLEND));

			return array(
							'NewCustCombGeoLayer'		=> $this->NewCustCombGeoLayer($f_date,$l_date),
							'NewCustCombGeoSales'		=> $this->NewCustCombGeoSales($f_date,$l_date),
						);
		}
	} 

	public function NewCustCombGeoLayer($f_date,$l_date)
	{
		

        $f_date     = $f_date;
        $l_date     = $l_date;

        $namabulan  = date('F Y', strtotime($f_date));

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
	public function NewCustCombGeoSales($f_date,$l_date)
	{
		

        $f_date     = $f_date;
        $l_date     = $l_date;

        $namabulan  = date('F Y', strtotime($f_date));
        $parent 	= 'CUS.2016.000637';

        $commandlayer    = Yii::$app->db3
                                ->createCommand('
	                                				SELECT sales_profile.NM_FIRST as label,(CASE WHEN B.JUMLAH THEN B.JUMLAH ELSE 0 END)AS value
													FROM dbm001.user users 
													INNER JOIN dbm_086.user_profile sales_profile
													ON users.id = sales_profile.ID_USER
													LEFT JOIN
													(
															SELECT count(prof.id)AS JUMLAH,prof.username FROM c0001 cust 
															INNER JOIN dbm001.user prof
															ON cust.CREATED_BY = prof.username
															WHERE cust.CUST_GRP = "'.$parent.'" 
															AND cust.JOIN_DATE >= "'.$f_date.'" AND cust.JOIN_DATE <= "'.$l_date.'" GROUP BY cust.CREATED_BY
													)B
													ON users.username = B.username
													WHERE users.POSITION_LOGIN = 1 AND users.USER_ALIAS IS NOT NULL AND users.ID NOT IN(61,62) ORDER BY users.id
												')
                                ->queryAll();

        	$data 		= $commandlayer;


        $FS = new FusionChart();
        $FS->setCaption('New Customer ');
        $FS->setSubCaption('On '.$namabulan);
        $FS->setXAxisName('Geolocation');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

		$result = array('chart'=>$chart,'data'=>$data);
		return $result;
	}



}

