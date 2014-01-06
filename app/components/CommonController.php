<?php
/**
 * Class CommonController
 * Содержит стандартные универсальные функции для CRUD
 * @author devkp.ru
 */
class CommonController extends Controller {
    /**
     * Реализует простой экшен просмотра списка записей с возможностью
     * сортировки и фильтрации
     * @param string $className
     * @param array $additionalParams
     * @return mixed
     */
    protected function listing($className, $additionalParams = array()) {
        $model = new $className('search');
        $model->unsetAttributes();

        if(!empty($additionalParams)) {
            foreach($additionalParams as $name=>$value) {
                $model->$name = $value;
            }
        }

        $params = Yii::app()->request->getQuery($className);
        if(isset($params)) {
            $model->attributes = $params;
        }

        return $model;
    }

    public function getListing($className, $additionalParams = array()) {
        return $this->listing($className, $additionalParams);
    }

    /**
     * Удаления по $id
     * @param string $className имя класса
     * @param int $id айди для удаления
     * @throws CHttpException
     */
    protected function delete($className, $id) {
        if(Yii::app()->request->isPostRequest) {
            CActiveRecord::model($className)->findByPk($id)->delete();
            Yii::app()->user->setFlash('success', t('AlertMessage', 'Item was deleted!'));
        } else {
            throw new CHttpException(400, t('AlertMessage', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    /**
     * Геттер для _delete
     * @param type $className
     * @param $id
     * @return type
     */
    public function getDelete($className, $id) {
        return $this->delete($className, $id);
    }

    /**
     * Простое создание
     * @param string $className
     * @param array $message
     * @param array $additionalParams
     * @param bool $refresh
     * @return mixed
     */
    protected function create($className, $message = array(), $additionalParams = array(), $refresh = true, $redirectUrl = array()) {
        if(empty($message['success'])) {
            $message['success'] = t('AlertMessage', 'Item has been added!');
        }

        if(empty($message['error'])) {
            $message['error'] = t('AlertMessage', 'Item could not be added!');
        }

        $model = $this->_initClass($className, $additionalParams);
        $this->performAjaxValidation($model);

        $params = Yii::app()->getRequest()->getParam($className);
        if($params) {
            $model->attributes = $params;
            if($model->save()) {
                if($refresh) {
                    $model = $this->_initClass($className, $additionalParams);
                }
                Yii::app()->user->setFlash('success', $message['success']);
            } else {
                Yii::app()->user->setFlash('error', $message['error']);
            }

            if(is_array($redirectUrl))
                $this->redirect($redirectUrl);
        }

        return $model;
    }

    /**
     * Инициализация класса с параметрами
     * @param string $className
     * @param array $params
     * @return mixed
     */
    private function _initClass($className, $params) {
        $class = new $className();
        foreach($params as $name=>$value) {
            $class->$name = $value;
        }

        return $class;
    }

    /**
     * Геттер для _delete
     * @param string $className
     * @param array $message
     * @param array $additionalParams
     * @param bool $refresh
     * @return CActiveRecord
     */
    public function getCreate($className, $message = array(), $additionalParams = array(), $refresh = true, $redirectUrl = array()) {
        return $this->create($className, $message, $additionalParams, $refresh, $redirectUrl);
    }

    /**
     * Простое редактирование
     * @param string $className
     * @param array $message
     * @param array $additionalParams
     * @return CActiveRecord
     */
    protected function update($className, $message = array(), $additionalParams = array(), $redirectUrl = array()) {
        if(empty($message['success'])) {
            $message['success'] = t('AlertMessage', 'Item has been saved!');
        }

        if(empty($message['error'])) {
            $message['error'] = t('AlertMessage', 'Item could not be saved!');
        }

        $id = (int)Yii::app()->getRequest()->getQuery('id');
        $model = $this->loadModel($className, $id);
        foreach($additionalParams as $name=>$value) {
            $model->$name=$value;
        }
        $this->performAjaxValidation($model);

        $params = Yii::app()->getRequest()->getParam($className);
        if($params) {
            $model->attributes = $params;
            if($model->save()) {
                Yii::app()->user->setFlash('success', $message['success']);
            } else {
                Yii::app()->user->setFlash('error', $message['error']);
            }

            if(is_array($redirectUrl))
                $this->redirect($redirectUrl);
        }
        return $model;
    }

    /**
     * Геттер для _update
     * @param type $className
     * @param type $message
     * @param type $additionalParams
     * @return type
     */
    public function getUpdate($className, $message = array(), $additionalParams = array(), $redirectUrl = array()) {
        return $this->update($className, $message, $additionalParams, $redirectUrl);
    }
}