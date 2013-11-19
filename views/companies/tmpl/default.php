<?php defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_pindustry&view=companies'); ?>" method="post" name="adminForm">
    <select name="filter_idbusinessarea" class="inputbox" onchange="this.form.submit()">
        <?php echo JHtml::_('select.options', JFormFieldPindustrybusinessarea::getOptions(), 'value', 'text', $this->state->get('filter.idbusinessarea'));?>
    </select>
    <table class="adminlist">
		<thead>
            <tr>
                <th width="40"><?php echo JText::_('COM_ANIEWS_ANIME_ID_LABEL'); ?></th>
                <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
                <th><?php echo JText::_('COM_ANIEWS_ANIME_NAME_LABEL'); ?></th>
                <th width="5%"><?php echo JText::_('JSTATUS'); ?></th>
            </tr>
        </thead>
		<tbody>
            <?php foreach($this->items as $i => $item): ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td align="center"><?php echo $item->id; ?></td>
                    <td><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
                    <td align="center"><a href="<?php echo JRoute::_('index.php?option=com_pindustry&task=companie.edit&id='.(int)$item->id); ?>"><?php echo $item->name; ?></a></td>
                    <td class="center"><?php echo JHtml::_('jgrid.published', $item->published, $i, 'companies.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"><?php echo $this->pagination->getListFooter(); ?></td>
            </tr>
        </tfoot>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>