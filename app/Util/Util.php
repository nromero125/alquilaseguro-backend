<?php

namespace App\Util;

/**
 * Class Util
 */
class Util
{
    /**
     * Validate a dominican id
     * @param string $id
     * @return bool
     */
    public static function isValid(string $id): bool
    {
        $c            = str_replace("-", "", $id);
        $cedula       = substr($c, 0,  - 1);
        $verificador  = substr($c, - 1, 1);
        $suma         = 0;

        if (strlen($id) < 11) return false;

        for ($i = 0; $i < strlen($cedula); $i++) {

            $mod = "";

            if (($i % 2) == 0) {
                $mod = 1;
            } else {
                $mod = 2;
            }

            $res = substr($cedula, $i, 1) * $mod;

            if ($res > 9) {
                $res = (string) $res;
                $uno = substr($res, 0, 1);
                $dos = substr($res, 1, 1);

                $res = $uno + $dos;
            }

            $suma += $res;

        }

        $el_numero = (10 - ($suma % 10)) % 10;

        return $el_numero == $verificador && !str_starts_with($cedula, "000");
    }
}
