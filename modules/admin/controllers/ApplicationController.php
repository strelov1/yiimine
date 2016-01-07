<?php
namespace app\modules\admin\controllers;
use app\models\form\SettingsForm;
use app\models\Settings;
use app\modules\admin\components\AdminController;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class ApplicationController extends AdminController
{
    public function actionIndex()
    {
        $settings = Settings::getAppSettings();

        $model = new SettingsForm();
        $model->loadFromArray(ArrayHelper::map($settings, 'key', 'value'));

        if ($model->load(\Yii::$app->request->post())) {
            $model->app_logo = UploadedFile::getInstance($model, 'app_logo');
            $model->save();
            return $this->refresh();
        }

        return $this->render('index', ['model' => $model]);
    }
}