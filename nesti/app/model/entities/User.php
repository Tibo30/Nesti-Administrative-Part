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
        if (isset($data['roles'])) {
            $this->roles = $data['roles'];
        }
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
        } else if (!preg_match("/^[a-zA-ZÀ-ÿ ,.'-]{2,20}+$/i", $lastname)) {
            $userLastnameError = "The lastname is incorrect";
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
        } else if (!preg_match("/^[a-zA-ZÀ-ÿ ,.'-]{2,20}+$/i", $firstname)) {
            $userFirstnameError = "The firstname is incorrect";
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
        } else if (!preg_match("/^(?=.*?[A-Z])(?=(.*[a-z]))(?=(.*[\d]))(?=(.*[\W]))(?!.*\s).{12,}$/", $password)) {
            $userPasswordError = "The password isn't strong enough or doesn't respect the conditions";
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
     * Get the display date
     */
    public function getDisplayDate()
    {
        $date = new DateTime($this->creationDate);
        $displayDate = "";
        if ($this->creationDate != null) {
            $displayDate = $date->format('j F Y \a\t H\hi');
        }
        return $displayDate;
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
        } else if (!preg_match("/^[a-zA-ZÀ-ÿ0-9._-]{7,20}$/", $username)) {
            $userUsernameError = 'The username has to be between 7 to 20 alphanumeric characters("." "_" "-" accepted)';
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
        $postcode2 = $this->postcode;
        if ($postcode2 != null && (int) $postcode2 < 9999 && strlen($postcode2)<5) {
            $postcode2 = "0" . $postcode2;
        }
        return $postcode2;
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
            $userPostCodeError = "Please enter a valid postcode (5 digits)";
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
        $logDAO = new UserLogsDAO();
        $log = $logDAO->getLog($this->idUser);
        return $log;
    }

    /**
     * Get the logs of a user
     */
    public function getLogs()
    {
        $logDAO = new UserLogsDAO();
        $logs = $logDAO->getLogsUser($this->idUser);
        return $logs;
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
        $state = $this->state;
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
            if ($role == 'user') {
                $displayRoles[] = '';
            }
        }

        if ($displayRoles[0] == '') {
            $displayRoles[] = 'User';
        }

        return $displayRoles;
    }

    // get orders for a user
    public function getOrders()
    {
        $orderDAO = new OrderDAO();
        $orders = $orderDAO->getOrdersUser($this->idUser);
        return $orders;
    }

    // get total amount of orders for a user
    public function getTotalAmountOrders()
    {
        $amount = 0;
        $orderDAO = new OrderDAO();
        $articlePriceDAO = new ArticlePriceDAO();
        $orders = $this->getOrders();
        foreach ($orders as $order) {
            $orderLines = $orderDAO->getOrderLines($order->getIdOrder()); // get all the order lines for an order
            foreach ($orderLines as $orderLine) {
                $price = $articlePriceDAO->getPrice($orderLine->getIdArticle()); // get the articlePrice object
                $amount += ($orderLine->getQuantityOrdered()) * ($price->getPrice());
            }
        }
        return $amount;
    }

    // get last order for a user
    public function getLastOrder()
    {
        $orderDAO = new OrderDAO();
        $order = $orderDAO->getLastOrder($this->idUser);
        return $order;
    }

    // get last import for an admin
    public function getLastImport()
    {
        $importDAO = new ImportDAO();
        $import = $importDAO->getLastImportUser($this->idUser);
        return $import;
    }

    // get all imports for an admin
    public function getImports()
    {
        $importDAO = new ImportDAO();
        $imports = $importDAO->getImportsUser($this->idUser);
        return $imports;
    }

    // get all comment numbers for a moderator
    public function getCommentsNumber()
    {
        $approved = 0;
        $blocked = 0;
        $commentsDAO = new CommentsDAO();
        $comments = $commentsDAO->getCommentsModerator($this->idUser);
        foreach ($comments as $comment) {
            if ($comment->getState() == "a") {
                $approved++;
            } else if ($comment->getState() == "b") {
                $blocked++;
            }
        }
        $number["approved"] = $approved;
        $number["blocked"] = $blocked;
        return $number;
    }

    // get all comments for a moderator
    public function getComments()
    {
        $commentsDAO = new CommentsDAO();
        $comments = $commentsDAO->getComments($this->idUser);
        return $comments;
    }

    // get all recipes for a chief
    public function getRecipes()
    {
        $recipeDAO = new RecipeDAO();
        $recipes = $recipeDAO->getRecipesChief($this->idUser);
        return $recipes;
    }

    // get last recipe for a chief
    public function getLastRecipe()
    {
        $recipeDAO = new RecipeDAO();
        $recipe = $recipeDAO->getLastRecipe($this->idUser);
        return $recipe;
    }

    // get average grade for a chief
    public function getAverageGrade()
    {
        $recipeDAO = new RecipeDAO();
        $recipes = $recipeDAO->getRecipesChief($this->idUser);
        $totalgradeChief = 0;
        $count = 0;
        foreach ($recipes as $recipe) {
            $totalgradeChief += $recipe->getGrade();
            if ($recipe->getGrade() != null) {
                $count++;
            }
        }
        $averageGrade = null;
        if ($count > 0) {
            $averageGrade = $totalgradeChief / $count;
        }
        return $averageGrade;
    }
}
