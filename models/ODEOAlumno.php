<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ODEO_Alumno".
 *
 * @property int $ODEO_AlumnoKey
 * @property string $NumeroDocumento
 * @property string $Legajo
 * @property string $Apellido
 * @property string $Nombre
 * @property string $Sexo
 * @property string $FechaEgreso
 * @property int $ODEO_DivisionKey
 * @property int $Vigente
 * @property string $FechaNacimiento
 * @property string $FechaIngreso
 * @property string $PorcentajeBeca
 * @property int $LocalidadNacimientoKey
 *
 * @property ODEODivision $oDEODivisionKey
 * @property ODEOAlumnoCaracteristica[] $oDEOAlumnoCaracteristicas
 * @property ODEOAlumnoConceptoFacturacion[] $oDEOAlumnoConceptoFacturacions
 * @property ODEOConceptoFacturacion[] $oDEOConceptoFacturacionKeys
 * @property ODEOFamiliaIntegrante[] $oDEOFamiliaIntegrantes
 * @property Cliente[] $clienteKeys
 */
class ODEOAlumno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ODEO_Alumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ODEO_AlumnoKey', 'NumeroDocumento', 'Legajo', 'Apellido', 'Nombre', 'Sexo'], 'required'],
            [['ODEO_AlumnoKey', 'ODEO_DivisionKey', 'Vigente', 'LocalidadNacimientoKey'], 'integer'],
            [['FechaEgreso', 'FechaNacimiento', 'FechaIngreso'], 'safe'],
            [['PorcentajeBeca'], 'number'],
            [['NumeroDocumento'], 'string', 'max' => 20],
            [['Legajo'], 'string', 'max' => 10],
            [['Apellido', 'Nombre'], 'string', 'max' => 100],
            [['Sexo'], 'string', 'max' => 1],
            [['ODEO_AlumnoKey'], 'unique'],
            [['ODEO_DivisionKey'], 'exist', 'skipOnError' => true, 'targetClass' => ODEODivision::className(), 'targetAttribute' => ['ODEO_DivisionKey' => 'ODEO_DivisionKey']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ODEO_AlumnoKey' => 'Odeo Alumno Key',
            'NumeroDocumento' => 'Numero Documento',
            'Legajo' => 'Legajo',
            'Apellido' => 'Apellido',
            'Nombre' => 'Nombre',
            'Sexo' => 'Sexo',
            'FechaEgreso' => 'Fecha Egreso',
            'ODEO_DivisionKey' => 'Odeo Division Key',
            'Vigente' => 'Vigente',
            'FechaNacimiento' => 'Fecha Nacimiento',
            'FechaIngreso' => 'Fecha Ingreso',
            'PorcentajeBeca' => 'Porcentaje Beca',
            'LocalidadNacimientoKey' => 'Localidad Nacimiento Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEODivisionKey()
    {
        return $this->hasOne(ODEODivision::className(), ['ODEO_DivisionKey' => 'ODEO_DivisionKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOAlumnoCaracteristicas()
    {
        return $this->hasMany(ODEOAlumnoCaracteristica::className(), ['ODEO_AlumnoKey' => 'ODEO_AlumnoKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOAlumnoConceptoFacturacions()
    {
        return $this->hasMany(ODEOAlumnoConceptoFacturacion::className(), ['ODEO_AlumnoKey' => 'ODEO_AlumnoKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOConceptoFacturacionKeys()
    {
        return $this->hasMany(ODEOConceptoFacturacion::className(), ['ODEO_ConceptoFacturacionKey' => 'ODEO_ConceptoFacturacionKey'])->viaTable('ODEO_AlumnoConceptoFacturacion', ['ODEO_AlumnoKey' => 'ODEO_AlumnoKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOFamiliaIntegrantes()
    {
        return $this->hasMany(ODEOFamiliaIntegrante::className(), ['ODEO_AlumnoKey' => 'ODEO_AlumnoKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClienteKeys()
    {
        return $this->hasMany(Cliente::className(), ['ClienteKey' => 'ClienteKey'])->viaTable('ODEO_FamiliaIntegrante', ['ODEO_AlumnoKey' => 'ODEO_AlumnoKey']);
    }
}
