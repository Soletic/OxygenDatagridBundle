<?php
namespace Oxygen\DatagridBundle;

use Oxygen\DatagridBundle\DependencyInjection\Compiler\ConfigurationCompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Oxygen\DatagridBundle\DependencyInjection\Compiler\APYCompilerPass;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OxygenDatagridBundle extends Bundle
{
	
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		$container->addCompilerPass(new APYCompilerPass());
		$container->addCompilerPass(new ConfigurationCompilerPass());
	}
	
	
}
