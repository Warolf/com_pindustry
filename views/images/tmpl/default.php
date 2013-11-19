<?php defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
?>
<form action="<?php echo JRoute::_('index.php?option=com_pindustry&view=images'); ?>" method="post" name="adminForm">
	<fieldset id="filter-bar">
        <h2 style="float: left;color: #146295;"><a href="index.php?option=com_pindustry&view=companie&layout=edit&id=<?php echo $this->state->get('filter.company_id'); ?>"><?php echo $this->company_name; ?></a></h2>
		<div class="filter-select fltrt">
			<input type="hidden" name="filter_company_id" value="<?php echo $this->state->get('filter.company_id'); ?>" />

			<select name="filter_state" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived'=>false, 'trash'=>false, 'all'=>false, )), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>
		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%" nowrap="nowrap"><?php echo JHtml::_('grid.sort', 'COM_ANIEWS_IMAGE_ID_LABEL', 'id', $listDirn, $listOrder); ?></th>
				<th width="1%" nowrap="nowrap"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
				<th><?php echo JHtml::_('grid.sort', 'COM_ANIEWS_IMAGE_IMAGE_LABEL', 'img', $listDirn, $listOrder); ?></th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'ordering', $this->listDirn, $this->listOrder); ?>
					<?php if ($this->orderingEnabled) : ?>
						<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'images.saveorder'); ?>
					<?php endif;?>
				</th>
				<th width="1%" nowrap="nowrap"><?php echo JHtml::_('grid.sort', 'JSTATUS', 'published', $listDirn, $listOrder); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach($this->items as $i => $item): ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td><?php echo $item->id; ?></td>
				<td><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
				<td><a href="<?php echo JRoute::_('index.php?option=com_pindustry&task=image.edit&id='.(int)$item->id); ?>">
					<?php echo $item->img; ?></a></td>
				<td class="order">
					<?php if ($this->orderingEnabled) : ?>
						<?php if ($this->listDirn == 'asc') : ?>
							<span><?php echo $this->pagination->orderUpIcon($i, $this->orderingEnabled, 'images.orderup'); ?></span>
							<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, $this->orderingEnabled, 'images.orderdown'); ?></span>
						<?php elseif ($this->listDirn == 'desc') : ?>
							<span><?php echo $this->pagination->orderUpIcon($i, $this->orderingEnabled, 'images.orderdown'); ?></span>
							<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, $this->orderingEnabled, 'images.orderup'); ?></span>
						<?php endif; ?>
					<?php endif; ?>
					<?php $this->disabled = $this->orderingEnabled ?  '' : 'disabled="disabled"'; ?>
					<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $this->disabled; ?> class="text-area-order" />
				</td>
				<td class="center"><?php echo JHtml::_('jgrid.published', $item->published, $i, 'images.'); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $this->escape($this->state->get('list.ordering')); ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->escape($this->state->get('list.direction')); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>