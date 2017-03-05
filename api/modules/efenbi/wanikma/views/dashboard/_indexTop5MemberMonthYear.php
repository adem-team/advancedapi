<?php
use kartik\helpers\Html;	
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use ptrnov\fusionchart\Chart;

function tabelMember($data,$head){
	$fillhead1='<thead><tr><th width="1%">'.'#</th><th>Nama</th><th>GrandTotal</th></tr></thead><tbody>';
	$fillhead2='<thead><tr><th width="1%">'.'#</th><th>Card ID</th><th>Join Date</th></tr></thead><tbody>';
	$fillbody='';
	$nourut= 0;
	if(is_array($data)){
		$parsed_json = json_decode($data);
			foreach ($parsed_json as $key => $value) {
				$nourut+= 1;
				$fillbody = $fillbody . '<tr><td>'. $nourut .'</td><td>' . $value->nama . '</td><td class="right-align">'. $value->grandtotal . '</td></tr>';

			}
		$fillbody = $fillbody . '<tbody>';
		if ($head==1){
			return $fillhead1.$fillbody;
		}else{
			return $fillhead2.$fillbody;
		}
	}
	return [];
}

	$memberAllTotal= Chart::Widget([
		'urlSource'=> url::base().'/dashboard/foodtown/member',
		'userid'=>'piter@lukison.com',
		'dataArray'=>'[]',//$actionChartGrantPilotproject,				//array scource model or manual array or sqlquery
		'dataField'=>'[]',//['label','value'],							//field['label','value'], normaly value is numeric
		'type'=>'bar2d',//msline//'bar3d',//'gantt',					//Chart Type 
		'renderid'=>'bar2d-member-all-total',								//unix name render
		'autoRender'=>true,
		'width'=>'100%',
		'height'=>'300px'
	]);	


?>
<!-- Dashboard top of the month -->
	<div class="row">		
		<div class="col-sm-12 col-md-12 col-lg-12" style="margin-top:10px">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">TOP 5 Data</h3>
				</div>

				<div class="panel-body">
					<div class="col-md-4">
						<div class="panel panel-flat" >
							<div class="panel-heading">
								<h3 class="panel-title">Top 5 Member Of The Month</h3>
							</div>
							<table class="table table-condensed">
								<?=tabelMember($top5MemberMonth,1)?>
							</table>
						</div>
					</div>
					<div class="col-md-4">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h3 class="panel-title">Top 5 Member Of The Year</h3>
							</div>
							<table class="table table-condensed">
								<?=tabelMember($top5MemberYear,1)?>
							</table>
						</div>
					</div>
					<div class="col-md-4">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h3 class="panel-title">Lates New Member</h3>
							</div>
							<table class="table table-condensed">
								<?=tabelMember($top5MemberNew,2)?>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12" style="margin-top:10px">
			<div class="w3-card-2 w3-round w3-white w3-center">
				<div class="panel-heading">
					<div style="min-height:300px"><div style="height:300px"><?=$memberAllTotal?></div></div><div class="clearfix"></div>
				</div>	
			</div>	
		</div>	
	</div>