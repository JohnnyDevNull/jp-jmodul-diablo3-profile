<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_jpd3
 *
 * @copyright   Copyright (C) Philipp John, All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$profile	= ModDiabloProfileHelper::getCareerProfile($params);
$class_sfx	= htmlspecialchars($params->get('class_sfx'));

if(count($profile))
{
	require JModuleHelper::getLayoutPath('mod_diablo_profile', $params->get('layout', 'default'));
}
