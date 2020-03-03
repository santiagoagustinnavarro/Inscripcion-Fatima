<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alumno".
 *
 * @property int $alumno_id
 * @property int $alumno_postulante
 */
class MYSQLAlumno extends \yii\db\ActiveRecord
{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alumno_postulante'], 'required'],
            [['alumno_postulante'], 'integer'],
            [['alumno_id'],'integer'],
            [['alumno_postulante'], 'exist', 'skipOnError' => true, 'targetClass' => MYSQLPostulante::className(), 'targetAttribute' => ['postulante_id' => 'alumno_postulante']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'alumno_id' => 'Alumno ID',
            'alumno_postulante' => 'Alumno Postulante',
        ];
    }
    public function getPostulante(){
        return $this->hasOne(MYSQLPostulante::className(),['postulante_id' => 'alumno_postulante']);
    }
}
