<?php

/**
 * This is the model class for table "issue".
 *
 * The followings are the available columns in table 'issue':
 * @property string $id
 * @property string $project_id
 * @property integer $tracker_id
 * @property integer $status_id
 * @property integer $priority_id
 * @property string $assigned_to_id
 * @property string $subject
 * @property string $description
 * @property integer $done_ratio
 * @property string $due_date
 * @property string $author_id
 * @property string $created_date
 * @property string $updated_date
 */
class Issue extends CActiveRecord {
    const TRACKER_BUG = 1;
    const TRACKER_TASK = 2;

    const STATUS_NEW = 1;
    const STATUS_IN_WORK = 2;
    const STATUS_REVIEW = 3;
    const STATUS_CLOSED = 4;
    const STATUS_CANT_REPRODUCE = 5;

    const PRIORITY_HIGH = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_LOW = 3;

    public $tmpFiles;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'issue';
    }

    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_date',
                'updateAttribute' => 'updated_date',
            ),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('project_id, tracker_id, priority_id, subject, description', 'required'),
            array('tracker_id, status_id, priority_id, done_ratio', 'numerical', 'integerOnly' => true),
            array('project_id, assigned_to_id, author_id', 'length', 'max' => 11),
            array('subject', 'length', 'max' => 50),
            array('due_date, updated_date', 'safe'),
            array('tmpFiles', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, project_id, tracker_id, status_id, priority_id, assigned_to_id, subject, description, done_ratio, due_date, author_id, created_date, updated_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'files' => array(self::HAS_MANY, 'IssueFile', 'issue_id'),
            'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
            'assigned' => array(self::BELONGS_TO, 'User', 'assigned_to_id'),
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'project_id' => 'Проект',
            'tracker_id' => 'Трекер',
            'status_id' => 'Статус',
            'priority_id' => 'Приоритет',
            'assigned_to_id' => 'Исполнитель',
            'subject' => 'Заголовок',
            'description' => 'Описание',
            'done_ratio' => 'Готовность, %',
            'due_date' => 'Дата окончания',
            'author_id' => 'Автор',
            'created_date' => 'Дата создания',
            'updated_date' => 'Дата обновления',
            'tmpFiles' => 'Прикрепить файлы',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('project_id', $this->project_id, true);
        $criteria->compare('tracker_id', $this->tracker_id);
        $criteria->compare('status_id', $this->status_id);
        $criteria->compare('priority_id', $this->priority_id);
        $criteria->compare('assigned_to_id', $this->assigned_to_id, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('done_ratio', $this->done_ratio);
        $criteria->compare('due_date', $this->due_date, true);
        $criteria->compare('author_id', $this->author_id, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'status_id ASC, created_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Issue the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getTrackerOptions() {
        return array(
            self::TRACKER_BUG => 'Баг',
            self::TRACKER_TASK => 'Задача',
        );
    }

    public static function getPriorityOptions() {
        return array(
            self::PRIORITY_HIGH => 'Высокий',
            self::PRIORITY_MEDIUM => 'Средний',
            self::PRIORITY_LOW => 'Низкий',
        );
    }

    public static function getDoneRatioOptions() {
        return array(
            10 => '10',
            20 => '20',
            30 => '30',
            40 => '40',
            50 => '50',
            60 => '60',
            70 => '70',
            80 => '80',
            90 => '90',
            100 => '100',
        );
    }
    
    public static function getStatusOptions() {
        return array(
            self::STATUS_NEW => 'Новый',
            self::STATUS_IN_WORK => 'В работе',
            self::STATUS_REVIEW => 'На проверку',
            self::STATUS_CANT_REPRODUCE => 'Не повторить',
            self::STATUS_CLOSED => 'Закрытый',
        );
    }

    protected function beforeSave() {
        if(parent::beforeSave()) {
            if($this->isNewRecord) {
                $this->status_id = self::STATUS_NEW;
                $this->author_id = Yii::app()->user->id;
            }

            return true;
        } else
            return false;
    }

    public function getFileFolder()
    {
        $folder = Yii::getPathOfAlias('webroot').'/uploads/issue/'.$this->id.'/';
        if (is_dir($folder) == false)
            mkdir($folder, 0755, true);
        return $folder;
    }

    public function getOrigFilePath() {
        return Yii::app()->baseUrl.'/uploads/issue/'.$this->id.'/';
    }

    public function getThumbFilePath() {
        return Yii::app()->baseUrl.'/uploads/issue/'.$this->id.'/thumb_';
    }
}