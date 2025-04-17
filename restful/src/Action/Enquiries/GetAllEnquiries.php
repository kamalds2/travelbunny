<?php

  namespace App\Action\Enquiries;

  use App\Domain\Enquiries\Enquiries;
  use Psr\Http\Message\ResponseInterface;
  use Psr\Http\Message\ServerRequestInterface;

  final class GetAllEnquiries
  {
    private $enquiries;
    public function __construct(Enquiries $enquiries)
    {
      $this->enquiries = $enquiries; 
    }
    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response,$args
      ): ResponseInterface
      {
          
        $enquiries = $this->enquiries->getAllEnquiries($args);
        $response->getBody()->write((string)json_encode($enquiries));
        return $response->withHeader('Content-Type','application/json');
      }
  }