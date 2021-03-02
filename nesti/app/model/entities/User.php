<?php
class User
{
    protected $idUser;
    protected $lastname;
    protected $firstname;
    protected $username;
    protected $email;
    protected $password;
    protected $state;
    protected $creationDate;
    protected $address1;
    protected $address2;
    protected $postcode;
    protected $idCity;
    protected $roles = [];

    // constructor

    public function __construct()
    {
    }

    public function hydration($data)
    {
        $this->idUser = $data['id_users'];
        $this->lastname = $data['lastname'];
        $this->firstname = $data['firstname'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->state = $data['state'];
        $this->creationDate = $data['creation_date'];
        $this->address1 = $data['address1'];
        $this->address2 = $data['address2'];
        $this->postcode = $data['postcode'];
        $this->idCity = $data['id_city'];
        $this->roles = $data['roles'];
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
     * @return  $userLastnameError
     */
    public function setLastname($lastname)
    {
        $userLastnameError = "";
        $this->lastName = $lastname;
        return  $userLastnameError;
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
     * @return  $userFirstnameError
     */
    public function setFirstname($firstname)
    {
        $userFirstnameError = "";
        $this->firstname = $firstname;
        return  $userFirstnameError;
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
     * @return  $userEmailError
     */
    public function setEmail($email)
    {
        $userEmailError = "";
        if (empty($email)) {
            $userEmailError = 'Please enter an Email Adress';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $userEmailError = 'Please enter a valid Email Adress';
        } else {
            $this->email = $email;
        }

        return  $userEmailError;
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
     * @return  $userPasswordError
     */
    public function setPassword($password)
    {
        $userPasswordError = "";
        if (empty($password)) {
            $userPasswordError = 'Please enter a Password';
        } else {
            $this->password = $password;
        }

        return  $userPasswordError;
    }

    /**
     * Get the value of state
     */
    public function getState()
    {
        switch ($this->state) {
            case 'a':
                $this->state = "Accepted";
                break;
            case 'b':
                $this->state = "Blocked";
                break;
            case 'w':
                $this->state = "Waiting";
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
        $userStateError = "";
        $this->state = $state;
        return  $userStateError;
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
     * Get the value of address1
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set the value of address1
     *
     * @return  self
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get the value of address2
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set the value of address2
     *
     * @return  self
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

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
