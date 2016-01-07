<?php
namespace app\components\helpers;
use app\models\IssueComment;
use yii\helpers\Url;

class MailHelper
{
    const DEFAULT_VIEW = 'default';

    /**
     * @param $comment IssueComment
     */
    public static function newComment($comment)
    {
        if (\Yii::$app->user->id == $comment->issue->creator_id) {
            if (empty($comment->issue->assignee->email)) return;
            $email = $comment->issue->assignee->email;
        } elseif (\Yii::$app->user->id == $comment->issue->assignee_id) {
            if (empty($comment->issue->author->email)) return;
            $email = $comment->issue->author->email;
        } else {
            $email = [$comment->issue->author->email];
            if (!empty($comment->issue->assignee->email)) {
                $email[] = $comment->issue->assignee->email;
             }

        }

        $data = [
            'h1' => 'Новый комментарий',
            'message' => $comment->user->getFullName() . " добавил(а) новый комментарий: <br/>" .
                nl2br($comment->text),
            'link' => "http://{$_SERVER['HTTP_HOST']}" . Url::toRoute(['/issue/view', 'id' => $comment->issue_id]),
        ];

        self::send(self::DEFAULT_VIEW, $data, $email, 'Новый комментарий');
    }

    public static function send($renderFile, $data, $email, $subject)
    {
        \Yii::$app->mailer->compose($renderFile, ['data' => $data])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($email)
            ->setSubject($subject)
            ->send();
    }
} 