<?php
namespace Oxygen\DatagridBundle\Controller;

use Oxygen\FrameworkBundle\Controller\OxygenController;

/**
 * Actions to display Grid
 * 
 * @author lolozere
 *
 */
class GridController extends OxygenController
{
    public function viewAction($grid_id)
    {
    	echo $grid_id; exit();
        return $this->render('OxygenDatagridBundle:Default:index.html.twig', array('name' => $name));
    }
}
