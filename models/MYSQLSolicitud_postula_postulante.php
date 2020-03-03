<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitud_postula_postulante".
 *
 * @property int $solicitud_id
 * @property int $postulante_id
 *
 * @property SolicitudInscripcion $solicitud
 * @property Postulante $postulante
 */
class MYSQLSolicitud_postula_postulante extends \yii\db\ActiveRecord
{
   
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitud_postula_postulante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['solicitud_id', 'postulante_id'], 'required'],
            [['solicitud_id', 'postulante_id'], 'integer'],
            [['solicitud_id', 'postulante_id'], 'unique', 'targetAttribute' => ['solicitud_id', 'postulante_id']],
            [['solicitud_id'], 'exist', 'skipOnError' => true, 'targetClass' => MYSQLSolicitudInscripcion::className(), 'targetAttribute' => ['solicitud_id' => 'solicitud_id']],
            [['postulante_id'], 'exist', 'skipOnError' => true, 'targetClass' => MYSQLPostulante::className(), 'targetAttribute' => ['postulante_id' => 'postulante_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'solicitud_id' => 'Solicitud ID',
            'postulante_id' => 'Postulante ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitud()
    {
        return $this->hasOne(MYSQLSolicitudInscripcion::className(), ['solicitud_id' => 'solicitud_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostulante()
    {
        return $this->hasOne(MYSQLPostulante::className(), ['postulante_id' => 'postulante_id']);
    }
}
