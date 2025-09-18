<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace common\components\social;


use Yii;
// use yii\authclient\Collection;
use yii\base\Component;
use yii\base\InvalidArgumentException;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;

class PostingComponent extends Component
{
    public $clients = [];

    public $tokenStorage;

    private $_clients = [];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (!$this->tokenStorage) {
            throw new InvalidArgumentException('$tokenStorage is required arg.');
        }

        foreach ($this->clients as $id => $client) {
            $this->_clients[$id] = $this->createClient($id, $client);
        }
    }

    /**
     * @return ClientInterface[] list of clients.
     * @throws \yii\base\InvalidConfigException
     */
    public function getClients()
    {
        $clients = [];
        foreach ($this->clients as $id => $client) {
            $clients[$id] = $this->getClient($id);
        }

        return $clients;
    }

    /**
     * @param string $id service id.
     * @return ClientInterface auth client instance.
     * @throws InvalidParamException on non existing client request.
     * @throws \yii\base\InvalidConfigException
     */
    public function getClient($id)
    {
        if (!array_key_exists($id, $this->_clients)) {
            throw new InvalidParamException("Unknown client '{$id}'.");
        }
        if (!is_object($this->_clients[$id])) {
            $this->_clients[$id] = $this->createClient($id, $this->_clients[$id]);
        }

        return $this->_clients[$id];
    }


    /**
     * @param string $id client id.
     * @param array $config client instance configuration.
     * @return ClientInterface client instance.
     * @throws \yii\base\InvalidConfigException
     */
    protected function createClient($id, $config)
    {
        $tokenStorage = $this->getTokenStorage();
        $config['accessToken'] = $tokenStorage::getAccessToken($id);
        return Yii::createObject($config);
    }

    /**
     * @return TokenStorageInterface
     */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }


    /**
     * @param ClientInterface[] $clients
     */
    public function setClients(array $clients): void
    {
        $this->clients = $clients;
    }
}