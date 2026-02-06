<?php
  namespace App\Domain\Users;
  use App\Domain\Users\UsersRepository;
  use App\Exception\ValidationException;
  use App\Utilities\ImageUpload;
  /**
   * Service.
   */ 
  final class Users  {
    private $repository;
    public function __construct(UsersRepository $repository)  {
      $this->repository = $repository;
    }
    public function checkLogin($data)  {
      $users = $this->repository->checkLogin($data);
      return $users;
    }
    public function getUserDetails($data) {     
      $userId = $this->repository->getUserDetails($data);
      return $userId;
    }
     public function resetUserPassword($data) {     
      $userId = $this->repository->resetUserPassword($data);
      return $userId;
    }
      public function deleteUser($data) {     
      $userId = $this->repository->deleteUser($data);
      return $userId;
    }
    public function checkUserEmail($data) {     
      $userId = $this->repository->checkUserEmail($data);
      return $userId;
    }
    public function checkPassword($data) {     
      $userId = $this->repository->checkPassword($data);
      return $userId;
    }
    public function getUser($data) {     
      $userId = $this->repository->getUser($data);
      return $userId;
    }
     public function addUser($data) {     
      $userId = $this->repository->addUser($data);
      return $userId;
    }
    public function editUser($data) {     
      $userId = $this->repository->editUser($data);
      return $userId;
    }
    public function updateUserPassword($data) {     
      $userId = $this->repository->updateUserPassword($data);
      return $userId;
    }
  }
?>