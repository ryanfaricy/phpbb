<?php

namespace phpbb\storage;

use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;
use Dropbox\Client;

class dropbox_adapter implements adapter_interface
{
	protected $filesystem;

	public function __construct($accessToken, $appSecret, $prefix = '')
	{
		$client = new Client($accessToken, $appSecret);
		$adapter = new DropboxAdapter($client, $prefix);

		$this->filesystem = new Filesystem($adapter);
	}

	public function fopen($filename, $mode) {
		return ['handle' => fopen($filename, $mode), 'filename' => $filename];
	}

	public function fwrite($handle, $string) {
		$this->filesystem->writeStream($string, $handle['filename']);
		return 1; // !!
	}

	public function fread($handle, $length)
	{
		$stream = $this->filesystem->readStream($handle['filename']);
		return stream_get_contents($stream);
	}

	public function fclose($handle)
	{
		if(is_resource($handle['handle']))
		{
			fclose($handle['handle']);
		}
	}

	public function remove($files)
	{
		try
		{
			if(is_array($files))
			{
				foreach($files as $file)
				{
					$this->filesystem->delete($file);
				}
			}
			else
			{
				$this->filesystem->delete($files);
			}
		} catch(\Exception $e) {}
	}

	public function mkdir($dir, $mode)
	{
		return $this->filesystem->mkdir($dir);
	}

	public function copy($source, $dest, $override)
	{
		if($override)
		{
			$this->remove($dest);
		}
		$this->filesystem->write($dest, file_get_contents($source));
		return true;
		// !!!
		//return $this->filesystem->copy($source, $dest);
	}

	public function rename($source, $dest, $override)
	{
		if($override)
		{
			$this->remove($dest);
		}

		return $this->filesystem->rename($source, $dest);
	}

	public function phpbb_is_writable($file)
	{
		return true;
	}

	public function is_writable($files, $recursive)
	{
		return true;
	}

	public function exists($files)
	{
		if(is_array($files))
		{
			foreach($files as $file)
			{
				if($this->filesystem->has($file))
				{
					return true;
				}
			}
		}
		else
		{
			if($this->filesystem->has($files))
			{
				return true;
			}
		}

		return false;
	}

	public function phpbb_chmod($file, $perms, $recursive, $force_chmod_link)
	{
		return true;
	}

	public function move_uploaded_file($source, $dest)
	{
		$this->copy($source, $dest, true);
	}
}
