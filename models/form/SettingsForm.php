<?php
namespace app\models\form;

use app\models\Settings;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class SettingsForm extends Model
{
    public $app_name;
    public $app_logo;
    public $app_description;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['app_name'], 'string', 'max' => 255],
            [['app_logo', 'app_description'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'app_name' => \Yii::t('app', 'Application Title'),
            'app_logo' => \Yii::t('app', 'Application Logo'),
            'app_description' => \Yii::t('app', 'Welcome text'),
        ];
    }

    public function loadFromArray($settings)
    {
        foreach ($settings as $field => $value) {
            $this->{$field} = $value;
        }
    }

    public function save()
    {
        if ($this->app_name) {
            \Yii::$app->db->createCommand('UPDATE settings SET `value`=:val WHERE `key`=:key', [
                ':val' => $this->app_name,
                ':key' => 'app_name',
            ])->execute();
        }

        if ($this->app_description) {
            \Yii::$app->db->createCommand('UPDATE settings SET `value`=:val WHERE `key`=:key', [
                ':val' => $this->app_description,
                ':key' => 'app_description',
            ])->execute();
        }

        if (empty($this->app_logo)) {
            $this->app_logo = \Yii::$app->db->createCommand('SELECT `value` FROM settings WHERE `key`="app_logo"')->queryScalar();
        } else {
            $logoModel = Settings::findOne(['key' => 'app_logo']);
            $logoModel->saveFile($this->app_logo);
            \Yii::$app->db->createCommand('UPDATE settings SET `value`=:val WHERE `key`=:key', [
                ':val' => $this->app_logo->name,
                ':key' => 'app_logo',
            ])->execute();
        }
    }
}
