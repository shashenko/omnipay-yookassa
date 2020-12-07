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
use YooKassa\Model\PaymentStatus;
use YooKassa\Request\Payments\Payment\CreateCaptureResponse;

/**
 * Class CaptureResponse.
 *
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
