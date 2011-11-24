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
 * Establishes an admin user related query.
 * 
 * Exports the following fields:
 * <ul>
 * <li>user_id</li>
 * <li>username</li>
 * <li>firstname</li>
 * <li>lastname</li>
 * <li>email</li>
 * <li>role_name</li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

abstract class Knectar_Select_Admin extends Knectar_Select_Entity
{

	public function __construct()
	{
		parent::__construct();

		$this->from(
			array('user' => $this->getTable('admin/user')),
			array('user_id', 'username', 'firstname', 'lastname', 'email')
		);
		$this->joinLeft(
			array('role' => $this->getTable('admin/role')),
			'user.user_id=role.user_id',
			array('role_name')
		);
		$this->group('user_id');
	}

}

