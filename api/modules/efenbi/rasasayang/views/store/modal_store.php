<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/**
* ===============================
 * Button Permission.
 * Modul ID	: 11
 * Author	: ptr.nov2gmail.com
 * Update	: 01/02/2017
 * Version	: 2.1
 * ===============================
*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('11')){
			return Yii::$app->getUserOpt->Modul_akses('11');
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
 * Button & Link Modal store
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
				$title1 = Yii::t('app', ' Add Store');
				$url = Url::toRoute(['/efenbi-rasasayang/store/create']);
				$options1 = ['value'=>$url,
							'id'=>'store-button-create',
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
					'value'=>url::to(['/efenbi-rasasayang/store/view','id'=>$model->ID]),
					'id'=>'store-button-view',
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
					'value'=>url::to(['/efenbi-rasasayang/store/review','id'=>$model->ID]),
					'id'=>'store-button-review',
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
				$url = url::to(['/efenbi-rasasayang/store/remainder','id'=>$model->ID]);
				$options1 = [
					'value'=>$url,
					'id'=>'store-button-remainder',
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
		//if(Yii::$app->getUserOpt->Modul_aksesDeny('11')==0){
			$title1 = Yii::t('app',' Limited Access');
			$url = url::to(['/efenbi-rasasayang/store']);
			$options1 = [
				'value'=>$url,
				'id'=>'store-button-deny',
				'class'=>"btn btn-default btn-xs",      
				'style'=>['text-align'=>'left','width'=>'100%', 'height'=>'25px','border'=> 'none'],
			];
			$icon1 = '
				<span class="fa-stack fa-xs">																	
					<i class="fa fa-circle fa-stack-2x " style="color:#B81111"></i>
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
		$url =  Url::toRoute(['/efenbi-rasasayang/store']);
		$options = ['id'=>'store-id-refresh',
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
				$url = Url::toRoute(['/efenbi-rasasayang/store/export-excel']);
				$options1 = ['value'=>$url,
							'id'=>'store-button-export-excel',
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
 * Modal store
 * Author	: ptr.nov2gmail.com
 * Update	: 21/01/2017
 * Version	: 2.1
 * ==============================
*/
	/*
	 * store - CREATE.
	*/
	$modalHeaderColor='#fbfbfb';//' rgba(74, 206, 231, 1)';
	Modal::begin([
		'id' => 'store-modal-create',
		'header' => '
			<span class="fa-stack fa-xs">																	
				<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
				<i class="fa fa-plus fa-stack-1x" style="color:#fbfbfb"></i>
			</span><b> CREATE STORE</b>
		',		
		'size' => 'modal-dm',
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:'.$modalHeaderColor,
		],
	]);
	echo "<div id='store-modal-content-create'></div>";
	Modal::end();
	
	/*
	 * store - VIEW.
	*/
	Modal::begin([
		'id' => 'store-modal-view',
		'header' => '
			<span class="fa-stack fa-xs">																	
				<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
				<i class="fa fa-eye fa-stack-1x" style="color:#fbfbfb"></i>
			</span><b> VIEW store</b>
		',		
		'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:'.$modalHeaderColor,
		],
	]);
	echo "<div id='store-modal-content-view'></div>";
	Modal::end();
	
	/*
	 * store - REVIEW.
	*/
	Modal::begin([
		'id' => 'store-modal-review',
		'header' => '
			<span class="fa-stack fa-xs">																	
				<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
				<i class="fa fa-edit fa-stack-1x" style="color:#fbfbfb"></i>
			</span><b> REVIEW storeS</b>
		',		
		'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:'.$modalHeaderColor,
		],
	]);
	echo "<div id='store-modal-content-review'></div>";
	Modal::end();
	
	/*
	 * store - Remainder.
	*/
	Modal::begin([
		'id' => 'store-modal-remainder',
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
	echo "<div id='store-modal-content-remainder'></div>";
	Modal::end();
	
	/*
	 * store - EXPORT EXCEL.
	*/
	$modalHeaderColor='#fbfbfb';//' rgba(74, 206, 231, 1)';
	Modal::begin([
		'id' => 'store-modal-export-excel',
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
	echo "<div id='store-modal-content-export-excel'></div>";
	Modal::end();
?>