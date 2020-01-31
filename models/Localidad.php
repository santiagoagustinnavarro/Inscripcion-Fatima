<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Localidad".
 *
 * @property int $LocalidadKey
 * @property string $Nombre
 * @property string $CodigoPostal
 * @property int $ProvinciaKey
 * @property int $PaisKey
 * @property int $Activo
 * @property int $PartidoKey
 *
 * @property Cliente[] $clientes
 * @property Deposito[] $depositos
 * @property Empresa[] $empresas
 * @property Inmueble[] $inmuebles
 * @property Pais $paisKey
 * @property Provincia $provinciaKey
 * @property LocalidadZona[] $localidadZonas
 * @property Proveedor[] $proveedors
 * @property Vendedor[] $vendedors
 */
class Localidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Localidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LocalidadKey', 'Nombre', 'Activo'], 'required'],
            [['LocalidadKey', 'ProvinciaKey', 'PaisKey', 'Activo', 'PartidoKey'], 'integer'],
            [['Nombre'], 'string', 'max' => 50],
            [['CodigoPostal'], 'string', 'max' => 10],
            [['LocalidadKey'], 'unique'],
            [['PaisKey'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['PaisKey' => 'PaisKey']],
            [['ProvinciaKey'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['ProvinciaKey' => 'ProvinciaKey']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LocalidadKey' => 'Localidad Key',
            'Nombre' => 'Nombre',
            'CodigoPostal' => 'Codigo Postal',
            'ProvinciaKey' => 'Provincia Key',
            'PaisKey' => 'Pais Key',
            'Activo' => 'Activo',
            'PartidoKey' => 'Partido Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::className(), ['LocalidadKey' => 'LocalidadKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepositos()
    {
        return $this->hasMany(Deposito::className(), ['LocalidadKey' => 'LocalidadKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Empresa::className(), ['LocalidadKey' => 'LocalidadKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInmuebles()
    {
        return $this->hasMany(Inmueble::className(), ['LocalidadKey' => 'LocalidadKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaisKey()
    {
        return $this->hasOne(Pais::className(), ['PaisKey' => 'PaisKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinciaKey()
    {
        return $this->hasOne(Provincia::className(), ['ProvinciaKey' => 'ProvinciaKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidadZonas()
    {
        return $this->hasMany(LocalidadZona::className(), ['LocalidadKey' => 'LocalidadKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedors()
    {
        return $this->hasMany(Proveedor::className(), ['LocalidadKey' => 'LocalidadKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendedors()
    {
        return $this->hasMany(Vendedor::className(), ['LocalidadKey' => 'LocalidadKey']);
    }
}
