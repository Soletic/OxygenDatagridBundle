<?php
namespace Oxygen\DatagridBundle\Grid\Action;

/**
 * Colonne ajouté à un DataGrid
 * 
 * @author lolozere
 *
 */
class Copy extends Action {
	
	public function __construct($title, $route) {
		parent::__construct($title, $route);
		$this->addAttribute('row-action', 'copy');
		$this->addRouteParameters(array('id'));
	}
	
}