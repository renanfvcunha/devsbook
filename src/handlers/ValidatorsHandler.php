<?php

namespace src\handlers;

class ValidatorsHandler
{
    public static function birthdateValidator($birthdate)
    {
        $birthdate = explode('/', $birthdate);
        // Verificando se a data possui os três campos
        if (count($birthdate) !== 3) {
            return false;
        }
        // Verificando se a data informada está no formato correto
        if (!checkdate($birthdate[1], $birthdate[0], $birthdate[2])) {
            return false;
        }
        // Verificando se o ano de nascimento está abaixo do ano atual
        // e acima de 120 anos antes do ano atual
        if ($birthdate[2] < date('Y') - 120 || $birthdate[2] > date('Y')) {
            return false;
        }

        $birthdate = $birthdate[2] . '-' . $birthdate[1] . '-' . $birthdate[0];

        return $birthdate;
    }
}
