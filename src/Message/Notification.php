<?php

namespace Omnipay\YooKassa\Message;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\ResponseInterface;
use YooKassa\Model\PaymentStatus;

class Notification implements NotificationInterface
{
    /**
     * @var ResponseInterface|IncomingNotificationResponse
     */
    private $response;

    /**
     * @param ResponseInterface|IncomingNotificationResponse $response
     */
    public function __construct(ResponseInterface $response) {
        $this->response = $response;
    }

    /**
     * @return string|null
     */
    public function getTransactionReference() {
        return $this->response->getTransactionReference();
    }

    /**
     * @return string
     */
    public function getTransactionStatus() {
        $data = $this->response->getData();
        $status = $data['object']['status'] ?? null;

        if (!$status || !PaymentStatus::valueExists($status)) {
            throw new RuntimeException('Invalid status returned by gateway');
        }

        switch ($status) {
            case PaymentStatus::SUCCEEDED:
                return NotificationInterface::STATUS_COMPLETED;
            case PaymentStatus::CANCELED:
                return NotificationInterface::STATUS_FAILED;
            case PaymentStatus::PENDING:
            case PaymentStatus::WAITING_FOR_CAPTURE:
            default:
                return NotificationInterface::STATUS_PENDING;
        }
    }

    /**
     * @return string|null
     */
    public function getMessage() {
        return $this->response->getMessage();
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->response->getData();
    }
}
