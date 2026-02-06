<?php

namespace App\Action\Users;

use App\Domain\Users\Users;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateUserPassword
{
  private $users;

  public function __construct(Users $users)
  {
    $this->users = $users;
  }

  public function __invoke(
    ServerRequestInterface $request,
    ResponseInterface $response
  ): ResponseInterface {
    $data = (array) json_decode($request->getBody());
    $result = $this->users->updateUserPassword($data);
    $response->getBody()->write((string) json_encode($result));
    return $response->withHeader('Content-Type', 'application/json');
  }
}