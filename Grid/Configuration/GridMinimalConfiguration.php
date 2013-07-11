<?php
namespace Oxygen\DatagridBundle\Grid\Configuration;

use Oxygen\DatagridBundle\Grid\Configuration\GridConfigurationInterface;

class GridMinimalConfiguration extends GridConfiguration {

	protected function load() {
		$this->configuration = array();
	}
	
}