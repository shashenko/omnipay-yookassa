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

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class IncomingNotificationResponse extends AbstractResponse
{
    public function getTransactionId()
    {
        return $this->data['object']['metadata']['transactionId'] ?? null;
    }

    public function getTransactionReference()
    {
        return $this->data['object']['id'] ?? null;
    }

    public function isSuccessful()
    {
        return $this->getTransactionReference() !== null;
    }
}
