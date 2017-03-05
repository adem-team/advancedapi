<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\TransaksiType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Transaksi Type',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transaksi Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="transaksi-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
