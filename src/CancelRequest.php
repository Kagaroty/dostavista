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
     * @param int $substatusId Cancel reason. See SUBSTATUS_* constants
     */
    public function __construct(int $orderId)
    {
        parent::__construct();
        $this->orderId = $orderId;
    }
}