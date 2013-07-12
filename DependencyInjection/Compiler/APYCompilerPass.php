<?php
namespace Oxygen\DatagridBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Etend le bundle OxygenDiffusion
 * 
 * @author lolozere
 *
 */
class APYCompilerPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
	{
		if ($container->hasDefinition('grid')) {
			$definition = $container->getDefinition('grid');
			$definition->setClass($container->getParameter('oxygen_datagrid.grid_class'));
		}
		if ($container->hasDefinition('grid.twig_extension')) {
			$definition = $container->getDefinition('grid.twig_extension');
			$definition->setClass($container->getParameter('oxygen_datagrid.twig_class'));
		}
	}
}