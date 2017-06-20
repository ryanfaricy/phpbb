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

 class phpbb_storage_adapter_local_test extends phpbb_test_case
 {
	 protected $adapter;

	public function setUp()
 	{
 		parent::setUp();

		$this->adapter = new \phpbb\storage\adapter\local();
 	}

	public function tearDown()
	{
		$this->adapter = null;
	}

	public function test_put_contents()
	{
		$this->adapter->put_contents('file.txt', '');
		$this->assertTrue($this->adapter->exists('file.txt'));
		$this->adapter->delete('file.txt');
	}

	public function test_get_contents()
	{
		$this->adapter->put_contents('file.txt', 'abc');
		$this->assertEquals($this->adapter->get_contents('file.txt'), 'abc');
		$this->adapter->delete('file.txt');
	}

	public function test_exists()
	{
		// Exists with files
		$this->adapter->put_contents('file.txt', '');
		$this->assertTrue($this->adapter->exists('file.txt'));
		$this->adapter->delete('file.txt');
		// exists with directory
		$this->adapter->create_dir('directory');
		$this->assertTrue($this->adapter->exists('directory'));
		$this->adapter->delete_dir('directory');
	}

	public function test_delete()
	{
		$this->adapter->put_contents('file.txt', '');
		$this->assertTrue($this->adapter->exists('file.txt'));
		$this->adapter->delete('file.txt');
		$this->assertFalse($this->adapter->exists('file.txt'));

	}

	public function test_rename()
	{
		$this->adapter->put_contents('file.txt', '');
		$this->assertTrue($this->adapter->exists('file.txt'));
		$this->adapter->rename('file.txt', 'file2.txt');
		$this->assertFalse($this->adapter->exists('file.txt'));
		$this->assertTrue($this->adapter->exists('file2.txt'));
		$this->adapter->delete('file2.txt');
	}

	public function test_copy()
	{
		$this->adapter->put_contents('file.txt', 'abc');
		$this->assertTrue($this->adapter->exists('file.txt'));
		$this->adapter->copy('file.txt', 'file2.txt');
		$this->assertTrue($this->adapter->exists('file.txt'));
		$this->assertTrue($this->adapter->exists('file2.txt'));
		$this->assertEquals($this->adapter->get_contents('file.txt'), 'abc');
		$this->assertEquals($this->adapter->get_contents('file.txt'), 'abc');
		$this->adapter->delete('file.txt');
		$this->adapter->delete('file2.txt');
	}

	public function test_create_dir()
	{
		$this->adapter->create_dir('path/to/dir');
		$this->assertTrue($this->adapter->exists('path/to/dir'));
		$this->adapter->delete_dir('path');
	}

	public function test_delete_dir()
	{
		$this->adapter->create_dir('directory');
		$this->adapter->put_contents('directory/file.txt', '');
		$this->assertTrue($this->adapter->exists('directory'));
		$this->assertTrue($this->adapter->exists('directory/file.txt'));
		$this->adapter->delete_dir('directory');
		$this->assertFalse($this->adapter->exists('directory'));
		$this->assertFalse($this->adapter->exists('directory/file.txt'));
	}

	public function test_read_stream()
	{

	}

	public function test_write_stream()
	{

	}
 }
