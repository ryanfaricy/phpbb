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

// /download/file.php

class file
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
	 * Controller for /download/{type}/{id} routes
	 *
	 * Because of how phpBB organizes routes $mode must be set in the route config.
	 *
	 * @param int		$id		ID of the entity to report
	 * @param string	$mode
	 * @return \Symfony\Component\HttpFoundation\Response a Symfony response object
	 * @throws \phpbb\exception\http_exception when $mode or $id is invalid for some reason
	 */
	public function handle($type, $id)
	{
		$storage = $this->container->get('storage.'.$type);

		switch($type)
		{
			case 'attachment':
				$file = $this->get_attachment_file($id);
				break;
			case 'avatar':
				$file = $this->get_avatar_file($id);
				break;
		}

		echo $storage->get_contents($file)
	}

	protected function get_attachment_file()
	{
		// variables: id (attachment id), mode, t (thumbnail)

		if (!$config['allow_attachments'] && !$config['allow_pm_attach'])
		{
			send_status_line(404, 'Not Found');
			trigger_error('ATTACHMENT_FUNCTIONALITY_DISABLED');
		}

		$attachment = $this->get_attachment($id);

		if(!$attachment)
		{
			send_status_line(404, 'Not Found');
			trigger_error('ERROR_NO_ATTACHMENT');
			return;
		}

		if(!$this->is_download_allowed())
		{
			send_status_line(403, 'Forbidden');
			trigger_error($user->lang['LINKAGE_FORBIDDEN']);
			return;
		}
	}

	protected function get_avatar_file()
	{

	}

	protected function get_attachment($id)
	{
		$sql = 'SELECT attach_id, post_msg_id, topic_id, in_message, poster_id, is_orphan, physical_filename, real_filename, extension, mimetype, filesize, filetime
			FROM ' . $this->attachments_table . "
			WHERE attach_id = $id";
		$result = $this->db->sql_query($sql);
		$attachment = $this->db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		return $attachment;
	}

	// todo: include function content here
	/**
	 * Check if downloading item is allowed
	 */
	protected function id_download_allowed()
	{
		global $phpbb_root_path, $phpEx;

		if(!function_exists('download_allowed'))
		{
			require('includes/functions_download.php');
		}

		return download_allowed();
	}

}
