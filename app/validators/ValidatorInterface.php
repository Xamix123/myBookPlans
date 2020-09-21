<?php

namespace myBookPlans\app\validators;

interface ValidatorInterface
{
    public static function validateData($data, &$errors);
}
