<?php

namespace parsers;

use helpers\EncodeConvertHelper;

abstract class Parser {
    protected $userAgent = 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:36.0) Gecko/20100101 Firefox/36.0';
    protected $mainUrl;
    protected $mainEntityName;
    protected $paginationStep = 50;
    protected $pagesAmount = 0;

    protected $sourceResult;
    protected $collectionEntities = [];
    protected $params = [];

    public function __construct($params = []) {
        $this->params = $params;
    }

    abstract public function parseResults();

    protected function get() {
        $queryString = $this->prepareRequestData($this->params);
        $this->curlGet($queryString);
    }

    protected function prepareRequestData($params = []) {
        $queryString = $this->mainUrl . '?' . http_build_query($params, '', '&');
        return $queryString;
    }

    protected function curlGet($queryString) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $queryString);
        $this->sourceResult = curl_exec($curl);
        $this->sourceResult  = EncodeConvertHelper::toUTF8(EncodeConvertHelper::WINDOWS_1251, $this->sourceResult);
        curl_close($curl);
    }
}