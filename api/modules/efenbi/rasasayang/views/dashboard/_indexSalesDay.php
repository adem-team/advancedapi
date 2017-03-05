<?php
use kartik\helpers\Html;	
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\View;
use ptrnov\fusionchart\Chart;
// $xaxis=0;
// $canvasEndY=200;

//global $xaxis;
//global $canvasEndY;


	$hourly3DaysTafik= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/foodtown/3daily-hour',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'msline',//msline//'bar3d',//'gantt',					//Chart Type 
		'renderid'=>'msline-sss-hour-3daystrafik',								//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'265px',
		'chartOption'=>[				
			'caption'=>'Daily Customers Visits',			//Header Title
			'subCaption'=>'Custommer Call, Active Customer, Efictif Customer',			//Sub Title
			'xaxisName'=>'Parents',							//Title Bawah/ posisi x
			'yaxisName'=>'Total Child ', 					//Title Samping/ posisi y									
			'theme'=>'fint',								//Theme
			'is2D'=>"0",
			'showValues'=> "1",
			'palettecolors'=> "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
			'bgColor'=> "#ffffff",							//color Background / warna latar 
			'showBorder'=> "0",								//border box outside atau garis kotak luar
			'showCanvasBorder'=> "0",						//border box inside atau garis kotak dalam	
		],
	]);	

	$weeklyTafik= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/foodtown/weekly-sales',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'column2d',//msline//'bar3d',//'gantt',					//Chart Type 
		'renderid'=>'mscolumn2d-sss-weekly-trafik',								//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'160px',
		'chartOption'=>[				
			'caption'=>'Daily Customers Visits',			//Header Title
			'subCaption'=>'Custommer Call, Active Customer, Efictif Customer',			//Sub Title
			'xaxisName'=>'Parents',							//Title Bawah/ posisi x
			'yaxisName'=>'Total Child ', 					//Title Samping/ posisi y									
			'theme'=>'fint',								//Theme
			'is2D'=>"0",
			'showValues'=> "1",
			'palettecolors'=> "#583e78,#008ee4,#f8bd19,#e44a00,#6baa01,#ff2e2e",
			'bgColor'=> "#ffffff",							//color Background / warna latar 
			'showBorder'=> "0",								//border box outside atau garis kotak luar
			'showCanvasBorder'=> "0",						//border box inside atau garis kotak dalam	
		],
	]);		


 $this->registerCss("
	.count-ptr
		{
		   color:black;
		}	
 ");
 
$this->registerJs("
	$('.count-grand-total-hari').each(function () {
		$(this).prop('Counter',0).animate({
			Counter: $(this).text()
		}, {
			duration: 4000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			},
			complete: function() {
				$(this).text('".number_format($totalGrandHari)."');
			}
		});
	});
	$('.count-trans-total-hari').each(function () {
		$(this).prop('Counter',0).animate({
			Counter: $(this).text()
		}, {
			duration: 4000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			},
			complete: function() {
				$(this).text('".number_format($totalTransHari)."');
			}
		});
	});
",$this::POS_END);

?>
<div>  		
	<!-- KIRI !-->
	<div class="col-lg-3 col-md-3">
		<div class="row">		
			<div class="w3-card-2 w3-round w3-white w3-center">
				<div class="panel-heading">
					<div class="row" >
						<div class="col-lg-3">
							<span class="fa-stack fa-2x">
							  <i class="fa fa-circle fa-stack-2x" style="color:#64F298"></i>
							  <i class="fa fa-money fa-stack-1x" style="color:#FFFFFF"></i>
							</span>
						</div>						
						<div class="col-lg-9 text-left .small">
							<dl>
								
								<dt class="count-grand-total-hari" style="font-size:20px;color:#7e7e7e"><?=$totalGrandHari?></dt>
								<dd style="font-size:12px;color:#7e7e7e">DAILY SALES (IDR)</dd>
								
							</dl>							
						</div>
					</div>
				</div>	
			</div>	
			<br>
			<div class="w3-card-2 w3-round w3-white w3-center">
				<div class="panel-heading">
					<div class="row" >
						<div class="col-lg-3">
							<span class="fa-stack fa-2x">
							  <i class="fa fa-circle fa-stack-2x" style="color:#0ec1db"></i>
							  <i class="fa fa-dashboard fa-stack-1x" style="color:#FFFFFF"></i>
							</span>
						</div>						
						<div class="col-lg-9 text-left .small">
							<dl>
								<dt class="count-trans-total-hari" style="font-size:20px;color:#7e7e7e"><?=$totalTransHari;?></dt>
								<dd style="font-size:12px;color:#7e7e7e">DAILY TRANS</dd>
							</dl>
							
						</div>
					</div>
				</div>	
			</div>	
			<br>
			<div class="w3-card-2 w3-round w3-white w3-center">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<span class="fa-stack fa-2x">
							  <i class="fa fa-circle fa-stack-2x" style="color:#4455a9"></i>
							  <i class="fa fa-user fa-stack-1x" style="color:#FFFFFF"></i>
							</span>
						</div>						
						<div class="col-lg-9 text-left .small">
							<dl>
								<dt style="font-size:20px;color:#7e7e7e">0 of <?=number_format($totalMember)?></dt>
								<dd style="font-size:12px;color:#7e7e7e">DAILY MEMBER</dd>
							</dl>
							
						</div>
					</div>
				</div>	
			</div>				
		</div>
	</div>
	<!-- TENGAH !-->
	<div class="col-lg-6 col-md-6">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="w3-card-2 w3-round w3-white w3-center">
					<div class="panel-heading">
						<div class="row">
							<div style="min-height:265px"><div style="height:265px"><?=$hourly3DaysTafik?></div></div><div class="clearfix"></div>
						</div>
					</div>	
				</div>				
		</div>				
	</div>	
	<!-- KANAN !-->
	<div class="col-lg-3 col-md-3" style="margin-top:-15px">
		<div class="row">		
			<br>
			<div class="w3-card-2 w3-round w3-white w3-center">
				<div class="panel-heading">
					<div style="min-height:160px"><div style="height:160px"><?=$weeklyTafik?></div></div><div class="clearfix"></div>
				</div>	
			</div>	
			<br>
			<div class="w3-card-2 w3-round w3-white w3-center">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<span class="fa-stack fa-2x">
							  <i class="fa fa-circle fa-stack-2x" style="color:#64F298"></i>
							  <i class="fa fa-arrows-h fa-stack-1x" style="color:#FFFFFF"></i>
							</span>
						</div>						
						<div class="col-lg-9 text-left .small">
							<dl>
								<dt style="font-size:20px;color:#7e7e7e">36.123.123</dt>
								<dd style="font-size:12px;color:#7e7e7e">AVG OF WEEK SALES (IDR)</dd>
							</dl>
							
						</div>
					</div>
				</div>	
			</div>	
		</div>
		<br>
	</div>
	
</div>

<?php

?>