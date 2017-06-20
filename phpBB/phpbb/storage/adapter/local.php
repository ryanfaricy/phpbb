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

namespace phpbb\storage\adapter;

use phpbb\storage\exception\exception;

class local implements adapter_interface
{
	protected $symfony_filesystem;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->symfony_filesystem	= new \Symfony\Component\Filesystem\Filesystem();
	}

	/**
	 * {@inheritdoc}
	 */
	public function put_contents($path, $content)
	{
		if ($this->exists($path))
		{
			//throw new exception('FILE_EXISTS', $path);
		}

		try
		{
			$this->symfony_filesystem->dumpFile($path, $content);
		}
		catch (\Symfony\Component\Filesystem\Exception\IOException $e)
		{
			throw new exception('CANNOT_DUMP_FILE', $path, array(), $e);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_contents($path)
	{
		return file_get_contents($path);
	}

	/**
	 * {@inheritdoc}
	 */
	public function exists($path)
	{
		return $this->symfony_filesystem->exists($path);
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete($path)
	{
		$this->delete_dir($path);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rename($path_orig, $path_dest)
	{
		try
		{
			$this->symfony_filesystem->rename($path_orig, $path_dest, false);
		}
		catch (\Symfony\Component\Filesystem\Exception\IOException $e)
		{
			$msg = $e->getMessage();
			$filename = substr($msg, strpos($msg, '"'), strrpos($msg, '"'));

			throw new exception('CANNOT_RENAME_FILE', $filename, array(), $e);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function copy($path_orig, $path_dest)
	{
		try
		{
			$this->symfony_filesystem->copy($path_orig, $path_dest, false);
		}
		catch (\Symfony\Component\Filesystem\Exception\IOException $e)
		{
			throw new exception('CANNOT_COPY_FILES', '', array(), $e);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function create_dir($path)
	{
		if(!mkdir($path, 0777, true))
		{
			throw new exception('CANNOT_CREATE_DIRECTORY', $path);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete_dir($path)
	{
		try
		{
			$this->symfony_filesystem->remove($path);
		}
		catch (\Symfony\Component\Filesystem\Exception\IOException $e)
		{
			// Try to recover filename
			// By the time this is written that is at the end of the message
			$error = trim($e->getMessage());
			$file = substr($error, strrpos($error, ' '));

			throw new exception('CANNOT_REMOVE_DIRECTORY', $file, array(), $e);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function read_stream($path)
	{
		$stream = @fopen($path, 'rb');

		if (!$stream)
		{
			throw new exception('CANNOT_OPEN_FILE', $path);
		}

		return $stream;
	}

	/**
	 * {@inheritdoc}
	 */
	public function write_stream($path, $resource)
	{
		if ($this->exists($path))
		{
			throw new exception('CANNOT_OPEN_FILE', $path);
		}

		$stream = @fopen($path, 'w+b');

		if (!$stream)
		{
			throw new exception('CANNOT_OPEN_FILE', $path);
		}

		stream_copy_to_stream($resource, $stream);
	}
}
