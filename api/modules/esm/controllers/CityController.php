<?php

namespace api\modules\gsn\controllers;

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
use api\modules\gsn\models\City;
use yii\web\HttpException;
//use yii\data\ActiveDataProvider;
/**
 * Country Controller API
 *
 * @author -ptr.nov-
 */
class CityController extends ActiveController
{
    public $modelClass = 'api\modules\gsn\models\City';
	
	  
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                    ['class' => HttpBearerAuth::className()],
                    ['class' => QueryParamAuth::className(), 'tokenParam' => 'access-token'],
                ]
            ],
			'bootstrap'=> [
				'class' => ContentNegotiator::className(),
				'formats' => [
					'application/json' => Response::FORMAT_JSON,
				],
			],
            //'exceptionFilter' => [
            //    'class' => ErrorToExceptionFilter::className()            ],
        ]);
    }

	
	
	
	
	
	
	
	
	
	
	
	
	
	//===========================================
	/*[0]Author by  -ptr.nov-  Output Json, disable XML
	 tidak ada autorisasi
	*/
/*
	//==========================================
	public function behaviors()
    {

        $behaviors = parent::behaviors();
        // $behaviors['authenticator'] = [
        //'class' => CompositeAuth::className(),
        //'authMethods' => [
         //   HttpBasicAuth::className(),
         //  HttpBearerAuth::className(),
         //   QueryParamAuth::className(),
		//	],
		//];

        $behaviors['bootstrap'] = [
            'class' => ContentNegotiator::className(),
			'formats' => [
				'application/json' => Response::FORMAT_JSON,
			],
		];
        return $behaviors;
    }
*/







	//=============================================
	// [1] Auhot -ptr.nov-
	//HttpBasicAuth -> SHOW Use&password Author
	//=============================================
	/*
	public $user_password;
	public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
           'class' => HttpBasicAuth::className(),
		      'class' => HttpBearerAuth::className(),
              'class' => QueryParamAuth::className(),
		   //'auth' => [$this, 'auth']
        ];

        return $behaviors;
    }

	public function Auth($username, $password)
	{
		// username, password are mandatory fields
		if(empty($username) || empty($password))
			return null;

		// get user using requested email
		$user =  \common\models\User::findOne([
			'username' => $username,
		]);

		// if no record matching the requested user
		if(empty($user))
			return null;

		// hashed password from user record
		//$this->user_password = $user->password_hash;

		// validate password
	   // $isPass = \common\models\User::validatePassword($password);

		// if password validation fails
	  //  if(!$isPass)
		//    return null;

		// if user validates (both user_email, user_password are valid)
		return $user;
	}
	*/
	//---------------------------------------------------------------------------------------------------------------------------------------------------
	/*
	public function auth($username, $password)
    {
        return \common\models\User::findOne(['username' => $username, 'password_hash' => $password]);
    }

	//---------------------------------------------------------------------------------------------------------------------------------------------------
	public static function findIdentityByAccessToken($token, $type = null)
   {
     $apiUser = User::find()
        ->where(['access_token' => $token])
        ->one();
     return static::findOne(['id' => $apiUser->username, 'status' => self::STATUS_ACTIVE]);
   }
	*/
	//----------------------------------------------------------------------------------------------------------------------------------------------------
	/*
	 public function auth($username, $password)
    {
        // Do whatever authentication on the username and password you want.
        // Create and return identity or return null on failure
    }
	*/
	//----------------------------------------------------------------------------------------------------------------------------------------------------


	//==========================================
	/* [2] Auhot -ptr.nov-
	//HttpBearerAuth -> SHOW Use&password Author
	//==========================================
	*/
/*
	public function behaviors()
	{
		$behaviors = parent::behaviors();


		 $behaviors['authenticator'] = [
		//'class' => HttpBearerAuth::className(),
           // 'class' => HttpBasicAuth::className(),
            'class' => QueryParamAuth::className(),
            //'except' => ['viewkey'],

		];


		$behaviors['contentNegotiator'] = [
				'class' => ContentNegotiator::className(),
				'formats' => [
					'application/json' => Response::FORMAT_JSON,
				],
			];

		return $behaviors;
	}

    //public function actionViewKey($key)
    public function actionViewkey($key)
    {
        //if ($key == Yii::$app->user->identity->username) {
        //   return User::findOne($key);
        // }
        if ($key == 'azLSTAYr7Y7TLsEAMLLsVq9cAXLyAWa') {
            //$modelClass = 'api\modules\v1\models\Country';

           // return $modelClass;
            //return Yii::$app->Country;
            //return Yii::$app->Country;
           // $query = new User;//::findAll();
            // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
           // $dataProvider = new ActiveDataProvider([
           //     'query' => $query,
           // ]);
                 //$a=
           // return yii\helpers\Json::encode($dataProvider->getModels());
            //'class' => 'yii\rest\IndexAction',
            return array_merge(
                parent::actionViewkey(),
                [
                    //'index' => [
                        //'class' => 'yii\rest\IndexAction',
                        'modelClass' => $this->modelClass,
                        'prepareDataProvider' => function ($actionViewkey) {
                                // @var $model Post
                                $model = new $this->modelClass;
                                $query = $model::find();
                                $dataProvider = new ActiveDataProvider(['query' => $query]);
                                //$model->setAttribute('title', @$_GET['title']);
                                //$query->andFilterWhere(['like', 'title', $model->title]);
                                return $dataProvider;
                            }
                    //]
                ]
             );









        //return \yii\helpers\Json::encode($dataProvider->getModels());//; //'azLSTAYr7Y7TLsEAMLLsVq9cAXLyAWa';
           // throw new \HttpHeaderException();
        //else {
        //return 'admin';
        }
            //throw new HttpException(404);
        //throw new \yii\web\HttpException(400, 'Invalid attribute:' . $key);

    }
    */
    /*
    public function actions()
    {
        $actions = parent::actions();

        unset($actions['view']);

        return $actions;
    }

    public function actionView($id)
    {
        if ($id == Yii::$app->user->identity->username) {
            return User::findOne($id);
        }
        throw new HttpException(404);
    }
    */

    /*
	public function actionCountryview($id)
	{
	//     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		//$query = new User();
		//$test =
		//	[
			//	'/count' => $query->Checkincount($id),
				//'checkinid' => $username,
				//'username' => Yii::$app->user->identity->username,
				$test='ax';
		//	];
			 return $test; //Testing purpose
	}
    */
   /*
    public $serializer = [
        'class' => 'app\controllers\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
   */
    
	/*
	public $user_password;
    public function behaviors()
    {
	
       // return  ArrayHelper::merge(parent::behaviors(), [
            $behaviors = parent::behaviors([
    */        /*
            'verbFilter' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                            'index' => ['get'],

                    ]
            ],
            */
/*      
      'authenticator' => [
                #??????`ComopositeAuth` ????
                'class' => CompositeAuth::className(),
                #`authMethods` ??????????? ?? ?????????? ????
                'authMethods' => [
                   HttpBasicAuth::className(),
                   //HttpBearerAuth::className(),
                  // QueryParamAuth::className(),
                   // 'except' => ['option'],
                    'auth' => [$this, 'auth']
                ]
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    //'text/html' => Response::FORMAT_HTML,
                   'application/json' => Response::FORMAT_JSON,
                ]
            ],



        ]);

       return $behaviors;
    }

    public function Auth($username, $password)
    {
        // username, password are mandatory fields
        if(empty($username) || empty($password))
            return null;

        // get user using requested email
        $user = \common\models\User::findOne([
            'username' => $username,
        ]);

        // if no record matching the requested user
        if(empty($user))
            return null;

        // hashed password from user record
        //$this->user_password = $user->password_hash;

        // validate password
        // $isPass = \common\models\User::validatePassword($password);

        // if password validation fails
        //  if(!$isPass)
        //    return null;

        // if user validates (both user_email, user_password are valid)
        return $user;
    }
*/

    /*
    public function auth($username, $password)
    {
        return common\models\User::findOne(['username' => $username, 'password_hash' => $password]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $apiUser = User::find()
            ->where(['access_token' => $token])
            ->one();
        return static::findOne(['username' => $apiUser->username, 'status' => self::STATUS_ACTIVE]);
    }
*/


/*
   // public $serializer = [
       // 'class' => 'app\controllers\rest\Serializer',
        //'collectionEnvelope' => 'items',
    //];
    public function behaviors()
    {
        $pb = ArrayHelper::merge(parent::behaviors(), [
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'  => ['get'],
                    'view'   => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'put', 'post'],
                    'delete' => ['post', 'delete'],
                ],
            ],
            /*
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'text/html' => Response::FORMAT_HTML,
                    #'application/json' => Response::FORMAT_JSON,
                ],
            ],

            'authenticator' => [
                #??????`ComopositeAuth` ????
                'class' => CompositeAuth::className(),
                #`authMethods` ??????????? ?? ?????????? ????
                'authMethods' => [
                    //HttpBasicAuth::className(),
                    //HttpBearerAuth::className(),
                    QueryParamAuth::className(),
                ]
            ],

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ]);
        return $pb;
    }
    */
    /*
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
    */
}


