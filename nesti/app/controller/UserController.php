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
        }
        $data["title"] = "Users";
        $data["url"] = $this->_url;
        $this->_view = new View($this->_url);
        $this->_data = $data;
    }

    private function users()
    {

        $user = $this->userDAO->getUsers();

        $data = ['users' => $user['users'], 'logs' => $user['log'], 'url' => $this->_url, "title" => "User"];
        return $data;
    }

    private function modifyUser($idUser)
    {
        $user = $this->userDAO->getOneUser($idUser);
        $data = ['user' => $user['user'], 'log' => $user['log'], 'url' => $this->_url, "title" => "User"];
        return $data;
    }

    private function addUserDatabase()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            var_dump($_POST);
            $userLastname = filter_input(INPUT_POST, "userLastname", FILTER_SANITIZE_STRING);
            $userFirstname = filter_input(INPUT_POST, "userFirstname", FILTER_SANITIZE_STRING);
            $userUsername = filter_input(INPUT_POST, "userUsername", FILTER_SANITIZE_STRING);
            $userEmail = filter_input(INPUT_POST, "userEmail", FILTER_SANITIZE_STRING);
            // $userPassword = filter_input(INPUT_POST, "recipeName", FILTER_SANITIZE_ENCODED);
            $userPassword = filter_input(INPUT_POST, "userPassword", FILTER_SANITIZE_STRING);
            $userState = filter_input(INPUT_POST, "userState", FILTER_SANITIZE_STRING);
            $userAddress1 = filter_input(INPUT_POST, "userAddress1", FILTER_SANITIZE_STRING);
            $userAddress2 = filter_input(INPUT_POST, "userAddress2", FILTER_SANITIZE_STRING);
            $userPostCode = filter_input(INPUT_POST, "userPostCode", FILTER_SANITIZE_STRING);
            $userCity = filter_input(INPUT_POST, "userCity", FILTER_SANITIZE_STRING);
            $userRoles = filter_input(INPUT_POST, "userRoles", FILTER_SANITIZE_STRING);

            $userAdd = new User();
            $userLastnameError = $userAdd->setLastname($userLastname);
            $userFirstnameError = $userAdd->setLastname($userFirstname);
            $userUsernameError = $userAdd->setLastname($userUsername);
            $userEmailError = $userAdd->setLastname($userEmail);
            $userPasswordError = $userAdd->setLastname($userPassword);
            $userStateError = $userAdd->setLastname($userState);
            $userAddress1Error = $userAdd->setLastname($userAddress1);
            $userAddress2Error = $userAdd->setLastname($userAddress2);
            $userPostCodeError = $userAdd->setLastname($userPostCode);
            $userCityError = $userAdd->setLastname($userCity);
            $userRolesError = $userAdd->setLastname($userRoles);
            $errorMessages = ['userLastname' => $userLastnameError, 'userFirstname' => $userFirstnameError, 'userUsername' => $userUsernameError, 'userEmail' => $userEmailError, 'userPassword' => $userPasswordError, 'userState' => $userStateError, 'userAdress1' => $userAddress1Error, 'userAdress2' => $userAddress2Error,'userPostCode' => $userPostCodeError, 'userCity' => $userCityError, 'userRoles' => $userRolesError];
            $data['errorMessages'] = $errorMessages;

            // if all the datas inputed are correct, we do the query
            if ($userLastnameError == null && $userFirstnameError == null && $userUsernameError == null && $userEmailError == null&& $userPasswordError == null && $userStateError == null && $userAddress1Error == null&& $userAddress2Error == null && $userPostCodeError == null && $userCityError == null && $userRolesError == null) {
                $this->userDAO->addUser($userAdd);
                $data['userAdd'] = $userAdd;
            }
        }

        return $data;
    }
}
