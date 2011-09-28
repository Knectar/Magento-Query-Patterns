<?php

/**
 * Establishes a store-specific query.
 * 
 * Exports the following fields:
 * <ul>
 * <li><code>store_id</code></li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Store extends Knectar_Select_Entity
{

	public function __construct()
	{
		parent::__construct();

		$this->from(array('store'=>$this->getTable('core/store')), 'store_id');
		$this->joinEntity('storegroup', 'core/store_group', 'storegroup.group_id=store.group_id');
		$this->group('store_id');
	}

}

