<?php
class User{
    protected $idUser;
    protected $lastname;
    protected $firstname;
    protected $username;
    protected $email;
    protected $password;
    protected $state;
    protected $creationDate;
    protected $adress1;
    protected $adress2;
    protected $postcode;
    protected $idCity;
    protected $roles=[];

// constructor

public function __construct(){  
}

    public function hydration($data){
        $this->idUser=$data['id_users'];
        $this->lastname=$data['lastname'];
        $this->firstname=$data['firstname'];
        $this->username=$data['username'];
        $this->email=$data['email'];
        $this->password=$data['password'];
        $this->state=$data['state'];
        $this->creationDate=$data['creation_date'];
        $this->adress1=$data['adress1'];
        $this->adress2=$data['adress2'];
        $this->postcode=$data['postcode'];
        $this->idCity=$data['id_city'];
        $this->roles=$data['roles'];
        return $this;
    }

    /**
     * Get the value of idUser
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of state
     */ 
    public function getState()
    {
        switch($this->state){
            case 'a':
                $this->state="Accepted";
                break;
            case 'b':
                $this->state="Blocked";
                break;
            case 'w':
                $this->state="Waiting";
                break;
        }

        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */ 
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the value of creationDate
     */ 
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of adress1
     */ 
    public function getAdress1()
    {
        return $this->adress1;
    }

    /**
     * Set the value of adress1
     *
     * @return  self
     */ 
    public function setAdress1($adress1)
    {
        $this->adress1 = $adress1;

        return $this;
    }

    /**
     * Get the value of adress2
     */ 
    public function getAdress2()
    {
        return $this->adress2;
    }

    /**
     * Set the value of adress2
     *
     * @return  self
     */ 
    public function setAdress2($adress2)
    {
        $this->adress2 = $adress2;

        return $this;
    }

    /**
     * Get the value of postCode
     */ 
    public function getPostCode()
    {
        return $this->postcode;
    }

    /**
     * Set the value of postCode
     *
     * @return  self
     */ 
    public function setPostCode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get the value of idCity
     */ 
    public function getIdCity()
    {
        return $this->idCity;
    }

    /**
     * Set the value of idCity
     *
     * @return  self
     */ 
    public function setIdCity($idCity)
    {
        $this->idCity = $idCity;

        return $this;
    }

    /**
     * Get the value of roles
     */ 
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     *
     * @return  self
     */ 
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }
}