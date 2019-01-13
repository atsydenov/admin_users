<?php

/**
 * Class DB
 * Connection to DB.
 */
class DB
{
    /**
     * @var array
     */
    private $params;

    /**
     * Path to parameters for connection to DB.
     */
    CONST PARAMS_PATH = ROOT . '/config/db.php';

    /**
     * DB constructor.
     */
    public function __construct()
    {
        $paramsPath = self::PARAMS_PATH;
        $this->params = include($paramsPath);
    }

    /**
     * Return connection to DB if success and false if fail.
     * @return bool|PDO
     */
    public function getConnection()
    {
        $params = $this->params;
        try {
            $dsn = sprintf('mysql:host=%s;dbname=%s', $params['host'], $params['dbname']);
            $db = new PDO($dsn, $params['username'], $params['password']);
            return $db;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
