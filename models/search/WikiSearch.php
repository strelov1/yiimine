<?php

namespace app\models\search;

use app\components\helpers\CommonHelper;
use app\models\TagModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Wiki;

/**
 * ProjectSearch represents the model behind the search form about `app\models\Project`.
 */
class WikiSearch extends Wiki
{
    public $tagId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id'], 'integer'],
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
        $query = Wiki::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andFilterWhere([
            'id' => $this->id,
            'project_id' => $this->project_id,
        ]);

        if (isset($this->tagId)) {
            CommonHelper::addCriteriaForTagid($query, TagModel::MODEL_WIKI, $this->tagId);
        }

        if (!($this->load($params) && $this->validate())) {
            //die(var_dump($query));
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}