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
                    'class'         => 'AppBundle\Entity\File',
                    'firewall'      => 'main',
                    'persistence'   => 'doctrine_odm_mongodb',
                    'default_roles' => [
                        'ROLE_USER',
                    ],
                    'use_cases'     => [
                        'security'        => [
                            'enabled' => true,
                        ],
                        'sign_up'         => [
                            'enabled' => true,
                            'type'    => 'default',
                        ],
                        'change_password' => [
                            'enabled' => true,
                            'type'    => 'default',
                        ],
                        'remove'          => [
                            'enabled' => true,
                        ],
                    ],
                    'routes'        => [
                        'security'                  => [
                            'login'                     => [
                                'name' => 'bengor_file_file_login',
                                'path' => '/file/login',
                            ],
                            'login_check'               => [
                                'name' => 'bengor_file_file_login_check',
                                'path' => '/file/login_check',
                            ],
                            'logout'                    => [
                                'name' => 'bengor_file_file_logout',
                                'path' => '/file/logout',
                            ],
                            'success_redirection_route' => 'bengor_file_file_homepage',
                        ],
                        'sign_up'                   => [
                            'name'                      => 'bengor_file_file_sign_up',
                            'path'                      => '/file/sign-up',
                            'success_redirection_route' => 'bengor_file_file_homepage',
                        ],
                        'invite'                    => [
                            'name'                      => 'bengor_file_file_invite',
                            'path'                      => '/file/invite',
                            'success_redirection_route' => null,
                        ],
                        'enable'                    => [
                            'name'                      => 'bengor_file_file_enable',
                            'path'                      => '/file/confirmation-token',
                            'success_redirection_route' => null,
                        ],
                        'change_password'           => [
                            'name'                      => 'bengor_file_file_change_password',
                            'path'                      => '/file/change-password',
                            'success_redirection_route' => null,
                        ],
                        'request_remember_password' => [
                            'name'                      => 'bengor_file_file_request_remember_password',
                            'path'                      => '/file/remember-password',
                            'success_redirection_route' => null,
                        ],
                        'remove'                    => [
                            'name'                      => 'bengor_file_file_remove',
                            'path'                      => '/file/remove',
                            'success_redirection_route' => null,
                        ],
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
                    'class'         => 'AppBundle\Entity\File',
                    'firewall'      => 'main',
                    'persistence'   => 'doctrine_orm',
                    'default_roles' => [
                        'ROLE_USER',
                    ],
                    'use_cases'     => [
                        'security'        => [
                            'enabled' => true,
                        ],
                        'sign_up'         => [
                            'enabled' => true,
                            'type'    => 'default',
                        ],
                        'change_password' => [
                            'enabled' => true,
                            'type'    => 'default',
                        ],
                        'remove'          => [
                            'enabled' => true,
                        ],
                    ],
                    'routes'        => [
                        'security'                  => [
                            'login'                     => [
                                'name' => 'bengor_file_file_login',
                                'path' => '/file/login',
                            ],
                            'login_check'               => [
                                'name' => 'bengor_file_file_login_check',
                                'path' => '/file/login_check',
                            ],
                            'logout'                    => [
                                'name' => 'bengor_file_file_logout',
                                'path' => '/file/logout',
                            ],
                            'success_redirection_route' => 'bengor_file_file_homepage',
                        ],
                        'sign_up'                   => [
                            'name'                      => 'bengor_file_file_sign_up',
                            'path'                      => '/file/sign-up',
                            'success_redirection_route' => 'bengor_file_file_homepage',
                        ],
                        'invite'                    => [
                            'name'                      => 'bengor_file_file_invite',
                            'path'                      => '/file/invite',
                            'success_redirection_route' => null,
                        ],
                        'enable'                    => [
                            'name'                      => 'bengor_file_file_enable',
                            'path'                      => '/file/confirmation-token',
                            'success_redirection_route' => null,
                        ],
                        'change_password'           => [
                            'name'                      => 'bengor_file_file_change_password',
                            'path'                      => '/file/change-password',
                            'success_redirection_route' => null,
                        ],
                        'request_remember_password' => [
                            'name'                      => 'bengor_file_file_request_remember_password',
                            'path'                      => '/file/remember-password',
                            'success_redirection_route' => null,
                        ],
                        'remove'                    => [
                            'name'                      => 'bengor_file_file_remove',
                            'path'                      => '/file/remove',
                            'success_redirection_route' => null,
                        ],
                    ],
                ],
            ],
        ]);

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
