<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace common\components\social;


use VK\Client\VKApiClient;
use yii\httpclient\Client;

class VkClient extends ClientAbstract implements ClientInterface
{
    public $owner_id;
    public $from_group = 1;

    public function send(Message $message)
    {
        $vk = $this->getClient();
        $token = $this->getAccessToken();
        $address = $vk->photos()->getWallUploadServer($token);
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl($address['upload_url'])
            ->setFormat('JSON')
            ->addFile('photo', $message->getThumbnail())
            ->send();
        $photos = $response->getData();
        $uploadedPhotos = $vk->photos()->saveWallPhoto($token, $photos);
        $thumbnail = array_shift($uploadedPhotos);
        $vk->wall()->post($token, [
            'owner_id' => $this->owner_id,
            'from_group' => $this->from_group,
            'message' => $message->getText(),
            'attachments' => implode(",", [
                'photo' . $thumbnail['owner_id'] . '_' . $thumbnail['id'],
                $message->getUrl()
            ])
        ]);
        return true;
    }

    protected function getClient()
    {
        $vk = new VKApiClient();
        return $vk;
    }
}