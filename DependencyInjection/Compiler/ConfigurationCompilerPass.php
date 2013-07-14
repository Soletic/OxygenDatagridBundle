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
		$gridServicesToGridId = array();
		
		// Search tag
		$grids = $container->findTaggedServiceIds('oxygen.grid');
		$gridActions = $container->findTaggedServiceIds('oxygen.grid_action');
		
		// Grids
		foreach ($grids as $id => $tagAttributes) {
			if (count($tagAttributes) > 1)
				throw new \Exception("Too much tag oxygen.grid.configuration on service " . $id);
			
			$attributes = $tagAttributes[0];
			$definition = $container->getDefinition($id)
				->addArgument($attributes['grid_id'])
				->addArgument($attributes['source_type'])
				->addArgument($attributes['source_reference']);
			
			$configurations[$attributes['grid_id']] = $id;
			$gridServicesToGridId[$id] = $attributes['grid_id'];
		}
		
		//Actions
		$attributesRequired = array('route', 'type');
		foreach ($gridActions as $id => $tagAttributes) {
			foreach($tagAttributes as $attributes) {
				if (!empty($gridServicesToGridId[$id])) {
					// Attribute required
					foreach($attributesRequired as $attribute) {
						if (empty($attributes[$attribute]))
							throw new \Exception(sprintf("Attribute %s required for tag oxygen.grid_action in service %s", $attribute, $id));
					}
					$definition = $container->getDefinition($id)->addMethodCall('addActionType', array($attributes['route'], $attributes['type']));
				}
			}
		}	
		$pool->addMethodCall('setConfigurations', array($configurations));
	}
}