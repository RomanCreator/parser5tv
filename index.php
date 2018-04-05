<?php
session_start();

spl_autoload_register(function ($name) {
    $name = str_replace('\\', '/', $name);
    require_once ('app/' . $name . '.php');
});

use parsers\MoscowFlatsParser;
use helpers\Request;

$request = new Request();

$MoscowFlats = new MoscowFlatsParser($request->getRequest());

$typesFlat = $MoscowFlats->getFlatsType();
$roomsAmountTypes = $MoscowFlats->getRoomsAmounts();
$apartments = $MoscowFlats->parseResults();
$pagination = $MoscowFlats->getPagination();

require_once 'templates/main.php';
