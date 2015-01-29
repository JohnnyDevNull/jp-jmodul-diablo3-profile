<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_jpd3
 *
 * @copyright   Copyright (C) Philipp John, All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_diablo_profile
 *
 * @package     Joomla.Site
 * @subpackage  mod_jpd3
 */
class ModDiabloProfileHelper
{
	/**
	 * Gets a career or a hero profile.
	 *
	 * @param JRegistry &$params The module options.
	 *
	 * @return null|json
	 */
	public static function getCareerProfile(&$params)
	{
		$battleUrl = $params->get('battle_url');
		$battleName = $params->get('battle_name');
		$battleID = $params->get('battle_id');

		if (
			empty($battleUrl)
			|| empty($battleName)
			|| empty($battleID)
		) {
			return null;
		}

		$filepart = $battleName.'_'.$battleID.'_';
		$cachedString = self::checkForCacheFiles($filepart, $params->get('cache_duration'));

		if($cachedString === false)
		{
			$buffer = '';
			$path = '/api/d3/profile/'.$battleName.'-'.$battleID.'/';
			$fp = fsockopen($battleUrl, 80, $errno, $errstr, 30);

			if (!$fp)
			{
				$buffer .= "$errstr ($errno)<br />\n";
			}
			else
			{
				$out = "GET ".$path." HTTP/1.1\r\n";
				$out .= "Host: ".$battleUrl."\r\n";
				$out .= "Connection: Close\r\n\r\n";

				fwrite($fp, $out);

				while (!feof($fp))
				{
					$buffer .= fgets($fp, 128);
				}

				fclose($fp);
			}

			$careerData = array();
			$data = explode("\r\n\r\n", $buffer);
			$start = strpos($data[1], '{');
			$end = strrpos($data[1], '}');

			if($start !== false && $end !== false)
			{
				$length = ($end - $start + 1);
				$jsonString = substr($data[1], $start, $length);

				if(!empty($jsonString))
				{
					if((bool)$params->get('cache_requests'))
					{
						self::writeToModuleCache($jsonString, $filepart);
					}

					$careerData = json_decode($jsonString, true);
				}
			}
		}
		else
		{
			$careerData = json_decode($cachedString, true);
			$careerData['cache_used'] = 1;
		}

		return $careerData;
	}

	/**
	 * Writes a given career or hero profile to module cache folder.
	 *
	 * @param string $json
	 *
	 * @return bool
	 */
	public static function writeToModuleCache($json, $filepart)
	{
		jimport('joomla.filesystem.folder');
		$folder = 'modules/mod_diablo_profile/cache/';
		$requestFilename = $filepart.time().'.career';
		$fileArray = JFolder::files($folder, $filepart.'*');

		if(empty($fileArray))
		{
			jimport('joomla.filesystem.file');

			if(JFile::write($folder.$requestFilename, $json))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Checks if chached files for the new request exists.
	 *
	 * @param string $filepart
	 * @param int $cacheDuration
	 */
	public static function checkForCacheFiles($filepart, $cacheDuration)
	{
		jimport('joomla.filesystem.folder');
		$folder = 'modules/mod_diablo_profile/cache/';
		$fileArray = JFolder::files($folder, $filepart.'*');

		foreach($fileArray as $file)
		{
			$filename = basename($file, '.career');
			$nameParts = explode('_', $filename);
			$timestamp = end($nameParts);
			$timediff = time() - (int)$timestamp;

			if($timediff > $cacheDuration)
			{
				jimport('joomla.filesystem.file');
				JFile::delete($folder.$file);
				return false;
			}
			else
			{
				return file_get_contents($folder.$file);
			}
		}

		return false;
	}
}
