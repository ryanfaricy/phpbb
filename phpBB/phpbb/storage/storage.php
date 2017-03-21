<?php

namespace phpbb\storage;

class storage implements storage_interface
{
	/**
	 * {@inheritdoc}
	 */
	public function chgrp($files, $group, $recursive = false)
	{
		return $this->adapter->chgrp($files, $group, $recursive);
	}

	/**
	 * {@inheritdoc}
	 */
	public function chmod($files, $perms = null, $recursive = false, $force_chmod_link = false)
	{
		return $this->adapter->chmod($files, $perms, $recursive, $force_chmod_link);
	}

	/**
	 * {@inheritdoc}
	 */
	public function chown($files, $user, $recursive = false)
	{
		return $this->adapter->chmod($files, $user, $recursive);
	}

	/**
	 * {@inheritdoc}
	 */
	public function clean_path($path)
	{
		return $this->adapter->chmod($path);
	}

	/**
	 * {@inheritdoc}
	 */
	public function copy($origin_file, $target_file, $override = false)
	{
		return $this->adapter->copy($origin_file, $target_file, $override);
	}

	/**
	 * {@inheritdoc}
	 */
	public function dump_file($filename, $content)
	{
		return $this->adapter->dump_file($filename, $content);
	}

	/**
	 * {@inheritdoc}
	 */
	public function exists($files)
	{
		return $this->adapter->exists($files);
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_absolute_path($path)
	{
		return $this->adapter->is_absolute_path($path);;
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_readable($files, $recursive = false)
	{
		return $this->adapter->is_readable($files, $recursive);
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_writable($files, $recursive = false)
	{
		return $this->adapter->is_writable($files, $recursive);
	}

	/**
	 * {@inheritdoc}
	 */
	public function make_path_relative($end_path, $start_path)
	{
		return $this->symfony_filesystem->makePathRelative($end_path, $start_path);
	}

	/**
	 * {@inheritdoc}
	 */
	public function mirror($origin_dir, $target_dir, \Traversable $iterator = null, $options = array())
	{
		return $this->adapter->mirror($origin_dir, $target_dir, $iterator, $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function mkdir($dirs, $mode = 0777)
	{
		return $this->adapter->mkdir($dirs, $mode);
	}

	/**
	 * {@inheritdoc}
	 */
	public function phpbb_chmod($files, $perms = null, $recursive = false, $force_chmod_link = false)
	{
		return $this->adapter->chmod($files, $perms, $recursive, $force_chmod_link);
	}

	/**
	 * {@inheritdoc}
	 */
	public function realpath($path)
	{
		return $this->adapter->realpath($path);
	}

	/**
	 * {@inheritdoc}
	 */
	public function remove($files)
	{
		return $this->adapter->realpath($path);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rename($origin, $target, $overwrite = false)
	{
		return $this->adapter->rename($origin, $target, $overwrite);
	}

	/**
	 * {@inheritdoc}
	 */
	public function symlink($origin_dir, $target_dir, $copy_on_windows = false)
	{
		return $this->adapter->rename($origin_dir, $target_dir, $copy_on_windows);
	}

	/**
	 * {@inheritdoc}
	 */
	public function touch($files, $time = null, $access_time = null)
	{
		return $this->adapter->touch($files, $time, $access_time);
	}

	/**
	 * phpBB's implementation of is_writable
	 *
	 * @todo Investigate if is_writable is still buggy
	 *
	 * @param string	$file	file/directory to check if writable
	 *
	 * @return bool	true if the given path is writable
	 */
	protected function phpbb_is_writable($file)
	{
		return $this->adapter->is_writable($file);
	}

	/**
	 * Try to resolve real path when PHP's realpath failes to do so
	 *
	 * @param string	$path
	 * @return bool|string
	 */
	protected function phpbb_own_realpath($path)
	{
		return $this->adapter->realpath($path);
	}

	/**
	 * Convert file(s) to \Traversable object
	 *
	 * This is the same function as Symfony's toIterator, but that is private
	 * so we cannot use it.
	 *
	 * @param string|array|\Traversable	$files	filename/list of filenames
	 * @return \Traversable
	 */
	protected function to_iterator($files)
	{
		if (!$files instanceof \Traversable)
		{
			$files = new \ArrayObject(is_array($files) ? $files : array($files));
		}

		return $files;
	}

	/**
	 * Try to resolve symlinks in path
	 *
	 * @param string	$path			The path to resolve
	 * @param string	$prefix			The path prefix (on windows the drive letter)
	 * @param bool 		$absolute		Whether or not the path is absolute
	 * @param bool		$return_array	Whether or not to return path parts
	 *
	 * @return string|array|bool	returns the resolved path or an array of parts of the path if $return_array is true
	 * 								or false if path cannot be resolved
	 */
	protected function resolve_path($path, $prefix = '', $absolute = false, $return_array = false)
	{
		return $this->adapter->resolve_path($path, $prefix = '', $absolute = false, $return_array = false);
	}
}
