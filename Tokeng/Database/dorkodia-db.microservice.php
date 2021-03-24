<?php
	require_once "db.interface.php";
	require_once "mysql.class.php";

	class DorkodiaDB implements DBInterface {

		//default db connection of dorkodia
		protected $defaultHost = "localhost";
		protected $defaultPass = "c0deordie";
		protected $defaultUser = "root";
		protected $defaultDb = "dorkodia";
		protected $connection;

		public function __construct () {
			$this->connection = new MysqlConnection($this->defaultHost, $this->defaultDb, $this->defaultUser, $this->defaultPass);
		}

		//dışarıda mysqlconn tanımlayıp içine atcam
		public function setConnection(Connection $conn) {
			try {
				$this->connection = $conn;
				return $this->connection;
			} catch(Throwable $e) {
				return false;
			}
		}

		//standard pdo querying without any security hesitations, good... go on man.
		public function query($sql) {
			try {
				$this->connection->pdo->query($sql);
				return true;
			} catch(Throwable $e) {
				echo $e->getMessage();
				return false;
			}
		}

		public function prepareStatement($sql, $params = array()) {
			try {
			  $stmt = $this->connection->pdo->prepare($sql);
			  $stmt->execute($params);
			  return $stmt;
			} catch(Throwable $e) {
				return false;
			}
		}

		public function sude($sql, $params = array()) {
			try {
				$stmt = $this->connection->pdo->prepare($sql);
				$stmt->execute($params);
				return $stmt;
			} catch(Throwable $e) {
				return false;
			}
		}

/*  bunu bulamayanlar da var, eee neden mi israf ediyorum?
 		çünkü tam 4 gün bunun buglarıyla uğraştım. aman abicim sakın denemeyin.
		görünürde ogubugucuuu cici bebiş, ama içinde chuckky var (bir çeşit öcü :D ).

		public function sude($sql, $params = array()) {
		  $stmt = $this->connection->pdo->prepare($sql);
		  foreach ($params as $key => $value) {
				$stmt->bindParam($key, $value);
		  }
		  $stmt->execute();
		  return $stmt;
		}
		*/
	}
