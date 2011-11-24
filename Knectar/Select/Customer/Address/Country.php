<?php
/*
 * Copyright (C) 2011 by Knectar Design
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Queries all customers and their country names.
 * 
 * Exports the following fields:
 * <ul>
 * <li>customer_id</li>
 * <li>customer_address_id</li>
 * <li>country</li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Customer_Address_Country extends Knectar_Select_Customer_Address
{

	public function __construct()
	{
		parent::__construct();

		$this->joinAttribute('location', 'customer_address', 'country_id', 'custaddr.entity_id', null);

		// Country names are locale dependent and not stored in DB, need to be imported somehow
		$list = Mage::app()->getLocale()->getCountryTranslationList();
		$ids = '"' . join('","', array_keys($list)) . '"';
		$names = '"' . join('","', $list) . '"';
		$this->columns(array(
			'country' => "ELT(FIELD(location.value, {$ids}), {$names})"
		));
	}

	/**
	 * Adds the columns 'country' to {$select}
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
			$columns ? $columns : 'country'
		);
	}

}

