<?php

class Database
{
    private static $conn;

    public static function conectar()
    {
        if (!self::$conn) {
            self::$conn = new PDO(
                "pgsql:host=127.0.0.1;port=55432;dbname=crud_series",
                "postgres",
                "",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }

        return self::$conn;
    }
}
