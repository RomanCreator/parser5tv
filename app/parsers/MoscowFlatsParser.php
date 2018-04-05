<?php

namespace parsers;
use entities\TypeAmountRoom;
use entities\TypeFlat;
use entities\Apartments;
use helpers\Request;


class MoscowFlatsParser extends Parser {
    protected $mainUrl = 'http://50.bn.ru/sale/city/flats/';
    protected $mainEntityName = 'Apartments';

    protected $typeFlat = [];
    protected $roomsAmounts = [];

    public function parseResults() {
        if (empty($this->sourceResult)) {
            $this->get();
            $this->collectionEntities = [];
        }

        if (empty($this->collectionEntities)) {
            $sourceResult = str_replace("\n", '', $this->sourceResult);
            preg_match('/<div class=\"result\">(\s*?)<table>(.*?)<\/table>/', $sourceResult, $sourceResult);
            if (!empty($sourceResult[2])) {
                $sourceResult = $sourceResult[2];
                preg_match_all('/<tr([A-Za-z\(\)\=_\"\s]+)>(.)*?<\/tr>/', $sourceResult, $sourceResult);
                if (!empty($sourceResult[0])) {
                    $sourceResult = $sourceResult[0];
                    foreach ($sourceResult as $item) {
                        $params = [];
                        preg_match_all('/<td>(.*?)<\/td>/', $item, $params);
                        if (!empty($params[1])) {
                            $params = $params[1];
                            $address = '';
                            $amountPhoto = 0;
                            $rooms = 0;
                            $footage = '';
                            $floor = '';
                            $typeBuilding = '';
                            $price = 0;
                            $currency = 'руб.';

                            $namePhoto = [];
                            preg_match_all('/<a[a-zA-Z0-9\s"\/=_;]+?>(.*?)<\/a>/', $params[0], $namePhoto);
                            if (!empty($namePhoto[1])) {
                                $namePhoto = $namePhoto[1];
                                if (!empty($namePhoto[0])) {
                                    $address = $namePhoto[0];
                                }

                                if (!empty($namePhoto[1])) {
                                    $amountPhoto = $namePhoto[1];
                                }
                            }

                            $rooms = str_replace(" ", '', $params[1]);
                            $footage = str_replace(" ", '', $params[2]);
                            $floor = str_replace(" ", '', $params[3]);
                            if (!empty($params[4])) {
                                preg_match('/\"(.*?)\">/', $params[4], $typeBuilding);
                                if (!empty($typeBuilding[1])) {
                                    $typeBuilding = $typeBuilding[1];
                                } else {
                                    $typeBuilding = '';
                                }
                            }
                            $price = preg_replace('/[^\d]/', '', $params[5]);

                            $this->collectionEntities[] = new Apartments($address, $amountPhoto, $rooms, $footage,
                                $floor, $typeBuilding, $price, $currency);
                        }
                    }
                }
            }
        }

        return $this->collectionEntities;
    }

    public function getPagination() {
        if (empty($this->sourceResult)) {
            $this->get();
        }

        $pages = [];
        $sourceResult = str_replace("\n", '', $this->sourceResult);
        preg_match('/<div class=\"pager\"><div class=\"count\">(.*?)<b>(.*?)<\/b>(.*?)<b>(.*?)<\/b>/',
            $sourceResult, $pages);
        if (!empty($pages[4])) {
            $this->pagesAmount = (int) $pages[4];
        }

        $links = [];
        for ($i = 0; $i < $this->pagesAmount; $i++) {
            $position = $i * $this->paginationStep;
            $request = new Request($this->params);
            $request = $request->getPrepareRequestParams();
            if (!empty($request)) {
                $href = '/?' . $request . '&start=' . $position;
            } else {
                $href = '/?' . 'start=' . $position;
            }

            $links[] = '<a href="' . $href . '">' . ($i+1) . '</a>';
        }

        return $links;
    }

    public function getFlatsType() {
        if (empty($this->sourceResult)) {
            $this->get();
            $this->typeFlat = [];
        }

        if (empty($this->typeFlat)) {
            $typesFlatSource = [];
            preg_match('/\<select id="sct2" name="type" class="styled" style="display:none"\>(.|\n)*?\<\/select\>/',
                $this->sourceResult, $typesFlatSource);
            if (!empty($typesFlatSource[0])) {
                preg_match_all('/\<option value=\"([A-Za-z09\/\-\_]*)\"([A-Za-z\s]*)\>(.*?)\<\/option\>/', $typesFlatSource[0], $typesFlatSource);

                if (!empty($typesFlatSource[1]) && !empty($typesFlatSource[3])) {
                    $typeFlatValue = $typesFlatSource[1];
                    $typeFlatName = $typesFlatSource[3];

                    foreach ($typeFlatValue as $key => $value) {
                        $this->typeFlat[] = new TypeFlat($value, $typeFlatName[$key]);
                    }
                }
            }
        }

        return $this->typeFlat;
    }

    public function getRoomsAmounts() {
        if (empty($this->sourceResult)) {
            $this->get();
            $this->roomsAmounts = [];
        }

        if (empty($this->roomsAmounts)) {
            $roomsAmounts = [];
            preg_match('/\<div id=\"rooms\"\>(.|\n)*?\<\/div\>/', $this->sourceResult, $roomsAmounts);
            if (!empty($roomsAmounts[0])) {
                preg_match_all('/value=\"(\d*?)\"/', $roomsAmounts[0], $roomsAmounts);
                if (!empty($roomsAmounts[1])) {
                    $roomsAmounts = $roomsAmounts[1];
                    foreach ($roomsAmounts as $amount) {
                        $this->roomsAmounts[] = new TypeAmountRoom($amount);
                    }
                }
            }
        }

        return $this->roomsAmounts;
    }
}