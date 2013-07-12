<?php
namespace Oxygen\DatagridBundle\Grid\Configuration;

use Symfony\Component\DependencyInjection\Container;

/**
 * Pool of grid configurations in the application
 * 
 * @author lolozere
 *
 */
class ConfigurationPool {
	
	protected $configurations = array();
	/**
	 * 
	 * @var Container
	 */
	protected $container;
	
	public function __construct($container) {
		$this->container = $container;
	}
	
	public function setConfigurations($configurations) {
		$this->configurations = $configurations;
	}
	/**
	 * 
	 * @param string $id
	 * @return ConfigurationInterface
	 */
	public function get($id) {
		return $this->container->get($this->configurations[$id]);
	}
	
	/**
	 *
	 * @param string $id
	 * @return bool
	 */
	public function has($id) {
		return !empty($this->configurations[$id]);
	}
	
}