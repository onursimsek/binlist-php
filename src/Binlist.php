<?php

namespace Binlist;

use GuzzleHttp\Client;

class Binlist
{
    private $endpoint = 'https://lookup.binlist.net';

    private $bin;

    private $response;

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

    private $bank;

    private $digitLength;

    private $luhnValidation;

    private $client;

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

    private function getData()
    {
        $this->response = $this->sendRequest();

        $this->setScheme($this->response->scheme)
            ->setType($this->response->type)
            ->setBrand($this->response->brand)
            ->setPrepaid($this->response->prepaid)
            ->setCountry($this->response->country)
            ->setCurrency($this->response->country->currency)
            ->setBank($this->response->bank)
            ->setDigitLength($this->response->number->length)
            ->setLuhnValidation($this->response->number->luhn);
    }

    private function sendRequest()
    {
        $this->client = new Client([
            'defaults' => [
                'verify' => false,
                CURL_SSLVERSION_DEFAULT => false,
            ],
            'headers' => [
                'Accept-Version' => 3,
            ]
        ]);

        return json_decode($this->client->get($this->endpoint . '/' . $this->bin)->getBody()->getContents());
    }

    public function __toString()
    {
        return $this->getBank()->name;
    }
}