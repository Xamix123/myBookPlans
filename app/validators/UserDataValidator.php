<?php

namespace myBookPlans\app\validators;

use myBookPlans\app\models\User;

class UserDataValidator implements ValidatorInterface
{
    /**
     * @param string $name
     *
     * @return bool
     */
    private static function checkName($name)
    {
        /* данное регулярное выражение проверяет что входная строка состоит только из символов
        исключая цифры и любые другие спец символы */

        return (strlen($name)>= 2) && preg_match("/^([А-ЯЁа-яё\s]+|[A-Za-z\s]+)$/iu", $name);
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    private static function checkEmail($email)
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Validate password
     *
     * @param string $password
     *
     * @return bool
     */
    private static function checkPassword($password)
    {
        return strlen($password) >= 6;
    }

    /**
     * @param array $data
     * @param array $errors
     * example data
     * data {
     *  'name' => exampleName,
     *  'password' => examplePass,
     *  'email' => exampleEmail@gmail.com
     * }
     */
    public static function validateData($data, &$errors)
    {
        if (!UserDataValidator::checkName($data['name'])) {
            $errors[] = 'ФИО не валидно. 
            ФИО должно содержать более 2-х символов.
            ФИО не может содержать спец символов или цифр';
        }

        if (!UserDataValidator::checkPassword($data['password'])) {
            $errors[] = 'Пароль не валиден. Пароль не должен быть короче 6-ти символов';
        }

        if (!UserDataValidator::checkEmail($data['email'])) {
            $errors[] = 'Email не валиден';
        }

        if (USER::checkEmailExists($data['email'])) {
            $errors[] = 'Пользователь с таким email уже зарегестрирован';
        }
    }
}
