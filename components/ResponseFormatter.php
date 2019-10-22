<?php


namespace app\components;


use yii\base\Event;
use yii\web\Response;

class ResponseFormatter
{
    public static function handle(Event $event) {
        /** @var Response $sender */
        $sender = $event->sender;

        //"Нормальный" ответ
        if($sender->statusCode === 200) {
            $sender->data = self::getWrappedData(CustomResponseStatus::RESPONSE_STATUS_SUCCESS, $sender->data);
        }

        //User-level exception по кодам
        elseif(isset($sender->data['name']) && $sender->data['name']==='Exception') {
            switch($sender->data['code']) {
                case(RecordNotFoundException::CODE):
                    $sender->data = self::getWrappedData(CustomResponseStatus::RESPONSE_STATUS_RECORD_NOT_FOUND, $sender->data);
                    break;
                default:
                    break;
            }
        }
        //404 и остальные по http статусам.. добавляем те статус коды, которые хотим показать явно, остальные покажут общую ошибку
        else {
            switch ($sender->statusCode) {
                case(404):
                    $sender->data = self::getWrappedData(CustomResponseStatus::RESPONSE_STATUS_URL_NOT_FOUND, $sender->data);
                    break;
                default:
                    $sender->data = self::getWrappedData(CustomResponseStatus::RESPONSE_GENERAL_INTERNAL_ERROR, $sender->data);
                    break;

            }
        }

    }

    private static function getWrappedData(?string $responseStatus, $data)
    {
        $ret = [];
        if(!is_null($responseStatus)) {
            $ret['status'] = $responseStatus;
            $ret['message'] = CustomResponseStatus::getStatusMessage($responseStatus);
        }
        $ret['data'] = $data;
        return $ret;
    }
}