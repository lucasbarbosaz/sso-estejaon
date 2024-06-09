<?php
	class Database {
		private $hostname = "localhost";
		private $database = "sso_db";
		private $username = "root";
		private $password = "";

		public static $pdo = null;
		
		public function __construct() {
			try {
				self::$pdo = new \PDO('mysql:charset=utf8;host=' . $this->hostname . ';dbname=' . $this->database, $this->username, $this->password, [
					\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
					\PDO::ATTR_PERSISTENT => true,
					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
					\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
				]);

				return self::$pdo;
			} catch (\PDOException $e) {           
				echo "ERROR: " . $e->getMessage();

				die();
			}
		}

		public function connection() {
			return self::$pdo;
		}
	}
?>