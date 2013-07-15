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
	
	/**
	 * Convert type column to class
	 *
	 * @var array
	 */
	private $columnsType = array(
			'array' => 'ArrayColumn', 'blank' => 'BlankColumn', 'boolean' => 'BooleanColumn',
			'date' => 'DateColumn', 'datetime' => 'DateTimeColumn', 'number' => 'NumberColumn',
			'text' => 'TextColumn', 'time' => 'TimeColumn', 'untype' => 'UntypeColumn'
		);
	
	public function __construct($gridId, $sourceType, $sourceReference) {
		$this->configuration['source'] = array('type' => array($sourceType), 'reference' => array($sourceReference));
		$this->configuration['id'] = array($gridId);
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\DatagridBundle\Grid\Configuration.ConfigurationInterface::getConfiguration()
	 */
	public function getConfiguration($path = null) {
		$path = explode('/', $path);
		$configuration = $this->configuration;
		foreach($path as $part) {
			if (!empty($configuration[$part])) {
				$configuration = $configuration[$part];
			} else {
				return null;
			}
		}
		return $configuration;
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\DatagridBundle\Grid\Configuration.ConfigurationInterface::getScalarConfiguration()
	 */
	public function getScalarConfiguration($path = null) {
		$value = $this->getConfiguration($path);
		if (is_array($value) && count($value) > 1) {
			throw new \Exception("Configuration path $path is not a scalar value");
		} elseif (is_array($value) && count($value) == 1) {
			return current($value);
		}
		return null;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\DatagridBundle\Grid\Configuration.ConfigurationInterface::getConfiguration()
	 */
	public function addConfiguration($path, $value) {
		$this->setConfiguration($path, $value, $this->configuration);
		return $this;
	}
	/**
	 * Add value to a configuration path
	 * 
	 * @param string $path
	 * @param mixed $value
	 * @param array $configuration
	 */
	private function setConfiguration($path, $value, array &$configuration) {
		if (!is_array($path))
			$path = explode('/', $path);
		$part = array_shift($path);
		if (empty($configuration[$part])) {
			$configuration[$part] = array();
		}
		if (count($path) == 0) {
			$configuration[$part][] = $value;
			return;
		}		
		$this->setConfiguration($path, $value, $configuration[$part]);
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
		$this->addConfiguration('actions', $action);
	}
	
	public function getActions() {
		return $this->getConfiguration('actions');
	}
	
	public function getGridId() {
		return $this->getScalarConfiguration('id');
	}
	
	/**
	* @return string
	*/
	public function getSourceType()
	{
	    return $this->getScalarConfiguration('source/type');
	}
	
	/**
	 * @return string
	 */
	public function getSourceReference()
	{
		return $this->getScalarConfiguration('source/reference');
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\DatagridBundle\Grid\Configuration.ConfigurationInterface::isFilters()
	 */
	public function isFilters() {
		return ($this->getScalarConfiguration('filters') === true);
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\DatagridBundle\Grid\Configuration.ConfigurationInterface::isSortable()
	 */
	public function isSortable() {
		return ($this->getScalarConfiguration('sortable') === true);
	}
	
	public function addColumn($params, $type = null) {
		$class = 'APY\DataGridBundle\Grid\Column\\' . $this->columnsType['untype'];
		if (!is_null($type) && !empty($this->columnsType[$type]))
			$class = 'APY\DataGridBundle\Grid\Column\\' . $this->columnsType[$type];
		
		// Method to add (source or lazy)
		if (!empty($params['method']) && $params['method'] == 'source') {
			$params['source'] = true;
		}
		
		// Title
		if (!empty($params['id']) && empty($params['title']))
			$params['title'] = $params['id'];
		
		$this->addConfiguration('columns', new $class($params));
	}
	/**
	 * (non-PHPdoc)
	 * @see Oxygen\DatagridBundle\Grid\Configuration.ConfigurationInterface::getColumnsAdded()
	 */
	public function getColumnsAdded() {
		return (count($this->getConfiguration('columns')) > 0)?$this->getConfiguration('columns'):array();
	}
	
	abstract protected function load();
	
}