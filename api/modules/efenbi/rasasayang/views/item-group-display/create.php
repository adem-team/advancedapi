<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\ItemGroupDisplay */

$this->title = Yii::t('app', 'Create Item Group Display');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item Group Displays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-group-display-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
