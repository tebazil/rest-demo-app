<?php


namespace app\components;


use Throwable;
use yii\base\UserException;

class RecordNotFoundException extends UserException
{
    const CODE = 1001;
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, self::CODE, $previous);
    }

}