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

class EsmsaleskunjungancustomerController extends ActiveController
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
						'Kunjungan_Geo_Per_Bulan'		=> $this->TotalKunjunganGeoPerBulan($query_date),
					);
	} 


	public function TotalKunjunganGeoPerBulan($query_date)
	{
        $f_date     = date('Y-m-01', strtotime($query_date));
        $l_date     = date('Y-m-t', strtotime($query_date));
        $namabulan  = date('F Y', strtotime($query_date));

        $commandgeo             = Yii::$app->db3
                                ->createCommand('SELECT geo.GEO_ID,geo.GEO_NM FROM dbc002.c0002scdl_geo geo WHERE geo.GEO_ID IS NOT NULL AND geo.GEO_ID != 1 AND geo.GEO_ID != 7')
                                ->queryAll();
                                
        foreach ($commandgeo as $key => $valuegeo) 
        {
            $GEO_NM         = $valuegeo['GEO_NM'];
            $GEO_ID         = $valuegeo['GEO_ID'];

        	$commandcust    = Yii::$app->db3
                                ->createCommand('SELECT scdldetail.CUST_ID,cust.CUST_NM, scdldetail.USER_ID,cust.GEO,cust.LAYER FROM dbc002.c0002scdl_detail scdldetail 
                                                    INNER JOIN dbc002.c0001 cust on scdldetail.CUST_ID = cust.CUST_KD 
                                                    WHERE scdldetail.STATUS=1 AND scdldetail.TGL BETWEEN "'.$f_date.'" AND "'.$l_date.'" AND cust.GEO='.$GEO_ID.' GROUP BY scdldetail.CUST_ID ORDER BY scdldetail.USER_ID DESC')
                                ->queryAll();
            $jumlahlayer	= count($commandcust);
        	$data[] 		= array('label' => $GEO_NM,'value'=>$jumlahlayer);
        }

        $FS = new FusionChart();
        $FS->setCaption('Cust Kunjungan Geo');
        $FS->setSubCaption($namabulan);
        $FS->setXAxisName('Geo');
        $FS->setYAxisName('Customer Yang Dikunjungi');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

		$result = array('chart'=>$chart,'data'=>$data);
		return $result;
	}
}

