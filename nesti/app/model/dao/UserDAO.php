<?php
class UserDAO extends ModelDAO{
    public function getUsers(){
        return $this->getAll('users','User');
    }
}