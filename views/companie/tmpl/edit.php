<?php	defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'companie.cancel' || document.formvalidator.isValid(document.id('companie-form'))) {
			Joomla.submitform(task, document.getElementById('companie-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_pindustry&layout=edit&id='.(int)$this->form->getField('id')->value); ?>" method="post" name="adminForm" id="companie-form" enctype="multipart/form-data">

<div class="width-55 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_ANIEWS_ANIME_DETAILS'); ?></legend>
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

<div class="width-45 fltrt">
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_ANIEWS_ANIME_IMAGE'); ?></legend>
		<ul class="adminformlist">
			<?php foreach($this->form->getFieldset("image") as $field): ?>
			<li>
				<?php echo $field->label;echo $field->input;?>
				<div class="clr"></div>
			</li>
			<?php endforeach; ?>
		</ul>
	</fieldset>
</div>

<div class="width-45 fltrt">
    <fieldset class="adminform">
        <legend><?php echo JText::_('Tags'); ?></legend>
        <label><?php echo JText::_('COM_ANIEWS_TAGS') ?></label>
        <ul class="adminformlist">
            <?php foreach($this->form->getFieldset("tags") as $field): ?>
            <li>
                <?php echo $field->label;echo $field->input;?>
                <div class="clr"></div>
            </li>
            <?php endforeach; ?>
        </ul>
    </fieldset>
</div>

<div>
	<input type="hidden" name="task" value="companie.edit" />
	<?php echo JHtml::_('form.token'); ?>
</div>
</form>