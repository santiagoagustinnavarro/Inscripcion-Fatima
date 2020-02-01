<?php
namespace app\models;
use Yii;
class MYSQLSolicitud_postula_postulante extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    public static function tableName(){
        return 'solicitud_postula_postulante';
    }

    public function rules()
    {
        return [
            [['postulante_id', 'solicitud_id'], 'required'],
           
        ];
    }

    public function attributeLabels()
    {
        return [
            'postulante_id' => 'ID Postulante',
            'solicitud_id' => 'ID Solicitud',
            
        ];

    }

}

?>