<?php

namespace crm\sistem\models;

use Yii;

/**
 * This is the model class for table "modul_permission".
 *
 * @property string $ID
 * @property string $USER_ID
 * @property string $MODUL_ID
 * @property integer $STATUS
 * @property integer $BTN_CREATE
 * @property integer $BTN_EDIT
 * @property integer $BTN_DELETE
 * @property integer $BTN_VIEW
 * @property integer $BTN_PROCESS1
 * @property integer $BTN_PROCESS2
 * @property integer $BTN_PROCESS3
 * @property integer $BTN_PROCESS4
 * @property integer $BTN_PROCESS5
 * @property integer $BTN_SIGN1
 * @property integer $BTN_SIGN2
 * @property integer $BTN_SIGN3
 * @property integer $BTN_SIGN4
 * @property integer $BTN_SIGN5
 * @property integer $CREATED_BY
 * @property integer $UPDATED_BY
 * @property integer $UPDATED_TIME  
 */
class Mdlpermission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modul_permission';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USER_ID', 'MODUL_ID', 'STATUS', 'BTN_CREATE', 'BTN_EDIT', 'BTN_DELETE', 'BTN_VIEW', 'BTN_PROCESS1', 'BTN_PROCESS2', 'BTN_PROCESS3', 'BTN_PROCESS4', 'BTN_PROCESS5', 'BTN_SIGN1', 'BTN_SIGN2', 'BTN_SIGN3','BTN_SIGN4','BTN_SIGN5'], 'integer'],
			[['CREATED_BY','UPDATED_BY'],'string'],
			[['UPDATED_TIME'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'USER_ID' => 'User.ID',
            'MODUL_ID' => 'Modul.ID',
            'STATUS' => 'Status',
            'BTN_CREATE' => 'Create',
            'BTN_EDIT' => 'Edit',
            'BTN_DELETE' => 'Delete',
            'BTN_VIEW' => 'view',
            'BTN_PROCESS1' => 'Process1',
            'BTN_PROCESS2' => 'Process2',
            'BTN_PROCESS3' => 'Process3',
            'BTN_PROCESS4' => 'Process4',
            'BTN_PROCESS5' => 'Process5',
            'BTN_SIGN1' => 'Sign1',
            'BTN_SIGN2' => 'Sign2',
            'BTN_SIGN3' => 'Sign3',
			'BTN_SIGN4' => 'Sign4',
			'BTN_SIGN5' => 'Sign5',
			'CREATED_BY' => 'Createdby',
			'UPDATED_BY' => 'Updateby',
			'UPDATED_TIME' => 'Updatetime',
        ];
    }
}
