<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "b1002".
 *
 * @property string $id
 * @property string $kd_kategori
 * @property string $NM_KATEGORI
 * @property string $NOTE
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 * @property integer $status
 */
class Kategori extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	
	
    public static function tableName()
    {
        return 'b1002';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_KATEGORI', 'NM_KATEGORI'], 'required'],
            [['NOTE'], 'string'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['STATUS'], 'integer'],
            [['STATUS'], 'required'],
            [['KD_KATEGORI'], 'string', 'max' => 5],
            [['NM_KATEGORI'], 'string', 'max' => 200],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100]
        ];
    }

	public static function primaryKey()
    {
      return ['ID'];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_KATEGORI' => 'Kode Kategori',
            'NM_KATEGORI' => 'Nama Kategori',
            'NOTE' => 'Catatan',
            'CREATED_BY' => 'Created By',
            'CREATED_AT' => 'Created At',
            'UPDATED_BY' => 'Updated By',
            'UPDATED_AT' => 'Updated At',
            'STATUS' => 'status',
        ];
    }
}
