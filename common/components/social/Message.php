<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace common\components\social;


use yii\base\InvalidArgumentException;

class Message
{
    private $text;

    private $thumbnail;

    private $url;

    public function __construct($text, $thumbnail, $url)
    {
        if ($thumbnail && !filter_var($thumbnail, FILTER_VALIDATE_URL)) {
            if (!file_exists($thumbnail)) {
                throw new InvalidArgumentException('Please check $thumbnail path.');
            }
        }
        $this->text = $text;
        $this->thumbnail = $thumbnail;
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }
}