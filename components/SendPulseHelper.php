<?php

namespace panix\mod\sendpulse\components;

class SendPulseHelper
{

    public static function pushStatus($status)
    {
        if ($status == 2) {
            return 'Отправляется';
        } elseif ($status == 3) {
            return 'Рассылка отправлена';
        } elseif ($status == 8) {
            return 'Тестовая кампания отправлена';
        } elseif ($status == 12) {
            return 'Нет активных получателей';
        } elseif ($status == 13) {
            return 'Кампания в процессе создания — копирование подписок';
        } elseif ($status == 15) {
            return 'Кампания ожидает итога A/B тестирования';
        } elseif ($status == 16) {
            return 'Кампания отменена пользователем';
        } elseif ($status == 30) {
            return 'В архиве';
        } else { //0
            return 'Новая рассылка';
        }
    }


    public static function pushSubscriptionsStatus($status)
    {
        if ($status == 1) {
            return 'active';
        } elseif ($status == 6) {
            return 'unsubscribed';
        } else { //0
            return 'deactivated';
        }
    }


}