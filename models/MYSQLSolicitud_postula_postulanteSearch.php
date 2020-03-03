<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MYSQLSolicitud_postula_postulante;

/**
 * MYSQLSolicitud_postula_postulanteSearch represents the model behind the search form of `app\models\MYSQLSolicitud_postula_postulante`.
 */
class MYSQLSolicitud_postula_postulanteSearch extends MYSQLSolicitud_postula_postulante
{
    public $nombre;
    public $apellido;
    public $nroDoc;
    /*public static function getDb() { 
        return Yii::$app->get('dbTwo'); // Base de datos en MYSQL
     }*/
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['solicitud_id','postulante_id'], 'integer'],
            [['nombre','nroDoc','apellido'], 'string'],
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
        $query = MYSQLSolicitud_postula_postulante::find()->JoinWith('postulante')->innerJoin('persona','postulante.postulante_persona=persona.persona_id');

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
            'persona.persona_nro_doc'=>$this->nroDoc,
            'persona.persona_nombres'=>$this->nombre,
            'persona.persona_apellidos'=>$this->apellido,
            'solicitud_id' => $this->solicitud_id,
            'postulante.postulante_id' => $this->postulante_id,
        ]);

        return $dataProvider;
    }
}
