<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\models\ItemFormula */

$this->title = $model->ID_DTL_FORMULA;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item Formulas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-formula-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->ID_DTL_FORMULA], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->ID_DTL_FORMULA], [
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
            'ID_DTL_FORMULA',
            'CREATE_BY',
            'CREATE_AT',
            'UPDATE_BY',
            'UPDATE_AT',
            'STATUS',
            'TYPE',
            'TYPE_NM',
            'ID_STORE',
            'ID_ITEM',
            'DISCOUNT_PESEN',
            'DISCOUNT_WAKTU',
            'DISCOUNT_HARI',
        ],
    ]) ?>

</div>
