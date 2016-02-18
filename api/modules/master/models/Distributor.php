<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "d0001".
 *
 * @property string $idDbtr
 * @property string $KD_DISTRIBUTOR
 * @property string $nmDbtr
 * @property string $alamat
 * @property string $pic
 * @property string $tlp1
 * @property string $tlp2
 * @property string $fax
 * @property string $email
 * @property string $website
 * @property string $NOTE
 * @property integer $status
 * @property string $createBy
 * @property string $createAt
 * @property string $updateAt
 * @property string $data_all
 */
class Distributor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'd0001';
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
            [['KD_DISTRIBUTOR', 'NM_DISTRIBUTOR', 'ALAMAT', 'PIC', 'TLP1', 'TLP2', 'FAX', 'EMAIL', 'WEBSITE', 'NOTE', 'STATUS', 'CREATED_BY', 'CREATED_AT', 'UPDATED_AT', 'DATA_ALL', 'UPDATED_BY'], 'string'],
            [['KD_DISTRIBUTOR', 'NM_DISTRIBUTOR', 'ALAMAT', 'PIC', 'STATUS'], 'required'],
 //           [['alamat', 'NOTE'], 'string'],
            [['TLP1', 'TLP2', 'FAX', 'STATUS'], 'integer'],
            [['KD_DISTRIBUTOR'], 'string', 'max' => 255],
 //           [['nmDbtr', 'pic', 'email', 'website', 'createBy', 'createAt', 'updateAt', 'DATA_ALL'], 'string', 'max' => 255]
            
            [['CREATED_BY','UPDATED_BY'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'Id Dbtr',
            'KD_DISTRIBUTOR' => 'Kode Distributor',
            'NM_DISTRIBUTOR' => 'Nama Distributor',
            'ALAMAT' => 'Alamat Distributor',
            'PIC' => 'Penanggung Jawab',
            'TLP1' => 'Telephone 1',
            'TLP2' => 'Telephone 2',
            'FAX' => 'Fax',
            'EMAIL' => 'Email',
            'WEBSITE' => 'Website',
            'NOTE' => 'Note',
            'STATUS' => 'Status Distributor',
            'CREATED_BY' => 'Create By',
            'CREATED_AT' => 'Create At',
            'UPDATED_AT' => 'Update At',
            'UPDATED_BY' => 'Update By',
            'DATA_ALL' => 'Data All',
        ];
    }
}
