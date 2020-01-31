<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Cliente".
 *
 * @property int $ClienteKey
 * @property string $RazonSocial
 * @property string $Domicilio
 * @property string $Localidad
 * @property string $Telefono
 * @property int $SituacionIVAKey
 * @property string $CUIT
 * @property string $Fax
 * @property string $Email
 * @property string $Notas
 * @property int $ListaPreciosKey
 * @property string $PorcentajeDescuento
 * @property int $Activo
 * @property string $Codigo
 * @property int $CondicionPagoKey
 * @property int $LocalidadKey
 * @property int $CategoriaKey
 * @property int $VendedorKey
 * @property string $PorcentajeVendedor
 * @property string $PorcentajeVendedorRef
 * @property string $FechaNacimiento
 * @property string $TipoDocumento
 * @property string $NumeroDocumento
 * @property string $Nombre
 * @property string $Apellido
 * @property int $TransmissionEnabled
 * @property string $NombreFantasia
 * @property int $ZonaKey
 * @property int $DiasVtoVentas
 * @property int $WebEnabled
 * @property string $FechaAlta
 * @property string $FechaModificacion
 * @property string $FechaBaja
 * @property int $ClasificacionComercialKey
 * @property int $LocalKey
 * @property string $CodigoPostal
 * @property int $TransporteKey
 * @property string $TelefonoMovil
 * @property string $Tipo
 * @property string $IIBB
 * @property int $SituacionGananciasKey
 * @property int $SituacionSUSSKey
 * @property string $DesdeExGanancias
 * @property string $HastaExGanancias
 * @property string $DesdeExSUSS
 * @property string $HastaExSUSS
 * @property int $AplicarBonificacionGeneral
 * @property int $AdmiteDescuentoItemsVenta
 * @property int $MonedaFacturaElectronicaKey
 *
 * @property CFCanjeValores[] $cFCanjeValores
 * @property Cheque[] $cheques
 * @property Localidad $localidadKey
 * @property CategoriaClienteProveedor $categoriaKey
 * @property ListaPrecios $listaPreciosKey
 * @property Vendedor $vendedorKey
 * @property CondicionPago $condicionPagoKey
 * @property SituacionIVA $situacionIVAKey
 * @property ClientePedido[] $clientePedidos
 * @property CtaAsociado $ctaAsociado
 * @property Cuenta[] $cuentas
 * @property Evento[] $eventos
 * @property Inmueble[] $inmuebles
 * @property ODEOClienteConceptoFacturacion[] $oDEOClienteConceptoFacturacions
 * @property ODEOConceptoFacturacion[] $oDEOConceptoFacturacionKeys
 * @property ODEOFamiliaIntegrante[] $oDEOFamiliaIntegrantes
 * @property ODEOAlumno[] $oDEOAlumnoKeys
 * @property ODEOPeriodoFacturacionCliente[] $oDEOPeriodoFacturacionClientes
 * @property OperacionAlquiler[] $operacionAlquilers
 * @property OperacionCuentaClienteSenia[] $operacionCuentaClienteSenias
 * @property OperacionOrdenTrabajo[] $operacionOrdenTrabajos
 * @property OperacionOrdenTrabajoRevision[] $operacionOrdenTrabajoRevisions
 * @property OperacionParteOperativo[] $operacionParteOperativos
 * @property OperacionPresupuestoRevision[] $operacionPresupuestoRevisions
 * @property OperacionVenta[] $operacionVentas
 * @property ParteDiario[] $parteDiarios
 * @property Pedido[] $pedidos
 * @property Remito[] $remitos
 * @property TERMUnidadTransporte[] $tERMUnidadTransportes
 */
class ODEOCliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ClienteKey', 'RazonSocial', 'SituacionIVAKey', 'Activo'], 'required'],
            [['ClienteKey', 'SituacionIVAKey', 'ListaPreciosKey', 'Activo', 'CondicionPagoKey', 'LocalidadKey', 'CategoriaKey', 'VendedorKey', 'TransmissionEnabled', 'ZonaKey', 'DiasVtoVentas', 'WebEnabled', 'ClasificacionComercialKey', 'LocalKey', 'TransporteKey', 'SituacionGananciasKey', 'SituacionSUSSKey', 'AplicarBonificacionGeneral', 'AdmiteDescuentoItemsVenta', 'MonedaFacturaElectronicaKey'], 'integer'],
            [['Notas'], 'string'],
            [['PorcentajeDescuento', 'PorcentajeVendedor', 'PorcentajeVendedorRef'], 'number'],
            [['FechaNacimiento', 'FechaAlta', 'FechaModificacion', 'FechaBaja', 'DesdeExGanancias', 'HastaExGanancias', 'DesdeExSUSS', 'HastaExSUSS'], 'safe'],
            [['RazonSocial', 'Domicilio', 'NombreFantasia'], 'string', 'max' => 100],
            [['Localidad', 'Email', 'Nombre', 'Apellido'], 'string', 'max' => 50],
            [['Telefono', 'CUIT', 'Fax', 'CodigoPostal', 'IIBB'], 'string', 'max' => 20],
            [['Codigo'], 'string', 'max' => 30],
            [['TipoDocumento'], 'string', 'max' => 5],
            [['NumeroDocumento'], 'string', 'max' => 13],
            [['TelefonoMovil'], 'string', 'max' => 150],
            [['Tipo'], 'string', 'max' => 1],
            [['ClienteKey'], 'unique'],
            [['LocalidadKey'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['LocalidadKey' => 'LocalidadKey']],
            [['CategoriaKey'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaClienteProveedor::className(), 'targetAttribute' => ['CategoriaKey' => 'CategoriaKey']],
            [['ListaPreciosKey'], 'exist', 'skipOnError' => true, 'targetClass' => ListaPrecios::className(), 'targetAttribute' => ['ListaPreciosKey' => 'ListaPreciosKey']],
            [['VendedorKey'], 'exist', 'skipOnError' => true, 'targetClass' => Vendedor::className(), 'targetAttribute' => ['VendedorKey' => 'VendedorKey']],
            [['CondicionPagoKey'], 'exist', 'skipOnError' => true, 'targetClass' => CondicionPago::className(), 'targetAttribute' => ['CondicionPagoKey' => 'CondicionPagoKey']],
            [['SituacionIVAKey'], 'exist', 'skipOnError' => true, 'targetClass' => SituacionIVA::className(), 'targetAttribute' => ['SituacionIVAKey' => 'SituacionIVAKey']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ClienteKey' => 'Cliente Key',
            'RazonSocial' => 'Razon Social',
            'Domicilio' => 'Domicilio',
            'Localidad' => 'Localidad',
            'Telefono' => 'Telefono',
            'SituacionIVAKey' => 'Situacion Iva Key',
            'CUIT' => 'Cuit',
            'Fax' => 'Fax',
            'Email' => 'Email',
            'Notas' => 'Notas',
            'ListaPreciosKey' => 'Lista Precios Key',
            'PorcentajeDescuento' => 'Porcentaje Descuento',
            'Activo' => 'Activo',
            'Codigo' => 'Codigo',
            'CondicionPagoKey' => 'Condicion Pago Key',
            'LocalidadKey' => 'Localidad Key',
            'CategoriaKey' => 'Categoria Key',
            'VendedorKey' => 'Vendedor Key',
            'PorcentajeVendedor' => 'Porcentaje Vendedor',
            'PorcentajeVendedorRef' => 'Porcentaje Vendedor Ref',
            'FechaNacimiento' => 'Fecha Nacimiento',
            'TipoDocumento' => 'Tipo Documento',
            'NumeroDocumento' => 'Numero Documento',
            'Nombre' => 'Nombre',
            'Apellido' => 'Apellido',
            'TransmissionEnabled' => 'Transmission Enabled',
            'NombreFantasia' => 'Nombre Fantasia',
            'ZonaKey' => 'Zona Key',
            'DiasVtoVentas' => 'Dias Vto Ventas',
            'WebEnabled' => 'Web Enabled',
            'FechaAlta' => 'Fecha Alta',
            'FechaModificacion' => 'Fecha Modificacion',
            'FechaBaja' => 'Fecha Baja',
            'ClasificacionComercialKey' => 'Clasificacion Comercial Key',
            'LocalKey' => 'Local Key',
            'CodigoPostal' => 'Codigo Postal',
            'TransporteKey' => 'Transporte Key',
            'TelefonoMovil' => 'Telefono Movil',
            'Tipo' => 'Tipo',
            'IIBB' => 'Iibb',
            'SituacionGananciasKey' => 'Situacion Ganancias Key',
            'SituacionSUSSKey' => 'Situacion Suss Key',
            'DesdeExGanancias' => 'Desde Ex Ganancias',
            'HastaExGanancias' => 'Hasta Ex Ganancias',
            'DesdeExSUSS' => 'Desde Ex Suss',
            'HastaExSUSS' => 'Hasta Ex Suss',
            'AplicarBonificacionGeneral' => 'Aplicar Bonificacion General',
            'AdmiteDescuentoItemsVenta' => 'Admite Descuento Items Venta',
            'MonedaFacturaElectronicaKey' => 'Moneda Factura Electronica Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCFCanjeValores()
    {
        return $this->hasMany(CFCanjeValores::className(), ['ClienteObraSocialCanjeKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCheques()
    {
        return $this->hasMany(Cheque::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidadKey()
    {
        return $this->hasOne(Localidad::className(), ['LocalidadKey' => 'LocalidadKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriaKey()
    {
        return $this->hasOne(CategoriaClienteProveedor::className(), ['CategoriaKey' => 'CategoriaKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListaPreciosKey()
    {
        return $this->hasOne(ListaPrecios::className(), ['ListaPreciosKey' => 'ListaPreciosKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendedorKey()
    {
        return $this->hasOne(Vendedor::className(), ['VendedorKey' => 'VendedorKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondicionPagoKey()
    {
        return $this->hasOne(CondicionPago::className(), ['CondicionPagoKey' => 'CondicionPagoKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSituacionIVAKey()
    {
        return $this->hasOne(SituacionIVA::className(), ['SituacionIVAKey' => 'SituacionIVAKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientePedidos()
    {
        return $this->hasMany(ClientePedido::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCtaAsociado()
    {
        return $this->hasOne(CtaAsociado::className(), ['AsociadoKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuentas()
    {
        return $this->hasMany(Cuenta::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Evento::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInmuebles()
    {
        return $this->hasMany(Inmueble::className(), ['ClientePropietarioKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOClienteConceptoFacturacions()
    {
        return $this->hasMany(ODEOClienteConceptoFacturacion::className(), ['ODEO_ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOConceptoFacturacionKeys()
    {
        return $this->hasMany(ODEOConceptoFacturacion::className(), ['ODEO_ConceptoFacturacionKey' => 'ODEO_ConceptoFacturacionKey'])->viaTable('ODEO_ClienteConceptoFacturacion', ['ODEO_ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOFamiliaIntegrantes()
    {
        return $this->hasMany(ODEOFamiliaIntegrante::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOAlumnoKeys()
    {
        return $this->hasMany(ODEOAlumno::className(), ['ODEO_AlumnoKey' => 'ODEO_AlumnoKey'])->viaTable('ODEO_FamiliaIntegrante', ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOPeriodoFacturacionClientes()
    {
        return $this->hasMany(ODEOPeriodoFacturacionCliente::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperacionAlquilers()
    {
        return $this->hasMany(OperacionAlquiler::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperacionCuentaClienteSenias()
    {
        return $this->hasMany(OperacionCuentaClienteSenia::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperacionOrdenTrabajos()
    {
        return $this->hasMany(OperacionOrdenTrabajo::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperacionOrdenTrabajoRevisions()
    {
        return $this->hasMany(OperacionOrdenTrabajoRevision::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperacionParteOperativos()
    {
        return $this->hasMany(OperacionParteOperativo::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperacionPresupuestoRevisions()
    {
        return $this->hasMany(OperacionPresupuestoRevision::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperacionVentas()
    {
        return $this->hasMany(OperacionVenta::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParteDiarios()
    {
        return $this->hasMany(ParteDiario::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemitos()
    {
        return $this->hasMany(Remito::className(), ['ClienteKey' => 'ClienteKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTERMUnidadTransportes()
    {
        return $this->hasMany(TERMUnidadTransporte::className(), ['ClienteKey' => 'ClienteKey']);
    }
}
