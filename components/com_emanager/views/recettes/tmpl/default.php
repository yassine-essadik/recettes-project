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