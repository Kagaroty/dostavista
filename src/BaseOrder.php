<?php

namespace Dostavista;

use DateTime;

abstract class BaseOrder extends AbstractModel
{
    /**
     * Что везем
     * @var float
     */
    protected $matter;

    /**
     * Тип транспорта
     * @var int
     */
    protected $vehicleTypeId = 6;

    /**
     * Общий вес отправления, кг
     * @var int
     */
    protected $totalWeightKg = 0;

    /**
     * Сумма страховки.
     * @var string
     */
    protected $insuranceAmount = "0.00";

    /**
     * Отправлять клиенту SMS уведомления о статусе заказа
     * @var bool
     */
    protected $isClientNotificationEnabled = false;
    
    /**
     * Отправлять получателям SMS с интервалом прибытия и телефоном курьера.
     * @var bool
     */
    protected $isContactPersonNotificationEnabled = false;

    /**
     * Требуемое число грузчиков (включая водителя).
     * @var int
     */
    protected $loadersCount = 0;

    /**
     * Реквизиты для перевода выручки. Например, номер карты или Qiwi-кошелька.
     * @var string|null
     */
    protected $backpaymentDetails = null;

    /**
     * Список адресов (точек) в заказе. В заказе может быть от 2 до 99 точек. Значение по умолчанию: [].
     * @var array
     */
    protected $points = [];

    /**
     * @param Point[]|array|required $points
     *
     * @return $this
     */
    public function setPoints(array $points)
    {
        foreach ($points as &$point) {
            if (!$point instanceof Point) {
                $point = new Point(
                    $point['address'], 
                    new DateTime($point['required_start_datetime']), 
                    new DateTime($point['required_finish_datetime']),
                    $point['contact_person'], 
                    $point
                );
            }
        }

        $this->points = $points;
        return $this;
    }
}