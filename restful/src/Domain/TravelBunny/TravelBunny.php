<?php
namespace App\Domain\TravelBunny;

use App\Domain\TravelBunny\TravelBunnyRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/** 
 * Service.
 */
final class TravelBunny
{ 
  /**
   * @var TravelBunnyRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param TravelBunnyRepository $repository The repository
   */
  public function __construct(TravelBunnyRepository $repository){
    $this->repository = $repository;
  }
 
   
  public function getAllMenus($data){
    $result = $this->repository->getAllMenus($data);
    return $result;
  }
 
 
  public function getAllSliders($data){
    $result = $this->repository->getAllSliders($data);
    return $result;
  } 
 
  public function getDomesticPackages($data){
    $result = $this->repository->getDomesticPackages($data);
    return $result;
  }
 
  public function getAllPackages($data){
    $result = $this->repository->getAllPackages($data);
    return $result;
  }
 
  public function getAllTestimonials($data){
    $result = $this->repository->getAllTestimonials($data);
    return $result;
  }
 
  public function getFeaturedPackages($data){
    $result = $this->repository->getFeaturedPackages($data);
    return $result;
  } 

  public function getAllDomesticPackages($data){
    $result = $this->repository->getAllDomesticPackages($data);
    return $result;
  } 

  public function getPackageDetails($data){
    $result = $this->repository->getPackageDetails($data);
    return $result;
  }
 
  public function getPackageGallery($data){
    $result = $this->repository->getPackageGallery($data);
    return $result;
  }
 
  public function sendEnquiry($data){
    $result = $this->repository->sendEnquiry($data);
    return $result;
  }
 
  public function addContactDetails($data){
    $result = $this->repository->addContactDetails($data);
    return $result;
  }
 
  public function getPageDetails($data){
    $result = $this->repository->getPageDetails($data);
    return $result;
  }
  
  public function getModuleDetails($data){
    $result = $this->repository->getModuleDetails($data);
    return $result;
  }
  
  public function getSettingsData($data){
    $result = $this->repository->getSettingsData($data);
    return $result;
  }
  
  public function getHomePageDetails($data){
    $result = $this->repository->getHomePageDetails($data);
    return $result;
  }
 



}