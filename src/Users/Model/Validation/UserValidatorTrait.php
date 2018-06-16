<?php

namespace Users\Model\Validation;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira@univicosa.com.br>
 */
trait UserValidatorTrait
{
    /**
     * @param string $name
     * @param string $lastName
     * @param array  $groups
     *
     * @throws \Exception
     */
    public function validate(
        string $name,
        string $lastName,
        array $groups = []
    ) {
        $this->isEmpty($name);
        $this->isEmpty($lastName);

        $this->nameValidate($name);
        $this->lastNameValidate($lastName);

        if (count($groups) <= 1) {
            throw new \Exception('Você deve informar no mínimo 2 grupos');
        }
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function isEmpty(string $value) : bool
    {
        return empty($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     * @throws \Exception
     */
    private function nameValidate(string $value) : bool
    {
        if (strlen($value) <= 2 || strlen($value) > 50) {
            throw new \Exception('"Nome" deve conter no mínimo 3 e no máximo 50 caracteres', 0);
        }

        return true;
    }

    /**
     * @param string $value
     *
     * @return bool
     * @throws \Exception
     */
    private function lastNameValidate(string $value) : bool
    {
        if (strlen($value) < 3 || strlen($value) > 100) {
            throw new \Exception('"Sobrenome" deve conter no mínimo 3 e no máximo 100 caracteres', 1);
        }

        return true;
    }
}
