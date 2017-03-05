/**
 * ===============================
 * JS Modal store
 * Author	: ptr.nov2gmail.com
 * Update	: 21/01/2017
 * Version	: 2.1
 * ===============================
*/

/*
 * store-Create.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#store-button-create', function(ehead){ 			  
	$('#store-modal-create').modal('show')
	.find('#store-modal-content-create').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * store-View.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#store-button-view', function(ehead){ 			  
	$('#store-modal-view').modal('show')
	.find('#store-modal-content-view').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * store-REview.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#store-button-review', function(ehead){ 			  
	$('#store-modal-review').modal('show')
	.find('#store-modal-content-review').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * store-Remainder.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#store-button-remainder', function(ehead){ 			  
	$('#store-modal-remainder').modal('show')
	.find('#store-modal-content-remainder').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * store-Export-Excel.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#store-button-export-excel', function(ehead){ 			  
	$('#store-modal-export-excel').modal('show')
	.find('#store-modal-content-export-excel').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});


/**
 * ======================================== TIPS ========================================
 * HELPER INCLUDE FILE
 * include 	: index.php [MODAL JS AND CONTENT].
 * File		: modal_store.js And modal_store.php
 * Version	: 2.1
*/
/* 
	$this->registerJs($this->render('modal_store.js'),View::POS_READY);
	echo $this->render('modal_store');
*/

/**
 * HELPER BUTTON 
 * Action 	: Button
 * include	: View
 * Version	: 2.1
*/
/* 
	return  Html::button(Yii::t('app', 
		'<span class="fa-stack fa-xs">																	
			<i class="fa fa-circle fa-stack-2x " style="color:#f08f2e"></i>
			<i class="fa fa-cart-arrow-down fa-stack-1x" style="color:#fbfbfb"></i>
		</span> View Customers'
	),
	['value'=>url::to(['/marketing/sales-promo/view','id'=>$model->ID]),
	'id'=>'store-button-view',
	'class'=>"btn btn-default btn-xs ",      
	'style'=>['text-align'=>'left','width'=>'170px', 'height'=>'25px','border'=> 'none'],
	]); 
*/

/*=========================================================================================*/