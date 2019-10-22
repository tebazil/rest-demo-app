<?php


namespace app\components;


class CustomResponseStatus
{
    const RESPONSE_STATUS_SUCCESS = 'Success';
    const RESPONSE_STATUS_RECORD_NOT_FOUND = 'RecordNotFound';
    const RESPONSE_STATUS_URL_NOT_FOUND = 'UrlNotFound';
    const RESPONSE_GENERAL_INTERNAL_ERROR = 'GeneralInternalError';

    private static $statusList = [
        self::RESPONSE_STATUS_SUCCESS => 'Успешно',
        self::RESPONSE_STATUS_RECORD_NOT_FOUND => 'Запись не найдена',
        self::RESPONSE_STATUS_URL_NOT_FOUND => 'URL не найден',
        self::RESPONSE_GENERAL_INTERNAL_ERROR => 'Произошла ошибка',
    ];

    public static function getStatusMessage($status)
    {
        if(!isset(self::$statusList[$status])) {
            throw new \DomainException("Статус не найден");
        }
        return self::$statusList[$status];
    }
}