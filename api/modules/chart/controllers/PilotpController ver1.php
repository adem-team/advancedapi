<?php

namespace api\modules\chart\controllers;

use yii;
use kartik\datecontrol\Module;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
//use common\models\User;
use lukisongroup\models\system\user\UserloginSearch;
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
use api\modules\chart\models\Pilotproject;
//use api\modules\chart\models\PilotprojectSearch;
use api\modules\chart\models\Pilotplan;
use api\modules\chart\models\Pilotactual;
use api\modules\chart\models\Pilotdelay;
use api\modules\chart\models\Pilotmilestone;
use yii\web\HttpException;
//use yii\data\ActiveDataProvider;

/**
  * Controller Pilotproject Class  
  *
  * @author ptrnov  <piter@lukison.com>
  * @since 1.1
  * @link https://github.com/C12D/advanced/blob/master/api/modules/chart/controllers/PilotpController.php
  * @see https://github.com/C12D/advanced/blob/master/api/modules/chart/controllers/PilotpController.php
 */
class PilotpController extends ActiveController
{	
	/**
	  * Source Database declaration 
	 */
    public $modelClass = 'api\modules\chart\models\Cnfweek';
	//public $serializer = [
	//	'class' => 'yii\rest\Serializer',
	//	'collectionEnvelope' => 'Personalia',
	//];
	
	/**
     * @inheritdoc
     */
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                 ['class' => HttpBearerAuth::className()],
                 ['class' => QueryParamAuth::className()],//, 'tokenParam' => 'access-token'],
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
					'Origin' => ['http://lukisongroup.com', 'http://lukisongroup.int'],
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
	/**
     * Get Request id_user 
	 * @type GET
     */
	protected function gt_userid(){
		$request = Yii::$app->request;		
		return $request->get('id_user');		
	}
	
	protected function gt_deptid(){
		$UserloginSearch = new UserloginSearch();	
		$ModelUser = UserloginSearch::findUserAttr($this->gt_userid())->one();
		if (count($ModelUser)<>0){ /*RECORD TIDAK ADA*/
			$deptid=$ModelUser->emp->DEP_ID;			
			return $deptid;
		} else{
			return 0;
		}
	}
	
	/**
     * Where String Kombinasi 
	 * Employe Where [CREATED_BY and DESTINATION_TO]
	 * Department Where [DEP_ID]
     */
	protected function gt_opt(){
		$request = Yii::$app->request;
		if ($request->get('pilih')==0){
			return 'DEP_ID="'. $this->gt_deptid() .'"';
		}elseif($request->get('pilih')==1){
			return 'CREATED_BY='. $this->gt_userid() .' OR DESTINATION_TO='. $this->gt_userid();
		}
		//return $request->get('pilih');		
	}
		 
	/**
     * parent1, Header Chart Json Object, foreach object pertama
	 * @type GET
     */
	protected function parent1(){
		$prn1='
			"chart": {
                "caption": "LukisonGroup Pilot Project",
                "subcaption": "Planned vs Actual 2015/2016",                
                "dateformat": "dd/mm/yyyy",
                "outputdateformat": "ddds mns yy",
                "ganttwidthpercent": "70",
                "ganttPaneDuration": "50",
                "ganttPaneDurationUnit": "d",					
                "plottooltext": "$processName{br} $label starting date $start{br}$label ending date $end",
                "theme": "fint"
            }
		';
		return $prn1;
	}
	
	/**
     * parent2, Json Object Bulan/month, foreach object pertama categories, dengan sub category foreach Minggu/Week
	 * @type GET
     */
	protected function parent2(){
		$prn2='
			"categories": [					
					{
						"bgcolor": "#33bdda",
						"align": "middle",
						"fontcolor": "#ffffff",						
						"fontsize": "16",
						"category": '. $this->prnt2category_month() . '
					},
					{
						"bgcolor": "#ffffff",
						"fontcolor": "#1288dd",
						"fontsize": "12",
						"isbold": "1",
						"align": "center",
						"category": '. $this->prnt2category_week() . '
					}
				]
		';
		return $prn2;
	}
	
	/**
     * parent3, Json Object Task, foreach subobject  process
	 * @type GET
     */
	protected function parent3(){
		$prn3='
			"processes": {
                "headertext": "Pilot Task",
                "fontcolor": "#000000",
                "fontsize": "11",
                "isanimated": "1",
                "bgcolor": "#6baa01",
                "headervalign": "bottom",
                "headeralign": "left",
                "headerbgcolor": "#6baa01",
                "headerfontcolor": "#ffffff",
                "headerfontsize": "16",
                "align": "left",
                "isbold": "1",
                "bgalpha": "25",
                "process": '. $this->parent3task().'
            }
		';
		return $prn3;
	}
	
	/* HEADER TASK Planned/Actual/Delay */
	protected function parent4(){
		$prn4='
			"tasks": {
				"showlabels": "1",
                "task": ' .$this->parent4process_task(). '	
            }
		';
		return $prn4;
	}
	
	/* LINK TO NEXT PROJECT*/
	protected function parent5(){
		$prn5='
			"connectors": [
                {
                    "connector": [
                        {
                            "fromtaskid": "1",
                            "totaskid": "1",
                            "color": "#008ee4",
                            "thickness": "2",
                            "fromtaskconnectstart_": "1"
                        },
                        {
                            "fromtaskid": "2-2",
                            "totaskid": "3",
                            "color": "#008ee4",
                            "thickness": "2"
                        },
                        {
                            "fromtaskid": "3-2",
                            "totaskid": "4",
                            "color": "#008ee4",
                            "thickness": "2"
                        },
                        {
                            "fromtaskid": "3-2",
                            "totaskid": "6",
                            "color": "#008ee4",
                            "thickness": "2"
                        },
                        {
                            "fromtaskid": "7",
                            "totaskid": "8",
                            "color": "#008ee4",
                            "thickness": "2"
                        },
                        {
                            "fromtaskid": "7",
                            "totaskid": "9",
                            "color": "#008ee4",
                            "thickness": "2"
                        },
                        {
                            "fromtaskid": "12",
                            "totaskid": "16",
                            "color": "#008ee4",
                            "thickness": "2"
                        },
                        {
                            "fromtaskid": "12",
                            "totaskid": "17",
                            "color": "#008ee4",
                            "thickness": "2"
                        },
                        {
                            "fromtaskid": "17-2",
                            "totaskid": "18",
                            "color": "#008ee4",
                            "thickness": "2"
                        },
                        {
                            "fromtaskid": "19",
                            "totaskid": "22",
                            "color": "#008ee4",
                            "thickness": "2"
                        }
                    ]
                }
            ]
		';
		return $prn5;
	}
	
	protected function parent6(){
		$prn6='
			"milestones": {
                "milestone": '. $this->parent6milestone().
			'}
		';
		return $prn6;
	}	
		
	protected function parent7(){
		$prn7='
			"legend": {
                "item": [
                    {
                        "label": "Planned",
                        "color": "#008ee4"
                    },
                    {
                        "label": "Actual",
                        "color": "#6baa01"
                    },
                    {
                        "label": "Slack (Delay)",
                        "color": "#e44a00"
                    }
                ]
            }			 
		';
		
		return $prn7;
		
	}
	
	/*COMBINASI FUNCTION BUILD JSON */
	protected function pilotpHeader() 
	{
		$json_pilot='{'
			.$this-> parent1().
			','.$this-> parent2().		
			','.$this-> parent3().
			','.$this-> parent4().
			','.$this-> parent5().			
			','.$this-> parent6().
			','.$this-> parent7().			
		'}';			
		return  Json::decode($json_pilot);
	}
		
	/*Author ptr.nov Model Json*/
	protected function getCategsub()
	{
		 $modelClass = $this->modelClass;
         $query = $modelClass::find();
		 $ctg= new ActiveDataProvider([
             'query' => $query			 
         ]);
		 return Json::encode($ctg->getModels());
	}
	
	
	/*Author ptr.nov Model Json*/
	protected function prnt2category_month()
	{
		 $query = Cnfmonth::find();
		 $ctg= new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
					'pageSize' => 24,
				],			 
         ]);
		 return Json::encode($ctg->getModels());
	}
	
	/*Author ptr.nov Model Json*/
	protected function prnt2category_week()
	{
		 $query = Cnfweek::find();
		 $ctg= new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
					'pageSize' => 200,
			],			 
         ]);
		 return Json::encode($ctg->getModels());
	}
	
	/*Author ptr.nov Model Json*/
	protected function parent3task()
	{
		 //$request = Yii::$app->request;
		 //$userid = $request->get('id_user');
		 //$deptid = $request->get('id_dept');	
		 $query = Pilotproject::find()->Where($this->gt_opt());
		 if (count($query)<>0){ /*RECORD TIDAK ADA*/	
			 $ctg= new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
						'pageSize' => 200,
					],				 
			 ]);
			  return Json::encode($ctg->getModels());
		 }else{
			$taskKosong='[{
				"label": "No Data",
                "id": "1"
			}]';
			return $taskKosong;
		 }		
	}
	
	
	/*Author ptr.nov Model plan/action/delay */
	protected function parent4process_task()
	{
		// $request = Yii::$app->request;
		 //$userid = $request->get('id_user');
		// $deptid = $request->get('id_dept');		 
		 $query = Pilotplan::find()->Where($this->gt_opt());
		 if (count($query)<>0){ /*RECORD TIDAK ADA*/	
			 $ctg= new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
						'pageSize' => 200,
					],				 
			 ]);		 
			$arr = [];
			foreach($ctg->getModels() as $t)
			{			
				/*PLAN RUN*/
				if ($t->PLAN_DATE1<>'' AND $t->PLAN_DATE2<>''){
					$arr[] = $t;	
					/*ACTUAL RUN*/
					if ($t->ACTUAL_DATE1<>'' AND $t->ACTUAL_DATE2<>''){
							$querySub1 = Pilotactual::find()->Where('ID='.$t->ID);
							$sub1= new ActiveDataProvider([
								'query' => $querySub1,
								'pagination' => [
										'pageSize' => 200,
									], 
							 ]);
							 foreach($sub1->getModels() as $su1){
								$arr[] = $su1;							
									$querySub2 = Pilotdelay::find()->Where('ID='.$t->ID);
									$sub2= new ActiveDataProvider([
										'query' => $querySub2,
										'pagination' => [
												'pageSize' => 200,
											], 
									 ]);
									 /*RUN DELAY*/
									 foreach($sub2->getModels() as $su2){									
											 $arr[] = $su2;								
									 }															
							 }										 
					}
				}			
			}	
		 }else{
			 $arr = [];
		 }
		 //return $arr;		
		 return Json::encode($arr);
	}
	
	/*Author ptr.nov Model BINTANG Completion */
	protected function parent6milestone(){
		//$request = Yii::$app->request;
		//$userid = $request->get('id_user');
		//$deptid = $request->get('id_dept');		
		$queryStr = Pilotplan::find()->Where($this->gt_opt());
		if (count($queryStr)<>0){ /*RECORD TIDAK ADA*/		 
			 $ctgstart= new ActiveDataProvider([
				'query' => $queryStr,
				'pagination' => [
						'pageSize' => 200,
					],				 
			 ]);		 
			$arrStr = [];
			foreach($ctgstart->getModels() as $st)
			{		
				if (($st->STATUS)==1 AND ((Yii::$app->ambilKonvesi->convert($st->ACTUAL_DATE2,'date'))<=(Yii::$app->ambilKonvesi->convert($st->PLAN_DATE2,'date')))){ /*CLOSE PROGRESS */
					$querySub1 = Pilotmilestone::find()->Where('ID='.$st->ID);
					$sub1start= new ActiveDataProvider([
						'query' => $querySub1,
						'pagination' => [
								'pageSize' => 200,
							], 
					 ]);
					 foreach($sub1start->getModels() as $str1){
						 $arrStr[] = $str1;
					 }				
				}
			}
		}else{
			$arrStr = [];
		}
		
		return Json::encode($arrStr);
	}
	
	/**
	  * getUrl: http://api.lukisongroup.int/chart/pilotps?access-token=azLSTAYr7Y7TLsEAML-LsVq9cAXLyAWa&id_user=1&pilih=1
	  * id_user=1 [user id login]
	  * pilih=1 [0=department;1=user aktif]
	  * @link http://api.lukisongroup.int/chart/pilotps?access-token=azLSTAYr7Y7TLsEAML-LsVq9cAXLyAWa&id_user=1&pilih=1
	*/
	public function actionIndex()
     {
		
		return $this->pilotpHeader();
		// echo $this->gt_deptid();
		//return $this->parent6milestone();
		// return $this->parent4process_task();		
     }
	
	 /*
	 public function actionCreate()
     {
         $model = new $this->modelClass();
         // $model->load(Yii::$app->getRequest()
         // ->getBodyParams(), '');
         $model->attributes = Yii::$app->request->post();
         if (! $model->save()) {
             return ($model->getFirstErrors())[0];
         }
         return $model;
     }
	 */
	 /*
	 public function actionView($id)
     {
         return $this->findModel($id);
     }
	 
	 protected function findModel($id)
     {
         $modelClass = $this->modelClass;
         if (($model = $modelClass::findOne($id)) !== null) {
             return $model;
         } else {
            // throw new NotFoundHttpException('The requested page does not exist.');
			echo 'Data Tidak Temukan, coba data yang lain !  helpdesk : helpdesk@lukison.com';
         }
	}
	*/
	
}


