<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\ItemGroupDisplay */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Item Group Display',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item Group Displays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="item-group-display-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
