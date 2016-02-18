<?php
/**
 * Created by PhpStorm.
 * User: ptr.nov
 * Date: 10/08/15
 * Time: 19:44
 */

namespace common\components;
use Yii;
use Yii\base\Model;
use modulprj\models\hrd\Karyawan;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\base\Component;

class Static_sttComponent extends Component {
    public function getGender($id){
        //if ($id==1){return 'Pria123';}else {return 'Wanita123';}
        switch ($id) {
            case 1:
                return  'Pria';
                break;
            case 2:
                return  'Wanita';
                break;
            default:
                echo "";
        }
    }
    public function getAgama($id){
            switch ($id) {
                case 1:
                    return  'Islam';
                    break;
                case 2:
                    return  'Kristen';
                    break;
                case 3:
                    return  'Katholik';
                    break;
                case 4:
                    return  'Budha';
                    break;
                case 5:
                    return  'Hindu';
                    break;
                default:
                    echo "";
        }
    }
    public function getMarital($id){
        switch ($id) {
            case 'K':
                return  'Kawin';
                break;
            case 'TK':
                return  'Tidak Kawin';
                break;
            default:
                echo "";
        }
    }
} 