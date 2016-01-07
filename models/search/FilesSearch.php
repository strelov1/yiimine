<?php

namespace app\models\search;

use app\models\TagModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Files;
use app\components\helpers\CommonHelper;

/**
 * ProjectSearch represents the model behind the search form about `app\models\Project`.
 */
class FilesSearch extends Files
{
    public $tagId;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id'], 'integer'],
            [['file'], 'safe'],
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
        $query = Files::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $query->andFilterWhere([
            'id' => $this->id,
            'project_id' => $this->project_id,
        ]);

        if (isset($this->tagId)) {
            CommonHelper::addCriteriaForTagid($query, TagModel::MODEL_FILES, $this->tagId);
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}