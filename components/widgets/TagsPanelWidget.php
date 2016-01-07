<?php
namespace app\components\widgets;

use app\models\Tag;
use yii\base\Widget;
use yii\helpers\Html;

class TagsPanelWidget extends Widget
{
    public $modelName;
    public $projectId;

    public function run() {
        $tags = \Yii::$app->db->createCommand('SELECT id, name FROM tag RIGHT JOIN tag_model ON tag_model.tag_id=tag.id AND tag_model.model_name=:mName WHERE tag.project_id=:pId GROUP BY tag.id ORDER BY tag.name', [
            ':mName' => $this->modelName,
            ':pId' => $this->projectId,
        ])->queryAll();

        $tagArr = [];
        foreach ($tags as $t) {
            if(empty($t['name'])) continue;
            $tagArr[] = Html::a($t['name'], ['/' . $this->modelName . '/index', 'id' => $this->projectId, 'tagId' => $t['id']]);
        }

        return $this->render('tagsPanelWidget', [
            'tags' => $tagArr,
        ]);
    }
}