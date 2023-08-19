<?php

require_once __DIR__ .'/../repo/userRepo.php';
require_once __DIR__.'/../util/sessionUtil.php';

class UserService {
    private $userRepo;

    public function __construct(UserRepository $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function getAllUsers() {
        return $this->userRepo->getAllUsers();
    }

    public function getUserById($id) {
        return $this->userRepo->getUserById($id);
    }

    public function getUserByName($username) {
        return $this->userRepo->getUserByName($username);
    }

    public function insertUser($username, $password) {
        return $this->userRepo->insertUser($username, $password);
    }

    public function updateUser($id, $newUsername) {
        return $this->userRepo->updateUser($id, $newUsername);
    }

    public function login($username, $password) {
        $userId = SessionUtil::getFromSession("userId");

        if($userId != null) {
            return $this->getUserById($userId);
        } else {
            $user = $this->getUserByName($username);
            
            if($user == null) {
                return null;
            } 
            
            if($user->verifyPassword($password)) {
                SessionUtil::setToSession("userId", $user->getId());
                return $user;
            } 
        }

        return null;
    }

    public function isLogin(){
        return SessionUtil::getFromSession("userId") != null;
    }

    public function getCurrentUserId() {
        return SessionUtil::getFromSession("userId");
    }  
}
