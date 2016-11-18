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
class EsmsalesexpiredcustomerController extends ActiveController
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
						'ExpiredPerGeo'		=> $this->ExpiredPerGeo($query_date),
                        'ExpiredPerLayer'   => $this->ExpiredPerLayer($query_date),
                        'TotalExpired'      => $this->TotalExpired($query_date),
                        'ExpiredAllYear'    => $this->ExpiredAllYear($query_date)
					);
	} 

	public function ExpiredPerGeo($query_date)
	{
		$f_date     = date('Y-m-01', strtotime($query_date));
        $l_date     = date('Y-m-t', strtotime($query_date));
        $namabulan  = date('F Y', strtotime($query_date));

        $commandgeo             = Yii::$app->db3
                                ->createCommand('SELECT geo.GEO_ID,geo.GEO_NM FROM dbc002.c0002scdl_geo geo WHERE geo.GEO_ID IS NOT NULL AND geo.GEO_ID != 1 AND geo.GEO_ID != 7')
                                ->queryAll();
        $commandproduct         = Yii::$app->db3
                                ->createCommand('SELECT prod.KD_BARANG,prod.NM_BARANG,prod.KD_TYPE FROM dbc002.b0001 prod WHERE prod.KD_TYPE=01 AND prod.KD_KATEGORI=01')
                                ->queryAll();

        foreach ($commandgeo as $key => $valuegeo) 
        {
            $GEO_NM         = $valuegeo['GEO_NM'];
            $category[]     = array('label' => $GEO_NM);
        }

        foreach ($commandproduct as $key => $valueproduct) 
        {
        	$KD_BARANG 		= $valueproduct['KD_BARANG'];
        	$NM_BARANG 		= $valueproduct['NM_BARANG'];

            $data           = array();
            foreach ($commandgeo as $key => $valuegeo) 
            {
                $GEO_NM         = $valuegeo['GEO_NM'];
                $GEO_ID         = $valuegeo['GEO_ID'];

                $commandstock   = Yii::$app->db3
                                ->createCommand('SELECT SUM(exp.QTY)AS TOTAL FROM dbc002.c0012 exp INNER JOIN (SELECT MAX(expired.ID)AS MAX_ID FROM dbc002.c0012 expired 
                    INNER JOIN dbc002.c0001 cust on expired.CUST_ID = cust.CUST_KD 
                    WHERE expired.BRG_ID = "'. $KD_BARANG. '" AND cust.GEO = '.$GEO_ID.' AND expired.DATE_EXPIRED >= "'.$f_date.'" AND expired.DATE_EXPIRED <= "'.$l_date.'" GROUP BY cust.CUST_NM ORDER BY cust.CUST_NM 
                    )as R on exp.ID = R.MAX_ID')
                                ->queryAll();

                if($commandstock[0]['TOTAL'])
                {
                    $total = $commandstock[0]['TOTAL'];
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
        $FS->setCaption('Expired Per Geolocation');
        $FS->setSubCaption($namabulan);
        $FS->setXAxisName('Products');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);


        $result = array('chart'=>$chart,'categories'=>$categories,'dataset'=>$dataset);
        return $result;
	}

    public function ExpiredPerLayer($query_date)
    {
        $f_date     = date('Y-m-01', strtotime($query_date));
        $l_date     = date('Y-m-t', strtotime($query_date));
        $namabulan  = date('F Y', strtotime($query_date));

        $commandlayer    = Yii::$app->db3
                                ->createCommand('SELECT layer.LAYER_ID,layer.LAYER_NM FROM dbc002.c0002scdl_layer layer')
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
                                ->createCommand('SELECT SUM(exp.QTY)AS TOTAL FROM dbc002.c0012 exp INNER JOIN (SELECT MAX(expired.ID)AS MAX_ID FROM dbc002.c0012 expired 
                    INNER JOIN dbc002.c0001 cust on expired.CUST_ID = cust.CUST_KD 
                    WHERE expired.BRG_ID = "'. $KD_BARANG. '" AND cust.LAYER = '.$LAYER_ID.' AND expired.DATE_EXPIRED >= "'.$f_date.'" AND expired.DATE_EXPIRED <= "'.$l_date.'" GROUP BY cust.CUST_NM ORDER BY cust.CUST_NM 
                    )as R on exp.ID = R.MAX_ID')
                                ->queryAll();

                if($commandstock[0]['TOTAL'])
                {
                    $total = $commandstock[0]['TOTAL'];
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
        $FS->setCaption('Expired Per Layer');
        $FS->setSubCaption($namabulan);
        $FS->setXAxisName('Layer');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);
        $result = array('chart'=>$chart,'categories'=>$categories,'dataset'=>$dataset);
        return $result;
    }

    public function TotalExpired($query_date)
    {
        $f_date     = date('Y-m-01', strtotime($query_date));
        $l_date     = date('Y-m-t', strtotime($query_date));
        $namabulan  = date('F Y', strtotime($query_date));

        $commandproduct         = Yii::$app->db3
                                ->createCommand('SELECT prod.KD_BARANG,prod.NM_BARANG,prod.KD_TYPE FROM dbc002.b0001 prod WHERE prod.KD_TYPE=01 AND prod.KD_KATEGORI=01')
                                ->queryAll();

        foreach ($commandproduct as $key => $valueproduct) 
        {
            $KD_BARANG      = $valueproduct['KD_BARANG'];
            $NM_BARANG      = $valueproduct['NM_BARANG'];

            $commandstock   = Yii::$app->db3
                            ->createCommand('SELECT SUM(exp.QTY)AS TOTAL FROM dbc002.c0012 exp INNER JOIN (SELECT MAX(expired.ID)AS MAX_ID FROM dbc002.c0012 expired 
                INNER JOIN dbc002.c0001 cust on expired.CUST_ID = cust.CUST_KD 
                WHERE expired.BRG_ID = "'. $KD_BARANG. '" AND expired.DATE_EXPIRED >= "'.$f_date.'" AND expired.DATE_EXPIRED <= "'.$l_date.'" GROUP BY cust.CUST_NM ORDER BY cust.CUST_NM 
                )as R on exp.ID = R.MAX_ID')
                            ->queryAll();

            if($commandstock[0]['TOTAL'])
            {
                $total = $commandstock[0]['TOTAL'];
            }
            else
            {
                $total = 0;
            }
            $data[]  = array('label' => $NM_BARANG,'value'=>$total);
        }

        $FS = new FusionChart();
        $FS->setCaption('Total Expired Customers');
        $FS->setSubCaption($namabulan);
        $FS->setXAxisName('Products');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);

        $result = array('chart'=>$chart,'data'=>$data);
        return $result;
    }

    public function ExpiredAllYear($query_date)
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


                $commandstock   = Yii::$app->db3
                                ->createCommand('SELECT SUM(exp.QTY)AS TOTAL FROM dbc002.c0012 exp INNER JOIN (SELECT MAX(expired.ID)AS MAX_ID FROM dbc002.c0012 expired 
                    INNER JOIN dbc002.c0001 cust on expired.CUST_ID = cust.CUST_KD 
                    WHERE expired.BRG_ID = "'. $KD_BARANG. '" AND expired.DATE_EXPIRED >= "'.$f_date.'" AND expired.DATE_EXPIRED <= "'.$l_date.'" GROUP BY cust.CUST_NM ORDER BY cust.CUST_NM 
                    )as R on exp.ID = R.MAX_ID')
                                ->queryAll();

                if($commandstock[0]['TOTAL'])
                {
                    $total = $commandstock[0]['TOTAL'];
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
        $FS->setCaption('Expired All Year');
        $FS->setSubCaption($xx);
        $FS->setXAxisName('Month');
        $FS->setLabelDisplay('rotate');
        $chart = Yii::$app->ambilkonci->objectToArray($FS);
        $result = array('chart'=>$chart,'categories'=>$categories,'dataset'=>$dataset);
        return $result;
    }
}

