<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persona".
 *
 * @property int $persona_id
 * @property string $persona_apellidos
 * @property string $persona_nombres
 * @property string $persona_nro_doc
 * @property int $persona_tipodoc
 * @property string $persona_cuil
 * @property int $persona_sexo
 * @property int $persona_domicilio
 *
 * @property PersonaDomicilio $personaDomicilio
 * @property Postulante[] $postulantes
 */
class MYSQLPersona extends \yii\db\ActiveRecord
{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['persona_apellidos', 'persona_nombres', 'persona_nro_doc', 'persona_tipodoc', 'persona_sexo', 'persona_domicilio'], 'required'],
            [['persona_tipodoc', 'persona_sexo', 'persona_domicilio'], 'integer'],
            [['persona_apellidos', 'persona_nombres'], 'string', 'max' => 150],
            [['persona_nro_doc'], 'string', 'max' => 10],
            [['persona_cuil'], 'string', 'max' => 20],
            [['persona_domicilio'], 'exist', 'skipOnError' => true, 'targetClass' => MYSQLDomicilio::className(), 'targetAttribute' => ['persona_domicilio' => 'domicilio_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'persona_id' => 'Persona ID',
            'persona_apellidos' => 'Persona Apellidos',
            'persona_nombres' => 'Persona Nombres',
            'persona_nro_doc' => 'Persona Nro Doc',
            'persona_tipodoc' => 'Persona Tipodoc',
            'persona_cuil' => 'Persona Cuil',
            'persona_sexo' => 'Persona Sexo',
            'persona_domicilio' => 'Persona Domicilio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomicilio()
    {
        return $this->hasOne(MYSQLDomicilio::className(), ['domicilio_id' => 'persona_domicilio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostulantes()
    {
        return $this->hasMany(Postulante::className(), ['postulante_persona' => 'persona_id']);
    }
}
