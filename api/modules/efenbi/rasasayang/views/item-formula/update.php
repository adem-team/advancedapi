<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\models\ItemFormula */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Item Formula',
]) . $model->ID_DTL_FORMULA;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item Formulas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_DTL_FORMULA, 'url' => ['view', 'id' => $model->ID_DTL_FORMULA]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="item-formula-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
