<?php
namespace Oxygen\DatagridBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Oxygen\DatagridBundle\DependencyInjection\Compiler\APYCompiler;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OxygenDatagridBundle extends Bundle
{
	
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		$container->addCompilerPass(new APYCompiler());
	}
	
	
}
