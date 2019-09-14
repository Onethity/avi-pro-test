<?php
/**
 * Main controller of application
 */

declare(strict_types=1);

namespace Aviprotest\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Aviprotest\Datamapper\StorageMapper;
use Aviprotest\Entity\Storage;

class ApiController 
{
    /**
     * @var StorageMappper;
     */
    protected $storageMapper;


    public function __construct(ContainerInterface $container)
    {
        $this->storageMapper = new StorageMapper($container);
    }

    /**
     * Generate random value and it's id
     */
    public function generate(Request $request, Response $response, array $args)
    {
        //create random entity
        $storage = new Storage;
        $storage->fillRandom();

        //then insert it to database
        $this->storageMapper->insert($storage);

        //format storage data as json and print it
        $payload = json_encode($storage);
        $response->getBody()->write($payload);
        return $response
                  ->withHeader('Content-Type', 'application/json');
    }

    /**
     * Retrieve value by it's id
     */
    public function retrieve(Request $request, Response $response, array $args)
    {
        return $response;
    }
}
