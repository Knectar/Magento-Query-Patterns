<?php

/**
 * Queries all products by their categories and store.
 * 
 * Exports the following fields:
 * <ul>
 * <li><code>store_id</code></li>
 * <li><code>category_id</code></li>
 * <li><code>parent_id</code>: ID of each category's parent category, if it exists.</li>
 * <li><code>product_id</code></li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Store_Category_Product extends Knectar_Select_Entity
{

	public function __construct()
	{
		parent::__construct();

		$this->from(array('catprod'=>$this->getTable('catalog/category_product')), 'product_id');
		$this->joinEntity('catprodin', 'catalog/category_product_index', '(catprodin.category_id=catprod.category_id) AND (catprodin.product_id=catprod.product_id)', 'store_id');
		$this->joinEntity('cat', 'catalog/category', '(cat.entity_id=catprod.category_id)');
		$this->group('store_id')->group('product_id');
	}

}

