/**
 * ===============================
 * JS Modal item-group
 * Author	: ptr.nov2gmail.com
 * Update	: 21/01/2017
 * Version	: 2.1
 * ===============================
*/

/*
 * item-group-Create.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#item-group-button-create', function(ehead){ 			  
	$('#item-group-modal-create').modal('show')
	.find('#item-group-modal-content-create').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * item-group-View.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#item-group-button-view', function(ehead){ 			  
	$('#item-group-modal-view').modal('show')
	.find('#item-group-modal-content-view').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * item-group-REview.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#item-group-button-review', function(ehead){ 			  
	$('#item-group-modal-review').modal('show')
	.find('#item-group-modal-content-review').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * item-group-Remainder.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#item-group-button-remainder', function(ehead){ 			  
	$('#item-group-modal-remainder').modal('show')
	.find('#item-group-modal-content-remainder').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});

/*
 * item-group-Export-Excel.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};	
$(document).on('click','#item-group-button-export-excel', function(ehead){ 			  
	$('#item-group-modal-export-excel').modal('show')
	.find('#item-group-modal-content-export-excel').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	.load(ehead.target.value);
});


/**
 * ======================================== TIPS ========================================
 * HELPER INCLUDE FILE
 * include 	: index.php [MODAL JS AND CONTENT].
 * File		: modal_item-group.js And modal_item-group.php
 * Version	: 2.1
*/
/* 
	$this->registerJs($this->render('modal_item-group.js'),View::POS_READY);
	echo $this->render('modal_item-group');
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
	'id'=>'item-group-button-view',
	'class'=>"btn btn-default btn-xs ",      
	'style'=>['text-align'=>'left','width'=>'170px', 'height'=>'25px','border'=> 'none'],
	]); 
*/

/*=========================================================================================*/