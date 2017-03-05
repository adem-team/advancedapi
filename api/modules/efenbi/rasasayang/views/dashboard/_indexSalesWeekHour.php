<?php
use kartik\helpers\Html;	
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\bootstrap\Modal;
use ptrnov\fusionchart\Chart;

	$btn_srchChart = Html::button(Yii::t('app', 'Search Date'),
		['value'=>url::to(['ambil-tanggal-chart']),
		'id'=>'modalButtonDashboardChartTgl',
		'class'=>"btn btn-info btn-sm"						
	]);
	
	$mslineTrans9DayHour= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/foodtown/8daily-hour',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'msline',//msline//'bar3d',//'gantt',					//Chart Type 
		'renderid'=>'msline-sss-week-hour',								//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'450px',
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
	


?>
<div  class="row">	
	<div class="col-sm-12 col-md-12 col-lg-12" style="margin-top:10px">
		<div class="w3-card-2 w3-round w3-white w3-center">
				<div class="panel-heading">
					<div class="row">
						<div style="min-height:450px"><div style="height:450px"><?=$mslineTrans9DayHour?></div></div><div class="clearfix"></div>
					</div>
				</div>	
			</div>				
		<?php
			 // echo Html::panel(
				// [
					// 'heading' => false,
					// 'body'=> '<div style="min-height:450px"><div style="height:450px">'.$mslineSalesYear.'</div></div><div class="clearfix"></div>',
				// ],
				// Html::TYPE_INFO
			// );
		?>
	</div>
</div>
	