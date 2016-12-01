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
class EsmsaleskpiController extends ActiveController
{	
	/**
	  * Source Database declaration 
	 */
    public $modelClass = 'api\modules\chart\models\Cnfweek';

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

	public function actionIndex()
	{		
		if (!empty($_GET)) 
        {
            $query_date = $_GET['MONTH'];
            $tanggal 	= Yii::$app->ambilkonci->getDayStartAndEnd($query_date);
            $user_id 	= $_GET['USER_ID'];
        }
        else
        {
            $query_date = date('Y-m-d');
            $tanggal 	= Yii::$app->ambilkonci->getDayStartAndEnd($query_date);
            $user_id 	= 61;
        }
        $data = array(
        					'AC'		=> $this->CustomerCall($tanggal,$user_id),
        					'EC'		=> $this->EffectiveCall(9,$tanggal,$user_id),
        					'SC'		=> $this->EffectiveCall(10,$tanggal,$user_id),
							'NOO'		=> $this->NOO($tanggal,15,$user_id)
						);
		return $data;
	}

 	protected function CustomerCall($query_date,$user_id) 
	{
		$f_date 	= $query_date[0];
		$l_date 	= $query_date[1];
		$user_id 	= $user_id;

		$commandgeo    = Yii::$app->db3
                                ->createCommand('
                                					SELECT scdl.CUST_ID,
													SUM(CASE WHEN (scdl.STATUS=1) THEN 1 END) AS AC
													FROM dbc002.c0002scdl_detail scdl 
													WHERE scdl.STATUS <> 3 AND scdl.TGL >= "'.$f_date.'" AND scdl.TGL <= "'.$l_date.'"
													AND scdl.USER_ID = '.$user_id.'
												')
                             	->queryOne();
        $result = $commandgeo['AC'];
        if(!$result)
        {
        	$result = 0;
        }                     	
     	return $result;
	}

	protected function EffectiveCall($type,$query_date,$user_id) 
	{
		$type 		= $type;
		$f_date 	= $query_date[0];
		$l_date 	= $query_date[1];
		$user_id 	= $user_id;
		$commandgeo    = Yii::$app->db3
                                ->createCommand('
													SELECT sale.CUST_KD FROM so_t2 sale WHERE sale.SO_TYPE = '.$type.' 
													AND sale.TGL >= "'.$f_date.'" 
													AND sale.TGL <= "'.$l_date.'"
													AND sale.USER_ID = '.$user_id.'
												 	GROUP BY sale.CUST_KD
												')
                             	->queryAll();
        $result = count($commandgeo);                     	
     	return $result;
	}

	protected function NOO($query_date,$target,$user_id) 
	{
		$f_date 	= $query_date[0];
		$l_date 	= $query_date[1];
		$user_id 	= $user_id;
		$target 	= $target;
		$parent 	= 'CUS.2016.000637';
		$commandgeo    = Yii::$app->db3
                                ->createCommand('
                                					SELECT COUNT(cust.CUST_KD)as JUMLAH FROM c0001 cust
                                					INNER JOIN dbm001.user users 
													ON cust.CREATED_BY = users.username 
													WHERE cust.CUST_GRP = "'.$parent.'" 
													AND cust.JOIN_DATE >= "'.$f_date.'" 
													AND cust.JOIN_DATE <= "'.$l_date.'"
													AND users.id = '.$user_id.'
												')
                             	->queryOne();
        $result = $commandgeo['JUMLAH'];                     	
     	return $result;
	}
}

