Dostavista API client
=====================

Non-official PHP library for the dostavista.ru REST API

[![Latest Stable Version](https://poser.pugx.org/kagaroty/dostavista/version)](https://packagist.org/packages/kagaroty/dostavista)
[![Total Downloads](https://poser.pugx.org/kagaroty/dostavista/downloads)](https://packagist.org/packages/kagaroty/dostavista)
[![License](https://poser.pugx.org/kagaroty/dostavista/license)](https://packagist.org/packages/kagaroty/dostavista)

[API documentation](https://docs.google.com/document/d/1-yjBzfkI9Zb44kkQB_rMcq5pNeLThyD6YbvXR9wl7IY/edit?usp=sharing)

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
composer require kagaroty/dostavista
```

## Usage

```php
// Note, that we use sandbox API URL here, change to production one after tests 
$client = new \Dostavista\Dostavista(new \GuzzleHttp\Client, [
    'baseUrl' => 'https://robotapitest.dostavista.ru/api/business/1.1',
    'token' => '...'
]);
```

### Calculate order

```php
use Dostavista\OrderRequest;
use Dostavista\Point;

$orderRequest = (new OrderRequest('Весы'))
    ->setVehicleType(6)
    ->setBackpaymentDetails('Карта Сбербанка XXXX, получатель СЕРГЕЙ ИВАНОВИЧ П')
    ->setPoints([
        (new Point(
            'Москва, Магистральный пер., 1',
            new DateTime('17:00'),
            new DateTime('18:00'),
            '4951234567'
        )),
        (new Point(
            'Москва, Бобруйская, 28',
            new DateTime('18:00'),
            new DateTime('19:00'),
            '9261234567'
        ))
        ->setTaking(3000),
    ]);
    
$deliveryFee = $client->calculateOrder($orderRequest);
```

### Create order

```php
use Dostavista\OrderRequest;
use Dostavista\Point;

$orderRequest = (new OrderRequest('Весы'))
    ->setRequireCar(OrderRequest::DELIVERY_TYPE_FOOT)
    ->setBackpaymentMethod(OrderRequest::BACKPAYMENT_CARD)
    ->setBackpaymentDetails('Карта Сбербанка XXXX, получатель СЕРГЕЙ ИВАНОВИЧ П')
    ->setPoints([
        (new Point(
            'Москва, Магистральный пер., 1',
            new DateTime('17:00'),
            new DateTime('18:00'),
            '4951234567'
        ))
        ->setContactPerson('Менеджер Склада Иван')
        ->setNote('Комплекс "Сити-Бокс"'),
        
        (new Point(
            'Москва, Бобруйская, 28',
            new DateTime('18:00'),
            new DateTime('19:00'),
            '9261234567'
        ))
        ->setContactPerson('Анна Иванова')
        ->setNote('кв.66, домоф.1234')
        ->setTaking(3000),
    ]);
    
$orderId = $client->createOrder($orderRequest);
```

### Cancel order

```php
use Dostavista\CancelRequest;

$client->cancelOrder(new CancelRequest(
    123456,
    CancelRequest::SUBSTATUS_NOT_NEEDED
));
```
