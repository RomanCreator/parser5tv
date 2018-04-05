<?php

namespace helpers;


class EncodeConvertHelper {
    const WINDOWS_1251 = 'windows-1251';

    static public function toUTF8 ($fromEncode = '', $data = '') {
        return mb_convert_encoding($data, 'UTF-8', $fromEncode);
    }
}