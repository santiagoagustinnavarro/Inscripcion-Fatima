<?php
namespace app\models;
use Yii;
class MYSQLSolicitudInscripcion extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    public static function tableName(){
        return 'solicitud_inscripcion';
    }

    public function rules()
    {
        return [
            [['solicitud_id', 'solicitud_nro','solicitud_fecha','solicitud_estado','solicitud_establecimiento'], 'required'],
           
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

}

?>