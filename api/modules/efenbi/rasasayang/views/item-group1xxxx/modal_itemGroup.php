<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/**
* ===============================
 * Button Permission.
 * Modul ID	: 12
 * Author	: ptr.nov2gmail.com
 * Update	: 01/02/2017
 * Version	: 2.1
 * ===============================
*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('12')){
			return Yii::$app->getUserOpt->Modul_akses('12');
		}else{
			return false;
		}
	}
	/*
	 * Backgroun Icon Color.
	*/
	function bgIconColor(){
		//return '#f08f2e';//kuning.
		return '#1eaac2';//biru Laut.
	}
	
	
/**
* ===============================
 * Button & Link Modal item-group
 * Author	: ptr.nov2gmail.com
 * Update	: 21/01/2017
 * Version	: 2.1
 * ===============================
*/
	/*
	 * Button - CREATE.
	*/
	function tombolCreate(){
		if(getPermission()){
			if(getPermission()->BTN_CREATE==1){
				$title1 = Yii::t('app', ' New');
				$url = Url::toRoute(['/efenbi/item-group/create']);
				$options1 = ['value'=>$url,
							'id'=>'item-group-button-create',
							'class'=>"btn btn-danger btn-xs"  
				];
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1,$options1);
				return $content;
			}
		}
	}
	
	/*
	 * Button - VIEW.
	*/
	function tombolView($url, $model){
		if(getPermission()){
			//Jika BTN_CREATE Show maka BTN_CVIEW Show.
			if(getPermission()->BTN_VIEW==1 OR getPermission()->BTN_CREATE==1){
				$title1 = Yii::t('app',' View');
				$options1 = [
					'value'=>url::to(['/efenbi/item-group/view','id'=>$model->ID_item-group]),
					'id'=>'item-group-button-view',
					'class'=>"btn btn-default btn-xs",      
					'style'=>['text-align'=>'left','width'=>'100%', 'height'=>'25px','border'=> 'none'],
				];
				$icon1 = '
					<span class="fa-stack fa-xs">																	
						<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
						<i class="fa fa-eye fa-stack-1x" style="color:#fbfbfb"></i>
					</span>
				';      
				$label1 = $icon1 . '  ' . $title1;
				$content = Html::button($label1,$options1);		
				return $content;
			}
		}
	}
	
	/*
	 * Button - REVIEW.
	*/
	function tombolReview($url, $model){
		if(getPermission()){
			//Jika REVIEW Show maka Bisa Update/Editing.
			if(getPermission()->BTN_REVIEW==1){
				$title1 = Yii::t('app',' Review');
				$options1 = [
					'value'=>url::to(['/efenbi/item-group/review','id'=>$model->ID_item-group]),
					'id'=>'item-group-button-review',
					'class'=>"btn btn-default btn-xs",      
					'style'=>['text-align'=>'left','width'=>'100%', 'height'=>'25px','border'=> 'none'],
				];
				//thin -> untuk bulet luar
				$icon1 = '
					<span class="fa-stack fa-xs">																	
						<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
						<i class="fa fa-edit fa-stack-1x" style="color:#fbfbfb"></i>
					</span>
				';      
				$label1 = $icon1 . '  ' . $title1;
				$content = Html::button($label1,$options1);		
				return $content;
			}
		}
	}
	
	/*
	 * Button - REMAINDER.
	 * BTN_PROCESS1.
	*/	
	function tombolRemainder($url, $model){
		if(getPermission()){
			if(getPermission()->BTN_PROCESS1==1){
				$title1 = Yii::t('app',' Remainder');
				$url = url::to(['/efenbi/item-group/remainder','id'=>$model->ID_item-group]);
				$options1 = [
					'value'=>$url,
					'id'=>'item-group-button-remainder',
					'class'=>"btn btn-default btn-xs",      
					'style'=>['text-align'=>'left','width'=>'100%', 'height'=>'25px','border'=> 'none'],
				];
				$icon1 = '
					<span class="fa-stack fa-xs">																	
						<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
						<i class="fa fa-clock-o fa-stack-1x" style="color:#fbfbfb"></i>
					</span>
				';      
				$label1 = $icon1 . '  ' . $title1;
				$content = Html::button($label1,$options1);		
				 return $content;
			}
		}
	}
	
	/*
	 * Button - DENY.
	 * Limited Access.
	 * update : 24/02/2017.
	 * PR	  : useroption invalid foreach.
	*/	
	function tombolDeny($url, $model){
		//if(Yii::$app->getUserOpt->Modul_aksesDeny('12')==0){
			$title1 = Yii::t('app',' Limited Access');
			$url = url::to(['/efenbi/item-group']);
			$options1 = [
				'value'=>$url,
				'id'=>'item-group-button-deny',
				'class'=>"btn btn-default btn-xs",      
				'style'=>['text-align'=>'left','width'=>'100%', 'height'=>'25px','border'=> 'none'],
			];
			$icon1 = '
				<span class="fa-stack fa-xs">																	
					<i class="fa fa-circle fa-stack-2x " style="color:#B81212"></i>
					<i class="fa fa-remove fa-stack-1x" style="color:#fbfbfb"></i>
				</span>
			';      
			$label1 = $icon1 . '  ' . $title1;
			$content = Html::button($label1,$options1);		
			return $content;
		//}
	}
	//Link Button Refresh 
	function tombolRefresh(){
		$title = Yii::t('app', 'Refresh');
		$url =  Url::toRoute(['/efenbi/item-group']);
		$options = ['id'=>'item-group-id-refresh',
				  'data-pjax' => 0,
				  'class'=>"btn btn-info btn-xs",
				];
		$icon = '<span class="fa fa-history fa-lg"></span>';
		$label = $icon . ' ' . $title;

		return $content = Html::a($label,$url,$options);
	}
	
	/*
	 * Button - EXPORT EXCEL.
	*/
	function tombolExportExcel(){
		// if(getPermission()){
			// if(getPermission()->BTN_PROCESS1==1){
				$title1 = Yii::t('app', ' Export Excel');
				$url = Url::toRoute(['/efenbi/item-group/export-excel']);
				$options1 = ['value'=>$url,
							'id'=>'item-group-button-export-excel',
							'class'=>"btn btn-info btn-xs"  
				];
				$icon1 = '<span class="fa fa-file-excel-o fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1,$options1);
				return $content;
			// }
		// }
	}	
	
/**
 * ===============================
 * Modal item-group
 * Author	: ptr.nov2gmail.com
 * Update	: 21/01/2017
 * Version	: 2.1
 * ==============================
*/
	/*
	 * item-group - CREATE.
	*/
	$modalHeaderColor='#fbfbfb';//' rgba(74, 206, 231, 1)';
	Modal::begin([
		'id' => 'item-group-modal-create',
		'header' => '
			<span class="fa-stack fa-xs">																	
				<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
				<i class="fa fa-plus fa-stack-1x" style="color:#fbfbfb"></i>
			</span><b> CREATE PROMOTION</b>
		',		
		'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:'.$modalHeaderColor,
		],
	]);
	echo "<div id='item-group-modal-content-create'></div>";
	Modal::end();
	
	/*
	 * item-group - VIEW.
	*/
	Modal::begin([
		'id' => 'item-group-modal-view',
		'header' => '
			<span class="fa-stack fa-xs">																	
				<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
				<i class="fa fa-eye fa-stack-1x" style="color:#fbfbfb"></i>
			</span><b> VIEW item-group</b>
		',		
		'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:'.$modalHeaderColor,
		],
	]);
	echo "<div id='item-group-modal-content-view'></div>";
	Modal::end();
	
	/*
	 * item-group - REVIEW.
	*/
	Modal::begin([
		'id' => 'item-group-modal-review',
		'header' => '
			<span class="fa-stack fa-xs">																	
				<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
				<i class="fa fa-edit fa-stack-1x" style="color:#fbfbfb"></i>
			</span><b> REVIEW item-groupS</b>
		',		
		'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:'.$modalHeaderColor,
		],
	]);
	echo "<div id='item-group-modal-content-review'></div>";
	Modal::end();
	
	/*
	 * item-group - Remainder.
	*/
	Modal::begin([
		'id' => 'item-group-modal-remainder',
		'header' => '
			<span class="fa-stack fa-xs">																	
				<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
				<i class="fa fa-clock-o fa-stack-1x" style="color:#fbfbfb"></i>
			</span><b> REMAINDER SETTING</b>
		',		
		'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:'.$modalHeaderColor,
		],
	]);
	echo "<div id='item-group-modal-content-remainder'></div>";
	Modal::end();
	
	/*
	 * item-group - EXPORT EXCEL.
	*/
	$modalHeaderColor='#fbfbfb';//' rgba(74, 206, 231, 1)';
	Modal::begin([
		'id' => 'item-group-modal-export-excel',
		'header' => '
			<span class="fa-stack fa-xs">																	
				<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
				<i class="fa fa-file-excel-o fa-stack-1x" style="color:#fbfbfb"></i>
			</span><b> Export to Excel</b>
		',		
		'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:'.$modalHeaderColor,
		],
	]);
	echo "<div id='item-group-modal-content-export-excel'></div>";
	Modal::end();
?>