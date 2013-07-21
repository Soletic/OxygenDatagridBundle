<?php
namespace Oxygen\DatagridBundle\Grid\Action;

use APY\DataGridBundle\Grid\Action\RowAction;

/**
 * Colonne ajouté à un DataGrid
 * 
 * @author lolozere
 *
 */
abstract class Action {
	
	protected $route;
	protected $roles = array();
	protected $title;
	protected $confirm = false;
	protected $target = '_self';
	protected $attributes = array();
	protected $routeParameters = array();
	
	public function __construct($title, $route) {
		$this->title = $title;
		$this->route = $route;
	}
	/**
	 * Remplace list of parameters path
	 * 
	 * @param array $routeParameters
	 */
	public function setRouteParameters(array $routeParameters) {
		$this->routeParameters = $routeParameters;	
	}
	/**
	 * Add list of parameters path
	 *
	 * @param array $routeParameters
	 */
	public function addRouteParameters(array $routeParameters) {
		$this->routeParameters = array_merge($this->routeParameters, $routeParameters);
	}
	
	/**
	* @param string $target
	* @return ActionColumn
	*/
	public function setTarget($target)
	{
	    $this->target = $target;
	    return $this;
	}
	 
	/**
	* @return string
	*/
	public function getTarget()
	{
	    return $this->target;
	}
	
	/**
	 * True for asking confirmation
	 * 
	 * @param bool $confirm
	 * @return ActionColumn
	 */
	public function setConfirm($confirm)
	{
	    $this->confirm = $confirm;
	    return $this;
	}
	 
	/**
	* @return bool
	*/
	public function isConfirm()
	{
	    return $this->confirm;
	}
	
	/**
	 * Limit the display of the action for this roles
	 * 
	 * @param array $roles
	 * @return ActionColumn
	 */
	public function setRoles(array $roles) {
		$this->roles = $roles;
		return $this;
	}
	
	public function getRoles() {
		return $this->roles;
	}
	
	/**
	 * Add attribute to anchor of action
	 * 
	 * @param string $key
	 * @param string $value
	 * @return ActionColumn
	 */
	public function addAttribute($key, $value) {
		if (!empty($this->attributes[$key])) {
			$this->attributes[$key] .= ' ' . $value;
		} else {
			$this->attributes[$key] = $value;
		}
		return $this;
	}
	
	public function getAttributes() {
		return $this->attributes;
	}
	/**
	 * Return a new APY row action
	 * 
	 * @param array $params Params of the Datagrid
	 * @return RowAction
	 */
	public function getRowAction(array $params) {
		$action = new RowAction(
				$this->title, $this->route, $this->isConfirm(), $this->getTarget(), $this->getAttributes(), 
				(is_null($this->getRoles()) || count($this->getRoles()<=0))?null:$this->getRoles()
			);
		foreach($this->routeParameters as $key => $parameter) {
			if (!empty($params[$parameter])) {
				$this->routeParameters[$parameter] = $params[$parameter];
				unset($this->routeParameters[$key]);
			}
		}
		$action->setRouteParameters($this->routeParameters);
		return $action;
	}
	
}