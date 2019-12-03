<?php

namespace Dostavista;

class BaseEvent extends AbstractModel
{
    /**
     * Order changed
     */
    const EVENT_ORDER_CHANGED = 'order_changed';

    protected $eventData;

    protected $event_datetime;
    protected $event_type;
    protected $order;

    public function __construct(array $eventData)
    {
        parent::__construct();

        $this->eventData = $eventData;
        
        $this->event_datetime = $this->event_datetime;
        $this->event_type     = $this->event_type;
        $this->order          = $this->order;
    }

    public function getSignature(): string
    {
        return json_encode($this->eventData);
    }

    public function getOrder(): array
    {
        return $this->eventData['order'];
    }

    public function asArray(): array
    {
        return $this->eventData;
    }

    public function asString(): string
    {
        return json_encode($this->eventData);
    }
}