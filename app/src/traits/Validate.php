<?php

declare(strict_types=1);

namespace src\traits;

use Respect\Validation\Validator as v;
use Respect\Validation\Rules;
use ReCaptcha\ReCaptcha;
use Ramsey\Uuid\Uuid;

trait Validate
{

    public function uuid_valid(string $uuid): bool
    {
        return Uuid::isValid($uuid);
    }

    public function email_valid(string $email): bool
    {
        return v::email()->validate($email);
    }

    public function contain(string $expectedValue, string $text): bool
    {
        return v::contains($expectedValue)->validate($text);
    }

    public function alpha(string $text): bool
    {
        return v::alpha(' ')->validate($text);
    }

    public function alphanum(string $text): bool
    {
        return v::alnum(' ')->validate($text);
    }

    public function cpf_valid(string $cpf): bool
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public function cnpj_valid(string $cnpj): bool
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    public function phone_valid(string $phone): bool
    {
        $phoneValidator = new Rules\AllOf(
            new Rules\Digit('(', ')', ' ', '-'),
            new Rules\Length(15, 15)
        );

        return $phoneValidator->validate($phone);
    }

    public function age_valid(string $age): bool
    {
        $ageValidator = new Rules\AllOf(
            new Rules\Digit(),
            new Rules\Length(2, 3)
        );

        return $ageValidator->validate($age);
    }

    public function number_valid(string $number): bool
    {
        return v::number()->validate($number);
    }

    public function cep_valid(string $cep): bool
    {
        return v::regex('/^[0-9]{5}-[0-9]{3}$/')->validate($cep);
    }

    public function state_valid(string $state): bool
    {
        $states = [
            "Acre", "Alagoas", "Amazonas", "Amapá", "Bahia", "Ceará", "Distrito Federal",
            "Espírito Santo", "Goiás", "Maranhão", "Minas Gerais", "Mato Grosso do Sul",
            "Mato Grosso", "Pará", "Paraíba", "Pernambuco", "Piauí", "Paraná",
            "Rio de Janeiro", "Rio Grande do Norte", "Rondônia", "Roraima", "Rio Grande do Sul",
            "Santa Catarina", "Sergipe", "São Paulo", "Tocantins"
        ];

        return v::containsAny($states)->validate($state);
    }

    public function city_valid(string $city): bool
    {
        $cityValidator = new Rules\AllOf(
            new Rules\Alpha(' ', '-', '\''),
            new Rules\Length(1, 255)
        );

        return $cityValidator->validate($city);
    }

    public function passwd_valid(string $password): bool
    {
        return v::regex('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[:;.+^#@$!%*?&])[A-Za-z\d:;.+^#@$!%*?&]{11,255}/')->validate($password);
    }

    public function equals(string $text1, string $text2): bool
    {
        return v::equals($text1)->validate($text2);
    }

    public function onlyText(string $text): bool
    {
        return v::regex('/[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]/')->validate($text);
    }

    public function recaptcha_valid(string $codeRecaptcha): bool
    {


        $recaptcha = new ReCaptcha(CONF_RECAPTCHA_PRIVATE_KEY);

        $response = $recaptcha
            ->setExpectedHostname(CONF_RECAPTCHA_HOSTNAME)
            ->setExpectedAction('registry')
            ->setScoreThreshold(CONF_RECAPTCHA_MINIMUN_SCORE)
            ->verify($codeRecaptcha, $_SERVER["REMOTE_ADDR"]);


        if ($response->isSuccess()) {
            // dump($response);
            return true;
        } else {
            // dump($response);
            return false;
        }
    }
}
