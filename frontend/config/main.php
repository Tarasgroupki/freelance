<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
	'homeUrl' => '/',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['chiliec\vote\components\VoteBootstrap','log'],
	'language'   => 'en',
    'sourceLanguage' => 'en',
	'on beforeAction' => ['\pjhl\multilanguage\Start', 'run'],
    'controllerNamespace' => 'frontend\controllers',
	'modules' => [
		// ...
		'vote' => [
        'class' => 'chiliec\vote\Module',
        // show messages in popover
        'popOverEnabled' => true,
        // global values for all models
        // 'allowGuests' => true,
        // 'allowChangeVote' => true,
        'models' => [
        	// example declaration of models
            // \common\models\Post::className(),
            // 'backend\models\Post',
            // 2 => 'frontend\models\Story',
            // 3 => [
            //     'modelName' => \backend\models\Mail::className(),
            //     you can rewrite global values for specific model
            //     'allowGuests' => false,
            //     'allowChangeVote' => false,
            // ],
        ],      
    ],
		'comments' => [
		    'class' => 'rmrevin\yii\module\Comments\Module',
		    'userIdentityClass' => 'common\models\User',
		    'useRbac' => true,
		]
	],
    'components' => [
	'view' => [
        'theme' => [
            'pathMap' => [
                '@chiliec/vote/widgets/views' => '@app/views/vote'
            ],
        ],
    ],
	  'authManager' => [
            'class'           => 'yii\rbac\DbManager', 
            'itemTable'       => 'auth_item',
            'itemChildTable'  => 'auth_item_child',
            'assignmentTable' => 'auth_assignment',
            'ruleTable'       => 'auth_rule',
            'defaultRoles'    => ['guest'],// роль которая назначается всем пользователям по умолчанию
        ],
        'request' => [
		'class' => 'pjhl\multilanguage\components\AdvancedRequest',
		'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
        ],
		'mymessages' => [
                //Обязательно
            'class'    => 'vision\messages\components\MyMessages',
                //не обязательно
                //класс модели пользователей
                //по-умолчанию \Yii::$app->user->identityClass
            'modelUser' => 'common\models\User',
                //имя контроллера где разместили action
            'nameController' => 'messages',
                //не обязательно
                //имя поля в таблице пользователей которое будет использоваться в качестве имени
                //по-умолчанию username
            'attributeNameUser' => 'username',
                //не обязательно
                //можно указать роли и/или id пользователей которые будут видны в списке контактов всем кто не подпадает 
                //в эту выборку, при этом указанные пользователи будут и смогут писать всем зарегестрированным пользователям
           // 'admins' => ['customer'],
                //не обязательно
                //включение возможности дублировать сообщение на email
                //для работы данной функции в проектк должна быть реализована отправка почты штатными средствами фреймворка
            'enableEmail' => true,
                //задаем функцию для возврата адреса почты
                //в качестве аргумента передается объект модели пользователя
            'getEmail' => function($user_model) {
                return $user_model->email;
            },
                //задаем функцию для возврата лого пользователей в списке контактов (для виджета cloud)
                //в качестве аргумента передается id пользователя
            'getLogo' => function() {
                //return Yii::$app->db->createCommand("SELECT avatar FROM `profile` WHERE user_id =".Yii::$app->user->identity['id']."")->queryOne()['avatar'];
				if(Yii::$app->user->can('customer')):
				$users = Yii::$app->db->createCommand("SELECT `id` FROM `user` JOIN `orders` ON `user`.`username` = `orders`.`from` WHERE `orders`.`user_id` = '".Yii::$app->user->id."'")->queryAll();  
				foreach($users as $key => $id):
	    $users[$key] = $id['id'];	
		endforeach;
		$subQuery = (new yii\db\Query())->select([
                'user_id',
				'avatar'
            ])->from(['profile'])
			->where([
			    'in', 'user_id', $users
			])->all();
			foreach($subQuery as $query):
			$subQuery[$query['user_id']] = $query['avatar'];
			endforeach;
			elseif(Yii::$app->user->can('performer')):
			$users = Yii::$app->db->createCommand("SELECT `user_id` FROM `orders` WHERE `from` = '".Yii::$app->user->identity['username']."'")->queryAll(); 
            foreach($users as $key => $id):
	    $users[$key] = $id['user_id'];	
		endforeach;
		$subQuery = (new yii\db\Query())->select([
                'user_id',
				'avatar'
            ])->from(['profile'])
			->where([
			    'in', 'user_id', $users
			])->all();
			foreach($subQuery as $query):
			$subQuery[$query['user_id']] = $query['avatar'];
			endforeach;
			endif;
			return $subQuery;
			},
                //указываем шаблоны сообщений, в них будет передаваться сообщение $message
            'templateEmail' => [
                'html' => 'private-message-text',
                'text' => 'private-message-html'
            ],
                //тема письма
            'subject' => 'Private message'
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
		'i18n' => [
            'translations' => [
                'vote' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/modules/vote/messages',
                ],
                // ...
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
			'class' => 'pjhl\multilanguage\components\AdvancedUrlManager',
            'rules' => [
			'orders/connect/<id:\d+>/<user_id:\d+>' => 'orders/connect',
            'orders/out/<id:\d+>' => 'orders/out',
			'orders/view/<id:\d+>/<slug:[\w\-]+>' => 'orders/view',
			'messages/index/<id:\d+>' => 'messages/index',
			'orders/responce/<id:\d+>' => 'orders/responce',
			'orders/index/<cat_id:\d+>/<slug:[\w\-]+>' => 'orders/index',
			],
        ],
    ],
    'params' => $params,
];
