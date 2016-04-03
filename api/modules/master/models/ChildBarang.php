<?php

namespace api\modules\master\models;

use api\modules\master\models\ParentBarang;
use Yii;

/**
 * This is the model class for table "childbarang".
 *
 * @property integer $id
 * @property string $nama_child
 * @property string $keterangan
 * @property string $create_at
 * @property integer $create_by
 * @property integer $parent
 *
 * @property Parentbarang $parent0
 * @property Grandbarang[] $grandbarangs
 */
class ChildBarang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'childbarang';
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
            [['nama_child', 'keterangan', 'create_at', 'create_by', 'parent'], 'required'],
            [['keterangan'], 'string'],
            [['create_at'], 'safe'],
            [['create_by', 'parent'], 'integer'],
            [['nama_child'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_child' => 'Nama Child',
            'keterangan' => 'Keterangan',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'parent' => 'Parent',
        ];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasOne(Parentbarang::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrandbarangs()
    {
        return $this->hasMany(Grandbarang::className(), ['childof' => 'id']);
    }

    public function extraFields()
    {
        return ['grandbarangs'];
        //return ['unit'];
    }

    public function relations()
    {
        return array(
            'parents'=>array(self::BELONGS_TO, 'ParentBarang', 'parent'),
            'grandbarangs'=>array(self::HAS_MANY, 'GrandBarang', 'childof'),
        );
    }
}
