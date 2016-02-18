<?php
/**
 * Created by PhpStorm.
 * User: ptr.nov
 * Date: 10/08/15
 * Time: 19:44
 */

namespace common\components;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Component;

class TgljamconvertComponent {	
    const DATE_FORMAT = 'php:d/m/Y';
    const DATETIME_FORMAT = 'php:d/m/Y H:i:s';
    const TIME_FORMAT = 'php:H:i:s';

    public static function convert($dateStr, $type='date', $format = null) {
        if ($type === 'datetime') {
              $fmt = ($format == null) ? self::DATETIME_FORMAT : $format;
        }
        elseif ($type === 'time') {
              $fmt = ($format == null) ? self::TIME_FORMAT : $format;
        }
        else {
              $fmt = ($format == null) ? self::DATE_FORMAT : $format;
        }
        return \Yii::$app->formatter->asDate($dateStr, $fmt);
    }
	
	public static function Tgldiff($tgl_max,$tgl_min,$opt){
		$date1 = date_create($tgl_max);
		$date2 = date_create($tgl_min);
		$interval =date_diff($date1,$date2);
		if ($opt=='y'){
			$fmt_interval=$interval->y;
		}elseif ($opt=='m'){
			$fmt_interval=$interval->m;
		}elseif($opt=='d'){
			$fmt_interval=$interval->d;
		}
		return $fmt_interval;
	}
	public static function tglSekarang(){
    	return date('Y-m-d');
    } 
    
    public static function jamSekarang(){
    	return date('h:i:s');
    } 
    
    public static function tgljamSekarang(){
    	return date('Y-m-d h:i:s');
    } 
}
/* Yii2 Components Convert Date & datetime waktu Asia/Jakarta
Petunjuk Pengunaan

1. common/config/main.php
   Tambahkan pada komponen   
   'components' => [	      
		'ambilKonvesi' =>[
            'class'=>'common\components\TgljamconvertComponent',
        ],
   ],

2. Pemanggilan
   Untuk tanggal default:
	Yii::$app->ambilKonvesi->convert($model->start,'date');
   Untuk tanggal dan  waktu
	Yii::$app->ambilKonvesi->convert($model->start,'datetime');
   Untuk waktu
	Yii::$app->ambilKonvesi->convert($model->start,'time');
 
3. Lainya
   Yii2 menambahkan di model
   
    public function fields()
	{
		return [
			'tgl'=>function($model){
					return Yii::$app->ambilKonvesi->convert($model->tgl,'date');
				  },			
		];
	}
   
*/