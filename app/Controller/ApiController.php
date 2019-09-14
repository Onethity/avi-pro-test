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
use Aviprotest\Exception\ControllerException;
use Aviprotest\Service\QueryValidator;

class ApiController 
{
    /**
     * @var StorageMappper;
     */
    protected $storageMapper;

    /**
     * @var QueryValidator;
     */
    protected $queryValidator;

    public function __construct(ContainerInterface $container)
    {
        $this->storageMapper = new StorageMapper($container);
        $this->queryValidator = new QueryValidator();
    }

    /**
     * Generate random value and print it
     */
    public function generate(Request $request, Response $response, array $args)
    {
        //create random entity
        $storage = new Storage;
        $storage->fillRandom();

        //then insert it to database
        $this->storageMapper->insert($storage);

        return $this->jsonResponse((array) $storage, $response);
    }

    /**
     * Retrieve value by it's id
     */
    public function retrieve(Request $request, Response $response, array $args)
    {
        //get requested id from query
        $id = intval($request->getQueryParams()['id']);

        if($this->queryValidator->isIdValid($id)) {
            //get storage object by requested id
            $storage = $this->storageMapper->getById($id);

            return $this->jsonResponse((array) $storage, $response);
        }
    }

    /**
     * Puts an array to response using json format
     * @return Response
     */
    protected function jsonResponse(array $arr, Response $response)
    {
        $payload = json_encode($arr);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
