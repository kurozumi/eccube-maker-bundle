<?php
/**
 * This file is part of EccubeMakerBundle
 *
 * Copyright(c) Akira Kurozumi <info@a-zumi.net>
 *
 * https://a-zumi.net
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Plugin\EccubeMakerBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('Plugin\EccubeMakerBundle\Maker\EccubeMakeFormExtension')) {
            return;
        }

        $servicesMap = [];
        foreach ($container->findTaggedServiceIds("form.type") as $serviceId => $tag) {
            // Add form type service to the service locator
            $serviceDefinition = $container->getDefinition($serviceId);
            $servicesMap[] = $serviceDefinition->getClass();
        }

        $commandDefinition = $container->getDefinition('Plugin\EccubeMakerBundle\Maker\EccubeMakeFormExtension');
        $commandDefinition->setArgument(0, $servicesMap);
    }
}
