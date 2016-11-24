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
		return array(
						'AC'		=> $this->CustomerCall(),
						'EC'		=> $this->EffectiveCall(9),
						'SC'		=> $this->EffectiveCall(10)
					);	
	}

 	protected function CustomerCall() 
	{
		$f_date = '2016-11-24';
		$commandgeo    = Yii::$app->db3
                                ->createCommand('SELECT scdl.CUST_ID,
													SUM(CASE WHEN (scdl.STATUS=1) THEN 1 END) AS AC,
													COUNT(scdl.CUST_ID) AS TOTCALL 
													FROM dbc002.c0002scdl_detail scdl 
													WHERE scdl.STATUS <> 3 AND scdl.TGL = "'.$f_date.'"
												')
                             	->queryOne();
        $result = $commandgeo['AC'].'/'.$commandgeo['TOTCALL'];                     	
     	return $result;
	}

	protected function EffectiveCall($type) 
	{
		$f_date = '2016-11-24';
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
}

