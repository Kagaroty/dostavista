<?php

namespace Dostavista;

use DateTime;

class Order extends BaseOrder
{
    /**
     * Полный номер заказа
     * @var int
     */
    protected $orderId;

    /**
     * Короткий номер заказа
     * @var string
     */
    protected $orderName;

    /**
     * Дата и время создания заказа
     * @var timestamp ISO 8601
     */
    protected $createdDateTime;

    /**
     * Дата и время завершения заказа
     * @var timestamp ISO 8601
     */
    protected $finishDateTime;

    /**
     * Статус заказа
     *
     *  new             [Созданный заказ, ожидает одобрения оператора.]
     *  available       [Заказ одобрен оператором и доступен курьерам.]
     *  active          [Заказ выполняется курьером.]
     *  completed       [Заказ выполнен.]
     *  reactivated     [Заказ повторно активирован и вновь доступен курьерам]
     *  draft           [Черновик заказа.]
     *  canceled        [Заказ отменен.]
     *  delayed         [Заказа отложен.]
     * 
     * @var string
     */
    protected $status;

    /**
     * Общая стоимость заказа.
     * @var string
     */
    protected $paymentAmount;

    /**
     * Стоимость доставки. Входит в общую стоимость заказа (payment_amount).
     * @var string
     */
    protected $deliveryFeeAmount;

    /**
     * Наценка за вес отправления. Входит в общую стоимость заказа (payment_amount).
     * @var string
     */
    protected $weightFeeAmount;

    /**
     * Стоимость страховки. Входит в общую стоимость заказа (payment_amount).
     * @var string
     */
    protected $insuranceFeeAmount;

    /**
     * Стоимость погрузки-разгрузки. Входит в общую стоимость заказа (payment_amount).
     * @var string
     */
    protected $loadingFeeAmount;

    /**
     * Комиссия за работу с деньгами (перевод выручки, получение денег на точках). Входит в общую стоимость заказа (payment_amount).
     * @var string
     */
    protected $moneyTransferFeeAmount;

    /**
     * Наценка за километраж при выезде в пригород. Входит в общую стоимость заказа (payment_amount).
     * @var string
     */
    protected $suburbanDeliveryFeeAmount;

    /**
     * Наценка за доставку с ночевкой. Входит в общую стоимость заказа (payment_amount).
     * @var string
     */
    protected $overnightFeeAmount;

    /**
     * Скидка. Уже учтена в общей стоимости заказа (payment_amount).
     * @var string
     */
    protected $discountAmount;

    /**
     * Наценка за кассовое обслуживание. Входит в общую стоимость заказа (payment_amount).
     * @var string
     */
    protected $codFeeAmount;

    /**
     * Ссылка на фотографию с чеком (подтверждение перевода выручки).
     * @var string|null
     */
    protected $backpaymentPhotoURL;

    /**
     * Ссылка на маршрутный лист.
     * @var string|null
     */
    protected $itineraryDocumentURL;

    /**
     * Ссылка на транспортную накладную.
     * @var string|null
     */
    protected $waybillDocumentURL;

    /**
     * @var Courier
     */
    protected $courier = [];


    protected function setOrderId(int $orderId)
    {
        $this->orderId = $orderId;
    }

    protected function setOrderName(string $orderName)
    {
        $this->orderName = $orderName;
    }

    protected function setCreatedDateTime(string $createdDateTime)
    {
        $this->createdDateTime = new DateTime($createdDateTime);
    }

    protected function setFinishDateTime($finishDateTime)
    {
        if ($finishDateTime) {
            $this->finishDateTime = new DateTime($finishDateTime);
        }
    }

    protected function setStatus(string $status)
    {
        $this->status = $status;
    }

    protected function setTotalWeight (string $totalWeight)
    {
        $this->totalWeightKg = $totalWeight;
    }

    protected function setIsClientNotificationEnabled(bool $isClientNotificationEnabled)
    {
        $this->isClientNotificationEnabled = $isClientNotificationEnabled;
    }

    protected function setIsContactPersonNotificationEnabled(bool $isContactPersonNotificationEnabled)
    {
        $this->isContactPersonNotificationEnabled = $isContactPersonNotificationEnabled;
    }

    protected function setLoadersCount(int $loadersCount)
    {
        $this->loadersCount = $loadersCount;
    }

    protected function setPaymentAmount(string $paymentAmount)
    {
        $this->paymentAmount = $paymentAmount;
    }

    protected function setDeliveryFeeAmount(string $deliveryFeeAmount)
    {
        $this->deliveryFeeAmount = $deliveryFeeAmount;
    }

    protected function setWeightFeeAmount(string $weightFeeAmount)
    {
        $this->weightFeeAmount = $weightFeeAmount;
    }

    protected function setInsuranceAmount(string $insuranceAmount)
    {
        $this->insuranceAmount = $insuranceAmount;
    }

    protected function setInsuranceFeeAmount(string $insuranceFeeAmount)
    {
        $this->insuranceFeeAmount = $insuranceFeeAmount;
    }

    protected function setLoadingFeeAmount(string $loadingFeeAmount)
    {
        $this->loadingFeeAmount = $loadingFeeAmount;
    }

    protected function setMoneyTransferFeeAmount(string $moneyTransferFeeAmount)
    {
        $this->moneyTransferFeeAmount = $moneyTransferFeeAmount;
    }

    protected function setSuburbanDeliveryFeeAmount(string $suburbanDeliveryFeeAmount)
    {
        $this->suburbanDeliveryFeeAmount = $suburbanDeliveryFeeAmount;
    }

    protected function setOvernightFeeAmount(string $overnightFeeAmount)
    {
        $this->overnightFeeAmount = $overnightFeeAmount;
    }

    protected function setDiscountAmount(string $discountAmount)
    {
        $this->discountAmount = $discountAmount;
    }

    protected function setCodFeeAmount(string $codFeeAmount)
    {
        $this->codFeeAmount = $codFeeAmount;
    }

    protected function setBackpaymentDetails(?string $backpaymentDetails)
    {
        $this->backpaymentDetails = $backpaymentDetails;
    }

    protected function setBackpaymentPhotoUrl(?string $backpaymentPhotoUrl)
    {
        $this->backpaymentPhotoUrl = $backpaymentPhotoUrl;
    }

    protected function setItineraryDocumentUrl(?string $itineraryDocumentUrl)
    {
        $this->itineraryDocumentUrl = $itineraryDocumentUrl;
    }

    protected function setWayBillDocumentUrl(?string $waybillDocumentUrl)
    {
        $this->waybillDocumentUrl = $waybillDocumentUrl;
    }

    protected function setCourier($courier = [])
    {
        if (!$courier) {
            $courier = [];
        }
        if (!$courier instanceof Courier) {
            $courier = new Courier($courier);
        }
        $this->courier = $courier;
    }

    public function getOrderId(): int 
    {
        return $this->orderId;
    }

    public function getOrderName(): string 
    {
        return $this->orderName;
    }

    public function getCreatedDateTime(): string 
    {
        return $this->createdDateTime;
    }

    public function getFinishDateTime(): ?string 
    {
        return $this->finishDateTime;
    }

    public function getStatus(): string 
    {
        return $this->status;
    }

    public function getTotalWeight (): string 
    {
        return $this->totalWeightKg;
    }

    public function getIsClientNotificationEnabled(): bool 
    {
        return $this->isClientNotificationEnabled;
    }

    public function getIsContactPersonNotificationEnabled(): bool 
    {
        return $this->isContactPersonNotificationEnabled;
    }

    public function getLoadersCount(): int 
    {
        return $this->loadersCount;
    }

    public function getPaymentAmount(): string 
    {
        return $this->paymentAmount;
    }

    public function getDeliveryFeeAmount(): string 
    {
        return $this->deliveryFeeAmount;
    }

    public function getWeightFeeAmount(): string 
    {
        return $this->weightFeeAmount;
    }

    public function getInsuranceAmount(): string 
    {
        return $this->insuranceAmount;
    }

    public function getInsuranceFeeAmount(): string 
    {
        return $this->insuranceFeeAmount;
    }

    public function getLoadingFeeAmount(): string 
    {
        return $this->loadingFeeAmount;
    }

    public function getMoneyTransferFeeAmount(): string 
    {
        return $this->moneyTransferFeeAmount;
    }

    public function getSuburbanDeliveryFeeAmount(): string 
    {
        return $this->suburbanDeliveryFeeAmount;
    }

    public function getOvernightFeeAmount(): string 
    {
        return $this->overnightFeeAmount;
    }

    public function getDiscountAmount(): string 
    {
        return $this->discountAmount;
    }

    public function getCodFeeAmount(): string 
    {
        return $this->codFeeAmount;
    }

    public function getBackpaymentDetails(): ?string 
    {
        return $this->backpaymentDetails;
    }

    public function getBackpaymentPhotoUrl(): ?string 
    {
        return $this->backpaymentPhotoUrl;
    }

    public function getItineraryDocumentUrl(): ?string 
    {
        return $this->itineraryDocumentUrl;
    }

    public function getWayBillDocumentUrl(): ?string 
    {
        return $this->waybillDocumentUrl;
    }

    public function getPoints(): array
    {
        return $this->points;
    }

    public function getCourier(): Courier
    {
        return $this->courier;
    }
}