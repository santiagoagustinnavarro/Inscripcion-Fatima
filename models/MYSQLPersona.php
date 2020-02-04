<?php
namespace app\models;
use Yii;
class MYSQLPersona extends \yii\db\ActiveRecord{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    public static function tableName(){
        return 'persona';
    }

    public function rules()
    {
        return [
            [['persona_id'], 'required'],
            [['persona_apellidos','persona_nombres','persona_cuil','persona_domicilio'], 'string'],
            [['persona_nro_doc','persona_tipodoc','persona_sexo'],'integer']
          
           
           
        ];
    }

    public function attributeLabels()
    {
        return [
            'persona_id' => 'ID Persona',
            'persona_nro_doc' => 'Numero de documento',
            'persona_cuil' => 'Numero de Cuil/Cuit',
            'persona_apellidos' => 'Apellidos',
            'persona_nombres'=>'Nombres',
            'persona_tipodoc'=>'Tipo de documento',
            'persona_sexo'=>'Sexo',
            'persona_domicilio'=>'Domicilio'
            

        ];

    }

}

?>