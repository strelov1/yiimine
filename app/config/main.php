<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Yiimine',
    'language' => 'ru',

    // preloading 'log' component
    'preload' => array('log', 'bootstrap'),

    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.helpers.*',
        'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.models.*',
        'application.modules.rights.components.*',
        'ext.YiiMailer.YiiMailer',
    ),

    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '666',
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'bootstrap.gii'
            ),
        ),
        'admin',
        'user' => array(
            'tableUsers' => 'users',
            'hash' => 'md5', // encrypting method (php hash function)
            'sendActivationMail' => false, // send activation email
            'loginNotActiv' => false, // allow access for non-activated users
            'activeAfterRegister' => true, // activate user on registration (only sendActivationMail = false)
            'autoLogin' => true, // automatically login from registration
            'registrationUrl' => array('/user/registration'), // registration path
            'recoveryUrl' => array('/user/recovery'), // recovery password path
            'loginUrl' => array('/user/login'), // login form path
            'returnUrl' => array('/user/profile'), // page after login
            'returnLogoutUrl' => array('/user/login'), // page after logout
        ),
        'rights' => array(
            'superuserName' => 'Admin', // Name of the role with super user privileges.
            'authenticatedName' => 'Authenticated', // Name of the authenticated user role.
            'userIdColumn' => 'id', // Name of the user id column in the database.
            'userNameColumn' => 'username', // Name of the user name column in the database.
            'enableBizRule' => true, // Whether to enable authorization item business rules.
            'enableBizRuleData' => true, // Whether to enable data for business rules.
            'displayDescription' => true, // Whether to use item description instead of name.
            'flashSuccessKey' => 'RightsSuccess', // Key to use for setting success flash messages.
            'flashErrorKey' => 'RightsError', // Key to use for setting error flash messages.
            'baseUrl' => '/rights', // Base URL for Rights. Change if module is nested.
            'layout' => 'application.views.layouts.layout-admin', // Layout to use for displaying Rights.
            'appLayout' => 'application.views.layouts.main', // Application layout.
            'install' => false, // Whether to enable installer.
            'debug' => false,
        ),
    ),
    // application components
    'components' => array(
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),
        'cache' => array(
            'class' => 'CDbCache',
            'connectionID' => 'db',
        ),
        'clientScript' => array(
            'class' => 'ext.NLSClientScript',
            'mergeJs' => false, //def:true
            'compressMergedJs' => false, //def:false
            'mergeCss' => false, //def:true
            'compressMergedCss' => false, //def:false
            'mergeAbove' => 1, //def:1, only "more than this value" files will be merged,
            'curlTimeOut' => 5, //def:5, see curl_setopt() doc
            'curlConnectionTimeOut' => 10, //def:10, see curl_setopt() doc
            'appVersion' => 1.0, //if set, it will be appended to the urls of the merged scripts/css
            'packages' => array(
                'select2' => array(
                    'baseUrl' => Yii::getPathOfAlias('webroot') . '/js/packages/select2/',
                    'js' => array('select2.min.js'),
                    'css' => array('select2.min.css'),
                    'depends' => array('jquery'),
                ),
                'fancybox' => array(
                    'baseUrl' => Yii::getPathOfAlias('webroot') . '/js/packages/fancybox/',
                    'js' => array('jquery.fancybox.pack.js', 'helpers/jquery.fancybox-buttons.min.js', 'helpers/jquery.fancybox-media.min.js', 'helpers/jquery.fancybox-thumbs.min.js'),
                    'css' => array('jquery.fancybox.min.css', 'helpers/jquery.fancybox-buttons.min.css', 'helpers/jquery.fancybox-thumbs.min.css'),
                    'depends' => array('jquery'),
                ),
            ),
        ),
        'image' => array(
            'class' => 'ext.image.CImageComponent', // Библиотека для обрезки изображений
            'driver' => 'GD',
            'params' => array('directory' => '/opt/local/bin'),
        ),
        'imageHandler' => array(
            'class' => 'ext.CImageHandler', // Библиотека для работы с изображениями, в т.ч. WaterMark
        ),
        'user' => array(
            'class' => 'RWebUser',
            'allowAutoLogin' => true,
            'loginUrl' => array('/user/login'),
        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
            'defaultRoles' => array('Guest'),
            'assignmentTable' => 'auth_assignment',
            'itemTable' => 'auth_item',
            'itemChildTable' => 'auth_item_child',
            'rightsTable' => 'rights',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => require(dirname(__FILE__) . '/_url.php'),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=yiimine',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'schemaCachingDuration' => 3600
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'adminEmail' => 'belyakov.u@gmail.com',
    ),
);