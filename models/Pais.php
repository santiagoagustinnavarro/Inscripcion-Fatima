<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Pais".
 *
 * @property int $PaisKey
 * @property string $Nombre
 * @property string $Codigo
 *
 * @property Localidad[] $localidads
 * @property Provincia[] $provincias
 */
class Pais extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Pais';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PaisKey', 'Nombre'], 'required'],
            [['PaisKey'], 'integer'],
            [['Nombre', 'Codigo'], 'string', 'max' => 50],
            [['PaisKey'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PaisKey' => 'Pais Key',
            'Nombre' => 'Nombre',
            'Codigo' => 'Codigo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidads()
    {
        return $this->hasMany(Localidad::className(), ['PaisKey' => 'PaisKey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvincias()
    {
        return $this->hasMany(Provincia::className(), ['PaisKey' => 'PaisKey']);
    }
}
