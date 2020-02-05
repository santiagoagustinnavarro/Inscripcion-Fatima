<?php
namespace app\models;
use Yii;
class MYSQLResponsable extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    public static function tableName(){
        return 'responsable';
    }

    public function rules()
    {
        return [
            [['responsable_id'], 'required'],
            [['responsable_tel_contacto','responsable_mail_contacto'],'string'],
            [['responsable_persona'],'integer']
           
           
        ];
    }

    public function attributeLabels()
    {
        return [
            'responsable_id' => 'ID Responsable',
            'responsable_tel_contacto' => 'Telefono',
            'responsable_persona'=>'Persona Responsable'
            

        ];

    }

}

?>