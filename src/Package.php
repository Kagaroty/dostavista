<?php

namespace Dostavista;

class Package extends AbstractModel
{
    /**
     * Артикул товара. Максимум 255 символов.
     * @var string|required
     */
    protected $wareCode;

    /**
     * Описание товара. Максимум 1000 символов.
     * @var string|required
     */
    protected $description;

    /**
     * Количество товаров.
     * @var float|required
     */
    protected $itemsCount;

    /**
     * Сумма оплаты за единицу товара.
     * @var string
     */
    protected $itemPaymentAmount;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function getWareCode(): string
    {
        return $this->wareCode;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }

    public function getItemsCount(): float
    {
        return $this->itemsCount;
    }

    public function getItemPaymentAmount(): string
    {
        return $this->itemPaymentAmount;
    }
}