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

namespace phpbb\storage\controller;

use phpbb\config;
use phpbb\db\driver\driver_interface;
use phpbb\exception\http_exception;
use Symfony\Component\HttpFoundation\RedirectResponse;

class attachment
{
	/**
	 * @var \phpbb\config\config
	 */
	protected $config;

	/**
	* @var ContainerInterface
	*/
	protected $container;

	/**
	 * @var \phpbb\db\driver\driver_interface
	 */
	protected $db;

	/**
	 * @var string
	 */
	protected $attachments_table;

	/**
	* Constructor.
	*
	* @param ContainerInterface $container A ContainerInterface instance
	*/
	public function __construct(config $config, ContainerInterface $container, db $db, $attachments_table)
	{
		$this->config = $config;
		$this->container = $container;
		$this->db = $db;
		$this->attachments_table = $attachments_table;
	}

	/**
	 * Controller for /download/attachment/{id} routes
	 *
	 * @param int		$id		ID of the entity to report
	 * @return \Symfony\Component\HttpFoundation\Response a Symfony response object
	 * @throws \phpbb\exception\http_exception when $mode or $id is invalid for some reason
	 */
	public function handle($filename)
	{
		$this->sun_check(); // ??

		$file = $this->get_avatar_file($id);


		$storage = $this->container->get('storage.'.$type);
		echo $storage->get_contents($file);
	}

	// TODO: dont use superglobals, use request
	protected function sun_check()
	{
		// Thank you sun.
		if (isset($_SERVER['CONTENT_TYPE']))
		{
			if ($_SERVER['CONTENT_TYPE'] === 'application/x-java-archive')
			{
				exit;
			}
		}
		else if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Java') !== false)
		{
			exit;
		}
	}

}
