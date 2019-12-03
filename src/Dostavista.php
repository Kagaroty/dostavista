<?php

namespace Dostavista;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class Dostavista
{
    use ConfigureTrait;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * Секретный авторизационный токен. Передается в HTTP заголовке запроса.
     * @var [type]
     */
    protected $token;

    /**
     * [$baseUrl description]
     * @var [type]
     */
    protected $baseUrl;

    /**
     * [__construct description]
     * @param ClientInterface $httpClient [description]
     * @param array           $config     [description]
     */
    public function __construct(ClientInterface $httpClient, array $config)
    {
        $this->httpClient = $httpClient;
        $this->configure($config);
    }

    /**
     * [parseResponse description]
     * @param  ResponseInterface $response [description]
     * @return [type]                      [description]
     */
    protected function parseResponse(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ParseException('JSON decode error: ' . json_last_error_msg());
        }
        if (!is_array($data)) {
            throw new ParseException('Response is not an array');
        }
        if ($data['is_successful'] === false) {
            if (isset($data['parameter_errors']['points']) && count($data['parameter_errors']['points']) > 0) {
                $context = [];
                foreach ($data['parameter_errors']['points'] as $pointNumber => $fields) {
                    $context[] = ['point_number' => $pointNumber, 'fields' => $fields];
                }
                throw new ValidationException($context);
            } elseif (isset($data['errors'], $data['errors'][0])) {
                throw new RequestException($data['errors'][0]);
            } else {
                throw new RequestException('Unknown request error');
            }
        }
        unset($data['is_successful']);
        return $data;
    }

    /**
     * [post description]
     * @param  string     $endPoint [description]
     * @param  Exportable $request  [description]
     * @return [type]               [description]
     */
    protected function post(string $endPoint, Exportable $request): array
    {
        try {
            $response = $this->httpClient->request('post', $this->baseUrl.'/'.$endPoint, [
                'headers' => [
                    'X-DV-Auth-Token' => $this->token,
                    'Content-Type'    => 'application/json'
                ],
                'json' => $request->export()
            ]);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
        }

        return $this->parseResponse($response);
    }

    /**
     * [get description]
     * @param  string $endPoint [description]
     * @param  array  $params   [description]
     * @return [type]           [description]
     */
    protected function get(string $endPoint, array $params = []): array
    {
        $response = $this->httpClient->request('get', $this->baseUrl.'/'.$endPoint, [
            'headers' => [
                'X-DV-Auth-Token' => $this->token,
            ],
            'query' => $params
        ]);

        return $this->parseResponse($response);
    }

    /**
     * @param OrderRequest $orderRequest
     *
     * @return float
     * @throws ParseException
     */
    public function calculateOrder(OrderRequest $orderRequest): float
    {
        $data = $this->post('calculate-order', $orderRequest);

        if (!isset($data['order']['payment_amount'])) {
            throw new ParseException('Invalid response: "payment_amount" key is missing. Response data: ' . json_encode($data));
        }

        return (float) $data['order']['payment_amount'];
    }

    /**
     * @param OrderRequest $orderRequest
     *
     * @return int Order ID
     * @throws ParseException
     */
    public function createOrder(OrderRequest $orderRequest): int
    {
        $data = $this->post('create-order', $orderRequest);

        if (!isset($data['order']['order_id'])) {
            throw new ParseException('Invalid response: "order_id" key is missing. Response data: ' . json_encode($data));
        }

        return (int) $data['order']['order_id'];
    }

    /**
     * @return array|Order[]
     * @throws ParseException
     */
    public function getOrders(array $params = []): array
    {
        $data = $this->get('orders', $params);

        if (!isset($data['orders'])) {
            throw new ParseException('Invalid response: "orders" key is missing. Response data: ' . json_encode($data));
        }

        $result = [];
        foreach ($data['orders'] as $orderData) {
            $result[] = new Order($orderData);
        }

        return $result;
    }

    /**
     * @param int $id
     * @param bool $showPoints
     *
     * @return Order
     * @throws ParseException
     */
    public function getOrder(int $id, array $params = []): Order
    {
        $data = $this->get('orders', ['order_id' => [$id]]);

        if (!isset($data['orders'])) {
            throw new ParseException('Invalid response: "order" key is missing. Response data: ' . json_encode($data));
        }

        return new Order($data['orders'][0]);
    }

    /**
     * @param CancelRequest $cancelRequest
     */
    public function cancelOrder(CancelRequest $cancelRequest)
    {
        return $this->post('cancel-order', $cancelRequest);
    }

    /**
     * [getCourier description]
     * @param  int    $order_id [description]
     * @return [type]           [description]
     */
    public function getCourier(int $order_id)
    {
        $data = $this->get('courier', ['order_id' => $order_id]);
        if (empty($data['courier'])) {
            return false;
        }

        return new Courier($data['courier']);
    }

    /**
     * [signEvent description]
     * @param  BaseEvent $event [description]
     * @return [type]           [description]
     */
    protected function signEvent(BaseEvent $event): string
    {
        return hash_hmac('sha256', $event->getSignature(), $this->token);
    }

    /**
     * [getEvent description]
     * @param  array  $eventData [description]
     * @return [type]            [description]
     */
    public function getEvent(array $eventData): BaseEvent
    {
        if (!isset($_SERVER['HTTP_X_DV_SIGNATURE'])) {
           throw new InvalidSignatureException('Signature not found. Event data: ' . json_encode($eventData));
        } 

        $event = new BaseEvent($eventData);
        if ($this->signEvent($event) != $_SERVER['HTTP_X_DV_SIGNATURE']) {
            throw new InvalidSignatureException('Could not validate received event. Event data: ' . json_encode($eventData));
        }

        return $event;
    }
    
    /**
     * Build order URL for order
     *
     * @param int $orderId Order identifier
     *
     * @return string Order URL
     */
    public function buildOrderUrl(int $orderId): string
    {
        return sprintf(
            'https://%s/cabinet-new/order-view/%u',
            parse_url($this->baseUrl, PHP_URL_HOST),
            $orderId
        );
    }
}
