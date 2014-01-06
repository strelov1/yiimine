<?php
class AdminModule extends CWebModule {
    public function init() {
        $this->setImport(array(
            'admin.models.*',
            'admin.components.*',
        ));

        Yii::app()->getComponent('bootstrap');
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            if (!Yii::app()->user->isAdmin()) {
                throw new CHttpException(403);
            } else {
                return true;
            }
        } else
            return false;
    }
}