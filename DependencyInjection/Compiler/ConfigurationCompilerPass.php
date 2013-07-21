<?php
namespace Oxygen\DatagridBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Definition;

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
		$gridColumns = $container->findTaggedServiceIds('oxygen.grid_column');
		
		// Grids
		foreach ($grids as $id => $tagAttributes) {
			if (count($tagAttributes) > 1)
				throw new \Exception("Too much tag oxygen.grid.configuration on service " . $id);
			
			$attributes = $tagAttributes[0];
			$definition = $container->getDefinition($id)
				->addArgument($attributes['gridId'])
				->addArgument($attributes['sourceType'])
				->addArgument($attributes['sourceReference']);
			
			// Class definition of the service
			$class = $definition->getClass();
			if ($container->hasParameter(str_replace('%', '', $definition->getClass())))
				$class = $container->getParameter(str_replace('%', '', $definition->getClass()));
			$class = new \ReflectionClass($class);
			
			if (!empty($attributes['groupBy']))
				$definition->addMethodCall('setGroupBy', array($attributes['groupBy']));
			if (!empty($attributes['hide']))
				$definition->addMethodCall('setHideColumns', array($attributes['hide']));
			
			// Inject data or service
			if ($container->has('oxygen_framework.entities') && $class->isSubclassOf('Oxygen\DatagridBundle\Grid\Configuration\Entity\EntityConfiguration')) {
				$definition->addMethodCall('setEntitiesServer', array(new Reference('oxygen_framework.entities')));
			}
			
			$configurations[$attributes['gridId']] = $id;
			$gridServicesToGridId[$id] = $attributes['gridId'];
		}
		
		// Columns
		foreach ($gridColumns as $id => $columns) {
			foreach($columns as $attributes) {
				if (!empty($gridServicesToGridId[$id])) {
					$type = (!empty($attributes['type']))?$attributes['type']:null;
					if (empty($attributes['id']) && empty($attributes['title'])) {
						throw new \Exception(sprintf("Attribute id or title required for tag oxygen.grid_column in service %s", $attribute, $id));
					}
					$definition = $container->getDefinition($id)->addMethodCall('addColumn', array($attributes, $type));
				}
			}
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
					$parameters = array();
					if (!empty($attributes['parameters'])) {
						$parameters = explode(',', $attributes['parameters']);
					}
					$definition = $container->getDefinition($id)->addMethodCall(
							'addActionType', array($attributes['route'], $attributes['type'], $parameters));
				}
			}
		}	
		$pool->addMethodCall('setConfigurations', array($configurations));
	}
}