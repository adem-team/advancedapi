<?php
namespace common\components;
use yii\base\Component;
use yii\helpers\Html;
use kartik\grid\GridView;
use Yii;

class gv extends Component	{
	
	public function grview($gridColumns,$dataProvider,$searchModel,$nm,$nmField,$title)
    {
		$grid = GridView::widget([
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $gridColumns,
			'pjax'=>true,
			'toolbar' => [
				'{export}',
			],
			'panel' => [
				'heading'=>'<h3 class="panel-title">'. Html::encode($title).'</h3>',
				'type'=>'warning',
				'before'=>Html::a('<i class="fa fa-plus fa-fw"></i> '.$nm, ['create'], ['class' => 'btn btn-warning']),
				'showFooter'=>false,
			],		
			
			'export' =>['target' => GridView::TARGET_BLANK],
			'exportConfig' => [
				GridView::PDF => [ 'filename' => $nmField.'-'.date('ymdHis') ],
				GridView::EXCEL => [ 'filename' => $nmField.'-'.date('ymdHis') ],
			],
		]);
		
		return $grid;
	}
}
