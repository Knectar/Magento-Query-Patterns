<?php

/**
 * Queries all categories by their store.
 * 
 * Exports the following fields:
 * <ul>
 * <li>store_id</li>
 * <li>category_id</li>
 * <li>parent_id: ID of each category's parent category, if it exists.</li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Store_Category extends Knectar_Select_Store
{

	public function __construct()
	{
		parent::__construct();

		$this->joinEntity('rootcat', 'catalog/category', 'rootcat.entity_id=storegroup.root_category_id');
		$this->joinEntity('cat', 'catalog/category', 'cat.path LIKE CONCAT(rootcat.path,"/%")', 
			array(
				'category_id'=>'entity_id',
				'parent_id'
			)
		);
		$this->group('category_id');
	}

}

