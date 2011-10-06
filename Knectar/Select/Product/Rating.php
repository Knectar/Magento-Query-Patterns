<?php

/**
 * Queries all products and their reviews.
 * 
 * Exports the following fields:
 * <ul>
 * <li>product_id</li>
 * <li>rating_summary: Individual percent value</li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Product_Rating extends Knectar_Select_Product
{

	public function __construct()
	{
		parent::__construct();

		$this->joinEntity('review', 'review/review_aggregate', 'review.entity_pk_value=products.entity_id', 'rating_summary');
	}

}

