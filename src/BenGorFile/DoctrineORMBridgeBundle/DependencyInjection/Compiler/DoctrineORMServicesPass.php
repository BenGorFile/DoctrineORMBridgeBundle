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

use BenGorFile\DoctrineORMBridge\Infrastructure\Persistence\DoctrineORMFileRepository;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Register Doctrine ORM services compiler pass.
 *
 * Service declaration via PHP allows more
 * flexibility with customization extend files.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class DoctrineORMServicesPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('bengor_file.config');
        foreach ($config['file_class'] as $key => $file) {
            if ('doctrine_orm' !== $file['persistence']) {
                continue;
            }

            $container->setDefinition(
                'bengor.file.infrastructure.persistence.' . $key . '_repository',
                (new Definition(
                    DoctrineORMFileRepository::class, [
                        $file['class'],
                    ]
                ))->setFactory([
                    new Reference('doctrine.orm.default_entity_manager'), 'getRepository',
                ])->setPublic(false)
            );
            $container->setAlias(
                'bengor_file.' . $key . '.repository',
                'bengor.file.infrastructure.persistence.' . $key . '_repository'
            );
        }
    }
}
