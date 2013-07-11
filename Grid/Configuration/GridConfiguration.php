<?php
namespace Oxygen\DatagridBundle\Grid\Configuration;

use Oxygen\DatagridBundle\Grid\Configuration\GridConfigurationInterface;

abstract class GridConfiguration implements GridConfigurationInterface {

	protected $configuration = array();
	
	public function isFilters() {
		return (!empty($this->configuration['filters']));
	}
	public function isSortable() {
		return (!empty($this->configuration['sortable']));
	}
	
	abstract protected function load();
	
}