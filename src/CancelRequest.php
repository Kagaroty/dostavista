<?php

namespace Dostavista;

class CancelRequest extends AbstractModel
{
    /**
     * Полный номер заказа, который нужно отменить.
     * @var int
     */
    protected $orderId;

    /**
     * CancelRequest constructor.
     * @param int $orderId Order ID
     */
    public function __construct(int $orderId)
    {
        parent::__construct();
        $this->orderId = $orderId;
    }
}