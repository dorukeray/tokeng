<?php
	interface DBInterface {
		public function setConnection(Connection $conn);
		public function query($dbQueryString);
	}
?>
