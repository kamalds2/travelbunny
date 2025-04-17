<?php
namespace App\Domain\Packages;

use App\Domain\Packages\PackagesRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/** 
 * Service.
 */
final class Packages
{ 
  /**
   * @var PackagesRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param PackagesRepository $repository The repository
   */
  public function __construct(PackagesRepository $repository){
    $this->repository = $repository;
  }
 
  public function getCategoryDetails($data){
    $result = $this->repository->getCategoryDetails($data);
    return $result;
  }
  
  public function getAllPackages($data){
    $result = $this->repository->getAllPackages($data);
    return $result;
  }
 
  public function getGeneralItems($data){
    $result = $this->repository->getGeneralItems($data);
    return $result;
  }
  
  public function addPackageDetails($data){
    $result = $this->repository->addPackageDetails($data);
    return $result;
  }
  
  public function getPackageGallery($data){
    $result = $this->repository->getPackageGallery($data);
    return $result;
  } 
  
  public function getPackageDetails($data){
    $result = $this->repository->getPackageDetails($data);
    return $result;
  }
 
  public function updatePackageDetails($data){
    $result = $this->repository->updatePackageDetails($data);
    return $result;
  } 

  public function deletePackage($data){
    $result = $this->repository->deletePackage($data);
    return $result;
  }
 
  public function uploadPackageImages($data){
    $result = $this->repository->uploadPackageImages($data);
    return $result;
  }
 


}