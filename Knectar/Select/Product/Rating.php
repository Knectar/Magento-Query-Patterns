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

	/**
	 * Adds the column 'rating_summary' to {$select}
	 *
	 * @param Varien_Db_Select $select
	 * @param string $tableName
	 * @param string $condition
	 * @param array $columns
	 * @param string $type
	 */
	public static function enhance(Varien_Db_Select $select, $tableName, $condition, $columns = null, $type = self::LEFT_JOIN)
	{
		$select->_join(
			$type,
			array($tableName => new self()),
			$condition,
			$columns ? $columns : 'rating_summary'
		);
	}

}

