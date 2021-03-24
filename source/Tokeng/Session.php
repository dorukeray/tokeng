<?php
	//Dorkodia session class (or a new nanoservice?!)

	session_start();

	class Session {
	
		protected $SESSID;
		protected $userID;
		protected $timestamp;
		protected $uniqToken;

		//dahili gereksinimler
		protected $dorkodiaDB;
		protected $sessionlogger;

		public function __construct() {
			$this->dorkodiaDB = new DorkodiaDB();
			$this->sessionlogger = new Log();
		}

		public function setSession($sessid, $userid, $ip, $useragent, $uniqtoken) {
			$this->timestamp = time();
			$this->SESSID = $sessid;
			$this->userID = $userid;
			$this->IP = $ip;
			$this->userAgent = $useragent;
			$this->uniqToken = $uniqtoken;
		}

		//simple php session variable function which soon to be
		// turned into an exclusive, state-of-art, revolutionary session nanoservice
		public function setWebSession($key, $value) {
		  try {
				$_SESSION[$key] = $value;
			return true;
		  } catch (Exception $e) {
			return false;
		  }
		}

		public function saveCurrentSessionToDB() {
			$sql = "INSERT INTO sessions (session_id, session_userID, session_IP, session_userAgent, session_uniqToken) VALUES ('{$this->SESSID}', '{$this->userID}', '{$this->IP}', '{$this->userAgent}' , '{$this->uniqToken}');";
			return $this->dorkodiaDB->query($sql);
		}

		public function getWebSession($key) {
			if(isset($_SESSION[$key])) {
				return $_SESSION[$key];
			} else {
				return false;
			}
		}

		public function isWebSessionSet($key) {
			return isset($_SESSION[$key]) ? true : false;;
		}

		public function getSessionBySESSID($sessid) {
			$sql = "SELECT * FROM sessions WHERE session_id=:sessid LIMIT 1;";
			$stmt = $this->dorkodiaDB->sude($sql, array(':sessid' => $sessid));
			if ($stmt->rowCount()) {
				while ($neuSession = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$this->setSession($neuSession['session_id'], $neuSession['session_userID'], $neuSession['session_IP'], $neuSession['session_userAgent'], $neuSession['session_uniqToken']);
				}
			} else {
				return false;
			}
		}

		public function getSessionByUniqToken($jeton) {
			$sql = "SELECT * FROM sessions WHERE session_uniqToken=:jeton LIMIT 1;";
			$stmt = $this->dorkodiaDB->sude($sql, array(':jeton' => $jeton));
			if ($stmt->rowCount()) {
				while ($neuSession = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$this->setSession($neuSession['session_id'], $neuSession['session_userID'], $neuSession['session_IP'], $neuSession['session_userAgent'], $neuSession['session_uniqToken']);
				}
			} else {
				return false;
			}
		}

		public function getSessionByIP($ip) {
			$sql = "SELECT * FROM sessions WHERE session_IP=:ip LIMIT 1;";
			$stmt = $this->dorkodiaDB->sude($sql, array(':ip' => $ip));
			if ($stmt->rowCount()) {
				while ($neuSession = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$this->setSession($neuSession['session_id'], $neuSession['session_userID'], $neuSession['session_IP'], $neuSession['session_userAgent'], $neuSession['session_uniqToken']);
				}
			} else { return false; }
		}

		public function getSessionByUserId($userid) {
			$sql = "SELECT * FROM sessions WHERE session_userID=:uid LIMIT 1;";
			$stmt = $this->dorkodiaDB->sude($sql, array(':uid' => $userid));
			if ($stmt->rowCount()) {
				while ($neuSession = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$this->setSession($neuSession['session_id'], $neuSession['session_userID'], $neuSession['session_IP'], $neuSession['session_userAgent'], $neuSession['session_uniqToken']);
				}
			} else { return false; }
		}

		public function getSessionByWeb() {
			if($this->isSessionExistInWeb()) {
				$sess = new self();
				$sess->setSession($this->getWebSession('dorkodia_SESSID'), $this->getWebSession('dorkodia_userID'), $this->getWebSession('dorkodia_IP'), $this->getWebSession('dorkodia_uniqToken'), $this->getWebSession('dorkodia_userAgent'), $this->getWebSession('dorkodia_sessionTimestamp'));
				return $sess;
			} else {
				return false;
			}
		}

		public function isThisSessionEmpty() {
			if(empty($this->SESSID) || empty($this->userID) || empty($this->timestamp) || empty($this->IP) || empty($this->uniqToken) || empty($this->userAgent))
				return true;
			else
				return false;
		}

		public function isSessionExistInWeb() {
			if($this->isWebSessionSet('dorkodia_SESSID') && $this->isWebSessionSet('dorkodia_userID') && $this->isWebSessionSet('dorkodia_IP') && $this->isWebSessionSet('dorkodia_timestamp') && $this->isWebSessionSet('dorkodia_uniqToken') && $this->isWebSessionSet('dorkodia_userAgent'))
				return true;
			 else
				return false;
		}

		public function saveSessionToWeb() {
			$this->setWebSession('dorkodia_SESSID', session_id());
			$this->setWebSession('dorkodia_userID', $this->userID);
			$this->setWebSession('dorkodia_IP', $this->IP);
			$this->setWebSession('dorkodia_sessionTimestamp', time());
			$this->setWebSession('dorkodia_uniqToken', $this->uniqToken);
			$this->setWebSession('dorkodia_userAgent', $this->userAgent);
		}

		public function startTheSession() {
			//dediğim anda vtye kaydet, web'e kaydet, logla ve nesneyi hazırla
			//şunun için --> mevcut oturum varsa onu yok et.
			$tempSess = new self();
			if(!$tempSess->getSessionByIP($this->IP)) {
				if(!$tempSess->getSessionBySESSID($this->SESSID)) {
					if(!$tempSess->getSessionByUserId($this->userID)) {
						if(!$tempSess->getSessionByUniqToken($this->uniqToken)) {
							//not problem, so start the session now xxD
							$this->saveSessionToWeb(); //web
							$this->saveCurrentSessionToDB(); //vt ve log
							$this->sessionlogger->writeLog("session-log-".date("Y-m-d").".log", "SESSION", "SESSID: {$this->SESSID} UserID: {$this->userID} IP: {$this->IP} Time: ".date('d.m.Y H:i:s')." User-Agent: {$this->userAgent} UniqToken: {$this->uniqToken}");
		
						} else
							$tempSess->terminateSession();
					} else
						$tempSess->terminateSession();
				} else
					$tempSess->terminateSession();
			} else
				$tempSess->terminateSession();
		}

		public function terminateSession() {
				$this->removeSessionFromDb($this);
				$this->destroyAllWebSession();
		}

		public function removeSessionFromDb(Session $antiqSession) {
			try {
				$sql = "DELETE FROM sessions WHERE session_id='{$antiqSession->SESSID}' OR session_userID='{$antiqSession->userID}' OR session_IP='{$antiqSession->IP}';";
				return $this->dorkodiaDB->query($sql);
			} catch(Exception $excpt) {
				return false;
			}
		}

		public function destroyWebSession($key) {
			unset($_SESSION[$key]);
		}

		public function destroyAllWebSession() {
			session_unset();
		}
	}
