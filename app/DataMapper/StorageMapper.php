<?php
/**
 * Data mapper for storage entity
 */

declare(strict_types=1);

namespace Aviprotest\Datamapper;

use Aviprotest\Entity\Storage;
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
}
