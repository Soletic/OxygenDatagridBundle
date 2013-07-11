<?php
namespace Oxygen\DatagridBundle\Grid\Configuration;

use APY\DataGridBundle\Grid\Column\Column;
use Oxygen\DatagridBundle\Grid\GridView;

/**
 * Configurateur de grilles
 * 
 * @author lolozere
 *
 */
class GridConfigurator {
	
	/**
	 * 
	 * @var GridConfigurationInterface
	 */
	protected $configuration = null;
	
	/**
	 * Ctor
	 * 
	 * @param string $configuration_class
	 */
	public function __construct($configurationClass) {
		$this->configuration = new $configurationClass();
	}

	/**
	 * Change configuration of grid view according to $configuration
	 * 
	 * @param GridView $gridView
	 * @param unknown_type $configuration
	 */
	public function configure(GridView $gridView) {
		if (!$this->configuration->isFilters()) {
			$gridView->getGrid()->hideFilters();
		}
		
		foreach($gridView->getGrid()->getColumns() as $column) {
			$column instanceof Column;
			if (!$this->configuration->isSortable()) {
				$column->setSortable(false);
			}
		}
	}
	
}