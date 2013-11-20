<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property string $id
 * @property string $identifier
 * @property string $title
 * @property string $description
 * @property integer $status_id
 * @property integer $is_public
 * @property string $author_id
 * @property string $created_date
 * @property string $updated_date
 */
class Project extends CActiveRecord {
    const STATUS_CLOSED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_ARCHIVE = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'project';
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

    public function scopes() {
        return array(
            'active' => array(
                'condition' => 'status_id = '.self::STATUS_ACTIVE,
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
            array('identifier, title', 'required'),
            array('status_id, is_public', 'numerical', 'integerOnly' => true),
            array('identifier', 'length', 'max' => 10, 'min' => 3),
            array('identifier', 'unique'),
            array('title', 'length', 'max' => 50),
            array('author_id', 'length', 'max' => 11),
            array('description, updated_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, identifier, title, description, status_id, is_public, author_id, created_date, updated_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'identifier' => 'Идентификатор',
            'title' => 'Название',
            'description' => 'Описание',
            'status_id' => 'Статус',
            'is_public' => 'Публичный проект',
            'author_id' => 'Автор',
            'created_date' => 'Дата создания',
            'updated_date' => 'Дата обновления',
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
        $criteria->compare('identifier', $this->identifier, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status_id', $this->status_id);
        $criteria->compare('is_public', $this->is_public);
        $criteria->compare('author_id', $this->author_id, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Project the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        if(parent::beforeSave()) {
            if($this->isNewRecord) {
                $this->status_id = self::STATUS_ACTIVE;
                $this->author_id = Yii::app()->user->id;
            }

            return true;
        } else
            return false;
    }

    public static function getActiveProjects() {
        return CHtml::listData(self::model()->active()->findAll(), 'id', 'title');
    }
}