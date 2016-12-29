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
class EsmsalescontrolController extends ActiveController
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
            $query_date = $_GET['TGLSTART'];
        }
        else
        {
            $query_date = date('Y-m-d');
        }
        $data[] = array(
        					'AC'		=> $this->CustomerCall($query_date),
        					'EC'		=> $this->EffectiveCall(9,$query_date),
        					
        				);
		$data[] = array(
							
							'SC'		=> $this->EffectiveCall(10,$query_date),
							'NOO'		=> $this->NOO($query_date,15),
							// 'ABSENSI'		=> $this->ABSENSI($query_date)
							// 'RO'		=> $this->NOO($query_date,50),
							// 'SO'		=> $this->NOO($query_date,50),
						);
		return $data;
	}

 	protected function CustomerCall($query_date) 
	{
		$f_date = $query_date;
		$commandgeo    = Yii::$app->db3
                                ->createCommand('   SELECT scdl.CUST_ID,
													SUM(CASE WHEN (scdl.STATUS=1) THEN 1 ELSE 0 END) AS AC,
													COUNT(scdl.CUST_ID) AS TOTCALL 
													FROM dbc002.c0002scdl_detail scdl 
													WHERE scdl.STATUS <> 3 AND scdl.TGL = "'.$f_date.'"
												')
                             	->queryOne();
        $result = $commandgeo['AC'].'/'.$commandgeo['TOTCALL'];                     	
     	return $result;
	}

	protected function EffectiveCall($type,$query_date) 
	{
		$type 	= $type;
		$f_date = $query_date;
		$commandgeo    = Yii::$app->db3
                                ->createCommand('
                                					SELECT count(B.CUST_KD)AS JUMLAH,count(cust.CUST_ID)AS TOTAL FROM c0002scdl_detail cust
													LEFT JOIN
														(SELECT sale.CUST_KD FROM so_t2 sale WHERE sale.SO_TYPE = '.$type.' AND sale.TGL = "'.$f_date.'" GROUP BY sale.CUST_KD)B
													 ON 
													cust.CUST_ID = B.CUST_KD WHERE cust.TGL = "'.$f_date.'" AND cust.STATUS <> 3
												')
                             	->queryOne();
        $result = $commandgeo['JUMLAH'].'/'.$commandgeo['TOTAL'];                     	
     	return $result;
	}

	protected function NOO($query_date,$target) 
	{
		$f_date = $query_date;
		$target = $target;
		$parent = 'CUS.2016.000637';
		$commandgeo    = Yii::$app->db3
                                ->createCommand('
                                					SELECT COUNT(cust.CUST_KD)as JUMLAH FROM c0001 cust 
                                					WHERE cust.CUST_GRP = "'.$parent.'" AND 
                                					cust.JOIN_DATE = "'.$f_date.'"
												')
                             	->queryOne();
        $result = $commandgeo['JUMLAH'].'/'.$target;                     	
     	return $result;
	}

	protected function ABSENSI($query_date) 
	{
		$f_date = $query_date;
		$commandgeo    = Yii::$app->db3
                                ->createCommand('
                                					SELECT R.ACTIVE,COUNT(users.id)TOTAL FROM dbm001.user users 
													INNER JOIN dbm_086.user_profile sales_profile
													ON users.id = sales_profile.ID_USER
													INNER JOIN
														(SELECT COUNT(ID)AS ACTIVE FROM c0015  WHERE TGL = "'.$f_date.'")R
													WHERE users.POSITION_LOGIN = 1 AND users.USER_ALIAS IS NOT NULL AND users.ID NOT IN(61,62)
												')
                             	->queryOne();
        $result = $commandgeo['ACTIVE'].'/'.$commandgeo['TOTAL'];                     	
     	return $result;
	}
}

