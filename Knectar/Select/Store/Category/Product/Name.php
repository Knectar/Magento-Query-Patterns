<?php

/**
 * Queries all categories by their store. Name of each product and category is included.
 * 
 * Exports the following fields:
 * <ul>
 * <li>store_id</li>
 * <li>category_id</li>
 * <li>parent_id</li>
 * <li>product_id</li>
 * <li>product_name</li>
 * <li>category_name</li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Store_Category_Product_Name extends Knectar_Select_Store_Category_Product
{

	public function __construct()
	{
		parent::__construct();

		$this->joinAttribute('prodname', 'catalog_product', 'name', 'catprod.product_id', 0, 'product_name', self::LEFT_JOIN);
		$this->joinAttribute('catname', 'catalog_category', 'name', 'catprod.category_id', 0, 'category_name', self::LEFT_JOIN);
	}

}

