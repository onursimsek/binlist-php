<?php

namespace Binlist;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Binlist
{
    private $endpoint = 'https://lookup.binlist.net';

    private $bin;

    private $rawResponse;

    private $parsedResponse;

    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $type;

    private $brand;

    private $prepaid;

    private $country;

    private $currency;

    private $currencyCode;

    private $bank;

    private $digitLength;

    private $luhnValidation;

    private $client;

    /**
     * @var boolean
     */
    private $responseStatus;

    public function __construct($bin)
    {
        $this->bin = $bin;

        $this->getData();
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param mixed $scheme
     * @return Binlist
     */
    private function setScheme($scheme)
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Binlist
     */
    private function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     * @return Binlist
     */
    private function setBrand($brand)
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrepaid()
    {
        return $this->prepaid;
    }

    /**
     * @param mixed $prepaid
     * @return Binlist
     */
    private function setPrepaid($prepaid)
    {
        $this->prepaid = $prepaid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return Binlist
     */
    private function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     * @return Binlist
     */
    private function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param mixed $currencyCode
     * @return Binlist
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param mixed $bank
     * @return Binlist
     */
    private function setBank($bank)
    {
        $this->bank = $bank;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDigitLength()
    {
        return $this->digitLength;
    }

    /**
     * @param mixed $digitLength
     * @return Binlist
     */
    private function setDigitLength($digitLength)
    {
        $this->digitLength = $digitLength;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLuhnValidation()
    {
        return $this->luhnValidation;
    }

    /**
     * @param mixed $luhnValidation
     * @return Binlist
     */
    private function setLuhnValidation($luhnValidation)
    {
        $this->luhnValidation = $luhnValidation;
        return $this;
    }

    /**
     * @return object
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->responseStatus;
    }

    private function getData()
    {
        $this->parsedResponse = $this->sendRequest();

        if (!$this->isSuccess()) {
            return false;
        }

        $this->setScheme($this->parsedResponse->scheme)
            ->setType(!empty($this->parsedResponse->type) ? $this->parsedResponse->type : null)
            ->setBrand(!empty($this->parsedResponse->brand) ? $this->parsedResponse->brand : null)
            ->setPrepaid(!empty($this->parsedResponse->prepaid) ? $this->parsedResponse->prepaid : null)
            ->setCountry($this->parsedResponse->country)
            ->setCurrencyCode($this->parsedResponse->country->numeric)
            ->setCurrency(!empty($this->parsedResponse->country->currency) ? $this->parsedResponse->country->currency : null)
            ->setBank($this->parsedResponse->bank)
            ->setDigitLength(!empty($this->parsedResponse->number->length) ? $this->parsedResponse->number->length : null)
            ->setLuhnValidation(!empty($this->parsedResponse->number->luhn) ? $this->parsedResponse->number->luhn : null);
    }

    private function sendRequest()
    {
        try {
            $this->client = new Client([
                'headers' => [
                    'Accept-Version' => 3,
                ]
            ]);

            $this->rawResponse = $this->client->get($this->endpoint . '/' . $this->bin)->getBody()->getContents();
            $this->responseStatus = true;

            return json_decode($this->rawResponse);

        } catch (ClientException $e) {
            $this->responseStatus = false;
        }
    }

    public function __toString()
    {
        return $this->getBank()->name;
    }
}
