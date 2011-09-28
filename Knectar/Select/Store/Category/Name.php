<?php

/**
 * Queries all categories by their store. Name is included.
 * 
 * Exports the following fields:
 * <ul>
 * <li><code>store_id</code></li>
 * <li><code>category_id</code></li>
 * <li><code>parent_id</code>: ID of each category's parent category, if it exists.</li>
 * <li><code>category_name</code></li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Store_Category_Name extends Knectar_Select_Store_Category
{

	public function __construct()
	{
		parent::__construct();

		$this->joinAttribute('catname', 'catalog_category', 'name', 'cat.entity_id', 0, 'category_name', self::LEFT_JOIN);
	}

}

