<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ODEO_Grado".
 *
 * @property int $ODEO_GradoKey
 * @property int $ODEO_NivelKey
 * @property string $Nombre
 * @property string $Codigo
 * @property int $ODEO_GradoSiguienteKey
 * @property int $Activo
 * @property string $DescripcionFacturacion
 *
 * @property ODEODivision[] $oDEODivisions
 * @property ODEONivel $oDEONivelKey
 * @property ODEOGradoConceptoFacturacion[] $oDEOGradoConceptoFacturacions
 * @property ODEOConceptoFacturacion[] $oDEOConceptoFacturacionKeys
 */
class ODEOGrado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ODEO_Grado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ODEO_GradoKey', 'ODEO_NivelKey'], 'required'],
            [['ODEO_GradoKey', 'ODEO_NivelKey', 'ODEO_GradoSiguienteKey', 'Activo'], 'integer'],
            [['Nombre'], 'string', 'max' => 20],
            [['Codigo'], 'string', 'max' => 5],
            [['DescripcionFacturacion'], 'string', 'max' => 50],
            [['ODEO_GradoKey'], 'unique'],
            [['ODEO_NivelKey'], 'exist', 'skipOnError' => true, 'targetClass' => ODEONivel::className(), 'targetAttribute' => ['ODEO_NivelKey' => 'ODEO_NivelKey']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ODEO_GradoKey' => 'Odeo Grado Key',
            'ODEO_NivelKey' => 'Odeo Nivel Key',
            'Nombre' => 'Nombre',
            'Codigo' => 'Codigo',
            'ODEO_GradoSiguienteKey' => 'Odeo Grado Siguiente Key',
            'Activo' => 'Activo',
            'DescripcionFacturacion' => 'Descripcion Facturacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEODivisions()
    {
        return $this->hasMany(ODEODivision::className(), ['ODEO_GradoKey' => 'ODEO_GradoKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEONivelKey()
    {
        return $this->hasOne(ODEONivel::className(), ['ODEO_NivelKey' => 'ODEO_NivelKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOGradoConceptoFacturacions()
    {
        return $this->hasMany(ODEOGradoConceptoFacturacion::className(), ['ODEO_GradoKey' => 'ODEO_GradoKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOConceptoFacturacionKeys()
    {
        return $this->hasMany(ODEOConceptoFacturacion::className(), ['ODEO_ConceptoFacturacionKey' => 'ODEO_ConceptoFacturacionKey'])->viaTable('ODEO_GradoConceptoFacturacion', ['ODEO_GradoKey' => 'ODEO_GradoKey']);
    }
}
