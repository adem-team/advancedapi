<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\TransaksiType */

$this->title = Yii::t('app', 'Create Transaksi Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transaksi Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
