<?php
/**
 *
 * This file is part of the phpBB Forum Software package.
 *
 * @copyright (c) phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * For full copyright and license information, please see
 * the docs/CREDITS.txt file.
 *
 */

namespace phpbb\storage;

class avatar
{
	protected $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function get_name()
	{
		return 'avatar';
	}

	public function get_items()
	{
		// this should return an iterator, or a generator or something like that
		// not an array with all items, because it could be huge
		// also this would allow to move all the files between storages when
		// it is changed from acp
		// $db -> select avatar from phpbb_users where user_avatar != ''
	}

	// return the number of stored items
	public function get_num_items()
	{
		// $db-> select count(*) from phpbb_users where  user_avatar != ''
	}

	// returns the total bytes
	// this is an aproximation, since every storage counts them in a different way
	// for example if i dont remember wrong, in s3 each file ocupies at least 128kb
	// even if they are empty
	public function get_size()
	{
		// $db -> select sum(user_avatar_size) from phpbb_users
		// or something like that
	}
}
