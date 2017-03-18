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

namespace phpbb\install\helper;

use phpbb\install\exception\cannot_build_container_exception;
use phpbb\language\language;
use phpbb\request\request;

class container_factory
{
	/**
	 * @var \phpbb\install\helper\config
	 */
	protected $config_helper;

	/**
	 * @var \phpbb\install\helper\database
	 */
	protected $db_helper;

	/**
	 * @var language
	 */
	protected $language;

	/**
	 * @var string
	 */
	protected $phpbb_root_path;

	/**
	 * @var string
	 */
	protected $php_ext;

	/**
	 * @var \phpbb\request\request
	 */
	protected $request;

	/**
	 * @var update_helper
	 */
	protected $update_helper;

	/**
	 * The full phpBB container
	 *
	 * @var \Symfony\Component\DependencyInjection\ContainerInterface
	 */
	protected $container;

	/**
	 * Constructor
	 *
	 * @param language 		$language			Language service
	 * @param request		$request			Request interface
	 * @param update_helper	$update_helper		Update helper
	 * @param string		$phpbb_root_path	Path to phpBB's root
	 * @param string		$php_ext			Extension of PHP files
	 */
	public function __construct(\phpbb\install\helper\config $config_helper, \phpbb\install\helper\database $db_helper, language $language, request $request, update_helper $update_helper, $phpbb_root_path, $php_ext)
	{
		$this->config_helper	= $config_helper;
		$this->db_helper		= $db_helper;
		$this->language			= $language;
		$this->request			= $request;
		$this->update_helper	= $update_helper;
		$this->phpbb_root_path	= $phpbb_root_path;
		$this->php_ext			= $php_ext;
		$this->container		= null;
	}

	/**
	 * Container getter
	 *
	 * @param null|string	$service_name	Name of the service to return
	 *
	 * @return \Symfony\Component\DependencyInjection\ContainerInterface|Object	phpBB's dependency injection container
	 * 																			or the service specified in $service_name
	 *
	 * @throws \phpbb\install\exception\cannot_build_container_exception							When container cannot be built
	 * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException			If the service is not defined
	 * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException	When a circular reference is detected
	 * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException			When the service is not defined
	 */
	public function get($service_name = null)
	{
		// Check if container was built, if not try to build it
		if ($this->container === null)
		{
			$this->build_container();
		}

		return ($service_name === null) ? $this->container : $this->container->get($service_name);
	}

	/**
	 * Returns the specified parameter from the container
	 *
	 * @param string	$param_name
	 *
	 * @return mixed
	 *
	 * @throws \phpbb\install\exception\cannot_build_container_exception	When container cannot be built
	 */
	public function get_parameter($param_name)
	{
		// Check if container was built, if not try to build it
		if ($this->container === null)
		{
			$this->build_container();
		}

		return $this->container->getParameter($param_name);
	}

	/**
	 * Build dependency injection container
	 *
	 * @throws \phpbb\install\exception\cannot_build_container_exception	When container cannot be built
	 */
	protected function build_container()
	{
		// If the container has been already built just return.
		// Although this should never happen
		if ($this->container instanceof \Symfony\Component\DependencyInjection\ContainerInterface)
		{
			return;
		}

		// Check whether container can be built
		// We need config.php for that so let's check if it has been set up yet
		if (!filesize($this->phpbb_root_path . 'config.' . $this->php_ext))
		{
			throw new cannot_build_container_exception();
		}

		$phpbb_config_php_file = new \phpbb\config_php_file($this->phpbb_root_path, $this->php_ext);
		$phpbb_container_builder = new \phpbb\di\container_builder($this->phpbb_root_path, $this->php_ext);

		// For BC with functions that we need during install
		global $phpbb_container, $table_prefix;

		$disable_super_globals = $this->request->super_globals_disabled();

		// This is needed because container_builder::get_env_parameters() uses $_SERVER
		if ($disable_super_globals)
		{
			$this->request->enable_super_globals();
		}

		$other_config_path = $this->phpbb_root_path . 'install/update/new/config';
		$config_path = (is_dir($other_config_path)) ? $other_config_path : $this->phpbb_root_path . 'config';

		$this->container = $phpbb_container_builder
			->with_environment('production')
			->with_config($phpbb_config_php_file)
			->with_config_path($config_path)
			->without_compiled_container()
			->get_container();

		// Setting request is required for the compatibility globals as those are generated from
		// this container
		if (!$this->container->isFrozen())
		{
			$this->container->register('config')->setSynthetic(true);
			$this->container->register('db')->setSynthetic(true);
			$this->container->register('request')->setSynthetic(true);
			$this->container->register('language')->setSynthetic(true);
		}

		$dbms = $this->db_helper->get_available_dbms($this->config_helper->get('dbms'));
		$dbms = $dbms[$this->config_helper->get('dbms')]['DRIVER'];

		$db = new $dbms();
		$db->sql_connect(
			$this->config_helper->get('dbhost'),
			$this->config_helper->get('dbuser'),
			$this->config_helper->get('dbpasswd'),
			$this->config_helper->get('dbname'),
			$this->config_helper->get('dbport'),
			false,
			false
		);

		$config = new \phpbb\config\db($db, new \phpbb\cache\driver\dummy, CONFIG_TABLE);

		$this->container->set('config', $config);
		$this->container->set('db', $db);
		$this->container->set('request', $this->request);
		$this->container->set('language', $this->language);

		$this->container->compile();

		$phpbb_container = $this->container;
		$table_prefix = $phpbb_config_php_file->get('table_prefix');

		// Restore super globals to previous state
		if ($disable_super_globals)
		{
			$this->request->disable_super_globals();
		}

		// Get compatibilty globals and constants
		$this->update_helper->include_file('includes/compatibility_globals.' . $this->php_ext);

		register_compatibility_globals();

		$this->update_helper->include_file('includes/constants.' . $this->php_ext);
	}
}
