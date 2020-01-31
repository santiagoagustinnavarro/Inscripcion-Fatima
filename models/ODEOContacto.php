<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Contacto".
 *
 * @property int $ContactoKey
 * @property string $Apellido
 * @property string $Nombre
 * @property string $Telefono
 * @property string $Celular
 * @property string $Email
 * @property string $Notas
 * @property int $Activo
 * @property string $Tipo
 * @property int $ClienteKey
 * @property int $ProveedorKey
 * @property string $FechaNacimiento
 * @property string $Domicilio
 * @property string $Localidad
 * @property int $LocalidadKey
 * @property string $DomicilioParticular
 * @property string $LocalidadParticular
 * @property int $LocalidadParticularKey
 * @property string $TelefonoParticular
 * @property string $EmailParticular
 * @property string $RazonSocial
 * @property string $Puesto
 * @property string $tipoDocumento
 * @property string $numeroDocumento
 * @property int $TipoContactoKey
 * @property resource $FotoCarnet
 * @property int $PaisNacimientoKey
 *
 * @property Evento[] $eventos
 * @property OperacionOrdenTrabajoRevision[] $operacionOrdenTrabajoRevisions
 * @property OperacionPresupuestoRevision[] $operacionPresupuestoRevisions
 */
class ODEOContacto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Contacto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ContactoKey', 'Apellido', 'Activo', 'Tipo'], 'required'],
            [['ContactoKey', 'Activo', 'ClienteKey', 'ProveedorKey', 'LocalidadKey', 'LocalidadParticularKey', 'TipoContactoKey', 'PaisNacimientoKey'], 'integer'],
            [['Notas', 'FotoCarnet'], 'string'],
            [['FechaNacimiento'], 'safe'],
            [['Apellido', 'Nombre', 'Telefono', 'Celular', 'Localidad', 'LocalidadParticular', 'EmailParticular'], 'string', 'max' => 50],
            [['Email', 'Domicilio', 'DomicilioParticular', 'RazonSocial', 'Puesto'], 'string', 'max' => 100],
            [['Tipo'], 'string', 'max' => 1],
            [['TelefonoParticular'], 'string', 'max' => 20],
            [['tipoDocumento'], 'string', 'max' => 5],
            [['numeroDocumento'], 'string', 'max' => 13],
            [['ContactoKey'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ContactoKey' => 'Contacto Key',
            'Apellido' => 'Apellido',
            'Nombre' => 'Nombre',
            'Telefono' => 'Telefono',
            'Celular' => 'Celular',
            'Email' => 'Email',
            'Notas' => 'Notas',
            'Activo' => 'Activo',
            'Tipo' => 'Tipo',
            'ClienteKey' => 'Cliente Key',
            'ProveedorKey' => 'Proveedor Key',
            'FechaNacimiento' => 'Fecha Nacimiento',
            'Domicilio' => 'Domicilio',
            'Localidad' => 'Localidad',
            'LocalidadKey' => 'Localidad Key',
            'DomicilioParticular' => 'Domicilio Particular',
            'LocalidadParticular' => 'Localidad Particular',
            'LocalidadParticularKey' => 'Localidad Particular Key',
            'TelefonoParticular' => 'Telefono Particular',
            'EmailParticular' => 'Email Particular',
            'RazonSocial' => 'Razon Social',
            'Puesto' => 'Puesto',
            'tipoDocumento' => 'Tipo Documento',
            'numeroDocumento' => 'Numero Documento',
            'TipoContactoKey' => 'Tipo Contacto Key',
            'FotoCarnet' => 'Foto Carnet',
            'PaisNacimientoKey' => 'Pais Nacimiento Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Evento::className(), ['ContactoKey' => 'ContactoKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperacionOrdenTrabajoRevisions()
    {
        return $this->hasMany(OperacionOrdenTrabajoRevision::className(), ['ContactoKey' => 'ContactoKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperacionPresupuestoRevisions()
    {
        return $this->hasMany(OperacionPresupuestoRevision::className(), ['ContactoKey' => 'ContactoKey']);
    }
}
