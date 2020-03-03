<?php
namespace app\models;
use Yii;
class MYSQLSolicitudOtorgada extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    public static function tableName(){
        return 'solicitud_otorgada';
    }

    public function rules()
    {
        return [
            [['solicitud_otorga_id', 'solicitud_otorga_solic','solicitud_fecha','solicitud_otorga_fecha','solicitud_otorga_nro'], 'required'],
            [['solicitud_otorga_solic'],'exist','skipOnError' => true,'targetClass'=>MYSQLSolicitudInscripcion::classname(),'targetAttributte'=>['solicitud_id','solicitud_otoroga_solic']]
           
        ];
    }

    public function attributeLabels()
    {
        return [
            'solicitud_id' => 'ID Soliciutd',
            'solicitud_fecha' => 'Fecha Solicitud',
            'solicitud_estado'=>'Estado de la solicitud',
            'solicitud_establecimiento'=>'Establecimiento de la solicitud'
            
        ];

    }
    public function getSolicitud(){
        return $this->hasOne(MYSQLSolcitudInscripcion::classname(),['solicitud_id','solicitud_otoroga_solic']);
    }

}

?>