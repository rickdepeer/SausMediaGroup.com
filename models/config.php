<?php

/**
 * Class db
 */
class db
{
    public $mysqli;

    /** db constructor.
     *      @param string $db_hostname
     *      @param string $db_username
     *      @param string $db_password
     *      @param string $db_database
     */
    function __construct($db_hostname = 'localhost', $db_username = 'conn_admin', $db_password = 'tBXUYSy8ymAeGMDu', $db_database = 'rick')
    {
        $this->mysqli = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
    }
}
