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
class ConfigurationCompilerPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
	{
		$pool = $container->getDefinition('oxygen_datagrid.configuration.pool');
		
		$configurations = array();
		$taggedServices = $container->findTaggedServiceIds('oxygen.grid.configuration');
		
		foreach ($taggedServices as $id => $tagAttributes) {
			if (count($tagAttributes) > 1)
				throw new \Exception("Too much tag oxygen.grid.configuration on service " . $id);
			
			$attributes = $tagAttributes[0];
			$definition = $container->getDefinition($id)
				->addArgument($attributes['grid_id'])
				->addArgument($attributes['source_type'])
				->addArgument($attributes['source_reference']);
			
			$configurations[$attributes['grid_id']] = $id;
		}
		$pool->addMethodCall('setConfigurations', array($configurations));
	}
}