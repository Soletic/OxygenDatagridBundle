<?php
namespace Oxygen\DatagridBundle\Grid;

use Oxygen\DatagridBundle\Grid\Configuration\ConfigurationPool;

use Oxygen\DatagridBundle\Grid\Configuration\Configurator;

use Oxygen\FrameworkBundle\Model\EntitiesServer;
use APY\DataGridBundle\Grid\Source\Entity;

/**
 * Build grid for a source
 * 
 * @author lolozere
 *
 */
class GridLoader {
	
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
	 * @var Configurator
	 */
	protected $configurator;
	/**
	 * 
	 * @var ConfigurationPool
	 */
	protected $configurationsPool;
	
	public function __construct($grid, $entitiesManager, $configurationsPool, $configurator) {
		$this->grid = $grid;
		$this->entitiesManager = $entitiesManager;
		$this->configurator = $configurator;
		$this->configurationsPool = $configurationsPool;
	}
	
	public function getView($gridId) {
		if ($this->configurationsPool->has($gridId)) {
			$configuration = $this->configurationsPool->get($gridId);
			
			switch($configuration->getSourceType()) {
				case 'entity':
					return $this->getEntityView($configuration->getSourceReference(), $configuration);
					break;
				default:
					throw new \Exception(sprintf('Source type %s unknown', $configuration->getSourceType()));
			}
			
		}
		throw new \Exception(sprintf("Grid id %s doesn't exist", $gridId));
	}
	
	protected function getEntityView($entity, $configuration) {
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
		$this->configurator->configure($gridView, $configuration);
		
		return $gridView;
	}
	
}