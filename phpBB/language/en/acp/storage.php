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

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(

	// Template
	'STORAGE_TITLE'					=> 'Storage Settings',
	'STORAGE_TITLE_EXPLAIN'			=> 'Change storage providers for the file storage types of phpBB. Choose local or remote providers to store files added to or created by phpBB.',
	'STORAGE_SELECT'				=> 'Select storage',
	'STORAGE_SELECT_DESC'			=> 'Select a storage from the list.',

	// Storage names
	'STORAGE_ATTACHMENT_TITLE'		=> 'Attachments storage',
	'STORAGE_AVATAR_TITLE'			=> 'Avatars storage',
	'STORAGE_BACKUP_TITLE'			=> 'Backup storage',

	// Local adapter
	'STORAGE_ADAPTER_LOCAL_NAME'			=> 'Local',
	'STORAGE_ADAPTER_LOCAL_OPTION_PATH'		=> 'Path',

	// AWS S3
	'STORAGE_ADAPTER_AWS_S3_NAME'						=> 'Amazon Web Services S3',
	'STORAGE_ADAPTER_AWS_S3_OPTION_KEY'					=> 'Key',
	'STORAGE_ADAPTER_AWS_S3_OPTION_SECRET'				=> 'Secret',
	'STORAGE_ADAPTER_AWS_S3_OPTION_REGION'				=> 'Region',
	'STORAGE_ADAPTER_AWS_S3_OPTION_VERSION'				=> 'Version',
	'STORAGE_ADAPTER_AWS_S3_OPTION_BUCKET'				=> 'Bucket',
	'STORAGE_ADAPTER_AWS_S3_OPTION_PATH'				=> 'Path',
	'STORAGE_ADAPTER_AWS_S3_OPTION_HOTLINK'				=> 'Hotlink',
	'STORAGE_ADAPTER_AWS_S3_OPTION_HOTLINK_EXPLAIN'		=> 'The file will be linked directly.',

	// Azure Blob adapter
	'STORAGE_ADAPTER_AZURE_BLOB_NAME'				=> 'Azure Blob',
	'STORAGE_ADAPTER_AZURE_BLOB_OPTION_ACCOUNTNAME'	=> 'Account Name',
	'STORAGE_ADAPTER_AZURE_BLOB_OPTION_ACCOUNTKEY'	=> 'Account Key',
	'STORAGE_ADAPTER_AZURE_BLOB_OPTION_CONTAINER'	=> 'Container Name',
	'STORAGE_ADAPTER_AZURE_BLOB_OPTION_PATH'		=> 'Local Path',

	// Dropbox
	'STORAGE_ADAPTER_DROPBOX_NAME'							=> 'Dropbox',
	'STORAGE_ADAPTER_DROPBOX_OPTION_ACCESS_TOKEN'			=> 'Access Token',
	'STORAGE_ADAPTER_DROPBOX_OPTION_PATH'					=> 'Path',
	'STORAGE_ADAPTER_DROPBOX_OPTION_HOTLINK'				=> 'Hotlink',
	'STORAGE_ADAPTER_DROPBOX_OPTION_HOTLINK_EXPLAIN'		=> 'The file will be linked directly.',

	// Ftp
	'STORAGE_ADAPTER_FTP_NAME'					=> 'Ftp',
	'STORAGE_ADAPTER_FTP_OPTION_HOST'			=> 'Host',
	'STORAGE_ADAPTER_FTP_OPTION_USERNAME'		=> 'Username',
	'STORAGE_ADAPTER_FTP_OPTION_PASSWORD'		=> 'Password',
	'STORAGE_ADAPTER_FTP_OPTION_PORT'			=> 'Port',
	'STORAGE_ADAPTER_FTP_OPTION_PATH'			=> 'Root path',
	'STORAGE_ADAPTER_FTP_OPTION_PASSIVE'		=> 'Passive',
	'STORAGE_ADAPTER_FTP_OPTION_SSL'			=> 'Ssl',

	// Google Drive
	'STORAGE_ADAPTER_GOOGLE_DRIVE_NAME'							=> 'Google Drive',
	'STORAGE_ADAPTER_GOOGLE_DRIVE_OPTION_APP_CLIENT_ID'			=> 'App client id',
	'STORAGE_ADAPTER_GOOGLE_DRIVE_OPTION_CLIENT_SECRET'			=> 'Client secret',
	'STORAGE_ADAPTER_GOOGLE_DRIVE_OPTION_REFRESH_TOKEN'			=> 'Refresh token',
	'STORAGE_ADAPTER_GOOGLE_DRIVE_OPTION_ROOT'					=> 'Root folder',

	// Form validation
	'STORAGE_UPDATE_SUCCESSFUL' 				=>	'All storage types were successfully updated.',
	'STORAGE_NO_CHANGES'						=>	'No changes have been applied.',
	'STORAGE_PROVIDER_NOT_EXISTS'				=>	'Provider selected for %s doesn’t exist.',
	'STORAGE_PROVIDER_NOT_AVAILABLE'			=>	'Provider selected for %s is not available.',
	'STORAGE_FORM_TYPE_EMAIL_INCORRECT_FORMAT'	=>	'Incorrect email for %s of %s.',
	'STORAGE_FORM_TYPE_TEXT_TOO_LONG'			=>	'Text is too long for %s of %s.',
	'STORAGE_FORM_TYPE_SELECT_NOT_AVAILABLE'	=>	'Selected value is not available for %s of %s.',
));
