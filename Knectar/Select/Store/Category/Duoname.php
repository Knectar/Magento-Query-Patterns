<?php

/**
 * Queries all categories by their store. Name of each category and it's parent is included.
 * 
 * Exports the following fields:
 * <ul>
 * <li><code>store_id</code></li>
 * <li><code>category_id</code></li>
 * <li><code>parent_id</code></li>
 * <li><code>category_name</code></li>
 * <li><code>parent_category_name</code></li>
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

}

