<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ContactoCaracteristica".
 *
 * @property int $ContactoKey
 * @property int $CaracteristicaKey
 * @property int $CaracteristicaVarianteKey
 * @property string $Valor
 * @property string $Caracteristica
 */
class ContactoCaracteristica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ContactoCaracteristica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ContactoKey', 'CaracteristicaKey', 'CaracteristicaVarianteKey'], 'required'],
            [['ContactoKey', 'CaracteristicaKey', 'CaracteristicaVarianteKey'], 'integer'],
            [['Valor'], 'string', 'max' => 255],
            [['Caracteristica'], 'string', 'max' => 100],
            [['CaracteristicaKey', 'CaracteristicaVarianteKey', 'ContactoKey'], 'unique', 'targetAttribute' => ['CaracteristicaKey', 'CaracteristicaVarianteKey', 'ContactoKey']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ContactoKey' => 'Contacto Key',
            'CaracteristicaKey' => 'Caracteristica Key',
            'CaracteristicaVarianteKey' => 'Caracteristica Variante Key',
            'Valor' => 'Valor',
            'Caracteristica' => 'Caracteristica',
        ];
    }
}
