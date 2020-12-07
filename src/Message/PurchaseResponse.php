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

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use YooKassa\Model\Confirmation\ConfirmationRedirect;
use YooKassa\Request\Payments\CreatePaymentResponse;

/**
 * Class PurchaseResponse.
 *
 * @property CreatePaymentResponse $data
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function getRedirectUrl()
    {
        $confirmation = $this->data->getConfirmation();
        if (!$confirmation instanceof ConfirmationRedirect) {
            throw new InvalidResponseException('Only redirect confirmation is supported');
        }

        return $confirmation->getConfirmationUrl();
    }

    public function getTransactionReference()
    {
        return $this->data->getId();
    }

    public function getTransactionId()
    {
        return $this->data->getMetadata()['transactionId'] ?? null;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return [];
    }
}
