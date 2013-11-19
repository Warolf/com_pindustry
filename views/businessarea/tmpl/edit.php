<?php	defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_pindustry&layout=edit&id='.(int)$this->form->getField('id')->value); ?>" method="post" name="adminForm" id="businessarea-form">
	<div class="width-55 fltlft">
        <fieldset class="adminform">
		    <legend><?php echo JText::_('COM_ANIEWS_MANGA_DETAILS'); ?></legend>
		        <ul class="adminformlist">
                    <?php foreach($this->form->getFieldset() as $field): ?>
			            <li>
                            <?php echo $field->label;echo $field->input;?>
                            <div class="clr"></div>
                        </li>
                    <?php endforeach; ?>
		        </ul>
	    </fieldset>
    </div>
	<div>
		<input type="hidden" name="task" value="businessarea.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>