<?php

/**
 * Queries all categories by their store. Name of each product and category is included.
 * 
 * Exports the following fields:
 * <ul>
 * <li><code>store_id</code></li>
 * <li><code>category_id</code></li>
 * <li><code>parent_id</code></li>
 * <li><code>product_id</code></li>
 * <li><code>product_name</code></li>
 * <li><code>category_name</code></li>
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

