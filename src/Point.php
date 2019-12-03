<?php

namespace Dostavista;

use DateTime;

class Point extends AbstractModel
{

    /**
     * Полный адрес в формате: город, улица, дом. Максимум 350 символов.
     * @var string|required
     */
    protected $address;

    /**
     * Данные контактного лица на точке.
     * @var array|required
     */
    protected $contactPerson = [];

    /**
     * Внутренний номер заказа в интернет-магазине клиента. Максимум 350 символов.
     * @var string|null
     */
    protected $clientOrderId;

    /**
     * Координаты точки (широта).
     * @var float
     */
    protected $latitude;

    /**
     * Координаты точки (долгота).
     * @var float
     */
    protected $longitude;

    /**
     * Ожидаемое время прибытия курьера на адрес (от).
     * @var timestamp ISO 8601
     */
    protected $requiredStartDatetime;

    /**
     * Ожидаемое время прибытия курьера на адрес (до).
     * @var timestamp ISO 8601
     */
    protected $requiredFinishDatetime;

    /**
     * Сумма для получения от клиента на точке.
     * @var string
     */
    protected $takingAmount = '0.00';

    /**
     * Сумма выкупа на точке.
     * @var string
     */
    protected $buyoutAmount = '0.00';

    /**
     * Дополнительная информация о заказе для курьера: номер офиса или квартиры, название компании, с какой купюры сдача, габариты отправления.
     * @var null
     */
    protected $note;

    /**
     * Выплата денег курьеру будет произведена на этом адресе.
     * @var boolean
     */
    protected $isOrderPaymentHere = false;

    /**
     * Номер здания.
     * @var string|null
     */
    protected $buildingNumber;

    /**
     * Подъезд.
     * @var string|null
     */
    protected $entranceNumber;

    /**
     * Код домофона.
     * @var string|null
     */
    protected $intercomCode;

    /**
     * Этаж.
     * @var string|null
     */
    protected $floorNumber;

    /**
     * Квартира/офис.
     * @var string|null
     */
    protected $apartmentNumber;

    /**
     * Инструкция для курьера, как пройти до получателя на месте.
     * @var string|null
     */
    protected $invisibleMileNavigationInstructions;

    /**
     * Требуется ли выдать кассовый чек получателю на точке.
     * @var boolean
     */
    protected $isCodCashVoucherRequired = false;

    /**
     * Список товаров на точке.
     * @var array
     */
    protected $packages = [];

    public function __construct(string $address, $requiredStartDatetime, $requiredFinishDatetime, $contactPerson, array $config = [])
    {
        parent::__construct($config);
        $this->address                = $address;
        $this->requiredStartDatetime  = $requiredStartDatetime->format(DateTime::ATOM);
        $this->requiredFinishDatetime = $requiredFinishDatetime->format(DateTime::ATOM);

        if (!$contactPerson instanceof ContactPerson) {
            $contactPerson = new ContactPerson($contactPerson);
        }
        $this->contactPerson = $contactPerson;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function setClientOrderId(?string $clientOrderId): self
    {
        $this->clientOrderId = $clientOrderId;
        return $this;
    }

    protected function setLatitude(?float $latitude)
    {
        $this->latitude = $latitude;
    }

    protected function setLongitude(?float $longitude)
    {
        $this->longitude = $longitude;
    }

    public function setTakingAmount(?float $takingAmount): self
    {
        $this->takingAmount = $takingAmount;
        return $this;
    }

    public function setBuyoutAmount(?float $buyoutAmount): self
    {
        $this->buyoutAmount = $buyoutAmount;
        return $this;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;
        return $this;
    }

    public function setIsOrderPaymentHere(int $isOrderPaymentHere): self
    {
        $this->isOrderPaymentHere = $isOrderPaymentHere;
        return $this;
    }

    public function setBuildingNumber(?string $buildingNumber): self
    {
        $this->buildingNumber = $buildingNumber;
        return $this;
    }

    public function setEntranceNumber(?string $entranceNumber): self
    {
        $this->entranceNumber = $entranceNumber;
        return $this;
    }

    public function setIntercomCode(?string $intercomCode): self
    {
        $this->intercomCode = $intercomCode;
        return $this;
    }

    public function setFloorNumber(?string $floorNumber): self
    {
        $this->floorNumber = $floorNumber;
        return $this;
    }

    public function setApartmentNumber(?string $apartmentNumber): self
    {
        $this->apartmentNumber = $apartmentNumber;
        return $this;
    }

    public function setInvisibleMileNavigationInstructions(?string $invisibleMileNavigationInstructions): self
    {
        $this->invisibleMileNavigationInstructions = $invisibleMileNavigationInstructions;
        return $this;
    }

    public function setIsCodCashVoucherRequired(bool $isCodCashVoucherRequired): self
    {
        $this->isCodCashVoucherRequired = $isCodCashVoucherRequired;
        return $this;
    }

    public function setPackages($packages): self
    {
        foreach ($packages as &$package) {
            if (!$package instanceof Package) {
                $package = new Package($package);
            }
        }
        $this->packages = $packages;
        return $this;
    }
}