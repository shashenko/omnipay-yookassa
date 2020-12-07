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

use Omnipay\YooKassa\Message\CaptureRequest;
use Omnipay\YooKassa\Message\CaptureResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CaptureRequestTest extends TestCase
{
    /** @var CaptureRequest */
    private $request;

    private $shopId               = '717161';
    private $secretKey            = 'test_jcOVYyyyloYVdkuJq6-_Z9Mh0yxwpXEDBbaSf2tqfGI';
    private $transactionReference = '275eeffd-000f-5000-8000-150dec00cdb0';
    private $transactionId        = '5ce3cdb0d1436';
    private $amount               = '187.50';
    private $currency             = 'RUB';

    public function setUp()
    {
        parent::setUp();

        $httpRequest = new HttpRequest();
        $this->request = new CaptureRequest($this->getHttpClient(), $httpRequest);
        $this->request->initialize([
            'yooClient' => $this->buildYooClient($this->shopId, $this->secretKey),
            'shopId' => $this->shopId,
            'secret' => $this->secretKey,
            'transactionReference' => $this->transactionReference,
            'transactionId' => $this->transactionId,
            'amount' => $this->amount,
            'currency' => $this->currency,
        ]);
    }

    public function testGetData(): void
    {
        $data = $this->request->getData();
        $this->assertEmpty($data);
    }

    public function testSendData(): void
    {
        $curlClientStub = $this->getCurlClientStub();
        $curlClientStub->method('sendRequest')->willReturn([
            [],
            $this->fixture('payment.succeeded'),
            ['http_code' => 200],
        ]);

        $this->getYooClient($this->request)
             ->setApiClient($curlClientStub)
             ->setAuth($this->shopId, $this->secretKey);

        $response = $this->request->sendData([]);
        $this->assertInstanceOf(CaptureResponse::class, $response);
    }
}
