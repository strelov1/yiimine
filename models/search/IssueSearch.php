<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Issue;

/**
 * IssueSearch represents the model behind the search form about `app\models\Issue`.
 */
class IssueSearch extends Issue
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tracker_id', 'status_id', 'priority_id', 'assignee_id', 'readiness_id', 'project_id', 'creator_id'], 'integer'],
            [['subject', 'description', 'deadline', 'created_date', 'updated_date'], 'safe'],
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
        $query = Issue::find()->joinWith(['author', 'project', 'checkLists']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'priority_id' => SORT_DESC,
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'tracker_id' => $this->tracker_id,
            'status_id' => $this->status_id,
            'priority_id' => $this->priority_id,
            'assignee_id' => $this->assignee_id,
            'deadline' => $this->deadline,
            'readiness_id' => $this->readiness_id,
            'project_id' => $this->project_id,
            'issue.creator_id' => $this->creator_id,
            'milestone_id' => $this->milestone_id,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}