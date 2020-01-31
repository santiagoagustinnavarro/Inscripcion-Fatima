<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Provincia".
 *
 * @property int $ProvinciaKey
 * @property string $Nombre
 * @property int $PaisKey
 * @property string $Pais
 * @property string $Codigo
 * @property int $CodigoAfip
 *
 * @property Localidad[] $localidads
 * @property Pais $paisKey
 */
class Provincia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Provincia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ProvinciaKey', 'Nombre'], 'required'],
            [['ProvinciaKey', 'PaisKey', 'CodigoAfip'], 'integer'],
            [['Nombre', 'Pais'], 'string', 'max' => 50],
            [['Codigo'], 'string', 'max' => 5],
            [['ProvinciaKey'], 'unique'],
            //[['PaisKey'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['PaisKey' => 'PaisKey']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ProvinciaKey' => 'Provincia Key',
            'Nombre' => 'Nombre',
           // 'PaisKey' => 'Pais Key',
            'Pais' => 'Pais',
            'Codigo' => 'Codigo',
            'CodigoAfip' => 'Codigo Afip',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidads()
    {
        return $this->hasMany(Localidad::className(), ['ProvinciaKey' => 'ProvinciaKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaisKey()
    {
        return $this->hasOne(Pais::className(), ['PaisKey' => 'PaisKey']);
    }
}
