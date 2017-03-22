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

namespace spec\BenGorFile\DoctrineORMBridgeBundle\DependencyInjection\Compiler;

use BenGorFile\DoctrineORMBridgeBundle\DependencyInjection\Compiler\DoctrineORMServicesPass;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Spec file of DoctrineORMServicesPass class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class DoctrineORMServicesPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DoctrineORMServicesPass::class);
    }

    function it_implmements_compiler_pass_interface()
    {
        $this->shouldImplement(CompilerPassInterface::class);
    }

    function it_does_not_process_because_the_persistence_layer_is_not_doctrine_orm(ContainerBuilder $container)
    {
        $container->getParameter('bengor_file.config')->shouldBeCalled()->willReturn([
            'file_class' => [
                'file' => [
                    'class'       => 'AppBundle\Entity\File',
                    'firewall'    => 'main',
                    'persistence' => 'doctrine_odm_mongodb',
                    'filesystem'  => [
                        'gaufrette' => 'gaufrette-configured-filesystem',
                    ],
                ],
            ],
        ]);

        $this->process($container);
    }

    function it_processes_doctrine_orm(ContainerBuilder $container, Definition $definition)
    {
        $container->getParameter('bengor_file.config')->shouldBeCalled()->willReturn([
            'file_class' => [
                'file' => [
                    'class'       => 'AppBundle\Entity\File',
                    'firewall'    => 'main',
                    'persistence' => 'doctrine_orm',
                    'filesystem'  => [
                        'gaufrette' => 'gaufrette-configured-filesystem',
                    ],
                ],
            ],
        ]);

        $container->setDefinition(
            'bengor.file.infrastructure.persistence.file_specification_factory',
            Argument::type(Definition::class)
        )->shouldBeCalled()->willReturn($definition);
        $container->setAlias(
            'bengor_file.file.specification_factory',
            'bengor.file.infrastructure.persistence.file_specification_factory'
        )->shouldBeCalled();

        $container->setDefinition(
            'bengor.file.infrastructure.persistence.file_repository',
            Argument::type(Definition::class)
        )->shouldBeCalled()->willReturn($definition);

        $container->setAlias(
            'bengor_file.file.repository',
            'bengor.file.infrastructure.persistence.file_repository'
        )->shouldBeCalled();

        $this->process($container);
    }
}
