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

use api\components\mastercode;
use api\modules\chart\models\Cnfweek; 
use api\modules\chart\models\Cnfmonth;

use api\modules\chart\models\FusionChart;
class EsmsalestargetcustomerController extends ActiveController
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
                        'TargetAllYear'             => $this->TargetAllYear($query_date),
                        'TotalSurplus'              => $this->TotalSurplus($query_date),
                        'SubTotalSurplus'           => $this->SubTotalSurplus($query_date),
                        'Final'                     => $this->Final($query_date),
                        'ProductSurplus'            => $this->ProductSurplus($query_date)
					);
	} 

    public function TargetAllYear($query_date)
    {
        
        $f_date     = date('Y-m-01', strtotime($query_date));
        $l_date     = date('Y-m-t', strtotime($query_date));
        $xx  = date('Y', strtotime($query_date));


        $commandproduct         = Yii::$app->db3
                                ->createCommand('SELECT prod.KD_BARANG,prod.NM_BARANG,prod.KD_TYPE FROM dbc002.b0001 prod WHERE prod.KD_TYPE=01 AND prod.KD_KATEGORI=01')
                                ->queryAll();

        for($i=1;$i<=12;$i++)
        {
            $f_date     = date('Y-'.$i.'-01', strtotime($query_date));
            $l_date     = date('Y-'.$i.'-t', strtotime($query_date));
            $namabulan  = date('F', strtotime($f_date));
            $category[] = array('label' => $namabulan);
        }

        foreach ($commandproduct as $key => $valueproduct) 
        {
            $KD_BARANG      = $valueproduct['KD_BARANG'];
            $NM_BARANG      = $valueproduct['NM_BARANG'];

            $data           = array();
            for($i=1;$i<=12;$i++)
            {
                $f_date     = date('Y-'.$i.'-01', strtotime($query_date));
                $l_date     = date('Y-'.$i.'-t', strtotime($query_date));
                $namabulan  = date('F Y', strtotime($f_date));
                if($i % 3 == 0)
                {
                    $total = -24;   
                }
                else if($i % 5 == 0)
                {
                   $total = 20; 
                }
                else
                {
                   $total = 5; 
                }
                

                $data[]     = array('value'=>$total);
            }
            $dataset[]  = array('seriesname'=>$NM_BARANG,'data'=>$data);
        }

        $categories[]   = array('category'=>$category);
        $FS = new FusionChart();
        $FS->setCaption('Target');
        $FS->setSubCaption($xx);
        $FS->setXAxisName('Month');
        $FS->setLabelDisplay('rotate');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);
        $result = array('chart'=>$chart,'categories'=>$categories,'dataset'=>$dataset);
        return $result;
    }

    public function TotalSurplus($query_date)
    {
        for($i=1;$i<=12;$i++)
        {
            $f_date     = date('Y-'.$i.'-01', strtotime($query_date));
            $l_date     = date('Y-'.$i.'-t', strtotime($query_date));
            $namabulan  = date('F', strtotime($f_date));
            if($i % 3 == 0)
            {
                $jumlah = -120;   
            }
            else if($i % 5 == 0)
            {
               $jumlah = 80; 
            }
            else
            {
               $jumlah = 25; 
            }

            $data[]         = array('label' => $namabulan,'value'=>$jumlah);
        }

        $FS = new FusionChart();
        $FS->setCaption('Defisit Surplus');
        $FS->setXAxisName('Month');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

        $result = array('chart'=>$chart,'data'=>$data);
        return $result;
    }

    public function SubTotalSurplus($query_date)
    {


        $data[]         = array('label' => 'Defisit','value'=>-480);
        $data[]         = array('label' => 'Surplus','value'=>310);

        $FS = new FusionChart();
        $FS->setCaption('Defisit/Surplus');
        $FS->setXAxisName('Ket');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

        $result = array('chart'=>$chart,'data'=>$data);
        return $result;
    }

    public function Final($query_date)
    {
        $data[]         = array('label' => 'Defisit','value'=>-170);
        $FS = new FusionChart();
        $FS->setCaption('Final');
        $FS->setXAxisName('');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

        $result = array('chart'=>$chart,'data'=>$data);
        return $result;
    }

    public function ProductSurplus($query_date)
    {
        $data[]         = array('label' => 'MAXI Cassava Chips Balado','value'=>-16);
        $data[]         = array('label' => 'MAXI Talos Chips Black Paper','value'=>-16);
        $data[]         = array('label' => 'MAXI Talos Roasted Corn','value'=>-16);
        $data[]         = array('label' => 'MAXI Cassava Crackers Hot Spicy','value'=>-16);
        $data[]         = array('label' => 'MAXI mixed Roots','value'=>-16);

        $FS = new FusionChart();
        $FS->setCaption(' Product Defisit/Surplus');
        $FS->setXAxisName('Product');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

        $result = array('chart'=>$chart,'data'=>$data);
        return $result;
    }
}

