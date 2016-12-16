<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Create a shortcut for params.
$params  = &$this->item->params;
$images  = json_decode($this->item->images);
$url = JRoute::_('index.php');
// load template params
$templateParams = JFactory::getApplication()->getTemplate(true)->params;
// load layout helper functions
require_once(__DIR__ . '/../../../inc/layout.php');

?>
<article 
	class="item item--notloaded clearfix" 
	itemprop="blogPost" 
	itemscope 
	itemtype="http://schema.org/BlogPosting"
	data-cols="4<?php //echo $this->item->columns; ?>"
>
	<div class="item__helper <?php if($templateParams->get('portfolioAnimation', '1') == '0') : ?>item__helper--animated<?php endif; ?> item__helper--<?php echo $templateParams->get('portfolioAnimationType', 'flip'); ?> item--transition-<?php echo $templateParams->get('portfolioAnimationSpeed', 'normal'); ?>">
		<?php if($templateParams->get('showPreview', '1') == '1') : ?>
		<div class="item__preview item__preview--<?php echo $templateParams->get('portfolioPrevieAnimationType', 'slide-up'); ?> item--transition-<?php echo $templateParams->get('portfolioPrevieAnimationSpeed', 'fast'); ?> <?php if($this->item->featured == 1) : ?>item__preview--featured<?php endif; ?>" <?php if($templateParams->get('clickablePreview', '0') == '1') : ?>data-url="<?php echo $url; ?>"<?php endif; ?>>
			<h2 class="item__title" itemprop="name" data-url="<?php echo $url; ?>">
				<a href="<?php echo $url; ?>" class="item__title_link" itemprop="url">
					<?php echo $this->escape($this->item->name); ?>
				</a>
			</h2>

			<div class="item__summary">
				<a href="<?php echo $url; ?>" class="item__summary_link">
					<?php 
						$text = $this->item->description; 
						$len = $templateParams->get('excerptWidth', 16);
						echo gkExcerpt($text, $len);
					?>
				</a>
			</div>
		</div>
		<?php endif; ?>
		
		<?php /*if($templateParams->get('portfolioInfo', 'tags') == 'tags') : ?>
			<?php if(count($this->item->tags->itemTags)) : ?>
				<?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
				<?php echo $this->item->tagLayout->render(array('tags' => $this->item->tags->itemTags, 'class' => 'item__info')); ?>
			<?php endif; ?>
		<?php endif;*/ ?>

		<?php /*if($templateParams->get('portfolioInfo', 'tags') == 'categories') : ?>
			<ul class="item__info item__info--categories">
				<li class="item__info_item item__info_item--categories">
					<?php $title = $this->escape($this->item->category_title); ?>
					<?php if ($templateParams->get('link_category') && $this->item->catslug) : ?>
						<?php $catURL = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)) . '" itemprop="genre">' . $title . '</a>'; ?>
						<?php echo $catURL; ?>
					<?php else : ?>
						<?php echo '<span itemprop="genre">' . $title . '</span>'; ?>
					<?php endif; ?>
				</li>
			</ul>
		<?php endif;*/ ?>

		<?php if($templateParams->get('portfolioInfo', 'tags') == 'title') : ?>
			<ul class="item__info item__info--title">
				<li class="item__info_item item__info_item--title">
					<?php echo $this->escape($this->item->name); ?>
				</li>
			</ul>
		<?php endif; ?>

		<?php if($templateParams->get('portfolioInfo', 'tags') == 'date') : ?>
			<ul class="item__info item__info--date">
				<li class="item__info_item item__info_item--date">
					<time datetime="<?php echo JHtml::_('date', $this->item->created, 'c'); ?>" itemprop="dateCreated">
						<?php echo JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC3')); ?>
					</time>
				</li>
			</ul>
		<?php endif; ?>

		<?php 
			// This image will be transformed into div with background-image
			if (isset($this->item->image_intro) && !empty($this->item->image_intro)) : 
		?>
		<img src="<?php echo htmlspecialchars($this->item->image_intro); ?>" alt="<?php echo $this->escape($this->item->name); ?>" class="item__hidden" />
		<?php endif; ?>
	</div>
</article>