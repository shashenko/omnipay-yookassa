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
use YooCheckout\Model\PaymentStatus;
use YooCheckout\Request\Payments\Payment\CreateCaptureResponse;

/**
 * Class CaptureResponse.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @property CreateCaptureResponse $data
 */
class CaptureResponse extends DetailsResponse
{
    protected function ensureResponseIsValid(): void
    {
        parent::ensureResponseIsValid();

        if ($this->getState() !== PaymentStatus::SUCCEEDED) {
            throw new InvalidResponseException(sprintf('Failed to capture payment "%s"', $this->getTransactionReference()));
        }
    }
}
