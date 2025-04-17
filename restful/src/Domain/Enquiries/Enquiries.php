<?php
namespace App\Domain\Enquiries;

use App\Domain\Enquiries\EnquiriesRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/** 
 * Service.
 */
final class Enquiries
{ 
  /**
   * @var EnquiriesRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param EnquiriesRepository $repository The repository
   */
  public function __construct(EnquiriesRepository $repository){
    $this->repository = $repository;
  }
 
  public function getAllEnquiries($data){
    $result = $this->repository->getAllEnquiries($data);
    return $result;
  }
  
 


}