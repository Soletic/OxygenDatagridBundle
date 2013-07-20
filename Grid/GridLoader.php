<?php
namespace Oxygen\DatagridBundle\Grid;
use APY\DataGridBundle\Grid\Column\NumberColumn;

use Oxygen\DatagridBundle\Grid\Configuration\Entity\QueryConfigurationInterface;
use Doctrine\ORM\QueryBuilder;
use Oxygen\DatagridBundle\Grid\Configuration\ConfigurationInterface;

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
class GridLoader
{

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

	public function __construct($grid, $entitiesManager, $configurationsPool, $configurator)
	{
		$this->grid = $grid;
		$this->entitiesManager = $entitiesManager;
		$this->configurator = $configurator;
		$this->configurationsPool = $configurationsPool;
	}

	public function getView($gridId, array $params = array())
	{
		if ($this->configurationsPool->has($gridId)) {
			$configuration = $this->configurationsPool->get($gridId);
			$configuration->setParameters($params);

			switch ($configuration->getSourceType()) {
				case 'entity':
					$gridView = $this->getEntityView($configuration->getSourceReference(), $configuration);
					break;
				default:
					throw new \Exception(sprintf('Source type %s unknown', $configuration->getSourceType()));
			}

			// Actions
			if (count($configuration->getActions()) > 0) {
				foreach ($configuration->getActions() as $action) {
					$gridView->getGrid()->addRowAction($action->getRowAction());
				}
			}
			
			$gridView->getGrid()->setLimits(array(10000 => '10000'));
			
			if (!$configuration->isNoDataMessage()) {
				$gridView->getGrid()->setNoDataMessage(false);
			}

			return $gridView;
		}
		throw new \Exception(sprintf("Grid id %s doesn't exist", $gridId));
	}

	protected function getEntityView($entity, ConfigurationInterface $configuration)
	{
		if ($this->entitiesManager->has($entity)) {
			$class_name = $this->entitiesManager->getManager($entity)->getClassName();
		} else {
			$class_name = $entity;
			$entityClass = new \ReflectionClass($entity);
		}
		$this->grid->setPrefixTitle($configuration->getGridId() . '.');
		$gridView = new GridEntityView($this->grid, $class_name);
		$gridView->setSource(new Entity($class_name));
		
		if (count($configuration->getGroupBy()) > 0)
			$gridView->getSource()->setGroupBy($configuration->getGroupBy());
		
		// Query manipulation
		if ($configuration instanceof QueryConfigurationInterface) {
			$gridView->getSource()->manipulateQuery(function (QueryBuilder $query) use ($configuration)
				{
					$configuration->manipulateQuery($query);
				});
		}
		
		// Columns added
		foreach($configuration->getColumnsAdded() as $column) {
			$gridView->getGrid()->addColumn($column);
		}

		// Configure
		$this->configurator->configure($gridView, $configuration);

		return $gridView;
	}

}
