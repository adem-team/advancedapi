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
class EsmsalescontroldetailusercallController extends ActiveController
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
            $action 	= $_GET['ACTION'];
        }
        else
        {
            $query_date = date('Y-m-d');
            $action 	= 'AC';
        }
        if($action == 'AC')
        {
        	return array('CustomerCall'		=> $this->CustomerCall($query_date));
        }
        if($action == 'NOO')
        {
        	return array('CustomerCall'		=> $this->NOO($query_date));
        }
        if($action == 'RO')
        {
        	return array('CustomerCall'		=> $this->REQUESTBYQTY($query_date,9));
        }
        if($action == 'SO')
        {
        	return array('CustomerCall'		=> $this->REQUESTBYQTY($query_date,10));
        }

        if($action == 'EC')
        {
        	return array('CustomerCall'		=> $this->REQUESTBYCUST($query_date,9));
        }
        if($action == 'SOC')
        {
        	return array('CustomerCall'		=> $this->REQUESTBYCUST($query_date,10));
        }
	}

 	protected function CustomerCall($query_date) 
	{
		$f_date = $query_date;
		$commandgeo    = Yii::$app->db3
                                ->createCommand('


													SELECT USERS.NM_FIRST,USERS.USERNAME,
													SUM(CASE WHEN SCDL.AC THEN SCDL.AC ELSE 0 END)AS AC,
													SUM(CASE WHEN SCDL.NOTCALL THEN SCDL.NOTCALL ELSE 0 END)AS NOTC,
													COUNT(SCDL.CUST_ID)AS TOTAL,
													CONCAT(SUM(CASE WHEN SCDL.AC THEN SCDL.AC ELSE 0 END),"/",COUNT(SCDL.CUST_ID))AS NILAI 
													FROM 
													(
														SELECT users.id AS USER_ID,users.username as USERNAME,sales_profile.NM_FIRST FROM dbm001.user users 
														INNER JOIN dbm_086.user_profile sales_profile
														ON users.id = sales_profile.ID_USER
														WHERE users.POSITION_LOGIN = 1 AND users.USER_ALIAS IS NOT NULL AND users.ID NOT IN(61,62)
													)USERS
													LEFT JOIN 
													(
														SELECT scdl.CUST_ID,scdl.USER_ID,(CASE WHEN scdl.STATUS = 1 THEN 1 END) AS AC ,(CASE WHEN scdl.STATUS = 0 THEN 1 END) AS NOTCALL
														FROM c0002scdl_detail scdl WHERE scdl.TGL = "'.$f_date.'"
													)SCDL
													ON USERS.USER_ID = SCDL.USER_ID GROUP BY USERS.USER_ID
												')
                             	->queryAll();                     	
     	return $commandgeo;
	}

	protected function NOO($query_date) 
	{
		$f_date = $query_date;
		$parent = 'CUS.2016.000637';
		$commandgeo    = Yii::$app->db3
                                ->createCommand('
                                					SELECT sales_profile.NM_FIRST as NM_FIRST,(CASE WHEN B.JUMLAH THEN B.JUMLAH ELSE 0 END)AS AC,3 AS TOTAL,
                                					CONCAT(CASE WHEN B.JUMLAH THEN B.JUMLAH ELSE 0 END)AS NILAI
													FROM dbm001.user users 
													INNER JOIN dbm_086.user_profile sales_profile
													ON users.id = sales_profile.ID_USER
													LEFT JOIN
													(
															SELECT count(prof.id)AS JUMLAH,prof.username FROM c0001 cust 
															INNER JOIN dbm001.user prof
															ON cust.CREATED_BY = prof.username
															WHERE cust.CUST_GRP = "'.$parent.'" 
															AND cust.JOIN_DATE = "'.$f_date.'" GROUP BY cust.CREATED_BY
													)B
													ON users.username = B.username
													WHERE users.POSITION_LOGIN = 1 AND users.USER_ALIAS IS NOT NULL AND users.ID NOT IN(61,62) ORDER BY users.id
												')
                             	->queryAll();                     	
     	return $commandgeo;
	}

	protected function REQUESTBYCUST($query_date,$type) 
	{
		$f_date = $query_date;
		$type 	= $type;
		$commandgeo    = Yii::$app->db3
                                ->createCommand('
													SELECT users.username,sales_profile.NM_FIRST,(CASE WHEN ISNULL(C.AC)THEN 0 ELSE C.AC END)AS AC,(CASE WHEN ISNULL(C.TOTAL)THEN 0 ELSE C.TOTAL END)AS TOTAL,
													CONCAT(CASE WHEN ISNULL(C.AC)THEN 0 ELSE C.AC END,"/",CASE WHEN ISNULL(C.TOTAL)THEN 0 ELSE C.TOTAL END)AS NILAI
													FROM dbm001.user users 
													INNER JOIN dbm_086.user_profile sales_profile
													ON users.id = sales_profile.ID_USER
													LEFT JOIN
													(SELECT A.CUST_ID,A.USER_ID,B.CUST_KD,SUM(CASE WHEN  ISNULL(B.CUST_KD) THEN 0 ELSE 1 END)AS AC,COUNT(A.USER_ID)TOTAL FROM 
														(SELECT CUST_ID,USER_ID FROM c0002scdl_detail sdtl WHERE sdtl.TGL = "'.$f_date.'")A
															LEFT JOIN 
														(SELECT CUST_KD,USER_ID FROM so_t2 WHERE SO_TYPE = '.$type.' AND TGL = "'.$f_date.'" GROUP BY CUST_KD)B
														  ON A.CUST_ID = B.CUST_KD
													GROUP BY A.USER_ID)C
													ON users.id = C.USER_ID 
													WHERE users.POSITION_LOGIN = 1 AND users.USER_ALIAS IS NOT NULL AND users.ID NOT IN(61,62)
													GROUP BY users.id ORDER BY users.id 
												')
                             	->queryAll();                     	
     	return $commandgeo;
	}

	protected function REQUESTBYQTY($query_date,$type) 
	{
		$f_date = $query_date;
		$type 	= $type;
		$commandgeo    = Yii::$app->db3
                                ->createCommand('
                                					SELECT absensi.USER_ID,absensi.USER_NM as NM_FIRST,
                                					(CASE WHEN B.PCS > 0 THEN B.PCS ELSE 0 END)JUMLAH,
                                					(CASE WHEN B.JUMLAH > 0 THEN B.JUMLAH ELSE 0 END)AS AC,10 AS TOTAL FROM c0015 as absensi
													LEFT JOIN
														(
															SELECT sale.USER_ID,sale.CUST_KD,sale.SO_TYPE,
															ROUND(SUM(sale.SO_QTY))AS PCS,
															ROUND(SUM(sale.SO_QTY/24))AS JUMLAH FROM so_t2 sale 
															WHERE sale.SO_TYPE = '.$type.' 
															AND sale.TGL = "'.$f_date.'" 
															GROUP BY sale.USER_ID
														)B
													ON absensi.USER_ID = B.USER_ID
													WHERE absensi.TGL = "'.$f_date.'" ORDER BY absensi.USER_ID
												')
                             	->queryAll();                     	
     	return $commandgeo;
	}
}

