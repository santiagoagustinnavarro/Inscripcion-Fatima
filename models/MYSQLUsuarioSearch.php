<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MYSQLUsuario;

/**
 * MYSQLUsuarioSearch represents the model behind the search form of `app\models\MYSQLUsuario`.
 */
class MYSQLUsuarioSearch extends MYSQLUsuario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'usuario_activo'], 'integer'],
            [['usuario_nick', 'usuario_nombre', 'usuario_clave'], 'safe'],
            [['usuario_creado'], 'boolean'],
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
        $query = MYSQLUsuario::find();

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
            'usuario_id' => $this->usuario_id,
            'usuario_activo' => $this->usuario_activo,
            'usuario_creado' => $this->usuario_creado,
        ]);

        $query->andFilterWhere(['like', 'usuario_nick', $this->usuario_nick])
            ->andFilterWhere(['like', 'usuario_nombre', $this->usuario_nombre])
            ->andFilterWhere(['like', 'usuario_clave', $this->usuario_clave]);

        return $dataProvider;
    }
}
