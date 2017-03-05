<?php

use kartik\helpers\Html;
use kartik\tabs\TabsX;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
ChartAsset::register($this);
use lukisongroup\assets\Profile;
Profile::register($this);

//include("fusioncharts.php");
$this->sideCorp = 'F&B - Miqu';                      			/* Title Select Company pada header pasa sidemenu/menu samping kiri */	
$this->sideMenu = 'efenbi_miqu';                                    					/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Reporting - PT.  Efembi Sukses Makmur');		/* title pada header page */
$this->params['breadcrumbs'][] = $this->title;   

	$_indexSalesDay=$this->render('_indexSalesDay',[
		'totalGrandHari'=>$totalGrandHari,
		'totalTransHari'=>$totalTransHari,
		'totalMember'=>$totalMember
	]);
	$_indexSalesWeekHour=$this->render('_indexSalesWeekHour');
	$_indexSalesWeek=$this->render('_indexSalesWeek');	
	$_indexTop5MemberTenanMonth=$this->render('_indexTop5MemberTenanMonth',[
		'top5MemberMonth'=>$top5MemberMonth,
		'top5TenantMonth'=>$top5TenantMonth,
		'top5MemberNew'=>$top5MemberNew
	]);
	$_indexSalesYear=$this->render('_indexSalesYear');	
	$_indexTop5TenanMonthYear=$this->render('_indexTop5TenanMonthYear',[
		'top5TenantMonth'=>$top5TenantMonth,
		'top5TenantNew'=>$top5TenantNew,
		'top5TenantYear'=>$top5TenantYear,
	]);
	$_indexTop5MemberMonthYear=$this->render('_indexTop5MemberMonthYear',[
		'top5MemberMonth'=>$top5MemberMonth,
		'top5MemberYear'=>$top5MemberYear,
		'top5MemberNew'=>$top5MemberNew,
	]);
	
	$items=[
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Sales-Miqu','content'=>
			$_indexSalesDay.
			$_indexSalesWeekHour.
			$_indexSalesWeek.						
			$_indexSalesYear.
			$_indexTop5MemberTenanMonth,
			'active'=>true,			
		],		
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Cabang','content'=>$_indexTop5TenanMonthYear,
			//active'=>true
		],
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Menu','content'=>$_indexTop5MemberMonthYear,
			//active'=>true
		],
	];	


	$tabSss= TabsX::widget([
			'items'=>$items,
			'position'=>TabsX::POS_ABOVE,
			'height'=>TabsX::SIZE_TINY,
			'bordered'=>true,
			'encodeLabels'=>false,
			'height'=>'450px',
			'align'=>TabsX::ALIGN_LEFT,						
		]);											
?>
<div id="loaderPtr"></div>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt; padding-top:-150px">
		<div class="row" >
			<?=$tabSss?>			
		</div>
</div>