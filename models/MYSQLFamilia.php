<?php
namespace app\models;
use Yii;
class MYSQLFamilia extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    public static function tableName(){
        return 'familia';
    }

    public function rules()
    {
        return [
            [['familia_id'], 'required'],
            [['familia_cant'],'integer']
          
           
           
        ];
    }

    public function attributeLabels()
    {
        return [
            'familia_id' => 'ID Familia',
            'familia_cant' => 'Cantidad de integrantes de la familia',
            

        ];

    }

}

?>