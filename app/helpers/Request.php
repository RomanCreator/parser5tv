<?php

namespace helpers;


class Request {
    protected $request = [];

    public function __construct() {
        $this->request = $_REQUEST;
    }

    public function getRequest() {
        return $this->request;
    }

    public function getPrepareRequestParams() {
        return http_build_query($this->request, '', '&');
    }

    public function getRequestParamByKey($key = '') {
        if (!empty($this->request[$key])) {
            return $this->request[$key];
        }

        return '';
    }
}