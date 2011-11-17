<?php

/**
 * Queries all products and their tags.
 * 
 * Exports the following fields:
 * <ul>
 * <li>product_id</li>
 * <li>product_tags: Comma-separated tag values.</li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Product_Tags extends Knectar_Select_Product
{

	public function __construct()
	{
		parent::__construct();

		$this->joinEntity('tag', 'tag/relation', 'tag.product_id=products.entity_id');
		$this->joinEntity('tagname', 'tag/tag', 'tagname.tag_id=tag.tag_id');
		$this->columns(array(
			'product_tags'=>'GROUP_CONCAT(DISTINCT tagname.name)'
		));
	}

	/**
	 * Adds the column 'product_tags' to {$select}
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
			$columns ? $columns : 'product_tags'
		);
	}

}

