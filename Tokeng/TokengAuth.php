<?php
	namespace Tokeng;

	class TokengAuth {

		public $session;
		public $logger;
		public $dorcrypted;

		//bunlar korunuyor çünkü dahili nanoservisler.
		protected $userService;
		protected $dorkodiaDB;

		public function __construct() {
			$this->session = new Session();
			$this->logger = new Log();
			$this->dorcrypted = new Dorcrypted();
			$this->dorkodiaUser = new DorkodiaUser();
			$this->dorkodiaDB = new DorkodiaDB();
		}

		//this is one of the most chaotic functions i have ever written ... | if there isn't someone : false, else : userID.
		public function isSomeoneLoggedIn() {
			if($this->session->isWebSessionSet('dorkodia_userID')) {
				$session_userID = $this->session->getWebSession('dorkodia_userID');
				return $session_userID;
			} else {
				if(!$sess = $this->session->getSessionByIP($this->getIP())) {
					if(!$this->session->getSessionBySESSID(session_id())) {
						if($this->session->isWebSessionSet('dorkodia_uniqToken')) {
							if(!$this->session->getSessionByUniqToken(getWebSession('dorkodia_uniqToken')))
								return $this->session->getSessionByUniqToken(getWebSession('dorkodia_uniqToken'))->userID;
						} else
							return false;
					} else {
						//SESSID'ye göre
						return $this->session->getSessionBySESSID(session_id())->userID;
					}
				} else {
					//IP'ye göre
					return $sess->userID;
				}
			}
		}

		public function generateLoginToken() {
			return sha1($this->dorcrypted->generateUniqid((string)rand(100000, 999999)."nothing left to say, demirovskji."));
		}

		public function freshSession($currentSess) {
			if ($currentSess->isThisSessionEmpty()) {
				if ($currentSess->isSessionExistInWeb()) {
					$currentSess = $currentSession->getSessionByWeb();
					$currentSess->terminateSession();
				} else {
					$currentSess->destroyAllWebSession();
				}
			} else {
				$currentSess->terminateSession();
			}
		}

		public function getCurrentUser() {
			if($this->session->isWebSessionSet('dorkodia_userID') && $this->session->isWebSessionSet('dorkodia_username') && $this->session->isWebSessionSet('dorkodia_userRealName') && $this->session->isWebSessionSet('dorkodia_userEmail') && $this->session->isWebSessionSet('dorkodia_loginToken'))
			{
				$user = new User();
				$user->userID = $this->session->getWebSession('dorkodia_userID');
				$user->userName = $this->session->getWebSession('dorkodia_username');
				$user->fullName = $this->session->getWebSession('dorkodia_userRealName');
				$user->email = $this->session->getWebSession('dorkodia_email');
				$user->statusID = $this->session->getWebSession('dorkodia_statusID');
			} elseif($this->session->isWebSessionSet('dorkodia_userID')) {
				$user = $this->dorkodiaUser->getUserById($this->session->getWebSession('dorkodia_userID'));
			} else {
				$user = false;
			}
			return $user;
		}

		public function isValidEmail($email) {
			if(filter_var($email, FILTER_VALIDATE_EMAIL))
			return true;
			else
			return false;
		}

		public function doLogin($username, $password) {
			//boş mu
			if(!empty($username) && !empty($password)) {
				$tempUser = $this->dorkodiaUser->getUserByUsername($username);
				if(!$tempUser) {
					return array('result' => false, 'message' => "login");
				} elseif(is_object($tempUser)) {
					if (password_verify($password, $tempUser->getHashedPass())) {
						unset($tempUser);
						return true;
					} else {
						unset($tempUser);
						return array('result' => false, 'message' => "login");
					}
				} else {
					unset($tempUser);
					return false;
				}
			} else {
				//boş uyarısı
				return array('result' => false, 'message' => "empty");
			}
		}

		public function registerNewUser($uName, $uFullName, $uEmail, $uPassword) {
			if(empty($uName) || empty($uFullName) || empty($uEmail) || empty($uPassword)) {
				return array('result' => false, 'message' => "empty-values");
			} else {
				if(!$this->isValidEmail($uEmail)) {
					return array('result' => false, 'message' => "invalid-email");
				} else {
					if(preg_match("/^[a-zA-Z_]*$/", $uName) && preg_match("/^[1-9a-zA-Z-&ÇŞĞÜÖİçşğüöıûîâôäë ]*$/", $uFullName)) {
						if(!$this->dorkodiaUser->isUsernameTaken($uName)) {
							//burada ileride daha iyi bi algoritma geliştirince onu kullan.
							$uToken = $this->dorcrypted->generateUniqToken(64, 'RANDOM_BYTES');
							return $this->dorkodiaUser->registerUser($uName, $uFullName, $uEmail, $uPassword, $uToken);
						} else {
							return array('result' => false, 'message' => "username-taken");
						}
					} else {
						return array('result' => false, 'message' => "invalid-char");
					}
				}
			}
		}

		public function getIP() {
			if(getenv('HTTP_CLIENT_IP')) {
				$ip = getenv('HTTP_CLIENT_IP');
			} elseif(getenv('HTTP_X_FORWARDED_FOR')) {
				$ip = getenv('HTTP_X_FORWARDED_FOR');
				if(strstr($ip, ',')) {
					$temp = explode(',',$ip);
					$ip = trim($temp[0]);
				}
			} else {
				$ip = getenv('REMOTE_ADDR');
			}
			return $ip;
		}

		public function getUserAgent() {
			return getenv('HTTP_USER_AGENT');
		}

		public function redirectForLogin($thisPage) {
			if(!headers_sent())
				header("Location: gir.php?to=$thisPage");
			else
				echo "<script>window.location='gir.php?to=".$thisPage."';</script>";
		}

		public function redirectToPage($targetPage = "index.php") {
			if(!headers_sent())
				header("Location: ".$targetPage);
			else
				echo "<script>window.location='".$targetPage."';</script>";
		}
	}
