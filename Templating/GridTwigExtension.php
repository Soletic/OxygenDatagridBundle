<?php
namespace Oxygen\DatagridBundle\Templating;

use APY\DataGridBundle\Twig\DataGridExtension;


class GridTwigExtension extends DataGridExtension {
	
	public function getGrid($grid, $theme = null, $id = '', array $params = array(), $withjs = true)
	{
		if (is_null($theme))
			$theme = 'OxygenDatagridBundle::blocks.html.twig';
		
		if ($grid->isExternalFilters()) {
			return $this->getGridSearch($grid, $theme, $id, $params) . parent::getGrid($grid, $theme, $id, $params, $withjs);
		}
		return parent::getGrid($grid, $theme, $id, $params, $withjs);
	}
	
}