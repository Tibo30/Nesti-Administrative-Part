<?php
require_once(PATH_VIEW . 'View.php');
require_once(PATH_MODEL . 'entities/user.php');

class UserController extends BaseController
{
    private $userDAO;

    public function initialize()
    {
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
        }
        $data["title"] = "Users";
        $data["url"] = $this->_url;
        $this->_view = new View($this->_url);
        $this->_data = $data;
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
            $userRoles = filter_input(INPUT_POST, "userRoles", FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
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
                $articles = [];
                $articleDAO = new ArticleDAO();
                foreach ($orderLines as $orderLine) { // we get all the articles of the orderLines
                    $articles[] = $articleDAO->getArticle($orderLine->getIdArticle());
                }
                $index = 0;
                // in this loop we prepare the return data from the fetch
                foreach ($articles as $article) {
                    $data['articles'][$index]['all'] = '<div class="d-flex flex-row justify-content-between"><div>' . $article->getQuantityPerUnit() . " " . $article->getUnitMeasure()->getName() . " " . $article->getProduct()->getProductName() . '</div>' . '<a id="seeArticle" class="btn-see-article" onclick="" data-id=' . $article->getIdArticle() . '>See</a></div>';
                    $index++;
                }
            }
        }
        echo json_encode($data);
        die;
    }
}
