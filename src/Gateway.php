<?php

namespace Omnipay\Bridgerpay;

use Omnipay\Bridgerpay\Message\CreateTransactionRequest;
use Omnipay\Bridgerpay\Message\FetchTransactionRequest;
use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Bridgerpay';
    }

    public function getDefaultParameters()
    {
        return [
            'merchant_id'   => '',
            'public_key'    => '',
            'private_key'   => '',
            'secret_key'    => '',
        ];
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchant_id');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchant_id', $value);
    }

    public function getPublicKey()
    {
        return $this->getParameter('public_key');
    }

    public function setPublicKey($value)
    {
        return $this->setParameter('public_key', $value);
    }

    public function getPrivateKey()
    {
        return $this->getParameter('private_key');
    }

    public function setPrivateKey($value)
    {
        return $this->setParameter('private_key', $value);
    }

    public function getSecretKey()
    {
        return $this->getParameter('secret_key');
    }

    public function setSecretKey($value)
    {
        return $this->setParameter('secret_key', $value);
    }

    public function createTransaction(array $parameters = [])
    {
        return $this->createRequest(CreateTransactionRequest::class, $parameters);
    }

    public function fetchTransaction(array $parameters = [])
    {
        return $this->createRequest(FetchTransactionRequest::class, $parameters);
    }

    /**
     * Check whether IPN callback has a valid signature
     *
     * @param $content - request payload ($request->getContent())
     * @param $hmacHeader - HMAC header ($request->header('HMAC'))
     * @return bool
     */
    public function isSignatureValid($content, $hmacHeader): bool
    {
        $hmac = hash_hmac('sha512', $content, $this->getSecretKey());
        return hash_equals($hmac, $hmacHeader);
    }
}
