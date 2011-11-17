<?php

/**
 * Queries all categories by their store. Name is included.
 * 
 * Exports the following fields:
 * <ul>
 * <li>store_id</li>
 * <li>category_id</li>
 * <li>parent_id: ID of each category's parent category, if it exists.</li>
 * <li>category_name</li>
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

	/**
	 * Adds the column 'category_name' to {$select}
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
			$columns ? $columns : 'category_name'
		);
	}

}

