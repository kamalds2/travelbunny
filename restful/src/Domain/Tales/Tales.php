<?php 
namespace App\Domain\Tales;

use App\Domain\Tales\TalesRepository;
use App\Exception\ValidationException;
class Tales {

		private $repository;

	public function __construct(TalesRepository $repository){
		$this->repository = $repository;
	}
		public function getAllTales(){
			$result = $this->repository->getAllTales();
			return $result;
		}

		 public function addTale($data){
    $result = $this->repository->addTale($data);
    return $result;
  }

	public function getTaleDetails($data){
    $result = $this->repository->getTaleDetails($data);
    return $result;
  }
 
  public function updateTale($data){
    $result = $this->repository->updateTale($data);
    var_dump($result);
    die();
    return $result;
  }


 
  public function deleteTale($data){
    $result = $this->repository->deleteTale($data);
    return $result;
  }
}