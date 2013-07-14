<?php
namespace Oxygen\DatagridBundle\Grid\Configuration;

interface ConfigurationInterface {
	
	public function getGridId();
	public function getActions();
	public function getSourceType();
	public function getSourceReference();
	public function isFilters();
	
	public function isSortable();
	
}