<?php

namespace api\modules\efenbi\rasasayang\models;

/**
 * This is the ActiveQuery class for [[Locate]].
 *
 * @see Locate
 */
class LocateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Locate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Locate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
