<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $usuario_id
 * @property string $usuario_nick
 * @property string $usuario_nombre
 * @property string $usuario_clave
 * @property int $usuario_activo
 * @property bool $usuario_creado
 */
class MYSQLUsuario extends \yii\db\ActiveRecord
{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_nick', 'usuario_clave'], 'required'],
            [['usuario_activo'], 'integer'],
            [['usuario_creado'], 'integer'],
            [['usuario_creado'], 'default','value'=>0],
            [['usuario_nick'], 'string', 'max' => 45],
            [['usuario_nombre'], 'string', 'max' => 100],
            [['usuario_clave'], 'string', 'max' => 30],
            ['usuario_clave', 'compare', 'compareValue' => 1234, 'operator' => '!='],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usuario_id' => 'Usuario ID',
            'usuario_nick' => 'Usuario Nick',
            'usuario_nombre' => 'Usuario Nombre',
            'usuario_clave' => 'Clave',
            'usuario_activo' => 'Usuario Activo',
            'usuario_creado' => 'Usuario Creado',
        ];
    }
}