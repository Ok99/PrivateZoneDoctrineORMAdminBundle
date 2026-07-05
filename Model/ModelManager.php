<?php

namespace Ok99\PrivateZoneCore\DoctrineORMAdminBundle\Model;

use Ok99\PrivateZoneCore\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager as AbstractModelManager;

class ModelManager extends AbstractModelManager
{

    public function createQuery($class, $alias = 'o')
    {
        $repository = $this->getEntityManager($class)->getRepository($class);

        return new ProxyQuery($repository->createQueryBuilder($alias));
    }

}