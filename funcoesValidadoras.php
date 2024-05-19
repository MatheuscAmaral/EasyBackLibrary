<?php
function formataString(string $string): string
{
    return $string = preg_replace('/\s+/', ' ', trim($string));
}

function stringLimiteTam(string $string, int $limite): bool
{
    if (strlen($string) <= $limite) {
        return true;
    } else {
        return false;
    }
}

function stringLimiteExatIgual(string $string, int $limite): bool
{
    if (strlen($string) == $limite) {
        return true;
    } else {
        return false;
    }
}

function retornaCampoTratado(mixed $string, int $limTam = null, int $limExt = null, string $campoNome, $formataString = true)
{
    $result = true;
    $message = '';

    try {
        if ($string == null) {
            throw new Exception("O campo $campoNome não foi informado.");
        }

        if ($formataString) {
            $string = formataString($string);
        }

        if (empty($string)) {
            throw new Exception("O campo $campoNome deve ser preenchido.");
        }

        if ($limTam != null) {
            if (!stringLimiteTam($string, $limTam)) {
                throw new Exception("O campo $campoNome ultrapassa o limite de caracteres de $limTam.");
            }
        }

        if ($limExt != null) {
            if (!stringLimiteExatIgual($string, $limExt)) {
                throw new Exception("O campo $campoNome deve ter exatamente $limExt caracteres.");
            }
        }

        $message = "Tudo OK";
    } catch (Exception $e) {
        $result = false;
        $message = $e->getMessage();
    }

    return array('result' => $result, 'message' => $message, 'string' => $string);
}
