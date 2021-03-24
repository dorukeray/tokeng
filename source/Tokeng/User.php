<?php
  namespace Tokeng;
  
  class User
  {
    protected $ID;
    protected $name;
    protected $email;
    protected $hashedPassword;
    protected $bio;
    protected $englishLevel;
    protected $socialHandle;
    protected $website;

    /**
     * Class constructor.
     */
    public function __construct(int $id, string $name, string $email, string $hashedPassword, string $bio, string $englishLevel, string $socialHandle, string $website)
    {
      $this->id = $id;  
      $this->name = $name;  
      $this->email = $email;  
      $this->hashedPassword = $hashedPassword;  
      $this->bio = $bio;
      $this->englishLevel = $englishLevel;  
      $this->socialHandle = $socialHandle;  
      $this->website = $website;  
    }

    //buff mage thingy.
    public function isThisHollowPerson() {
      return (empty($this->id) || empty($this->name) || empty($this->email) || empty($this->englishLevel));
    }

    public function getId() {
      return $this->id;
    }

    public function getHashedPassword() {
      return $this->hashedPassword;
    }

    public function getName() {
      return $this->name;
    }

    public function getEmail() {
      return $this->email;
    }

    public function getEnglishLevel() {
      return $this->email;
    }

    public function getBio() {
      return $this->fullName;
    }

    public function getWebsite() {
      return $this->website;
    }

    public function getSocialHandle() {
      return $this->socialHandle;
    }  
  }
  