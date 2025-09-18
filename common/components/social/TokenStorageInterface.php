<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace common\components\social;


interface TokenStorageInterface
{
    /**
     * Returns string token for client.
     * @param string $client
     * @return string
     */
    public static function getAccessToken(string $client);
}