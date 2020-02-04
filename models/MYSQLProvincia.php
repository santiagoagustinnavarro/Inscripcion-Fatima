<?php
namespace app\models;

use Yii;
class MYSQLProvincia extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // second database
     }
    public static function tableName(){
        return 'provincia';
    }

    public function rules()
    {
        return [
            [['provincia_id', 'provincia_nombre'], 'required'],
            [['provincia_id'], 'integer'],
            [['provincia_nombre'], 'string', 'max' => 50],
            [['rovincia_id'], 'unique'],
           
        ];
    }

    public function attributeLabels()
    {
        return [
            'provincia_nombre' => 'Nombre Provincia',
            'provincia_id' => 'ID Provincia',
        ];
    }

}






?>