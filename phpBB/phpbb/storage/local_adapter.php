<?php

namespace phpbb\storage;

class local_adapter implements adapter_interface
{
	protected $filesystem;

	public function __construct()
	{
		$this->filesystem = new \phpbb\filesystem\filesystem();
	}

	public function fopen($filename, $mode) {
		return fopen($filename, $mode);
	}

	public function fwrite($handle, $string) {
		return fwrite($handle, $string);
	}

	public function fread($handle, $length)
	{
		return fread($handle, $length);
	}

	public function fclose($handle)
	{
		return $this->adapter->fclose($handle);
	}

	public function remove($files)
	{
		return $this->filesystem->remove($files);
	}

	public function mkdir($dir, $mode)
	{
		return $this->filesystem->mkdir($dir, $mode);
	}

	public function copy($source, $dest, $override)
	{
		return $this->filesystem->copy($source, $dest, $override);
	}

	public function rename($source, $dest, $override)
	{
		return $this->filesystem->rename($source, $dest, $override);
	}

	public function phpbb_is_writable($file)
	{
		return $this->filesystem->phpbb_is_writable($file);
	}

	public function is_writable($files, $recursive = false)
	{
		return $this->filesystem->is_writable($files, $recursive);
	}

	public function exists($files)
	{
		return $this->filesystem->exists($files);
	}

	public function phpbb_chmod($file, $perms, $recursive, $force_chmod_link)
	{
		return $this->filesystem->phpbb_chmod($file, $perms, $recursive, $force_chmod_link);
	}

	public function move_uploaded_file($source, $dest)
	{
		return move_uploaded_file($source, $dest);
	}
}
