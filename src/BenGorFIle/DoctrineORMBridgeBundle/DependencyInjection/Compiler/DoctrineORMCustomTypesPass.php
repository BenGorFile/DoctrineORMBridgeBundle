<?php

/*
 * This file is part of the BenGorFile package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BenGorFile\DoctrineORMBridgeBundle\DependencyInjection\Compiler;

use BenGorFile\DoctrineORMBridge\Infrastructure\Persistence\Types\FileIdType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Load Doctrine ORM custom types compiler pass.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class DoctrineORMCustomTypesPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $customTypes = $container->getParameter('doctrine.dbal.connection_factory.types');
        $customTypes = array_merge($customTypes, [
            'file_id' => [
                'class'     => FileIdType::class,
                'commented' => true,
            ],
        ]);

        $container->setParameter('doctrine.dbal.connection_factory.types', $customTypes);
        $container->findDefinition('doctrine.dbal.connection_factory')->replaceArgument(
            0, '%doctrine.dbal.connection_factory.types%'
        );
    }
}
