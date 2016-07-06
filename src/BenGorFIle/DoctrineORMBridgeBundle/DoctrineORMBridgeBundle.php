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

namespace BenGorFile\DoctrineORMBridgeBundle;

use BenGorFile\DoctrineORMBridgeBundle\DependencyInjection\Compiler\DoctrineORMCustomTypesPass;
use BenGorFile\DoctrineORMBridgeBundle\DependencyInjection\Compiler\DoctrineORMServicesPass;
use BenGorFile\FileBundle\DependentBenGorFileBundle;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Doctrine ORM bridge bundle kernel class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class DoctrineORMBridgeBundle extends Bundle
{
    //    use DependentBenGorFileBundle;

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        //        $this->checkDependencies(['BenGorFileBundle', 'DoctrineBundle'], $container);

        $container
            ->addCompilerPass(new DoctrineORMCustomTypesPass(), PassConfig::TYPE_OPTIMIZE)
            ->addCompilerPass(new DoctrineORMServicesPass(), PassConfig::TYPE_OPTIMIZE);

        $container->loadFromExtension('doctrine', [
            'orm' => [
                'mappings' => [
                    'DoctrineORMBridgeBundle' => [
                        'type'      => 'yml',
                        'is_bundle' => true,
                        'prefix'    => 'BenGorFile\\File\\Domain\\Model',
                    ],
                ],
            ],
        ]);
    }
}
