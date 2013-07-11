<?php
namespace Oxygen\DatagridBundle\Templating;

use Oxygen\DatagridBundle\Grid\Configuration\GridConfigurator;

use Oxygen\DatagridBundle\Grid\GridEntityView;

use Oxygen\FrameworkBundle\Model\EntitiesServer;
use APY\DataGridBundle\Grid\Source\Entity;
use Oxygen\DatagridBundle\Grid\Grid;

/**
 * Build grid for a source
 * 
 * @author lolozere
 *
 */
class GridTemplating {
	
	/**
	 * @var Grid
	 */
	protected $grid;
	/**
	 * 
	 * @var EntitiesServer
	 */
	protected $entitiesManager;
	/**
	 * 
	 * @var GridConfigurator
	 */
	protected $configurator;
	
	public function __construct($grid, $entitiesManager, $configurator) {
		$this->grid = $grid;
		$this->entitiesManager = $entitiesManager;
		$this->configurator = $configurator;
	}
	
	public function getEntityView($entity, $configurator = null) {
		// Set configurator
		if (is_null($configurator))
			$configurator = $this->configurator;
		
		// Search if grid view exist has a service
		
		if ($this->entitiesManager->has($entity)) {
			$class_name = $this->entitiesManager->getManager($entity)->getClassName();
			$this->grid->setPrefixTitle($entity.'.');
		} else {
			$class_name = $entity;
			$entityClass = new \ReflectionClass($entity);
			$this->grid->setPrefixTitle($entityClass->getName() . ' ');
		}
		$gridView = new GridEntityView($this->grid, $class_name);
		$gridView->setSource(new Entity($class_name));
		
		// Configure
		$configurator->configure($gridView);
		
		return $gridView;
	}
	
}