<?php
namespace Via\Bundle\ApiBundle\Response\Blackbox;

use Guzzle\Service\Command\ResponseClassInterface;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Common\Collection;
use Doctrine\Common\Util\Debug;

class AuthResponse implements ResponseClassInterface
{
    public static function fromCommand(OperationCommand $command)
    {
        $response = $command->getResponse();
        
        return new self([
            'status' => $response->getStatusCode(),
            'reason' => $response->getReasonPhrase(),
            'text' => $response->getBody(true)
        ]);
    }
}