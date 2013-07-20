<?php
namespace Oxygen\DatagridBundle\Grid\Configuration\Entity;

use Oxygen\DatagridBundle\Grid\Configuration\Configuration;

use Oxygen\FrameworkBundle\Model\EntitiesServer;

/**
 * Base class to configure Datagrid of Entity
 * 
 * @author lolozere
 *
 */
class EntityConfiguration extends Configuration {
	
	/**
	 * 
	 * @var EntitiesServer
	 */
	private $entitiesServer;
	
	public function setEntitiesServer($entitiesServer) {
		$this->entitiesServer = $entitiesServer;
	}
	/**
	 * @return EntitiesServer
	 */
	public function getEntitiesServer() {
		return $this->entitiesServer;
	}
	
	protected function load() {
		$this->configuration = array();
	}
	
	public function getGroupBy() {
		return $this->getConfiguration('source/groupBy');
	}
	/**
	 * 
	 * @param string $fields Fields seperated by comma
	 */
	public function setGroupBy($fields) {
		$fields = explode(',', $fields);
		foreach($fields as $field) {
			$this->addConfiguration('source/groupBy', $field);
		}
	}
	
	protected function validateRequired(array $required) {
		foreach($required as $param) {
			if (is_null($this->getParameter('eventId'))) {
				throw new \Exception(sprintf('Parameter %s required for grid %s', $param, $this->getGridId()));
			}
		}
	}
	
}