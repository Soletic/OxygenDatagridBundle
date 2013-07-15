<?php
namespace Oxygen\DatagridBundle\Grid\Configuration\Entity;

use Doctrine\ORM\QueryBuilder;

/**
 * Implement this interface to manipulate the query of the Grid
 * 
 * @author lolozere
 *
 */
interface QueryConfigurationInterface {
	
	public function manipulateQuery(QueryBuilder $query);
	
}