<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\Transaksi */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transaksis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'CREATE_BY',
            'CREATE_AT',
            'UPDATE_BY',
            'UPDATE_AT',
            'STATUS',
            'TRANS_ID',
            'TRANS_TYPE',
            'TRANS_DATE',
            'USER_ID',
            'OUTLET_ID',
            'OUTLET_NM',
            'CONSUMER_NM',
            'CONSUMER_EMAIL:email',
            'CONSUMER_PHONE',
            'ITEM_ID',
            'ITEM_NM',
            'ITEM_QTY',
            'ITEM_HARGA',
            'ITEM_DISCOUNT',
            'ITEM_DISCOUNT_TIME',
        ],
    ]) ?>

</div>
