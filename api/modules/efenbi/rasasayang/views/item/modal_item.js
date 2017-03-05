/**
 * ===============================
 * JS Modal item
 * Author	: ptr.nov2gmail.com
 * Update	: 21/01/2017
 * Version	: 2.1
 * ===============================
*/

/*
 * item-Create.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#item-button-create', function(ehead){ 			  
	$('#item-modal-create').modal('show')
	.find('#item-modal-content-create').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * item-View.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#item-button-view', function(ehead){ 			  
	$('#item-modal-view').modal('show')
	.find('#item-modal-content-view').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * item-REview.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#item-button-review', function(ehead){ 			  
	$('#item-modal-review').modal('show')
	.find('#item-modal-content-review').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * item-Remainder.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#item-button-remainder', function(ehead){ 			  
	$('#item-modal-remainder').modal('show')
	.find('#item-modal-content-remainder').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * item-Export-Excel.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#item-button-export-excel', function(ehead){ 			  
	$('#item-modal-export-excel').modal('show')
	.find('#item-modal-content-export-excel').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});


/**
 * ======================================== TIPS ========================================
 * HELPER INCLUDE FILE
 * include 	: index.php [MODAL JS AND CONTENT].
 * File		: modal_item.js And modal_item.php
 * Version	: 2.1
*/
/* 
	$this->registerJs($this->render('modal_item.js'),View::POS_READY);
	echo $this->render('modal_item');
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
	'id'=>'item-button-view',
	'class'=>"btn btn-default btn-xs ",      
	'style'=>['text-align'=>'left','width'=>'170px', 'height'=>'25px','border'=> 'none'],
	]); 
*/

/*=========================================================================================*/