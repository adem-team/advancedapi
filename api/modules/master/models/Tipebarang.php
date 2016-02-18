<?php

namespace api\modules\master\models;

use Yii;

use lapi\modules\master\Barang;


/**
 * This is the model class for table "b1001".
 *
 * @property string $id
 * @property string $kd_type
 * @property string $NM_TYPE
 * @property string $NOTE
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 * @property integer $status
 */
class Tipebarang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b1001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

	public static function primaryKey()
    {
      return ['ID'];
    }
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_TYPE', 'NM_TYPE','STATUS'], 'safe'],
            [['NOTE'], 'string'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['STATUS'], 'integer'],
            [['KD_TYPE'], 'string', 'max' => 5],
            [['NM_TYPE'], 'string', 'max' => 200],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_TYPE' => 'Kode Type',
            'NM_TYPE' => 'Nama Type',
            'NOTE' => 'Catatan',
            'CREATED_BY' => 'Created By',
            'CREATED_AT' => 'Created At',
            'UPDATED_BY' => 'Updated By',
            'UPDATED_AT' => 'Updated At',
            'STATUS' => 'Status',
        ];
    }
}
