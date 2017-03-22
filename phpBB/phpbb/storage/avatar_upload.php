<?php

namespace phpbb\storage;

class avatar_upload extends storage
{
	public function __construct(\phpbb\config\config $config, \phpbb\filesystem\filesystem_interface $adapter, \phpbb\event\dispatcher_interface $dispatcher)
	{
		// $adapter = \phpbb\filesystem\filesystem
		// $adapter = \ext\rubencm\phpbb-cloud-storage\adapters\s3
		$this->config = $config;

		$vars = array('adapter');
		extract($dispatcher->trigger_event('core.storage_avatar_adapter', compact($vars)));

		$this->adapter = $adapter;
	}
}
