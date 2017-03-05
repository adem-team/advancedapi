<?php
use kartik\helpers\Html;	
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;


//print_r($top5MemberMonth);
function tabel($data){
	$fillhead='<thead><tr><th width="1%">'.'#</th><th>Nama</th><th>GrandTotal</th></tr></thead><tbody>';
	$fillbody='';
	$nourut= 0;
	// print_r($data);
	// die();
	if(is_array($data)){
		$parsed_json = json_decode($data);
			foreach ($parsed_json as $key => $value) {
				$nourut+= 1;
				$fillbody = $fillbody . '<tr><td>'. $nourut .'</td><td>' . $value->nama . '</td><td class="right-align">'. $value->grandtotal . '</td></tr>';

			}
		$fillbody = $fillbody . '<tbody>';
		return $fillhead.$fillbody;
	}
	return [];
}


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
								<?=tabel($top5MemberMonth); ?>
							</table>
						</div>
					</div>
					<div class="col-md-4">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h3 class="panel-title">Top 5 Tenant Of The Month</h3>
							</div>
							<table class="table table-condensed">
								<?=tabel($top5TenantMonth); ?>
							</table>
						</div>
					</div>
					<div class="col-md-4">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h3 class="panel-title">Lates New Member</h3>
							</div>
							<table class="table table-condensed">
								<?=tabel($top5MemberNew); ?>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>