<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\models\ItemFormula */

$this->title = Yii::t('app', 'Create Item Formula');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item Formulas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-formula-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
