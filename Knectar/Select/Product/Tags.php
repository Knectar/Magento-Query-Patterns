<?php

/**
 * Queries all products and their tags.
 * 
 * Exports the following fields:
 * <ul>
 * <li><code>product_id</code></li>
 * <li><code>product_tags</code>: Comma-separated tag values.</li>
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

}

