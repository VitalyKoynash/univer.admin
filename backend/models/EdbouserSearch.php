<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Edbouser;

/**
 * EdboUserSearch represents the model behind the search form about `common\models\Edbouser`.
 */
class EdbouserSearch extends Edbouser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id', 'sessionguid_updated_at', 'status', 'created_at', 'updated_at'], 'integer'],
            //[[ 'status'], 'integer'],
            //[['email', 'password'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Edbouser::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            //'sessionguid_updated_at' => $this->sessionguid_updated_at,
            'status' => $this->status,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);
            //->andFilterWhere(['like', 'sessionguid', $this->sessionguid]);

        return $dataProvider;
    }
}
