<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TipoContacto".
 *
 * @property int $TipoContactoKey
 * @property string $Nombre
 * @property int $Activo
 * @property string $Tipo
 */
class ODEOTipoContacto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'TipoContacto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TipoContactoKey', 'Nombre', 'Activo', 'Tipo'], 'required'],
            [['TipoContactoKey', 'Activo'], 'integer'],
            [['Nombre'], 'string', 'max' => 100],
            [['Tipo'], 'string', 'max' => 1],
            [['TipoContactoKey'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'TipoContactoKey' => 'Tipo Contacto Key',
            'Nombre' => 'Nombre',
            'Activo' => 'Activo',
            'Tipo' => 'Tipo',
        ];
    }
}
