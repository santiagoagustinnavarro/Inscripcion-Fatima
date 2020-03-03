<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MYSQLSolicitudInscripcion;

/**
 * MYSQLSolicitudInscripcionSearch represents the model behind the search form of `app\models\MYSQLSolicitudInscripcion`.
 */
class MYSQLSolicitudInscripcionSearch extends MYSQLSolicitudInscripcion
{
    public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['solicitud_id', 'solicitud_nro', 'solicitud_estado', 'solicitud_establecimiento'], 'integer'],
            [['solicitud_fecha'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MYSQLSolicitudInscripcion::find()->Join('postulante');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'postulante.postulante_id'=>$this->postulante_id,
            'solicitud_id' => $this->solicitud_id,
            'solicitud_nro' => $this->solicitud_nro,
            'solicitud_fecha' => $this->solicitud_fecha,
            'solicitud_estado' => $this->solicitud_estado,
            'solicitud_establecimiento' => $this->solicitud_establecimiento,
        ]);

        return $dataProvider;
    }
}
