<?php
namespace Oxygen\DatagridBundle\Grid\Configuration;

use Oxygen\DatagridBundle\Grid\Configuration\GridConfigurationInterface;

/**
 * Base class to configure a Grid
 * 
 * @author lolozere
 *
 */
abstract class Configuration implements ConfigurationInterface {
	
	protected $configuration = array();
	protected $gridId;
	protected $sourceType;
	protected $sourceReference;
	
	public function __construct($gridId, $sourceType, $sourceReference) {
		$this->sourceType = $sourceType;
		$this->sourceReference = $sourceReference;
		$this->gridId = $gridId;
	}
	
	public function getGridId() {
		return $this->getGridId;
	}
	
	/**
	* @return string
	*/
	public function getSourceType()
	{
	    return $this->sourceType;
	}
	
	/**
	 * @return string
	 */
	public function getSourceReference()
	{
		return $this->sourceReference;
	}
	
	public function isFilters() {
		return (!empty($this->configuration['filters']));
	}
	public function isSortable() {
		return (!empty($this->configuration['sortable']));
	}
	
	abstract protected function load();
	
}