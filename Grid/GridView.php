<?php
namespace Oxygen\DatagridBundle\Grid;

use APY\DataGridBundle\Grid\Mapping\Source;

/**
 * View of a source
 * 
 * @author lolozere
 *
 */
abstract class GridView {
	
	/**
	 * @var Grid
	 */
	protected $grid;
	protected $source;
	
	public function __construct($grid) {
		$this->grid = $grid;
	}
	/**
	 * @return Grid
	 */
	public function getGrid() {
		return $this->grid;
	}
	
	/**
	* @param Source $source
	* @return GridView
	*/
	public function setSource($source)
	{
	    $this->source = $source;
	    $this->grid->setSource($source);
	    return $this;
	}
	 
	/**
	* @return Source
	*/
	public function getSource()
	{
	    return $this->source;
	}
	
	public function getGridResponse($template) {
		return $this->grid->getGridResponse($template);
	}
} 