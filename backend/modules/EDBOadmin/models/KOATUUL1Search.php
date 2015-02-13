<?php

namespace app\modules\EDBOadmin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EDBOKOATUUL1;

/**
 * KOATUUL1Search represents the model behind the search form about EDBOKOATUUL1.
 */
class KOATUUL1Search extends Model
{
	public $id;
	public $Id_KOATUU;
	public $KOATUUCode;
	public $Type;
	public $Id_KOATUUName;
	public $KOATUUName;
	public $KOATUUFullName;
	public $KOATUUDateBegin;
	public $KOATUUDateEnd;
	public $Id_Language;
	public $KOATUUCodeL1;
	public $KOATUUCodeL2;
	public $KOATUUCodeL3;
	public $created_at;
	public $updated_at;

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
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'Id_KOATUU' => 'Id  Koatuu',
			'KOATUUCode' => 'Koatuucode',
			'Type' => 'Тип',
			'Id_KOATUUName' => 'Id  Koatuuname',
			'KOATUUName' => 'Koatuuname',
			'KOATUUFullName' => 'Koatuufull Name',
			'KOATUUDateBegin' => 'Koatuudate Begin',
			'KOATUUDateEnd' => 'Koatuudate End',
			'Id_Language' => 'Id  Language',
			'KOATUUCodeL1' => 'Koatuucode L1',
			'KOATUUCodeL2' => 'Koatuucode L2',
			'KOATUUCodeL3' => 'Koatuucode L3',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		];
	}

	public function search($params)
	{
		$query = EDBOKOATUUL1::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
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

	protected function addCondition($query, $attribute, $partialMatch = false)
	{
		$value = $this->$attribute;
		if (trim($value) === '') {
			return;
		}
		if ($partialMatch) {
			$value = '%' . strtr($value, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%';
			$query->andWhere(['like', $attribute, $value]);
		} else {
			$query->andWhere([$attribute => $value]);
		}
	}
}
