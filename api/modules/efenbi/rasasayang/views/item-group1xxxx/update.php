<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\models\ItemGroup */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Item Group',
]) . $model->ID_DTL_ITEM;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_DTL_ITEM, 'url' => ['view', 'id' => $model->ID_DTL_ITEM]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="item-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
