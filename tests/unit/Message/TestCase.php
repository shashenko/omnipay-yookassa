<?php
/**
 * Yoo.Kassa driver for Omnipay payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-yoo-kassa
 * @package   omnipay-yoo-kassa
 * @license   MIT
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\YooKassa\Tests\Message;

use Omnipay\YooKassa\Message\AbstractRequest;
use YooCheckout\Client;

class TestCase extends \Omnipay\Tests\TestCase
{
    protected function buildYooClient(string $shopId, string $secretKey): Client
    {
        $client = new Client();
        $client->setAuth($shopId, $secretKey);

        return $client;
    }

    protected function getCurlClientStub()
    {
        $clientStub = $this->getMockBuilder(Client\CurlClient::class)
                           ->setMethods(['sendRequest'])
                           ->getMock();

        return $clientStub;
    }

    protected function getYooClient(AbstractRequest $request): Client
    {
        $clientReflection = (new \ReflectionObject($request))->getProperty('client');
        $clientReflection->setAccessible(true);

        return $clientReflection->getValue($request);
    }

    protected function fixture(string $name): string
    {
        return file_get_contents(__DIR__ . '/fixture/' . $name . '.json');
    }
}
