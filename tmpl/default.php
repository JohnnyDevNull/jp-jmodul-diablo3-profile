<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_diablo_profile
 *
 * @copyright   Copyright (C) Philipp John, All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die;

if(empty($profile))
{
	echo JText::_('MOD_DIABLO_PROFILE_NO_CAREER_DATA');
}
else
{
	$paragon = reset($profile['heroes']);
	$paragon = $profile['paragonLevel'];
	$imgPath = JUri::base(true).'/media/mod_diablo_profile/images/';
	$logoClass = '';

	if($params->get('show_d3logo'))
	{
		$logoClass = 'd3logo';
	}

	JHtml::_('stylesheet', 'mod_diablo_profile/template.css', array(), true);
	?>

	<div class="jpd3_wrapper <?php echo $logoClass?>">
		<p class="battletag"><?php echo $profile['battleTag']; ?></p>
		<p class="paragon"><?php echo JText::_('MOD_DIABLO_PROFILE_CAREER_PARAGON_LABEL').' '.$paragon; ?></p>
		<div class="jpd3_profile_heroes">
			<legend><?php echo JText::_('MOD_DIABLO_PROFILE_CAREER_HERO_LEGEND')?></legend>
			<?php
			foreach($profile['heroes'] as $hero)
			{
				$classSuffix = strtoupper(str_replace('-', '', $hero['class']));

				?>
				<div class="hero <?php echo ($hero['hardcore']) ? 'hc' : '' ?>">
					<div class='jpd3_hero_img'>
						<img src="<?php echo $imgPath.str_replace('-', '', $hero['class']); ?>.png" alt="<?php echo $hero['class']; ?>" >
						<?php if($hero['hardcore']) : ?>
						<span class="hc_text">HC</span>
						<?php endif ?>
					</div>
					<div class='jpd3_info_group'>
						<label><?php echo JText::_('MOD_DIABLO_PROFILE_CAREER_NAME_LABEL') ?></label>
						<span><?php echo $hero['name'] ?></span>
					</div>
					<div class='jpd3_info_group'>
						<label><?php echo JText::_('MOD_DIABLO_PROFILE_CAREER_LEVEL_LABEL') ?></label>
						<span><?php echo $hero['level'] ?></span>
					</div>
					<div class='jpd3_info_group'>
						<label><?php echo JText::_('MOD_DIABLO_PROFILE_CAREER_CLASS_LABEL') ?></label>
						<span><?php echo  JText::_('MOD_DIABLO_PROFILE_CAREER_CLASS_'.$classSuffix) ?></span>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<div class="jpd3_profile_stats">
			<legend><?php echo JText::_('MOD_DIABLO_PROFILE_CAREER_KILLS_LEGEND')?></legend>
			<div class='jpd3_info_group'>
				<label><?php echo JText::_('MOD_DIABLO_PROFILE_CAREER_KILLS_MONSTERS_LABEL')?></label>
				<span><?php echo $profile['kills']['monsters'] ?></span>
			</div>
			<div class='jpd3_info_group'>
				<label><?php echo JText::_('MOD_DIABLO_PROFILE_CAREER_KILLS_ELITE_LABEL')?></label>
				<span><?php echo $profile['kills']['elites'] ?></span>
			</div>
			<div class='jpd3_info_group'>
				<label><?php echo JText::_('MOD_DIABLO_PROFILE_CAREER_KILLS_HARDCORE_LABEL')?></label>
				<span><?php echo $profile['kills']['hardcoreMonsters'] ?></span>
			</div>
		</div>
		<p class="last-updated"><?php echo date(JText::_('MOD_DIABLO_PROFILE_CAREER_DATEFORMAT'), $profile['lastUpdated']); ?></p>
		<?php echo isset($profile['cache_used']) ? '<input type="hidden" value="1" name="cache_used" />' : ''; ?>
	</div>
<?php
}