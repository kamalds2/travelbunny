<?php

namespace App\Action\Tales;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Tales\Tales;

class GetAllTales
{
		private $tales;

		public function __construct(Tales $tales) {
			$this->tales = $tales;

		}
		public function __invoke(Request $request,Response $response){
			$tales= $this->tales->getAllTales();
			$response->getBody()->write((string)json_encode($tales));
      		return $response->withHeader('Content-Type','application/json');

		}


}