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

use phpbb\config\config;

class adapter_factory
{
	protected $config;
	protected $adapters;
	protected $providers;

	public function __construct(config $config, $adapters, $providers)
	{
		$this->config = $config;
		$this->adapters = $adapters;
		$this->providers = $providers;
	}

	public function get($type)
	{
		$adapter = $this->config['storage_' . $type];
		$available = false;

		foreach($this->providers as $provider)
		{
			if($provider->get_name() == $adapter)
			{
				$available = true;
				break;
			}
		}

		return new $adapter();
	}
}
