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

namespace spec\BenGorFile\DoctrineORMBridgeBundle;

use BenGorFile\DoctrineORMBridgeBundle\DependencyInjection\Compiler\DoctrineORMCustomTypesPass;
use BenGorFile\DoctrineORMBridgeBundle\DependencyInjection\Compiler\DoctrineORMServicesPass;
use BenGorFile\DoctrineORMBridgeBundle\BenGorFileDoctrineORMBridgeBundle;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Spec file of DoctrineORMBridgeBundle class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class BenGorFileDoctrineORMBridgeBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BenGorFileDoctrineORMBridgeBundle::class);
    }

    function it_extends_symfony_bundle()
    {
        $this->shouldHaveType(Bundle::class);
    }

    function it_builds_without_dependent_bundles_enabled(ContainerBuilder $container)
    {
        $this->shouldThrow(RuntimeException::class)->duringBuild($container);
    }

    function it_builds(ContainerBuilder $container)
    {
        $container->getParameter('kernel.bundles')->shouldBeCalled()->willReturn([
            'BenGorFileBundle' => 'BenGorFile\\FileBundle\\BenGorFileBundle',
            'DoctrineBundle'   => 'Doctrine\\Bundle\\DoctrineBundle\\DoctrineBundle',
        ]);

        $container->addCompilerPass(
            new DoctrineORMCustomTypesPass(), PassConfig::TYPE_OPTIMIZE
        )->shouldBeCalled()->willReturn($container);
        $container->addCompilerPass(
            new DoctrineORMServicesPass(), PassConfig::TYPE_OPTIMIZE
        )->shouldBeCalled()->willReturn($container);

        $container->loadFromExtension('doctrine', [
            'orm' => [
                'mappings' => [
                    'BenGorFileDoctrineORMBridgeBundle' => [
                        'type'      => 'yml',
                        'is_bundle' => true,
                        'prefix'    => 'BenGorFile\\File\\Domain\\Model',
                    ],
                ],
            ],
        ])->shouldBeCalled()->willReturn($container);

        $this->build($container);
    }
}
