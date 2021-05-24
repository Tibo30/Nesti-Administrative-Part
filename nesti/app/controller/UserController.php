<?php
require_once(BASE_DIR.PATH_VIEW . 'View.php');

class UserController extends BaseController
{
    private $userDAO;

    /**
     * initialize the controller
     */
    public function initialize()
    {
        if (array_search("moderator", $_SESSION["roles"]) !== false || array_search("admin", $_SESSION["roles"]) !== false){
            $data[] = null;
            $this->userDAO = new UserDAO();
    
            if ($this->_url == "user") {
                $data = $this->users();
            } else if ($this->_url == "user_edit") {
                $idUser = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
                if (isset($idUser)) {
                    $data = $this->modifyUser($idUser);
                }
            } else if ($this->_url == "user_add") {
                if (!empty($_POST)) {
                    $this->addUserDatabase(); // this is the method called by the fetch API with the user/add ROOT.
                }
            } else if (($this->_url) == "user_userorder") {
                $this->order(); // this is the method called by the fetch API with the user/userorder ROOT.
            } else if (($this->_url) == "user_usercomment") {
                $this->changeStateComment(); // this is the method called by the fetch API with the user/usercomment ROOT.
            } else if (($this->_url) == "user_edituser") {
                $this->editUserDatabase(); // this is the method called by the fetch API with the user/edituser ROOT.
            } else if (($this->_url) == "user_delete") {
                $this->deleteUser(); // this is the method called by the fetch API with the user/delete ROOT.
            } else if (($this->_url) == "user_resetpassword") {
                $this->resetPassword(); // this is the method called by the fetch API with the user/resetpassword ROOT.
            }
            $data["title"] = "Users";
            $data["url"] = $this->_url;
            $this->_view = new View($this->_url);
            $this->_data = $data;
        } else {
            $this->_view = new View("norights");
        }
    }

    private function users()
    {

        $users = $this->userDAO->getUsers();

        $data = ['users' => $users];
        return $data;
    }

    private function modifyUser($idUser)
    {
        $user = $this->userDAO->getOneUser($idUser);
        $data = ['user' => $user];
        return $data;
    }

    private function addUserDatabase()
    {
        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {

            $userLastname = filter_input(INPUT_POST, "userLastname", FILTER_SANITIZE_STRING);
            $userFirstname = filter_input(INPUT_POST, "userFirstname", FILTER_SANITIZE_STRING);
            $userEmail = filter_input(INPUT_POST, "userEmail", FILTER_SANITIZE_STRING);
            $userUsername = filter_input(INPUT_POST, "userUsername", FILTER_SANITIZE_STRING);
            $userPassword = filter_input(INPUT_POST, "userPassword", FILTER_SANITIZE_STRING);
            $userConfirmPassword = filter_input(INPUT_POST, "userConfirmPassword", FILTER_SANITIZE_STRING);
            $userAddress1 = filter_input(INPUT_POST, "userAddress1", FILTER_SANITIZE_STRING);
            $userAddress2 = filter_input(INPUT_POST, "userAddress2", FILTER_SANITIZE_STRING);
            $userCity = filter_input(INPUT_POST, "userCity", FILTER_SANITIZE_STRING);
            $userPostCode = filter_input(INPUT_POST, "userPostCode", FILTER_SANITIZE_STRING);
            $userRoles = filter_input(INPUT_POST, "userRoles", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $userRoles[]='user';
            $userState = filter_input(INPUT_POST, "userState", FILTER_SANITIZE_STRING);

            // first we have to check if the city already exists, if not to create it
            $cityDAO = new CityDAO();
            $city = new City();
            $city = $cityDAO->doesCityExists($userCity); // we check if the city already exist
            $userCityError = "";
            if ($city->getIdCity() == null) { // if not we create it
                $userCityError = $city->setCityName($userCity);
                if ($userCityError == "") {
                    $cityId = $cityDAO->createCity($userCity);
                    $city->setIdCity($cityId);
                }
            }

            $userAdd = new User();
            $userLastnameError = $userAdd->setLastname($userLastname);
            $userFirstnameError = $userAdd->setFirstname($userFirstname);
            $userEmailError = $userAdd->setEmail($userEmail);
            $userUsernameError = $userAdd->setUsername($userUsername);
            $userPasswordError = $userAdd->setPassword($userPassword);
            $userAddress1Error = $userAdd->setAddress1($userAddress1);
            $userAddress2Error = $userAdd->setAddress2($userAddress2);
            $userPostCodeError = $userAdd->setPostCode($userPostCode);
            $userAdd->setIdCity($city->getIdCity());
            $userAdd->setState($userState);
            $userAdd->setRoles($userRoles);

            // check if the confirm password is right
            $userConfirmPasswordError = "";
            if ($userConfirmPassword != $userPassword) {
                $userConfirmPasswordError = "Passwords don't match";
            } else if ($userConfirmPassword == "") {
                $userConfirmPasswordError = "Please confirm the password";
            }

            // check if the email or username is already taken
            if ($this->userDAO->isEmailOrUsernameTaken($userAdd->getEmail()) == true) { // if the email is already taken
                $userEmailError = "this email already exists. Please choose another one";
            }
            if ($this->userDAO->isEmailOrUsernameTaken($userAdd->getUsername()) == true) { // if the username is already taken
                $userUsernameError = "this username already exists. Please choose another one";
            }

            $errorMessages = ['userLastname' => $userLastnameError, 'userFirstname' => $userFirstnameError, 'userUsername' => $userUsernameError, 'userEmail' => $userEmailError, 'userPassword' => $userPasswordError, 'userConfirmPassword' => $userConfirmPasswordError, 'userAddress1' => $userAddress1Error, 'userAddress2' => $userAddress2Error, 'userPostcode' => $userPostCodeError, 'userCity' => $userCityError];
            $data['errorMessages'] = $errorMessages;

            // if all the datas inputed are correct, we do the query
            // si bug, remettre null à la place de ""
            if ($userLastnameError == "" && $userFirstnameError == "" && $userUsernameError == "" && $userEmailError == "" && $userPasswordError == "" && $userConfirmPasswordError == "" && $userAddress1Error == "" && $userAddress2Error == "" && $userPostCodeError == "" && $userCityError == "") {

                // create the user in the database
                $idUser = $this->userDAO->addUser($userAdd);
                $userAdd->setIdUser($idUser);

                //add roles to the user
                $roleDAO = new RoleDAO();
                $roleDAO->createRoles($userAdd);

                $data['idUser'] = $userAdd->getIdUser();
                $data['userLastname'] = $userAdd->getLastname();
                $data['userFirstname'] = $userAdd->getFirstname();
                $data['userEmail'] = $userAdd->getEmail();
                $data['userUsername'] = $userAdd->getUsername();
                $data['userPassword'] = $userAdd->getPassword();
                $data['userConfirmPassword'] = $userAdd->getPassword();
                $data['userAddress1'] = $userAdd->getAddress1();
                $data['userAddress2'] = $userAdd->getAddress2();
                $data['userCity'] = $userAdd->getCity()->getCityName();
                $data['userPostcode'] = $userAdd->getPostCode();
                $data['userRoles'] = $userAdd->getRoles();
                $data['userState'] = $userAdd->getState();
                $data['success'] = true;
            }
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the method called by the fetch API with the user/userorder ROOT.
     */
    private function order()
    {
        $data = [];
        $data['success'] = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idOrder = $_POST["id_order"]; // first we get the id of the order
            $data["id"] = $idOrder;
            $ordersDAO = new OrderDAO();
            $orderLines = $ordersDAO->getOrderLines($idOrder); // we get all the orderLines for this order
            if (count($orderLines) > 0) { // if there is at least one orderLine
                $data['success'] = true;

                $articleDAO = new ArticleDAO();
                $index = 0;
                // in this loop we prepare the return data from the fetch
                foreach ($orderLines as $orderLine) { // we get all the articles of the orderLines
                    $article = $articleDAO->getArticle($orderLine->getIdArticle());
                    $data['articles'][$index]['all'] = '<div class="d-flex flex-row justify-content-between"><div>' . $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " " . $article->getProduct()->getProductName() . " x " . $orderLine->getQuantityOrdered() . '</div>' . '<a id="seeArticle" href="https://jolivet.needemand.com/realisations/nesti-client/public/article/'.$article->getIdArticle().'" class="btn-see-article" onclick="" data-id=' . $article->getIdArticle() . '>See</a></div>';
                    $index++;
                }
            }
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the method called by the fetch API with the user/usercomment ROOT.
     */
    private function changeStateComment()
    {
        $data = [];
        $data['success'] = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idComment = $_POST["id_comment"]; // first we get the id of the comment
            $state = $_POST["state"]; // first we get the state of the comment
            $data["id"] = $idComment;
            $data["state"] = $state;
            $commentDAO = new CommentsDAO();
            $comment = $commentDAO->getComment($idComment); // we get the comment from Database
            $comment->setState($state);
            $commentDAO->editComment($idComment, $state); // change the state in the database
            $data["state"] = $comment->getDisplayState();
            $data['success'] = true;
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the Ajax method to edit a user in the database
     */
    public function editUserDatabase()
    {
        $data = [];
        $data['success'] = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idUser = filter_input(INPUT_POST, "id_user", FILTER_SANITIZE_STRING);
            $userLastname = filter_input(INPUT_POST, "userLastname", FILTER_SANITIZE_STRING);
            $userFirstname = filter_input(INPUT_POST, "userFirstname", FILTER_SANITIZE_STRING);
            $userAddress1 = filter_input(INPUT_POST, "userAddress1", FILTER_SANITIZE_STRING);
            $userAddress2 = filter_input(INPUT_POST, "userAddress2", FILTER_SANITIZE_STRING);
            $userCity = filter_input(INPUT_POST, "userCity", FILTER_SANITIZE_STRING);
            $userPostCode = filter_input(INPUT_POST, "userPostcode", FILTER_SANITIZE_STRING);
            $userRoles = filter_input(INPUT_POST, "userRoles", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $userRoles[]='user';
            $userState = filter_input(INPUT_POST, "userState", FILTER_SANITIZE_STRING);

            // first we have to check if the city already exists, if not to create it
            $cityDAO = new CityDAO();
            $city = new City();
            $city = $cityDAO->doesCityExists($userCity); // we check if the city already exist
            $userCityError = "";
            if ($city->getIdCity() == null) { // if not we create it
                $userCityError = $city->setCityName($userCity);
                if ($userCityError == "") {
                    $cityId = $cityDAO->createCity($userCity);
                    $city->setIdCity($cityId);
                }
            }

            $userEdit = $this->userDAO->getOneUser($idUser); // get all the info of the user from the database

            $formerUserLastname = $userEdit->getLastname();
            $formerUserFirstname = $userEdit->getFirstname();
            $formerUserAddress1 = $userEdit->getAddress1();
            $formerUserAddress2 = $userEdit->getAddress2();
            $formerUserCity = $userEdit->getIdCity();
            $formerUserPostCode = $userEdit->getPostcode();
            $formerUserRoles = $userEdit->getRoles();
            $formerUserState = $userEdit->getState();

            $userLastnameError = $userEdit->setLastname($userLastname);
            $userFirstnameError = $userEdit->setFirstname($userFirstname);
            $userAddress1Error = $userEdit->setAddress1($userAddress1);
            $userAddress2Error = $userEdit->setAddress2($userAddress2);
            $userPostCodeError = $userEdit->setPostCode($userPostCode);
            $userEdit->setIdCity($city->getIdCity());
            $userEdit->setState($userState);
            $userEdit->setRoles($userRoles);

            $errorMessages = ['userLastname' => $userLastnameError, 'userFirstname' => $userFirstnameError, 'userAddress1' => $userAddress1Error, 'userAddress2' => $userAddress2Error, 'userPostcode' => $userPostCodeError, 'userCity' => $userCityError];
            $data['errorMessages'] = $errorMessages;

            // if all the datas inputed are correct, we do the query
            // si bug, remettre null à la place de ""
            if ($userLastnameError == "" && $userFirstnameError == ""  && $userAddress1Error == "" && $userAddress2Error == "" && $userPostCodeError == "" && $userCityError == "") {

                if ($formerUserLastname != $userLastname) { // if the lastname changed
                    $this->userDAO->editUser($userEdit, "lastname");
                }
                if ($formerUserFirstname != $userFirstname) { // if the firstname changed
                    $this->userDAO->editUser($userEdit, "firstname");
                }
                if ($formerUserAddress1 != $userAddress1) { // if the address1 changed
                    $this->userDAO->editUser($userEdit, "address1");
                }
                if ($formerUserAddress2 != $userAddress2) { // if the address2 changed
                    $this->userDAO->editUser($userEdit, "address2");
                }
                if ($formerUserCity != $city->getIdCity()) { // if the city changed
                    $this->userDAO->editUser($userEdit, "city");
                }
                if ($formerUserPostCode != $userPostCode) { // if the postcode changed
                    $this->userDAO->editUser($userEdit, "postcode");
                }

                if ($formerUserRoles != $userRoles) { // if the roles changed
                    $roleDAO = new RoleDAO();
                    if ($userRoles != null) {
                        foreach ($userRoles as $role) { // check which role has been added
                            if (array_search($role, $formerUserRoles) === false && array_search("old" . ucfirst($role), $formerUserRoles) === false) { // if this role or its old version wasn't in the former list we add the role
                                $roleDAO->createRole($userEdit, $role);
                            } else if (array_search($role, $formerUserRoles) === false && array_search("old" . ucfirst($role), $formerUserRoles) !== false) { // if this role wasn't in the former list but its old version is, we edit the role
                                $roleDAO->editRole($userEdit, $role, "a");
                            }
                        }
                        foreach ($formerUserRoles as $formerRole) { // check which role was in the database
                            if (array_search($formerRole, $userRoles) === false && ($formerRole == "admin" || $formerRole == "moderator" || $formerRole == "chief")) { // if this role is no longer checked, we change the state to "blocked"
                                $roleDAO->editRole($userEdit, $formerRole, "b");
                            }
                        }
                    } else { // if there is no role
                        foreach ($formerUserRoles as $formerRole) { // check which role was in the database
                            if ($formerRole == "admin" || $formerRole == "moderator" || $formerRole == "chief") { // we change all the states to "blocked"
                                $roleDAO->editRole($userEdit, $formerRole, "b");
                            }
                        }
                    }
                }
                if ($formerUserState != $userState) { // if the states changed
                    $this->userDAO->editUser($userEdit, "state");
                }

                $data['idUser'] = $userEdit->getIdUser();
                $data['userLastname'] = $userEdit->getLastname();
                $data['userFirstname'] = $userEdit->getFirstname();
                $data['userEmail'] = $userEdit->getEmail();
                $data['userUsername'] = $userEdit->getUsername();
                $data['userPassword'] = $userEdit->getPassword();
                $data['userConfirmPassword'] = $userEdit->getPassword();
                $data['userAddress1'] = $userEdit->getAddress1();
                $data['userAddress2'] = $userEdit->getAddress2();
                $data['userCity'] = $userEdit->getCity()->getCityName();
                $data['userPostcode'] = $userEdit->getPostCode();
                $data['userRoles'] = $userEdit->getRoles();
                $data['userState'] = $userEdit->getState();
                $data['success'] = true;
            }
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the Ajax method to delete a User (change state to Blocked)
     */
    private function deleteUser()
    {
        $data = [];
        $data['success'] = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idUser = $_POST["idUser"]; // first we get the id of the user
            $userEdit = $this->userDAO->getOneUser($idUser); // we get the user from the database
            $userEdit->setState("b"); // we change is state in local
            $this->userDAO->editUser($userEdit, "state"); // we change its state in the database
            $data["state"] = $userEdit->getDisplayState();
            $data['success'] = true;
        }
        echo json_encode($data);
        die;
    }

    /**
     * this is the Ajax method to reset the password of a User
     */
    private function resetPassword()
    {
        $data = [];
        $data['success'] = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $idUser = $_POST["id_user"]; // first we get the id of the user
            $userEdit = $this->userDAO->getOneUser($idUser); // we get the user from the database

            $list = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz@!$%#';
            $password = substr(str_shuffle($list), 0, 15); // get a random password

            do { // while the password doesn't match the regex we change it
                $password = substr(str_shuffle($list), 0, 15);
            } while (!preg_match("/^(?=.*?[A-Z])(?=(.*[a-z]))(?=(.*[\d]))(?=(.*[\W]))(?!.*\s).{12,}$/", $password));


            $passwordError = $userEdit->setPassword($password);
            $errorMessages = ['password' => $passwordError];
            $data['errorMessages'] = $errorMessages;

            if ($passwordError == "") {
                $this->userDAO->editUser($userEdit, "password");
                $data['success'] = true;
                $data['password'] = $password;
            }
        }
        echo json_encode($data);
        die;
    }
}
