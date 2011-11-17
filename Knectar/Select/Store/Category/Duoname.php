<?php

/**
 * Queries all categories by their store. Name of each category and it's parent is included.
 * 
 * Exports the following fields:
 * <ul>
 * <li>store_id</li>
 * <li>category_id</li>
 * <li>parent_id</li>
 * <li>category_name</li>
 * <li>parent_category_name</li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Store_Category_Duoname extends Knectar_Select_Store_Category_Name
{

	public function __construct()
	{
		parent::__construct();
		$this->joinAttribute('parentcatname', 'catalog_category', 'name', 'cat.parent_id', 0, null, self::LEFT_JOIN);
		$this->columns(array(
			'parent_category_name' => 'IF(cat.level > 2, parentcatname.value, NULL)',
		));
	}

	/**
	 * Adds the columns 'category_name' and 'parent_category_name' to {$select}
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
			$columns ? $columns : array('category_name', 'parent_category_name')
		);
	}

}

