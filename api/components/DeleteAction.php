<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace api\components;

use Yii;
use yii\web\ServerErrorHttpException;
use common\models\Followers;
/**
 * DeleteAction implements the API endpoint for deleting a model.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DeleteAction extends \yii\rest\Action
{
    /**
     * Deletes a model.
     * @param mixed $id id of the model to be deleted.
     * @throws ServerErrorHttpException on failure.
     */
    public function run($id)
    {
        $follower_id=Yii::$app->request->post('follower_id');
        $model = Followers::find()->where(['followed_id'=>$id,'follower_id'=>$follower_id])->one();
        //$this->findModel($id);
        /*if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->follow_id, $model);
        }*/
        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
        Yii::$app->getResponse()->setStatusCode(204);
    }
}