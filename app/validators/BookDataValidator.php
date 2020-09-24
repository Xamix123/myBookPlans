<?php

namespace myBookPlans\app\validators;

class BookDataValidator implements ValidatorInterface
{

    /**
     * validate image
     *
     * @param $filePath
     *
     * @return bool
     */
    private static function validateImageData($filePath)
    {
        $result = false;
        if (is_file($filePath) && ((exif_imagetype($filePath) == IMAGETYPE_JPEG)
                || (exif_imagetype($filePath) == IMAGETYPE_PNG))) {
            $result = true;
        }

        return $result;
    }

    /**
     * @param $data
     * @return string
     */
    public static function validateTextData($data)
    {

        $data = trim($data);
        $data = html_entity_decode($data);
        $data = htmlspecialchars_decode($data, ENT_NOQUOTES);

        return $data;
    }

    /**
     * validate data array
     *
     * @param $data
     * @param $errors
     */
    public static function validateData($data, &$errors)
    {
        if (empty($data['title'])) {
            $errors[] .= 'Поле "Название" не может быть пустым';
        }

        if (empty($data['author'])) {
            $errors[] .= 'Поле "Автор" не может быть пустым';
        }

        if (empty($data['publishingHouse'])) {
            $errors[] .= 'Поле "Издательство" не может быть пустым';
        }

        if ($data['img']['error'] != UPLOAD_ERR_NO_FILE) {
            if (! empty($data['img']['error'])
                && (!self::validateImageData($data['img']['tmp_name']))) {
                $errors[] .= 'Недопустимый формат изображение поддерживаються только файлы с расширением .jpg или .png';
            }
        }
    }
}
