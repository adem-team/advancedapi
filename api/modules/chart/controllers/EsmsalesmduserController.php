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

class EsmsalesmduserController extends ActiveController
{
	public $modelClass = 'api\modules\chart\models\Cnfweek';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'SalesUser',
	];
	  
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
        $f_date     = date('Y-m-01');
        $l_date     = date('Y-m-t');
        $NM_END 	= 'SALESMD';
		$data_view=Yii::$app->db_emp
						        ->createCommand('SELECT users.ID_USER,users.NM_FIRST,users.IMG_BASE64 FROM dbm_086.user_profile users WHERE users.NM_END = "'.$NM_END.'" ')
						        ->queryAll();  
		$provider= new ArrayDataProvider(['allModels'=>$data_view,'pagination' => ['pageSize' => 1000,]]);
		return $provider;
	}

	public function actionSearch()
    {
        if (!empty($_GET))
        {
        	$TGLSTART   = $_GET['TGLSTART'];
            $TGLEND     = $_GET['TGLEND'];
        	$USER_ID 	= $_GET['USER_ID'];
        	$f_date     = date('Y-m-d', strtotime($TGLSTART));
	        $l_date     = date('Y-m-d', strtotime($TGLEND));
	        $namabulan  = date('F Y', strtotime($TGLSTART));

        	$data_view=Yii::$app->db_emp
						        ->createCommand('SELECT SUM(CASE WHEN scdldetail.STATUS = 1 THEN 1 ELSE 0 END)AS CC,SUM(CASE WHEN scdldetail.STATUS = 0 THEN 1 ELSE 0 END)AS NC,scdldetail.ID,scdldetail.TGL,scdldetail.CUST_ID FROM dbc002.c0002scdl_detail scdldetail 
												WHERE scdldetail.USER_ID='.$USER_ID .' AND scdldetail.TGL BETWEEN "'.$f_date.'" AND "'.$l_date.'" GROUP BY scdldetail.TGL ORDER BY scdldetail.TGL ASC')
						        ->queryAll();  

			foreach ($data_view as $key => $value) 
			{
				$TGL         	= $value['TGL'];
            	$category[]     = array('label' => $TGL);
			}
			$categories[]   = array('category'=>$category);

			foreach ($data_view as $key => $value) 
			{
				$CC         	= $value['CC'];
				$NC         	= $value['NC'];
            	$dataCC[]     	= array('value'=>$CC);
            	$dataNC[]     	= array('value'=>$NC);
			}
	        $dataset[]  = array('seriesname'=>'ACTIVE CALL','data'=>$dataCC);
	        $dataset[]  = array('seriesname'=>'NONACTIVE CALL','data'=>$dataNC);
	    
			$FS = new FusionChart();
	        $FS->setCaption('Customer Call');
	        $FS->setSubCaption($namabulan);
	        $FS->setLabelDisplay('rotate');
	        $FS->setXAxisName('Tanggal Call');
	        $chart = Yii::$app->ambilkonci->objectToArray($FS);


	        $result = array('chart'=>$chart,'categories'=>$categories,'dataset'=>$dataset);
	        $resulteffectivecall = $this->EffectiveCall($TGLSTART,$TGLEND,$USER_ID);
	        $resultNewCustomer	 = $this->NewCustomer($TGLSTART,$TGLEND,$USER_ID);
            $JumlahKunjunganLayerA  = $this->JumlahKunjunganLayerA($TGLSTART,$TGLEND,$USER_ID);
            $JumlahKunjunganLayerB  = $this->JumlahKunjunganLayerB($TGLSTART,$TGLEND,$USER_ID);
	        return array(
                            'CustomerCall'=>$result,
                            'EffectiveCall'=>$resulteffectivecall,
                            'NewCustomer'=>$resultNewCustomer,
                            'JumlahKunjunganLayerA'=>$JumlahKunjunganLayerA,
                            'JumlahKunjunganLayerB'=>$JumlahKunjunganLayerB
                        );

        }
    } 

	public function EffectiveCall($TGLSTART,$TGLEND,$USER_ID)
    {
        $USER_ID	= $USER_ID;
        $f_date     = date('Y-m-d', strtotime($TGLSTART));
        $l_date     = date('Y-m-d', strtotime($TGLEND));
        $namabulan  = date('F Y', strtotime($TGLSTART));

        $commandlayer    = Yii::$app->db3
                                ->createCommand('SELECT layer.LAYER_ID,layer.LAYER_NM FROM dbc002.c0002scdl_layer layer WHERE layer.LAYER_ID != 5')
                                ->queryAll();

        $commandproduct         = Yii::$app->db3
                                ->createCommand('SELECT prod.KD_BARANG,prod.NM_BARANG,prod.KD_TYPE FROM dbc002.b0001 prod WHERE prod.KD_TYPE=01 AND prod.KD_KATEGORI=01')
                                ->queryAll();

        foreach ($commandlayer as $key => $valuelayer) 
        {
            $LAYER_NM       = $valuelayer['LAYER_NM'];
            $category[]     = array('label' => $LAYER_NM);
        }

        foreach ($commandproduct as $key => $valueproduct) 
        {
            $KD_BARANG      = $valueproduct['KD_BARANG'];
            $NM_BARANG      = $valueproduct['NM_BARANG'];

            $data           = array();
            foreach ($commandlayer as $key => $valuelayer) 
            {
                $LAYER_ID         = $valuelayer['LAYER_ID'];

                $commandstock   = Yii::$app->db3
                                ->createCommand('SELECT SUM(stock.SO_QTY) as JUMLAH ,stock.USER_ID,stock.NM_BARANG,stock.CUST_NM,stock.TGL,cust.LAYER,stock.SO_TYPE,stock.SO_QTY FROM dbc002.so_t2 stock 
												INNER JOIN dbc002.c0001 cust ON stock.CUST_KD = cust.CUST_KD
												WHERE 
												stock.SO_TYPE = 9 AND 
												stock.USER_ID = '.$USER_ID.' AND 
												stock.KD_BARANG= "'. $KD_BARANG. '" AND 
												stock.TGL BETWEEN "'.$f_date.'" AND "'.$l_date.'" AND cust.LAYER = '.$LAYER_ID.' ')
                                ->queryAll();

                if($commandstock[0]['JUMLAH'])
                {
                    $total = $commandstock[0]['JUMLAH'];
                }
                else
                {
                    $total = 0;
                }
                $data[]     = array('value'=>$total);
            }
            $dataset[]  = array('seriesname'=>$NM_BARANG,'data'=>$data);
        }

        $categories[]   = array('category'=>$category);
        $FS = new FusionChart();
        $FS->setCaption('Request Estimate');
        $FS->setSubCaption($namabulan);
        $FS->setXAxisName('Layer');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);
        $result = array('chart'=>$chart,'categories'=>$categories,'dataset'=>$dataset);
        return $result;
    }

    public function NewCustomer($TGLSTART,$TGLEND,$USER_ID)
	{
		

        $f_date     = date('Y-m-01', strtotime($TGLSTART));
        $l_date     = date('Y-m-t', strtotime($TGLEND));
        $USER_ID    = $USER_ID;
        $namabulan  = date('F Y', strtotime($TGLSTART));

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
                                ->createCommand('
                                                    SELECT cust.CUST_KD FROM dbc002.c0001 cust
                                                    INNER JOIN dbm001.user users on cust.CREATED_BY = users.username 
                                                    WHERE cust.JOIN_DATE BETWEEN "'.$f_date.'" 
                                                    AND "'.$l_date.'"
                                                    AND users.id = '.$USER_ID.' 
                                                    AND cust.GEO =' .$ID_GEO. ' 
                                                    AND cust.LAYER='.$ID_LAYER
                                                )
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

    public function JumlahKunjunganLayerA($TGLSTART,$TGLEND,$USER_ID)
    {
        
        $USER_ID    = $USER_ID;
        $f_date     = date('Y-m-01', strtotime($TGLSTART));
        $l_date     = date('Y-m-t', strtotime($TGLEND));

        $namabulan  = date('F Y', strtotime($TGLSTART));
        
        $commandlayer    = Yii::$app->db3
                                ->createCommand('SELECT layer.LAYER_ID,layer.LAYER_NM FROM dbc002.c0002scdl_layer layer WHERE layer.LAYER_ID != 5')
                                ->queryAll();

        $commandcust    = Yii::$app->db3
                            ->createCommand('SELECT cust.CUST_NM as label,Jadwal.LALA as value FROM dbc002.c0001 cust
                                            INNER JOIN  
                                            (
                                                SELECT scdl.CUST_ID,xx.LAYER,xx.GEO,SUM(scdl.STATUS)AS LALA 
                                                FROM dbc002.c0002scdl_detail scdl 
                                                INNER JOIN dbc002.c0001 xx ON scdl.CUST_ID = xx.CUST_KD 
                                                WHERE scdl.USER_ID = ' .$USER_ID. ' AND scdl.TGL BETWEEN "'.$f_date.'" AND "'.$l_date.'" GROUP BY scdl.CUST_ID 
                                            )AS Jadwal
                                            ON cust.CUST_KD = Jadwal.CUST_ID 
                                            WHERE  cust.GEO = Jadwal.GEO AND cust.LAYER = 1 
                                            ORDER BY Jadwal.LALA DESC')
                            ->queryAll();

        $data         = $commandcust;

        $FS = new FusionChart();
        $FS->setCaption('Jumlah Kunjungan');
        $FS->setXAxisName('Layer A');
        $FS->setLabelDisplay('rotate');
        $FS->setSlantLabels(1);
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

        $result = array('chart'=>$chart,'data'=>$data);
        return $result;
    }
    public function JumlahKunjunganLayerB($TGLSTART,$TGLEND,$USER_ID)
    {
        
        $USER_ID    = $USER_ID;
        $f_date     = date('Y-m-01', strtotime($TGLSTART));
        $l_date     = date('Y-m-t', strtotime($TGLEND));

        $namabulan  = date('F Y', strtotime($TGLSTART));
        
        $commandlayer    = Yii::$app->db3
                                ->createCommand('SELECT layer.LAYER_ID,layer.LAYER_NM FROM dbc002.c0002scdl_layer layer WHERE layer.LAYER_ID != 5')
                                ->queryAll();

        $commandcust    = Yii::$app->db3
                            ->createCommand('SELECT cust.CUST_NM as label,Jadwal.LALA as value FROM dbc002.c0001 cust
                                            INNER JOIN  
                                            (
                                                SELECT scdl.CUST_ID,xx.LAYER,xx.GEO,SUM(scdl.STATUS)AS LALA 
                                                FROM dbc002.c0002scdl_detail scdl 
                                                INNER JOIN dbc002.c0001 xx ON scdl.CUST_ID = xx.CUST_KD 
                                                WHERE scdl.USER_ID = ' .$USER_ID. ' AND scdl.TGL BETWEEN "'.$f_date.'" AND "'.$l_date.'" GROUP BY scdl.CUST_ID 
                                            )AS Jadwal
                                            ON cust.CUST_KD = Jadwal.CUST_ID 
                                            WHERE  cust.GEO = Jadwal.GEO AND cust.LAYER = 2 
                                            ORDER BY Jadwal.LALA DESC')
                            ->queryAll();

        $data         = $commandcust;

        $FS = new FusionChart();
        $FS->setCaption('Jumlah Kunjungan');
        $FS->setXAxisName('Layer B');
        $FS->setLabelDisplay('rotate');
        $FS->setSlantLabels(1);
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

        $result = array('chart'=>$chart,'data'=>$data);
        return $result;
    }	
	
}
