<?php
namespace Via\Bundle\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository as BaseEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Util\Debug;

class EntityRepository extends BaseEntityRepository
{
    public function createNew()
    {
        $className = $this->getClassName();
    
        return new $className;
    }
    
    public function find($id)
    {
        return $this
            ->getQueryBuilder()
            ->andWhere($this->getAlias().'.id = '.intval($id))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findAll()
    {
              
        return $this
            ->getCollectionQueryBuilder()
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBy(array $criteria)
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->applyCriteria($queryBuilder, $criteria);

        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $queryBuilder = $this->getCollectionQueryBuilder();

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);

        if (null !== $limit) {
            $queryBuilder->setMaxResults($limit);
        }

        if (null !== $offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder($this->getAlias());
    }

    protected function getCollectionQueryBuilder()
    {
        return $this->createQueryBuilder($this->getAlias());
    }

    protected function applyCriteria(QueryBuilder $queryBuilder, array $criteria = null)
    {
        if (null === $criteria) {
            return;
        }

        foreach ($criteria as $property => $value) {
            if (!is_array($value)) {
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->eq($this->getPropertyName($property), ':' . $property))
                    ->setParameter($property, $value);
            } else {
                $queryBuilder->andWhere($queryBuilder->expr()->in($this->getPropertyName($property), $value));
            }
        }
    }

    protected function applySorting(QueryBuilder $queryBuilder, array $sorting = null)
    {
        if (null === $sorting) {
            return;
        }

        foreach ($sorting as $property => $order) {
            if (!empty($order)) {
                $queryBuilder->orderBy($this->getPropertyName($property), $order);
            }
        }
    }

    protected function getPropertyName($name)
    {
        if (false === strpos($name, '.')) {
            return $this->getAlias().'.'.$name;
        }

        return $name;
    }

    protected function getAlias()
    {
        return 'o';
    }
}
