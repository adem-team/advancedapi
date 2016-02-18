<?php

namespace lukisongroup\models\system\erpmodul;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\models\system\erpmodul\Mdlpermission;

/**
 * MdlpermissionSearch represents the model behind the search form about `lukisongroup\models\system\erpmodul\Mdlpermission`.
 */
class MdlpermissionSearch extends Mdlpermission
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
         return [
            [['ID','USER_ID', 'MODUL_ID', 'STATUS', 'BTN_CREATE', 'BTN_EDIT', 'BTN_DELETE', 'BTN_VIEW', 'BTN_PROCESS1', 'BTN_PROCESS2', 'BTN_PROCESS3', 'BTN_PROCESS4', 'BTN_PROCESS5', 'BTN_SIGN1', 'BTN_SIGN2', 'BTN_SIGN3','BTN_SIGN4','BTN_SIGN5'], 'integer'],
			[['CREATED_BY','UPDATED_BY'],'string'],
			[['UPDATED_TIME'],'safe'],
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
        $query = Mdlpermission::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'USER_ID' => $this->USER_ID,
            'MODUL_ID' => $this->MODUL_ID,
            'STATUS' => $this->STATUS,
            'BTN_CREATE' => $this->BTN_CREATE,
            'BTN_EDIT' => $this->BTN_EDIT,
            'BTN_DELETE' => $this->BTN_DELETE,
            'BTN_VIEW' => $this->BTN_VIEW,
            'BTN_PROCESS1' => $this->BTN_PROCESS1,
            'BTN_PROCESS2' => $this->BTN_PROCESS2,
            'BTN_PROCESS3' => $this->BTN_PROCESS3,
            'BTN_PROCESS4' => $this->BTN_PROCESS4,
            'BTN_PROCESS5' => $this->BTN_PROCESS5,
            'BTN_SIGN1' => $this->BTN_SIGN1,
            'BTN_SIGN2' => $this->BTN_SIGN2,
            'BTN_SIGN3' => $this->BTN_SIGN3,
            'BTN_SIGN5' => $this->BTN_SIGN5,
            'CREATED_BY' => $this->CREATED_BY,
            'UPDATED_BY' => $this->UPDATED_BY,
            'UPDATED_TIME' => $this->UPDATED_TIME,
        ]);

        return $dataProvider;
    }
}
