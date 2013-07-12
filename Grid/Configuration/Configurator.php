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
class Configurator {
	
	/**
	 * Change configuration of grid view according to $configuration
	 * 
	 * @param GridView $gridView
	 * @param unknown_type $configuration
	 */
	public function configure(GridView $gridView, ConfigurationInterface $configuration) {
		if (!$configuration->isFilters()) {
			$gridView->getGrid()->hideFilters();
		}
		
		foreach($gridView->getGrid()->getColumns() as $column) {
			$column instanceof Column;
			if (!$configuration->isSortable()) {
				$column->setSortable(false);
			}
		}
	}
	
}