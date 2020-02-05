<?php
namespace app\models;
use Yii;
class MYSQLNivel extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    public static function tableName(){
        return 'nivel_educativo';
    }

    public function rules()
    {
        return [
            [['nivel_id'], 'required'],
            [['nivel_nombre','nivel_cue'],'string'],
          
           
           
        ];
    }

    public function attributeLabels()
    {
        return [
            'nivel_id' => 'ID Nivel',
            'nivel_nombre' => 'Nombre Nivel',
            'nivel_cue'=>'CUE Nivel'
            

        ];

    }

}

?>