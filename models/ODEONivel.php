<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ODEO_Nivel".
 *
 * @property int $ODEO_NivelKey
 * @property string $Nombre
 * @property string $Codigo
 * @property int $Activo
 *
 * @property ODEOGrado[] $oDEOGrados
 */
class ODEONivel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ODEO_Nivel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ODEO_NivelKey'], 'required'],
            [['ODEO_NivelKey', 'Activo'], 'integer'],
            [['Nombre'], 'string', 'max' => 50],
            [['Codigo'], 'string', 'max' => 5],
            [['ODEO_NivelKey'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ODEO_NivelKey' => 'Odeo Nivel Key',
            'Nombre' => 'Nombre',
            'Codigo' => 'Codigo',
            'Activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODEOGrados()
    {
        return $this->hasMany(ODEOGrado::className(), ['ODEO_NivelKey' => 'ODEO_NivelKey']);
    }
}
