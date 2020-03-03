<?php
namespace app\models;
use Yii;
use app\models\MYSQLPostulante;

class MYSQLSolicitudInscripcion extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
     
    public static function tableName(){
        return 'solicitud_inscripcion';
    }
    
   
   /*public function getPostulante(){
       return $this->hasOne(MYSQLPostulante::classname(),['postulante_id'=>'postulante_id'])->viaTable('solicitud_postula_postulante',['solicitud_id'=>'solicitud_id']);
   }*/
    public function rules()
    {
        return [
            [['solicitud_id', 'solicitud_nro','solicitud_establecimiento'], 'integer'],
        [['solicitud_fecha','solicitud_estado'],'string'],
        [['solicitud_id'],'required']
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