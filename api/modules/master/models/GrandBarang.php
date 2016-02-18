<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "grandbarang".
 *
 * @property integer $id
 * @property string $nama
 * @property string $keterangan
 * @property string $create_at
 * @property integer $create_by
 * @property integer $childof
 *
 * @property Childbarang $childof0
 */
class GrandBarang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grandbarang';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dblocal');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'keterangan', 'create_at', 'create_by', 'childof'], 'required'],
            [['keterangan'], 'string'],
            [['create_at'], 'safe'],
            [['create_by', 'childof'], 'integer'],
            [['nama'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'keterangan' => 'Keterangan',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'childof' => 'Childof',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildofs()
    {
        return $this->hasOne(Childbarang::className(), ['id' => 'childof']);
    }
    public function extraFields()
    {
        return ['childofs'];
        //return ['unit'];
    }

    public function relations()
    {
        return array(
            'childbarangs'=>array(self::BELONGS_TO, 'ChildBarang', 'childof'),
        );
    }

}
