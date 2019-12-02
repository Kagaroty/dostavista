<?php

namespace Dostavista;

class ContactPerson extends AbstractModel
{
    /**
     * Номер телефона контактного лица на точке.
     * @var string|required
     */
    protected $phone;

    /**
     * Имя контактного лица на точке. Максимум 350 символов.
     * @var string|null
     */
    protected $name = null;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
}