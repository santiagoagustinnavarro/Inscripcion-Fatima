<?php
namespace app\models;
use Yii;
class CiudadLocal extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // second database
     }
    public static function tableName(){
        return 'ciudad';
    }

    public function rules()
    {
        return [
            [['ciudad_id', 'ciudad_provincia'], 'required'],
            [['ciudad_cp'], 'integer'],
            [['ciudad_nombre'], 'string', 'max' => 50],
            [['ciudad_id'], 'unique'],
           
        ];
    }

    public function attributeLabels()
    {
        return [
            'ciudad_nombre' => 'Nombre Ciudad',
            'ciudad_id' => 'ID Ciudad',
        ];
    }

}




?>