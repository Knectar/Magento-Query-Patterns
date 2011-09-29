<?php

/**
 * Queries all categories by their store. 
 * Name of each product and category and parent category is included.
 * 
 * Exports the following fields:
 * <ul>
 * <li>store_id</li>
 * <li>category_id</li>
 * <li>parent_id</li>
 * <li>product_id</li>
 * <li>product_name</li>
 * <li>category_name</li>
 * <li>parent_category_name</li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Store_Category_Product_Duoname extends Knectar_Select_Store_Category_Product_Name
{

	public function __construct()
	{
		parent::__construct();

		$this->joinAttribute('parentcatname', 'catalog_category', 'name', 'cat.parent_id', 0, null, self::LEFT_JOIN);
		$this->columns(array(
			'parent_category_name' => 'IF(cat.level > 2, parentcatname.value, NULL)',
		));
	}

}

