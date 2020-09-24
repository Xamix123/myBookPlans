<?php
/**
 * Created by PhpStorm.
 * User: maksi
 * Date: 23.09.2020
 * Time: 15:25
 */

namespace myBookPlans\app\models;

class Image
{

    /**
     * Get Image extension
     *
     * @param $filePath
     *
     * @return string
     */
    public static function getImageExtension($filePath)
    {
        $result = "";
        if (exif_imagetype($filePath) == IMAGETYPE_JPEG) {
            $result = ".jpg";
        } elseif (exif_imagetype($filePath) == IMAGETYPE_PNG) {
            $result = ".png";
        }

        return $result;
    }

    /**
     * Get Image path
     *
     * @param int $bookId
     * @param string $path
     *
     * @return string
     */
    public static function getImagePath($bookId, $path)
    {
        $result = "";

        if (is_file(ROOT . $path . $bookId . ".jpg")) {
            $result = $path . $bookId . ".jpg";
        } elseif (is_file(ROOT . $path . $bookId . ".png")) {
            $result = $path . $bookId . ".png";
        } else {
            $result = $path . "no-image.png";
        }

        return $result;
    }

}
