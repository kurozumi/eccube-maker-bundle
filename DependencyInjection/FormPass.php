<?php


namespace Plugin\EccubeMakerBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

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