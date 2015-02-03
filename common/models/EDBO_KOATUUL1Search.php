<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EDBO_KOATUUL1;

/**
 * EDBO_KOATUUL1Search represents the model behind the search form about `common\models\EDBO_KOATUUL1`.
 */
class EDBO_KOATUUL1Search extends EDBO_KOATUUL1
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Id_KOATUU', 'Id_KOATUUName', 'Id_Language', 'created_at', 'updated_at'], 'integer'],
            [['KOATUUCode', 'Type', 'KOATUUName', 'KOATUUFullName', 'KOATUUDateBegin', 'KOATUUDateEnd', 'KOATUUCodeL1', 'KOATUUCodeL2', 'KOATUUCodeL3'], 'safe'],
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
        $query = EDBO_KOATUUL1::find();

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
            'Id_KOATUU' => $this->Id_KOATUU,
            'Id_KOATUUName' => $this->Id_KOATUUName,
            'KOATUUDateBegin' => $this->KOATUUDateBegin,
            'KOATUUDateEnd' => $this->KOATUUDateEnd,
            'Id_Language' => $this->Id_Language,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'KOATUUCode', $this->KOATUUCode])
            ->andFilterWhere(['like', 'Type', $this->Type])
            ->andFilterWhere(['like', 'KOATUUName', $this->KOATUUName])
            ->andFilterWhere(['like', 'KOATUUFullName', $this->KOATUUFullName])
            ->andFilterWhere(['like', 'KOATUUCodeL1', $this->KOATUUCodeL1])
            ->andFilterWhere(['like', 'KOATUUCodeL2', $this->KOATUUCodeL2])
            ->andFilterWhere(['like', 'KOATUUCodeL3', $this->KOATUUCodeL3]);

        return $dataProvider;
    }
}
