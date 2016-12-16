<?php
defined('_JEXEC') or die;
$items = $this->items;
?>
<div class = "container">

	<?php if(!empty($items)) :?>
		<?php foreach ($items as $item) :?>
				<div>
					<div><?php echo $item->name; ?></div>
				
				</div>
		
		<?php endforeach;?>
	
	
	<?php endif;?>

	<?php // Add pagination links ?>
	<?php if (!empty($items)) : ?>
		<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
			<div class="panel panel-default text-center">
				<?php if ($this->params->def('show_pagination_results', 1)) : ?>
					<div class="counter">
						<?php echo $this->pagination->getPagesCounter(); ?>
					</div>
				<?php endif; ?>
				<?php echo $this->pagination->getPagesLinks(); ?>
			</div>
		<?php endif; ?>
	<?php  endif; ?>
	
</div>













<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Merging the leading and intro items
$items = array_merge($this->lead_items, $this->intro_items);

// Header layout
$headerData = array(
	'show' => $this->params->get('show_page_heading'),
	'text' => $this->params->get('page_heading')
);
$headerLayout = new JLayoutFile('gk.content.header');

// Pagination layout
$paginationData = array(
	'params' => $this->params,
	'pagination' => $this->pagination
);
$paginationLayout = new JLayoutFile('gk.content.pagination');

?>
<div class="content <?php echo $this->pageclass_sfx; ?>" itemscope itemtype="http://schema.org/Blog">

	<div class="content__header">
		<h2 class="content__header_title">Textee</h2>
	</div>

	<div class="content__desc clearfix">
		<img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt')); ?>" class="content__desc_img" />
		<div>texte</div>
	</div>

	<?php if (!empty($items)) : ?>
	<div class="content__items clearfix">
		<?php foreach ($items as &$item) : ?>
			<?php
				$this->item = &$item;
				echo $this->loadTemplate('item');
			?>
		<?php endforeach; ?>
	</div>
	<?php else: ?>
			<p class="content__empty_msg"><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>

	<?php echo $paginationLayout->render($paginationData); ?>
</div>
