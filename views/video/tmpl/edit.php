<?php	defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_pindustry&layout=edit&id='.(int)$this->form->getField('id')->value); ?>" method="post" name="adminForm" id="video-form">

	<div class="width-55 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_ANIEWS_VIDEO_DETAILS'); ?></legend>
			<ul class="adminformlist">
				<?php foreach($this->form->getFieldset("fields") as $field): ?>
				<li>
					<?php echo $field->label;echo $field->input;?>
					<div class="clr"></div>
				</li>
				<?php endforeach; ?>
			</ul>
		</fieldset>
	</div>
    
	<div>
		<input type="hidden" name="filter_company_id" value="<?php echo (int)$this->form->getField('company_id')->value; ?>" />
		<input type="hidden" name="task" value="video.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
