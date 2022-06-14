<?php

require_once("../config.php");

class UrlShortener
{
    protected $db;

    public function __construct()
    {
        $this->db = new mysqli(HOST_NAME, USER_NAME, USER_PASSWORD, DB_NAME);

        if ($this->db->connect_error) {
            header("Location: ../index.php?error=db");
            die();
        }
    }

    /**
     * random generate url
     */

    public function generateUniqueUrl($idOfRow)
    {
//        $abc = 'abcdefghijklmnopqrstuvwxyzABCDFEGHIJKLMNOPRSTUVWXYZ0123456789';
//        $new_abc = str_split($abc);
//        $idOfRow = '';

        $idOfRow += 10000000;
        return base_convert($idOfRow, 10, 36);
    }


    public function validateUrlAndReturnCode($orignalURL)
    {
        $orignalURL = trim($orignalURL);

        if (!filter_var($orignalURL, FILTER_VALIDATE_URL)) {
            header("Location: ../index.php?error=nourl");
            die();
        } else {
            $orignalURL = $this->db->real_escape_string($orignalURL);
            $existInDatabase = $this->db->query("SELECT * FROM link WHERE url ='{$orignalURL}'");

            if ($existInDatabase->num_rows) {
                $uniqueCode = $existInDatabase->fetch_object()->code;

                return $uniqueCode;
            }

            $insertInDatabase = $this->db->query("INSERT INTO link (url,created) VALUES ('{$orignalURL}',NOW())");
            $fetchFromDatabase = $this->db->query("SELECT * FROM link WHERE url = '{$orignalURL}'");
            $getIdOfRow = $fetchFromDatabase->fetch_object()->id;
            $uniqueCode = $this->generateUniqueUrl($getIdOfRow);
            $updateInDatabase  = $this->db->query("UPDATE link SET code = '{$uniqueCode}' WHERE url = '{$orignalURL}'");

            return $uniqueCode;
        }
    }


    public function getOriginalURL($url)
    {
        $url = $this->db->real_escape_string(strip_tags(addslashes($url)));

    }

    /**
     * Generate tag link for short url
     */

    public function generateLinkForShortURL($uniqueCode,$originalURL)
    {
        return '<a href="' . $originalURL  .'">' . BASE_URL . $uniqueCode . '</a>';
    }
}

