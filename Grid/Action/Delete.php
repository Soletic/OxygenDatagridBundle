<?php
namespace Oxygen\DatagridBundle\Grid\Action;

/**
 * Colonne ajouté à un DataGrid
 * 
 * @author lolozere
 *
 */
class Delete extends Action {
	
	public function __construct($title, $route) {
		parent::__construct($title, $route);
		$this->addAttribute('row-action', 'delete');
		$this->setConfirm(true);
		$this->addRouteParameters(array('id'));
	}
	
}