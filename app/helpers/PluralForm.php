<?php

namespace helpers;


class PluralForm
{
    static public function plural($pluralForms = [], $numeral) {
        $plural = ($numeral % 10 == 1 && $numeral % 100 != 11 ? 0 : ($numeral % 10 >= 2 && $numeral % 10 <= 4 &&
        ( $numeral % 100 < 10 || $numeral % 100 >= 20) ? 1 : 2));
        if (!empty($pluralForms[$plural])) {
            return $pluralForms[$plural];
        }

        throw new Exception('error plural form, index not found');
    }
}