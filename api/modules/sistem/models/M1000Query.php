<?php
namespace crm\sistem\models;
/**
 * This is the ActiveQuery class for [[M1000]].
 *
 * @see M1000
 */
class M1000Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/
    /**
     * @inheritdoc
     * @return M1000[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    /**
     * @inheritdoc
     * @return M1000|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    public function findMenu($kdmenu)
    {
        $this->where(['=','kd_menu', $kdmenu]);
        return $this;
    }
}