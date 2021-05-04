<?php

namespace Fira\Infrastructure\Database\Sql\Mysql;

use DateTimeImmutable;
use Fira\App\DependencyContainer;
use Fira\Domain\Entity\Entity;
use Fira\Domain\Entity\LocationEntity;
use Fira\Domain\Utility\Pager;
use Fira\Domain\Utility\Sort;
use phpDocumentor\Reflection\DocBlock\Description;

class LocationRepository implements \Fira\Domain\Repository\LocationRepository
{
    public function getByName(string $name, Pager $pager, Sort $sort): array
    {
        $rowData = DependencyContainer::getLocationRepository()->getByName($name, $pager, $sort);
        $entity = new LocationEntity();
        $entity
            ->setName($rowData['name'])
            ->setCategory($rowData['category'])
            ->setDescription($rowData['Description'])
            ->setLatitude($rowData['latitude'])
            ->setLongitude($rowData['longitude'])
            ->setCreatedAt(new DateTimeImmutable($rowData['created_at']));

        return array($entity);

    }

    public function getByCategory(string $category, Pager $pager, Sort $sort): array
    {
        $rowData = DependencyContainer::getLocationRepository()->getByCategory($category, $pager, $sort);
        $entity = new LocationEntity();
        $entity
            ->setName($rowData['name'])
            ->setCategory($rowData['category'])
            ->setDescription($rowData['Description'])
            ->setLatitude($rowData['latitude'])
            ->setLongitude($rowData['longitude'])
            ->setCreatedAt(new DateTimeImmutable($rowData['created_at']));

        return array($entity);
    }

    public function registerEntity(Entity $entity): void
    {
        $entity = new LocationEntity();
        $entity
            ->$this->getNextid($entity);
        return;
    }

    public function save(): void
    {
        // TODO: Implement save() method.
    }

    public function getById(int $id): Entity
    {
        $rowData = DependencyContainer::getSqlDriver()->getRowById($id, 'locations');
        $entity = new LocationEntity();
        $entity
            ->setId($rowData['id'])
            ->setName($rowData['name'])
            ->setCategory($rowData['category'])
            ->setDescription($rowData['description'])
            ->setLatitude($rowData['latitude'])
            ->setLongitude($rowData['longitude'])
            ->setCreatedAt(new DateTimeImmutable($rowData['created_at']));

        return $entity;
    }

    public function getByIds(array $ids): array
    {
        $rowData = DependencyContainer::getSqlDriver()->getRowById((int)$ids, 'locations');
        $entity = new LocationEntity();
        $entity
            ->setId($rowData['ids'])
            ->setName($rowData['name'])
            ->setCategory($rowData['category'])
            ->setDescription($rowData['description'])
            ->setLatitude($rowData['latitude'])
            ->setLongitude($rowData['longitude'])
            ->setCreatedAt(new DateTimeImmutable($rowData['created_at']));

        return array($entity);

    }

    public function delete(int $id): void
    {
        $rowData = DependencyContainer::getSqlDriver()->getRowById($id, 'locations');
        unset($rowData);

    }

    public function getNextid(): int
    {
        // TODO: Implement getNextid() method.
    }

    public function search(array $searchParams, Pager $pager, Sort $sort): array
    {
        $name = '';
        $where = '';
        if ($searchParams['name'] ?? null) {
            $where = "name = {searchParams['name]}";
        }

        $items = DependencyContainer::getSqlDriver()->select([$searchParams,$pager,$sort], 'locations', $where);
    }
}
