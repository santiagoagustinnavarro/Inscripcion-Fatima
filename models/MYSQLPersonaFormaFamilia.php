<?php
namespace app\models;
use Yii;
class MYSQLPersonaFormaFamilia extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    public static function tableName(){
        return 'persona_forma_familia';
    }

    public function rules()
    {
        return [
            [['familia_id','persona_id'], 'required'],
            [['parentezco'],'string']
           
           
        ];
    }

    public function attributeLabels()
    {
        return [
            'familia_id' => 'ID Familia',
            'persona_id' => 'Persona relacionada',
            'parentezco'=>'Parentezco de familia'
            

        ];

    }

}

?>