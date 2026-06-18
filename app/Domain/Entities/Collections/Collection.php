<?php

declare(strict_types=1);

namespace App\Domain\Entities\Collections;

use App\Domain\Ports\IEntity;
use App\Exceptions\InvalidCollectionDataException;

use function App\Helpers\getClassShortName;

abstract class Collection
{
    public function __construct(
        protected array $collectionEntities,
        protected string $entityType,
    ) {
        foreach ($this->collectionEntities as $entity) {
            if (! $entity instanceof IEntity && $entity instanceof $entityType) {
                throw new InvalidCollectionDataException(
                    getClassShortName(get_called_class()), 
                    getClassShortName($entityType),
                );
            }
        }
    }

    public function toArray(): array
    {
        $values = [];
        
        /** @var IEntity $entity */
        foreach ($this->collectionEntities as $entity) {
            $values[] = $entity->toArray();
        }
            
        return $values;
    }
}
