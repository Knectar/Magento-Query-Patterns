<?php

/**
 * Queries all categories by their store. 
 * Name of each product and category and parent and grandparent category is included.
 * 
 * Exports the following fields:
 * <ul>
 * <li>store_id</li>
 * <li>category_id</li>
 * <li>parent_id</li>
 * <li>grandparent_id</li>
 * <li>product_id</li>
 * <li>product_name</li>
 * <li>category_name</li>
 * <li>parent_category_name</li>
 * <li>grandparent_category_name</li>
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

