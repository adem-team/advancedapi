<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\TransaksiNotify */

$this->title = Yii::t('app', 'Create Transaksi Notify');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transaksi Notifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-notify-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
