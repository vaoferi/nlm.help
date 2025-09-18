<?php
/**
 * Created by PhpStorm.
 * User: rexit
 * Date: 08.05.19
 * Time: 11:16
 */

namespace common\components\social;


use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookResponse;
use Yii;

class FbClient extends ClientAbstract implements ClientInterface
{
    public $group_id;
    public $page_token;

    /**
     * @param Message $message
     * @return bool|string
     * @throws FacebookSDKException
     */
    public function send(Message $message)
    {
        $fb = $this->getClient();
        $accessToken = $this->getAccessToken('fb');
        $fb->get("/{$this->group_id}?fields=access_token", $accessToken);

        $attachment = array(
            'link' => $message->getUrl(),
            'message' => $message->getText(),
        );

        try {
            //Get page token
            /** @var FacebookResponse $response */
            $response = $fb->get("/{$this->group_id}?fields=access_token", $accessToken);
            $data = $response->getDecodedBody();
            $pageToken = null;
            if (isset($data['access_token'])) {
                $pageToken = $data['access_token'];
            }
            // Post to Facebook Group
            $fb->post("/{$this->group_id}/feed", $attachment, $pageToken);
            return true;
        } catch (FacebookSDKException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return Facebook
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    protected function getClient()
    {
        $fb = new Facebook([
            'app_id' => Yii::$app->params['fb']['appId'],
            'app_secret' => Yii::$app->params['fb']['secretKey'],
            'default_graph_version' => Yii::$app->params['fb']['version'],
        ]);
        return $fb;
    }
}