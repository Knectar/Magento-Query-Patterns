<?php

/**
 * Queries all categories by their store. 
 * Name of each product and category and parent and grandparent category is included.
 * 
 * Exports the following fields:
 * <ul>
 * <li><code>store_id</code></li>
 * <li><code>category_id</code></li>
 * <li><code>parent_id</code></li>
 * <li><code>product_id</code></li>
 * <li><code>product_name</code></li>
 * <li><code>category_name</code></li>
 * <li><code>parent_category_name</code></li>
 * <li><code>grandparent_category_name</code></li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Store_Category_Product_Trioname extends Knectar_Select_Store_Category_Product_Duoname
{

	public function __construct()
	{
		parent::__construct();
		$this->joinEntity('parentcat', 'catalog/category', 'parentcat.entity_id=cat.parent_id', array('grandparent_id'=>'parent_id'), self::LEFT_JOIN);
		$this->joinAttribute('grandparentcatname', 'catalog_category', 'name', 'parentcat.parent_id', 0, null, self::LEFT_JOIN);
		$this->columns(array(
			'grandparent_category_name' => 'IF(cat.level > 3, grandparentcatname.value, NULL)',
		));
	}

}

