<?php

namespace App\controllers;

class LoginController{
 
    public $user = [];
    public $jsonFile = "userdetails.json";
    public function signUp($name, $userName, $password, $mobileNumber){
        if (!preg_match('/^[A-Za-z]+$/', $name) || !preg_match('/^[A-Za-z]{1,10}\d{0,10}$/', $userName)||!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/', $password) || !preg_match('/^[0-9]{10}$/', $mobileNumber)) {
            return ["error" => "Invalid Input"];
        }

        if ($this->isUsernameExists($userName)) {
            return ["error" => "Username already exists"];
        }

        $this->addUserDetails($name, $userName, $password, $mobileNumber);
        return ["message" => "Account created successfully"];

    }
    
    protected function isUsernameExists($userName){
        $currentData = file_get_contents($this->jsonFile);
        $currentArray = json_decode($currentData, true);
        foreach ($currentArray['user'] as $user) {
            if ($user['username'] == $userName) {
                return true;
            }
        }

        return false;
    }

    protected function addUserDetails($name, $userName, $password, $mobileNumber){
        if (!file_exists($this->jsonFile)) {
            file_put_contents($this->jsonFile, '{"user": []}');
        }

        $currentData = file_get_contents($this->jsonFile);
        $currentArray = json_decode($currentData, true);
        $inputData = ["name" => $name, "username" => $userName, "password" => $password, "mobileNumber" => $mobileNumber];
        $currentArray['user'][] = $inputData;
        $jsonData = json_encode($currentArray);
        file_put_contents($this->jsonFile, $jsonData);
    }

    public function userLogin($username, $password){
        $currentData = file_get_contents($this->jsonFile);
        $currentArray = json_decode($currentData, true);
        foreach ($currentArray['user'] as $user){
            if ($user['username'] == $username && $user['password'] == $password) {
                echo "login successfull";
                return $user;
            }
        }

        return ["message" => "user not exist"];
    }

    public function getAllUserInformation() {
        $jsonFile = "userdetails.json";
        $currentData = file_get_contents($jsonFile);
        return $currentData;
    }


}
