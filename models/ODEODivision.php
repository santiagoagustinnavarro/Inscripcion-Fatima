<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ODEO_Division".
 *
 * @property int $ODEO_DivisionKey
 * @property string $Nombre
 * @property string $Codigo
 * @property int $ODEO_GradoKey
 * @property int $Activo
 * @property int $ODEO_DivisionSiguienteKey
 *
 * @property ODEOAlumno[] $oDEOAlumnos
 * @property ODEOGrado $oDEOGradoKey
 */
class ODEODivision extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ODEO_Division';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ODEO_DivisionKey', 'ODEO_GradoKey'], 'required'],
            [['ODEO_DivisionKey', 'ODEO_GradoKey', 'Activo', 'ODEO_DivisionSiguienteKey'], 'integer'],
            [['Nombre'], 'string', 'max' => 20],
            [['Codigo'], 'string', 'max' => 5],
            [['ODEO_DivisionKey'], 'unique'],
            [['ODEO_GradoKey'], 'exist', 'skipOnError' => true, 'targetClass' => ODEOGrado::className(), 'targetAttribute' => ['ODEO_GradoKey' => 'ODEO_GradoKey']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ODEO_DivisionKey' => 'Odeo Division Key',
            'Nombre' => 'Nombre',
            'Codigo' => 'Codigo',
            'ODEO_GradoKey' => 'Odeo Grado Key',
            'Activo' => 'Activo',
            'ODEO_DivisionSiguienteKey' => 'Odeo Division Siguiente Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOAlumnos()
    {
        return $this->hasMany(ODEOAlumno::className(), ['ODEO_DivisionKey' => 'ODEO_DivisionKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOGradoKey()
    {
        return $this->hasOne(ODEOGrado::className(), ['ODEO_GradoKey' => 'ODEO_GradoKey']);
    }
}
