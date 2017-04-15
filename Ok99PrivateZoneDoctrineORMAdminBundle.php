<?php

namespace Ok99\PrivateZoneCore\DoctrineORMAdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ok99\PrivateZoneCore\DoctrineORMAdminBundle\DependencyInjection\Compiler\AddAuditEntityCompilerPass;

class Ok99PrivateZoneDoctrineORMAdminBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataDoctrineORMAdminBundle';
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddAuditEntityCompilerPass());
    }}
