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
     * @return  string
     */
    public function setLastname($lastname)
    {
        $userLastnameError = "";
        if (empty($lastname)) {
            $userLastnameError = "Please enter a lastname";
        } else if (!preg_match("/^[a-z ,.'-]{3,20}+$/i", $lastname)) { // A MODIFIER
            $this->userLastnameError = "The lastname is incorrect";
        } else {
            $this->lastname = $lastname;
        }
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
     * @return  string
     */
    public function setFirstname($firstname)
    {
        $userFirstnameError = "";
        if (empty($firstname)) {
            $userFirstnameError = "Please enter a firstname";
        } else if (!preg_match("/^[a-z ,.'-]{3,20}+$/i", $firstname)) { // A MODIFIER
            $this->userFirstnameError = "The firstname is incorrect";
        } else {
            $this->firstname = $firstname;
        }
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
     * @return  string
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
     * @return  string
     */
    public function setPassword($password)
    {
        $userPasswordError = "";
        if (empty($password)) {
            $userPasswordError = 'Please enter a Password';
        } else if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%!?^&+=])(?=\\S+$).{12,}$/", $password)) {
            $this->userPasswordError = "The password isn't strong enough or doesn't respect the conditions";
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
     * @return  string
     */
    public function setUsername($username)
    {
        $userUsernameError = "";
        if (empty($username)) {
            $userUsernameError = 'Please enter a username';
        } else if (!preg_match("/^[a-zA-Z0-9._-]{3,20}$/", $username)) {
            $this->userUsernameError = "The username doesn't respect the conditions";
        } else {
            $this->username = $username;
        }
        return  $userUsernameError;
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
     * @return  string
     */
    public function setAddress1($address1)
    {
        $userAddress1Error = "";
        if (empty($address1)) {
            $userAddress1Error = "Please enter a postal address";
        } else {
            $this->address1 = $address1;
        }
        return  $userAddress1Error;
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
     * @return  string
     */
    public function setAddress2($address2)
    {
        $userAddress2Error = "";
        if (empty($address2)) {
            $this->address2 = null;
        } else {
            $this->address2 = $address2;
        }
        return  $userAddress2Error;
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
     * @return  string
     */
    public function setPostCode($postcode)
    {
        $userPostCodeError = "";
        if (empty($postcode)) {
            $userPostCodeError = "Please enter a postcode";
        } else if (!preg_match("/^[0-9]{5}$/", $postcode)) {
            $this->postcodeError = "Please enter a valid postcode (5 digits)";
        } else {
            $this->postcode = $postcode;
        }
        return  $userPostCodeError;
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
     * @return  string
     */
    public function setIdCity($idCity)
    {
        $userCityError = "";
        if (empty($idCity)) {
            $this->idCity = null;
        } else {
            $this->idCity = $idCity;
        }
        return  $userCityError;
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
     * @return  string
     */
    public function setRoles($roles)
    {
        $userRolesError = "";
        if (empty($roles)) {
            $this->roles = null;
        } else {
            $this->roles = $roles;
        }
        return  $userRolesError;
    }

    /**
     * Get the last log of a user
     */
    public function getLog()
    {
        $logDAO = new UserDAO();
        $log = $logDAO->getLog($this->idUser);
        return $log;
    }

    public function getCity()
    {
        $cityDAO = new UserDAO();
        $city = $cityDAO->getCity($this->idCity);
        return $city;
    }

     // Display state for tables
     public function getDisplayState()
     {
 
         if ($this->state == 'a') {
             $state = 'Active';
         }
         if ($this->state == 'b') {
             $state = 'Blocked';
         }
         if ($this->state == 'w') {
             $state = 'Waiting';
         }
         return $state;
     }
   
    // Display roles for tables
    public function getDisplayRoles()
    {
        $displayRoles = [];

        foreach ($this->roles as $role) {
            if ($role == 'admin') {
                $displayRoles[] = 'Administrator';
            }
            if ($role == 'moderator') {
                $displayRoles[] = 'Moderator';
            }
            if ($role == 'chief') {
                $displayRoles[] = 'Chief';
            }
        }

        if ($displayRoles == null) {
            $displayRoles[] = 'Utilisateur';
        }

        return $displayRoles;
    }
     
}
