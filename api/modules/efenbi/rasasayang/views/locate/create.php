<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\Locate */

$this->title = Yii::t('app', 'Create Locate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Locates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="locate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
