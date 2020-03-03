<?php
namespace app\models;
use Yii;
use app\models\MYSQLPersona;
class MYSQLPostulante extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    public static function tableName(){
        return 'postulante';
    }
   
    public function rules()
    {
        return [
            [['postulante_id'], 'required'],
            [['postulante_persona','postulante_confirmado','postulante_familia','postulante_nivel','postulante_responsable'], 'integer'],
            [['postulante_persona'],'exist','skipOnError'=>true,'targetClass'=>MYSQLPersona::classname(),'targetAttribute'=>['persona_id'=>'postulante_persona']]
           
           
        ];
    }

    public function attributeLabels()
    {
        return [
            'postulante_id' => 'ID Postulante',
            'postulante_confirmado' => 'Confrimacion postulante',
            'postulante_familia'=>'Familia del postulante',
            'postulante_nivel'=>'Nivel del postulante',
            'postulante_responsable'=>'Postulante Responsable'
        ];

    }
    public function getPersona(){
        return $this->hasOne(MYSQLPersona::classname(),['persona_id'=>'postulante_persona']);
    }

}

?>