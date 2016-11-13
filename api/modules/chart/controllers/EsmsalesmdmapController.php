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


class EsmsalesmdmapController extends ActiveController
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
		
		$conn = Yii::$app->db_esm;
		$hasil = $conn->createCommand("
			SELECT x1.CUST_KD,x1.CUST_NM,x1.ALAMAT,x1.MAP_LAT, x1.MAP_LNG,
						 (CASE WHEN x2.CUST_ID is NOT NULL THEN 1 ELSE 0 END) as STT_ONLINE,
						 (CASE WHEN x2.CUST_ID is NOT NULL THEN x2.NM_FIRST ELSE 'none' END) as USER_VISIT			 
				FROM c0001 x1 LEFT JOIN
						(	SELECT a1.CREATE_AT ,a1.CUST_ID, a2.CUST_NM,a1.USER_ID, a3.NM_FIRST
							FROM c0002scdl_detail a1 LEFT JOIN c0001 a2 on a2.CUST_KD=a1.CUST_ID
							LEFT JOIN dbm_086.user_profile a3 on a3.ID_USER=a1.USER_ID
							WHERE a1.TGL=CURDATE() AND a1.STATUS=1
							GROUP BY a1.CUST_ID
							ORDER BY a1.CREATE_AT DESC
						) x2 ON x2.CUST_ID=x1.CUST_KD
			
		")->queryAll();

		$hasil_icon = $conn->createCommand("SELECT MAP_ICON,STT FROM c0020 ORDER BY STT")->queryAll();
		
		return array('CustMap' => $hasil,'icon'=>$hasil_icon);				
	} 
	
	private function map()
    {
		$conn = Yii::$app->db_esm;
		$hasil = $conn->createCommand("SELECT c.SCDL_GROUP,c.CUST_KD, c.ALAMAT, c.CUST_NM,c.MAP_LAT,c.MAP_LNG,b.SCDL_GROUP_NM from c0001 c
									  left join c0007 b on c.SCDL_GROUP = b.ID")->queryAll();

		return $hasil;
    }
	
}
