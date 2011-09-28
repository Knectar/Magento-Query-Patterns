<?php

/**
 * Establishes a product related query.
 * 
 * Exports the following fields:
 * <ul>
 * <li><code>product_id</code></li>
 * </ul
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Product extends Knectar_Select_Entity
{

	public function __construct()
	{
		parent::__construct();

		$this->from(array('products'=>$this->getTable('catalog/product')), array('product_id'=>'entity_id'));
		$this->group('product_id');
	}

}

