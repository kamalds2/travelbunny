<?php

namespace App\Action\Tales;

use App\Domain\Tales\Tales;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteTale
{
  private $tales;
  public function __construct(Tales $tales)
  {
    $this->tales = $tales; 
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response,$args
    ): ResponseInterface
    {
    
      
      // print_r($data);die(); 
      $tales = $this->tales->deleteTale($args);
      $response->getBody()->write((string)json_encode($tales));
      return $response->withHeader('Content-Type','application/json');
    }
}