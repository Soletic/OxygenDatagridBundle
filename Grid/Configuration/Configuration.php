<?php
namespace Oxygen\DatagridBundle\Grid\Configuration;

use Oxygen\DatagridBundle\Grid\Action\Edit;
use Oxygen\DatagridBundle\Grid\Action\Delete;

use Oxygen\DatagridBundle\Grid\Configuration\ConfigurationInterface;

/**
 * Base class to configure a Grid
 * 
 * @author lolozere
 *
 */
abstract class Configuration implements ConfigurationInterface {
	
	protected $configuration = array();
	protected $actions = array();
	protected $gridId;
	protected $sourceType;
	protected $sourceReference;
	
	public function __construct($gridId, $sourceType, $sourceReference) {
		$this->sourceType = $sourceType;
		$this->sourceReference = $sourceReference;
		$this->gridId = $gridId;
	}
	/**
	 * Add action type foreach row
	 * 
	 * @param string $route
	 * @param string $parameterNameId Name of the parameter representing the identifier
	 * @param string $type edit or delete
	 * @throws \Exception Action type unknown
	 */
	public function addActionType($route, $type) {
		switch($type) {
			case 'edit':
				$action = new Edit('Modifier', $route);
				break;
			case 'delete':
				$action = new Delete('Supprimer', $route);
				break;
			default:
				throw new \Exception(sprintf("Action type %s unknown", $type));
		}
		$this->actions[] = $action;
	}
	
	public function getActions() {
		return $this->actions;
	}
	
	public function getGridId() {
		return $this->gridId;
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