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

use BenGorFile\DoctrineORMBridge\Infrastructure\Persistence\Types\FileIdType;
use BenGorFile\DoctrineORMBridgeBundle\DependencyInjection\Compiler\DoctrineORMCustomTypesPass;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Spec file of DoctrineORMCustomTypesPass class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class DoctrineORMCustomTypesPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DoctrineORMCustomTypesPass::class);
    }

    function it_implmements_compiler_pass_interface()
    {
        $this->shouldImplement(CompilerPassInterface::class);
    }

    function it_processes(ContainerBuilder $container, Definition $definition)
    {
        $container->getParameter('doctrine.dbal.connection_factory.types')->shouldBeCalled()->willReturn([]);
        $container->setParameter('doctrine.dbal.connection_factory.types', [
            'file_id' => [
                'class'     => FileIdType::class,
                'commented' => true,
            ],
        ])->shouldBeCalled();

        $container->findDefinition('doctrine.dbal.connection_factory')->shouldBeCalled()->willReturn($definition);
        $definition->replaceArgument(0, '%doctrine.dbal.connection_factory.types%')
            ->shouldBeCalled()->willReturn($definition);

        $this->process($container);
    }
}
