<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ODEO_FamiliaIntegrante".
 *
 * @property int $ClienteKey
 * @property int $ODEO_AlumnoKey
 *
 * @property Cliente $clienteKey
 * @property ODEOAlumno $oDEOAlumnoKey
 */
class ODEOFamiliaIntegrante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ODEO_FamiliaIntegrante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ClienteKey', 'ODEO_AlumnoKey'], 'required'],
            [['ClienteKey', 'ODEO_AlumnoKey'], 'integer'],
            [['ClienteKey', 'ODEO_AlumnoKey'], 'unique', 'targetAttribute' => ['ClienteKey', 'ODEO_AlumnoKey']],
            [['ClienteKey'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['ClienteKey' => 'ClienteKey']],
            [['ODEO_AlumnoKey'], 'exist', 'skipOnError' => true, 'targetClass' => ODEOAlumno::className(), 'targetAttribute' => ['ODEO_AlumnoKey' => 'ODEO_AlumnoKey']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ClienteKey' => 'Cliente Key',
            'ODEO_AlumnoKey' => 'Odeo Alumno Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClienteKey()
    {
        return $this->hasOne(Cliente::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOAlumnoKey()
    {
        return $this->hasOne(ODEOAlumno::className(), ['ODEO_AlumnoKey' => 'ODEO_AlumnoKey']);
    }
}
