<?php
namespace Oxygen\DatagridBundle\Grid;

use APY\DataGridBundle\Grid\Grid as GridAPY;

class Grid extends GridAPY {
	
	protected $isExternalFilters = false;
	
	/**
	* @param bool $isExternalFilters
	* @return Grid
	*/
	public function setIsExternalFilters($isExternalFilters)
	{
	    $this->isExternalFilters = $isExternalFilters;
	    return $this;
	}
	 
	/**
	* @return bool
	*/
	public function isExternalFilters()
	{
	    return $this->isExternalFilters;
	}
	
}
