<?php
	//required Dorkodia interfaces.
	require_once "connection.interface.php";
	//dorkodia purposed mysql connection class for creating custom conn's.
	class MysqlConnection implements ConnectionInterface {
		private $connID;
		private $dbUser;
		private $dbName;
		private $dbPassword;
		private $dbHost;
		public $pdo;
		private $lastConnTimestamp;
		
		public function __construct($host, $db, $user, $pass) {
			$this->dbUser = $user;
			$this->dbName = $db;
			$this->dbHost = $host;
			$this->dbPassword = $pass;
			$this->connect();
		}
		
		protected function updateConnectionTimestamp() {
			$this->lastConnTimestamp = time();
			return $this->lastConnTimestamp;
		}
		
		//classical pdo connection with dorkodu style :D
		public function connect() {
		  try {
			$pdo = new PDO('mysql:host='.$this->dbHost.';dbname='.$this->dbName.';charset=utf8', $this->dbUser, $this->dbPassword);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo = $pdo;
			$this->updateConnectionTimestamp();
		  } catch (PDOException $e) {
			echo ">> Dorkodia Db Connection Failed : <br>".$e->getMessage();
		  } catch (Throwable $e) {
			echo ">> Dorkodia Db Connection Failed : <br>".$e->getMessage();
		  }
		}
	}
?>
