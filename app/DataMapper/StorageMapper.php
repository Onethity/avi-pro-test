<?php
/**
 * Data mapper for storage entity
 */

declare(strict_types=1);

namespace Aviprotest\Datamapper;

use Aviprotest\Entity\Storage;
use Aviprotest\Exception\DataMapperException;
use Psr\Container\ContainerInterface;
use \PDO;

class StorageMapper
{
    /**
     * @var PDO
     */
    protected $pdo;
    
    public function __construct(ContainerInterface $container)
    {
        $this->pdo = $container->get('pdo');
    }

    /**
     * In inserts an entity to database and sets its id
     */
    public function insert(Storage $storage)
    {
        $query = "INSERT INTO storage VALUE (NULL, :value)";
        $stm = $this->pdo->prepare($query);
        $stm->execute([
            ':value' => $storage->value
        ]);

        //set id to entity
        $storage->id = intval($this->pdo->lastInsertId());
    }

    /**
     * It gets storage entity by its id
     */
    public function getById(int $id): Storage
    {
        $query = "SELECT * FROM storage WHERE id = :id LIMIT 1";
        $stm = $this->pdo->prepare($query);
        $stm->execute([
            ':id' => $id
        ]);

        $storage = $stm->fetchObject('Aviprotest\Entity\Storage');
        if(!$storage) {
            throw new DataMapperException('Value with this ID is not found');
        }

        return $storage;
    }
}
