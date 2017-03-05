<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\Transaksi */

$this->title = Yii::t('app', 'Create Transaksi');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transaksis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
