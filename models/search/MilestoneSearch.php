<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Milestone;

/**
 * ProjectSearch represents the model behind the search form about `app\models\Project`.
 */
class MilestoneSearch extends Milestone
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'user_id'], 'integer'],
            [['title'], 'safe'],
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
        $query = Milestone::find();

        $query->andFilterWhere(['project_id' => $this->project_id]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['user_id' => $this->user_id]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}