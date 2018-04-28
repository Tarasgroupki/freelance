<?php
/**
 * CommentFormWidget.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments\widgets;

use rmrevin\yii\module\Comments;

/**
 * Class CommentFormWidget
 * @package rmrevin\yii\module\Comments\widgets
 */
class CommentFormWidget extends \yii\base\Widget
{

    /** @var string|null */
    public $theme;

    /** @var string */
    public $entity;

	public $item_id;
	
	public $user_id;
	
	public $price;
	
	public $type_id;
    /** @var Comments\models\Comment */
    public $Comment;

    /** @var string */
    public $anchor = '#comment-%d';

    /** @var string */
    public $viewFile = 'comment-form';

    /**
     * Register asset bundle
     */
    protected function registerAssets()
    {
        CommentFormAsset::register($this->getView());
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerAssets();
        /** @var Comments\forms\CommentCreateForm $CommentCreateForm */
        $CommentCreateFormClassData = Comments\Module::instance()->model(
            'commentCreateForm', [
                'Comment' => $this->Comment,
                'entity' => $this->entity,
				'item_id' => $this->item_id,
				'type_id' => $this->type_id
            ]
        );

        $CommentCreateForm = \Yii::createObject($CommentCreateFormClassData);

        if ($CommentCreateForm->load(\Yii::$app->getRequest()->post())) {
			if ($CommentCreateForm->validate()) {
                if ($CommentCreateForm->save()) {
                    \Yii::$app->getResponse()
                        ->refresh(sprintf($this->anchor, $CommentCreateForm->Comment->id))
                        ->send();

                    exit;
                }
            }
        }

        return $this->render($this->viewFile, [
            'CommentCreateForm' => $CommentCreateForm
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return empty($this->theme)
            ? parent::getViewPath()
            : (\Yii::$app->getViewPath() . DIRECTORY_SEPARATOR . $this->theme);
    }
}
