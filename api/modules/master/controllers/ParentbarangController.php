<?php

namespace api\modules\master\controllers;

use yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use api\modules\master\models\ChildBarang;
use api\modules\master\models\ParentBarang;
use yii\web\HttpException;

use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;
//use yii\data\ActiveDataProvider;
/**
 * Country Controller API
 *
 * @author -ptr.nov-
 */
class ParentbarangController extends ActiveController
{
    public $modelClass = 'api\modules\master\models\ParentBarang';
	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'ParentBarang',
	];

    public function behaviors()    
    {
        return ArrayHelper::merge(parent::behaviors(), 
        [
            'authenticator' => 
            [
                'class' => CompositeAuth::className(),
                'authMethods' => 
                [
                    #Hapus Tanda Komentar Untuk Autentifikasi Dengan Token               
                   // ['class' => HttpBearerAuth::className()],
                   // ['class' => QueryParamAuth::className(), 'tokenParam' => 'access-token'],
                ]
            ],

			'bootstrap'=> 
            [
				'class' => ContentNegotiator::className(),
				'formats' => 
                [
					'application/json' => Response::FORMAT_JSON,
				],
			],
            //'exceptionFilter' => [
            //    'class' => ErrorToExceptionFilter::className()            ],
            'corsFilter' => [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                    // restrict access to
                    'Origin' =>['*'],// ['http://ptrnov-erp.dev', 'https://ptrnov-erp.dev'],
                    'Access-Control-Request-Method' => ['GET','POST', 'PUT'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],

            ],
        ]);
    }

    public function beforeAction($action) 
    { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }
    public function actionSearch()
    {
        if (!empty($_GET)) 
        {
            $model = new $this->modelClass;
            foreach ($_GET as $key => $value) 
            {
                if (!$model->hasAttribute($key)) 
                {
                    throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
                }
            }
            try 
            {
                $provider = new ActiveDataProvider([
                    'query' => $model->find()->where($_GET),
                    'pagination' => false
                ]);
            } 
            catch (Exception $ex) 
            {
                throw new \yii\web\HttpException(500, 'Internal server error');
            }

            if ($provider->getCount() <= 0) 
            {
                throw new \yii\web\HttpException(404, 'No entries found with this query string');
            } 
            else 
            {
                return $provider;
            }
        } 
        else 
        {
            throw new \yii\web\HttpException(400, 'There are no query string');
        }
    }

    public function actions()
    {
       $actions = parent::actions();
       unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
       return $actions;
    }

    public function actionIndex()
    {
        // $results = $this->getCustomers();
        // // foreach($results as $key)
        // // {
        // //    echo $key->CUST_KD ."</br>";
        // //    echo $key->EMAIL ."</br>";
        // // }
        // return array('Customer'=>$results);

        // $posts=ParentBarang::find()->with('childs.nama_child')->All();
        //return $customers = ParentBarang::find()->with('childbarangs')->asArray()->all();

        $parents = ParentBarang::find()->all();  // fetches only the authors
        foreach($parents as $parent) 
        {
            $childs=array();
            foreach($parent->childbarangs as $childbarangs) 
            {  // fetches the author's posts here
                $grands=array();
                foreach($childbarangs->grandbarangs as $grand)
                {
                    $grands[] = array('nama'=>$grand->nama);
                }

                $childs[]=array('nama'=>$childbarangs->nama_child,'grand'=>$grands);
            }

            $parental[]=array('namaparent'=>$parent->nama_parent,'child'=>$childs);
        }
        return $parental;
                return new ActiveDataProvider([
            'query' => Post::find(),
        ]);

    }

    // // public function getCustomers()
    // // {
    // //   return $models=Customer::find()->All();
    // // }
    // public function actions()
    // {
    //    $actions = parent::actions();
    //    unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
    //    return $actions;
    // }

    // public function actionIndex()
    // {
    //     // $results = $this->getCustomers();
    //     // // foreach($results as $key)
    //     // // {
    //     // //    echo $key->CUST_KD ."</br>";
    //     // //    echo $key->EMAIL ."</br>";
    //     // // }
    //     // return array('Customer'=>$results);

    //     // return array('Childbarangs' => $models);

    //    // $parent=ParentBarang::find()->asArray()->all();
    //    // return $parent;

    //     $posts = Yii::$app
    //             ->dblocal
    //             ->createCommand('SELECT * FROM ParentBarang p left join ChildBarang c on p.id=c.parent')
    //             ->queryAll();

    //     // $posts = Yii::$app
    //     //         ->dblocal
    //     //         ->createCommand('SELECT p.id FROM ParentBarang p left join ChildBarang c on p.id=c.parent')
    //     //         ->queryAll();

    //     // $posts = Yii::$app
    //     //         ->dblocal
    //     //         ->createCommand('SELECT p.id FROM ParentBarang p left join ChildBarang c on p.id=c.parent')
    //     //         ->queryColumn();

    //     // $posts = Yii::$app
    //     //         ->dblocal
    //     //         ->createCommand('SELECT * FROM ParentBarang p left join ChildBarang c on p.id=c.parent')
    //     //         ->queryScalar();

    //     //return $posts;

    // //    $customers = Customer::find()
    // // ->joinWith('orders')
    // // ->where(['order.status' => Order::STATUS_ACTIVE])
    // // ->all();

    //     #http://stackoverflow.com/questions/25993840/how-can-i-set-connection-for-query-builder-in-yii2
    //     $rows = (new \yii\db\Query());
    //     $rows->select(['id']);
    //     $rows->from('ParentBarang');
    //     $rows->limit(10);
    //     $rows->all(Yii::$app->dblocal);
    //     return $rows;
    // }

}


