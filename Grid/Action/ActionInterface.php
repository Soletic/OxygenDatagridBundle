<?php
namespace Oxygen\DatagridBundle\Grid\Action;

use APY\DataGridBundle\Grid\Action\RowAction;

/**
 * Action foreach row of DataGrid
 * 
 * @author lolozere
 *
 */
interface ActionInterface {

	/**
	 * True for asking confirmation
	 * 
	 * @param bool $confirm
	 * @return ActionInterface
	 */
	public function setConfirm($confirm);
	/**
	 * Limit the display of the action for this roles
	 * 
	 * @param array $roles
	 * @return ActionInterface
	 */
	public function setRoles(array $roles);
	/**
	 * Add attribute to anchor of action
	 * 
	 * @param string $key
	 * @param string $value
	 * @return ActionInterface
	 */
	public function addAttribute($key, $value);
	/**
	 * Return the row action
	 * 
	 * @return RowAction
	 */
	public function getRowAction();
	/**
	 * Set target window of action
	 * 
	 * @param string $target
	 * @return ActionInterface
	 */
	public function setTarget($target);
	
	/**
	 * Return true is confirmation asked
	 *
	 * @return bool
	 */
	public function isConfirm();
	/**
	 * Return roles authorized
	 *
	 * @return array
	 */
	public function getRoles();
	/**
	 * Return
	 *
	 * @return array
	 */
	public function getAttributes();

	/**
	 * Return target window of the action
	 *
	 * @return string
	 */
	public function getTarget();
}