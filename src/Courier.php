<?php

namespace Dostavista;

class Courier extends AbstractModel
{
    /**
     * Уникальный номер курьера.
     * @var int
     */
    protected $courierId ;

    /**
     * Имя курьера.
     * @var string
     */
    protected $name;

    /**
     * Контактный телефон курьера.
     * @var string
     */
    protected $phone;

    /**
     * Ссылка на фотографию курьера.
     * @var string
     */
    protected $photoUrl;
    
    /**
     * Координаты курьера (широта).
     * @var float
     */
    protected $latitude;

    /**
     * Координаты курьера (долгота).
     * @var float
     */
    protected $longitude;

    public function getCourierId(): ?int
    {
        return $this->courierId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }
}