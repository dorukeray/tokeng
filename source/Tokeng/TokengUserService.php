<?php
	namespace Tokeng;

	class TokengUserService {
		private $user;
		private $DB;
		private $session;

		public function __construct() {
			$this->user = new User();
			$this->DB = new DB();
			$this->session = new Session();
		}

		public function getUserFromSession()
		{
			if($this->session->isWebSessionSet('dorkodia_userID') && $this->session->isWebSessionSet('dorkodia_username') && $this->session->isWebSessionSet('dorkodia_fullname') && $this->session->isWebSessionSet('dorkodia_email')) {
				$tempU = new User();
				$tempU->setUser($this->session->getWebSession('dorkodia_userID'), $this->session->getWebSession('dorkodia_username'), $this->session->getWebSession('dorkodia_fullname'), NULL, $this->session->getWebSession('dorkodia_email'));
				return $tempU;
			} elseif ($this->session->isWebSessionSet('dorkodia_userID')) {
				return $this->getUserById($this->session->getWebSession('dorkodia_userID'));
			} elseif ($this->session->isWebSessionSet('dorkodia_username')) {
				return $this->getUserByUsername($this->session->getWebSession('dorkodia_username'));
			} else {
				return false;
			}
		}

		public function saveUserToWebSession(User $user) {
			$this->session->setWebSession('tokeng_ID', $user->getId());
			$this->session->setWebSession('tokeng_name', $user->getName());
			$this->session->setWebSession('tokeng_email', $user->getEmail());
		}

		//isUsernameTaken() ve isValidEmail() denetlemesi yap.
		public function registerUser($userName, $userFullName, $userEmail, $userPass, $userUniqToken) {
			$hashedPwd = password_hash($userPass, PASSWORD_DEFAULT);
			if(!empty($userName) && !empty($userFullName) && !empty($userEmail) && !empty($userPass)) {
				$sql = "INSERT INTO users (username, fullname, password, email, uniq_Token) VALUES (:uname, :urealname, :upass, :uemail, :utoken);";
				$stmt = $this->DB->prepareStatement($sql, array(':uname' => $userName, ':urealname' => $userFullName, ':upass' => $hashedPwd, ':uemail' => $userEmail, ':utoken' => $userUniqToken));
				//buradan sonra account oluştur, sosyal ağ özelliğiyle birlikte
				return true;
			} else {
				return false;
			}
		}

		public function isUsernameTaken($username) {
			$sql = "SELECT * FROM users WHERE username=:uname LIMIT 1;";
			$stmt = $this->DB->sude($sql, array(':uname' => $username));
			if ($stmt->rowCount())
				return true;
			else
				return false;
		}

		public function getUserById($user_id) {
			$user = new User();
			$sql = "SELECT * FROM users WHERE user_id=:uid LIMIT 1;";
			$stmt = $this->DB->sude($sql, array(':uid' => $user_id));
			if ($stmt->rowCount()) {
				while ($neuUser = $stmt->fetch(PDO::FETCH_OBJ))
					$user->setUser($neuUser->user_id, $neuUser->username, $neuUser->fullname, $neuUser->password, $neuUser->email);
			} else { $user = false; }
			return $user;
		}

		public function getUserByUsername($username) {
			$user = new User();
			$sql = "SELECT * FROM users WHERE username=:uname LIMIT 1;";
			$stmt = $this->DB->sude($sql, array(':uname' => $username));
			if ($stmt->rowCount()) {
				while ($neuUser = $stmt->fetch(PDO::FETCH_OBJ))
					$user->setUser($neuUser->user_id, $neuUser->username, $neuUser->fullname, $neuUser->password, $neuUser->email);
			} else { $user = false; }
			return $user;
		}

		public function destroyUser($userID) {
			//user'i sil
			try {
				$sql = "DELETE FROM users WHERE user_id=:uid;";
				$stmt = $this->DB->sude($sql, array(':uid' => $userID));
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function updateUserInfo($userInfo, $neuInfo, $userID) {
			//veriyi dbde değiştir ve yeni user nesnesi döndür
			if(!empty($userInfo) && !empty($neuInfo) && !empty($userID)) {
				switch ($userInfo) {
					case 'Username':
						$column='username';
						break;
					case 'Fullname':
						$column='fullname';
						break;
					case 'Password':
						$column='password';
						break;
					case 'Email':
						$column='email';
						break;
					default:
						return false;
						break;
				}
				$sql = "UPDATE users SET $column=:neuone WHERE user_id=:uid";
				if(!$this->DB->sude($sql, array(':neuone'=>$neuInfo, ':uid'=>$userID)))
					return false;
				else
					return true;
			} else
				return false;
		}
	}
