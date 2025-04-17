<?php

namespace App\Action\Tales;

use App\Domain\Tales\Tales;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class AddTale
{
  private $tales;
  
  public function __construct(Tales $tales)
  {
    $this->tales = $tales; 
  }
  
  public function __invoke(Request $request, Response $response): Response
  {
    $data = $request->getBody();
    $data = (array) json_decode($data);
    
    // print_r($data);die();
    
    $tales = $this->tales->addTale($data);
    $response->getBody()->write((string) json_encode($tales));
    
    return $response->withHeader('Content-Type', 'application/json');
  }
}
