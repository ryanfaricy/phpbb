<?php

namespace phpbb\storage;

class storage implements storage_interface
{
	protected $adapter;

	public function __construct(\phpbb\event\dispatcher_interface $dispatcher)
	{
		 $adapter = new \phpbb\storage\local_adapter();

		///*
		$adapter = new \phpbb\storage\dropbox_adapter('pZBNbKV5XvYAAAAAAAAGOgiQcNDhKFPylut9y239A082z26AiUx3t3-DI-jA4H_0', '1jeeqyjn02enjrl');

		//$vars = array('adapter');
		//extract($dispatcher->trigger_event('core.storage_adapter', compact($vars)));
		//*/

		$this->adapter = $adapter;
	}

	public function fopen($filename, $mode) {
		return $this->adapter->fopen($filename, $mode);
	}

	public function fwrite($handle, $string) {
		return $this->adapter->fwrite($handle, $string);
	}

	public function fread($handle, $length)
	{
		return $this->adapter->fread($handle, $length);
	}

	public function fclose($handle)
	{
		return $this->adapter->fclose($handle);
	}

	public function remove($files)
	{
		return $this->adapter->remove($files);
	}

	public function mkdir($dir, $mode = 0777)
	{
		return $this->adapter->mkdir($dir, $mode);
	}

	public function copy($source, $dest, $override = false)
	{
		return $this->adapter->copy($source, $dest, $override);
	}

	public function rename($source, $dest, $override = false)
	{
		return $this->adapter->rename($source, $dest, $override);
	}

	public function phpbb_is_writable($file)
	{
		return $this->adapter->phpbb_is_writable($file);
	}

	public function is_writable($files, $recursive = false)
	{
		return $this->adapter->is_writable($files, $recursive);
	}

	public function exists($files)
	{
		return $this->adapter->exists($files);
	}

	public function phpbb_chmod($file, $perms = null, $recursive = false, $force_chmod_link = false)
	{
		return $this->adapter->phpbb_chmod($file, $perms, $recursive, $force_chmod_link);
	}

	public function move_uploaded_file($source, $dest)
	{
		return $this->adapter->move_uploaded_file($source, $dest);
	}

}
