<?php
namespace Oxygen\DatagridBundle\Grid\Configuration;

interface ConfigurationInterface {
	
	public function getGridId();
	public function getActions();
	public function getSourceType();
	public function getSourceReference();
	/**
	 * Return true if filter displayed
	 * 
	 * @return bool
	 */
	public function isFilters();
	/**
	 * Return true if columns sortable
	 * 
	 * @return bool
	 */
	public function isSortable();
	/**
	 * Return true if no data message displayed
	 * 
	 * @return bool
	 */
	public function isNoDataMessage();
	
	public function addColumn($params, $type = null);
	/**
	 * Retourne les colonnes ajoutés au data grid
	 * 
	 * @return array
	 */
	public function getColumnsAdded();
	/**
	 * Return configuration value for a specific path
	 * 
	 * Example : getConfiguration('columns')
	 * 
	 * @param string $path Path configuration. If null, return full configuration
	 * @return mixed Return null if not found
	 */
	public function getConfiguration($path = null);
	
	/**
	 * 
	 * @param string $path
	 * @param mixed $value
	 * @return ConfigurationInterface
	 */
	public function addConfiguration($path, $value);
	
	public function getScalarConfiguration($path);
	
	/**
	* Set additional parameters
	* 
	* @param array array $params
	* @return ConfigurationInterface
	*/
	public function setParameters(array $params);
	 
	/**
	* @return array
	*/
	public function getParameters();
	/**
	 * Return a parameter by name or null if not exist
	 * 
	 * @param string $name
	 */
	public function getParameter($name);

}