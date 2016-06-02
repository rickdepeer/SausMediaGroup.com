<?php
/** The Saus Framework PHP 2015 ©
 *
 *  Login Module BETA v002
 *
 *
 *      NOTE:
 *
 *      TO CREATE INSTANCE USE:
 *
 *      $login = SessionLogin::getInstance();
 *      $login->login($tableName, $username, $password);
 *
 */
class SessionLogin
{
	private static $instance;
	protected $mysqli; //Conection object : mysqli
	protected $error; //Error Colection : string
	protected $mysqlError; //Error

	/** Singleton Principal implemented Class
	 *
	 *      Only 1 instance can be created
	 *      (^creation details noted above^)
	 */
	private function __construct()
	{
		$this->databaseLink();
	}

	public static function getInstance()
	{
		if (static::$instance === NULL)
		{
			static::$instance = new static();
		}
		return static::$instance;
	}



	/** Function for connection to database
	 *	This is done for consistent connection obj
	 *
	 *  	@param string $db_hostname
	 * 		@param string $db_username
	 * 		@param string $db_password
	 * 		@param string $db_database
	 */
	public function databaseLink()
	{
		require_once("config.php");
		$mysqli = new db();
		$this->mysqli = $mysqli;
	}



	/** Function for logging in
	 *
	 * 		@param $tableName
	 * 		@param $username
	 * 		@param $password
	 *
	 * 		@return bool : true || false
	 */
	public function login($tableName, $username, $password)
	{
		var_dump($tableName, $username, $password, "<br>");

		$mysqli = $this->mysqli;
		if (!empty($password))
		{
			$password = md5($password);
			$passCheck = true;
		}
		else
		{
			$passCheck = false;
		}

		if (!empty($username) && $passCheck == true)
		{
			if (!isset($_SESSION["username"]))
			{
				$SQLquery = "SELECT * FROM $tableName WHERE $tableName.username = '$username' AND $tableName.password = '$password'";
				$SQLresult = mysqli_query($mysqli, $SQLquery);

				if ($row = mysqli_fetch_array($SQLresult)) {
					session_start();

					$_SESSION["username"] = $username;
					$_SESSION["password"] = $password;
					$_SESSION["recht"] = $row["recht"];

					$bool = true;
				}
				else
				{
					$this->error .= "StartQ&RError&raquo;Couldn't Finish Request.<br>Query: &raquo;".$SQLquery."&laquo; Result: &raquo;".$SQLresult."&laquo; &laquo;EndQ&RError<br>";

					$bool = false;
				}
			}
			else
			{
				$this->error .= "StartSessionError&raquo;Name Already Exist In Session: ".$_SESSION["username"]."&laquo;EndSessionError<br>";

				$bool = false;
			}
		}
		else
		{
			$this->error .= "StartParam&raquo; usr: ".$username." pass: ".$password."&laquo;EndParamError<br>";

			$bool = false;
		}
		$this->mysqlError = mysqli_error();
		echo mysqli_error();
		return $bool; //Returns result bool : true || false
	}

	/**	Function for any error that may have occurred
	 *	Use only for development and debugging
	 *
	 * 		@return string : error message
	 */
	public function login_error()
	{
		if (empty($this->error))
		{
			$this->error = "Er is geen error. <br>";
		}
		else
		{
			$this->error .= "StartSQLError&raquo;".$this->mysqlError."&laquo;EndSQLErrorError</br>";
		}
		return $this->error;
	}
}