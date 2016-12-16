<?php
defined('_JEXEC') or die;
$items = $this->items;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

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
		<img src="<?php //echo $this->category->getParams()->get('image'); ?>" alt="<?php //echo htmlspecialchars($this->category->getParams()->get('image_alt')); ?>" class="content__desc_img" />
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
