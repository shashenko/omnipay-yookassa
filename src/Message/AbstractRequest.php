<?php
/**
 * Yoo.Kassa driver for Omnipay payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-yoo-kassa
 * @package   omnipay-yoo-kassa
 * @license   MIT
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\YooKassa\Message;

use Modules\PersonalAccount\Entities\YandexKassaPurchaseRequest;
use YooKassa\Client;

/**
 * Class AbstractRequest.
 *
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @var Client
     */
    protected $client;

    public function getShopId()
    {
        return $this->getParameter('shopId');
    }

    public function setShopId($value)
    {
        return $this->setParameter('shopId', $value);
    }

    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    public function getCapture()
    {
        return $this->getParameter('capture');
    }

    public function setCapture($value)
    {
        return $this->setParameter('capture', $value);
    }

    /**
     * Get the request receipt data.
     *
     * @return array
     */
    public function getReceipt()
    {
        return $this->getParameter('receipt');
    }

    /**
     * Sets the request receipt data.
     *
     * @param array $value
     * @return $this
     */
    public function setReceipt($value)
    {
        return $this->setParameter('receipt', $value);
    }

    public function setYooClient(Client $client): void
    {
        $this->client = $client;
    }
}
