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
use phpbb\di\service_collection;

class adapter_factory
{
	protected $config;
	protected $adapters;
	protected $providers;

	public function __construct(config $config, service_collection $adapters, service_collection $providers)
	{
		$this->config = $config;
		$this->adapters = $adapters;
		$this->providers = $providers;
//$this->providers->get_by_class($adapter);
	}

	public function get($type)
	{
		$adapter = $this->config['storage_' . $type];

		return new $this->providers->get_by_class($adapter);
	}
}
