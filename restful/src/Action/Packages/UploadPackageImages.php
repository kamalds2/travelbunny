<?php

namespace App\Action\Packages;

use App\Domain\Packages\Packages;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UploadPackageImages
{
  private $packages;
  public function __construct(Packages $packages)
  {
    $this->packages = $packages; 
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
    ): ResponseInterface
    {
      $data = $request->getBody();
      $data =(array) json_decode($data);
      $packages = $this->packages->uploadPackageImages($data);
      $response->getBody()->write((string)json_encode($packages));
      return $response->withHeader('Content-Type','application/json');
    }
}