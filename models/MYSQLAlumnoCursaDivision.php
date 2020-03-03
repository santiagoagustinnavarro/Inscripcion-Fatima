<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alumno_cursa_division".
 *
 * @property int $cursa_alumno
 * @property int $cursa_division
 * @property string $cursa_anio
 */
class MYSQLAlumnoCursaDivision extends \yii\db\ActiveRecord
{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alumno_cursa_division';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cursa_alumno', 'cursa_division', 'cursa_anio'], 'required'],
            [['cursa_alumno', 'cursa_division'], 'integer'],
            [['cursa_anio'], 'string', 'max' => 4],
            [['cursa_alumno', 'cursa_division'], 'unique', 'targetAttribute' => ['cursa_alumno', 'cursa_division']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cursa_alumno' => 'Cursa Alumno',
            'cursa_division' => 'Cursa Division',
            'cursa_anio' => 'Cursa Anio',
        ];
    }
}
