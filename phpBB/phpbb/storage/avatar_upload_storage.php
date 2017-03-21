<?php

namespace phpbb\storage;

class avatar_upload_storage extends storage
{
	public function __construct(\phpbb\phpbb\filesystem_interface $adapter)
	{
		// $adapter = \phpbb\filesystem\filesystem
		// $adapter = \ext\rubencm\phpbb-cloud-storage\adapters\s3

		// event to modify adapter

		$this->adapter = $adapter;
	}
}
