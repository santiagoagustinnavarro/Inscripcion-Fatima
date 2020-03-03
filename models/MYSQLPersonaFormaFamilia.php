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
            [['parentezco'],'string'],
            [['persona_id'], 'exist', 'skipOnError' => true, 'targetClass' => MYSQLPersona::className(), 'targetAttribute' => ['persona_id' => 'persona_id']],
            [['familia_id'], 'exist', 'skipOnError' => true, 'targetClass' => MYSQLFamilia::className(), 'targetAttribute' => ['familia_id' => 'familia_id']],
           
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFamilia()
    {
        return $this->hasOne(MYSQLFamilia::className(), ['familia_id' => 'familia_id']);
    }
      /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersona()
    {
        return $this->hasOne(MYSQLPersona::className(), ['persona_id' => 'persona_id']);
    }

}

?>