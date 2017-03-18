<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use api\modules\efenbi\rasasayang\models\Transaksi;

/**
 * TransaksiSearch represents the model behind the search form about `api\modules\efenbi\rasasayang\models\Transaksi`.
 */
class TransaksiSearch extends Transaksi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'STATUS', 'TRANS_TYPE', 'ITEM_QTY'], 'safe'],
            [['CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT', 'TRANS_ID', 'TRANS_DATE', 'USER_ID', 'OUTLET_ID', 'OUTLET_NM', 'CONSUMER_NM', 'CONSUMER_EMAIL', 'CONSUMER_PHONE', 'ITEM_ID', 'ITEM_NM', 'ITEM_DISCOUNT_TIME'], 'safe'],
            [['ITEM_HARGA', 'ITEM_DISCOUNT'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Transaksi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
            'STATUS' => $this->STATUS,
            'TRANS_TYPE' => $this->TRANS_TYPE,            
            'ITEM_QTY' => $this->ITEM_QTY,
            'ITEM_HARGA' => $this->ITEM_HARGA,
            'ITEM_DISCOUNT' => $this->ITEM_DISCOUNT,
        ]);

        $query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'TRANS_DATE', $this->TRANS_DATE])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'TRANS_ID', $this->TRANS_ID])
            ->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'OUTLET_ID', $this->OUTLET_ID])
            ->andFilterWhere(['like', 'OUTLET_NM', $this->OUTLET_NM])
            ->andFilterWhere(['like', 'CONSUMER_NM', $this->CONSUMER_NM])
            ->andFilterWhere(['like', 'CONSUMER_EMAIL', $this->CONSUMER_EMAIL])
            ->andFilterWhere(['like', 'CONSUMER_PHONE', $this->CONSUMER_PHONE])
            ->andFilterWhere(['like', 'ITEM_ID', $this->ITEM_ID])
            ->andFilterWhere(['like', 'ITEM_NM', $this->ITEM_NM])
            ->andFilterWhere(['like', 'ITEM_DISCOUNT_TIME', $this->ITEM_DISCOUNT_TIME]);

        return $dataProvider;
    } 
	
	public function searchBooking($params)
    {
		if(is_array($params)){
			if($params["TransaksiSearch"]["TRANS_TYPE"]=1){						
				//$outletCheck=$params["TransaksiSearch"]["OUTLET_ID"];
				//$outletRun=$outletCheck!=''? " AND OUTLET_ID".$outletCheck:'';
				// print_r(outletCheck);
				// die();
				$booking= new ArrayDataProvider([
					'allModels'=>Yii::$app->db_efenbi->createCommand("	
						SELECT *					
						FROM transaksi x1
							INNER JOIN 
							(SELECT OUTLET_ID,max(date(TRANS_DATE)) As TRANS_DATE,TRANS_TYPE
							FROM transaksi
							WHERE TRANS_TYPE=1 
							GROUP BY OUTLET_ID,TRANS_TYPE
							HAVING TRANS_TYPE=1) M 
						ON x1.OUTLET_ID=M.OUTLET_ID AND date(x1.TRANS_DATE)=M.TRANS_DATE AND x1.TRANS_TYPE=M.TRANS_TYPE
						ORDER BY x1.OUTLET_ID;
					")->queryAll(), 
					
				]);
				return $booking;
			}
		}else{
			$query = Transaksi::find();

			// add conditions that should always apply here

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
			]);

			$this->load($params);

			if (!$this->validate()) {
				// uncomment the following line if you do not want to return any records when validation fails
				// $query->where('0=1');
				return $dataProvider;
			}

			// grid filtering conditions
			$query->andFilterWhere([
				'ID' => $this->ID,
				'CREATE_AT' => $this->CREATE_AT,
				'UPDATE_AT' => $this->UPDATE_AT,
				'STATUS' => $this->STATUS,
				'TRANS_TYPE' => $this->TRANS_TYPE,            
				'ITEM_QTY' => $this->ITEM_QTY,
				'ITEM_HARGA' => $this->ITEM_HARGA,
				'ITEM_DISCOUNT' => $this->ITEM_DISCOUNT,
			]);

			$query->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
				->andFilterWhere(['like', 'TRANS_DATE', $this->TRANS_DATE])
				->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
				->andFilterWhere(['like', 'TRANS_ID', $this->TRANS_ID])
				->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
				->andFilterWhere(['like', 'OUTLET_ID', $this->OUTLET_ID])
				->andFilterWhere(['like', 'OUTLET_NM', $this->OUTLET_NM])
				->andFilterWhere(['like', 'CONSUMER_NM', $this->CONSUMER_NM])
				->andFilterWhere(['like', 'CONSUMER_EMAIL', $this->CONSUMER_EMAIL])
				->andFilterWhere(['like', 'CONSUMER_PHONE', $this->CONSUMER_PHONE])
				->andFilterWhere(['like', 'ITEM_ID', $this->ITEM_ID])
				->andFilterWhere(['like', 'ITEM_NM', $this->ITEM_NM])
				->andFilterWhere(['like', 'ITEM_DISCOUNT_TIME', $this->ITEM_DISCOUNT_TIME]);

			return $dataProvider;
			
		}
    }
}
