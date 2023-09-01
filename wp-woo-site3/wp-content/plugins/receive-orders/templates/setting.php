<h2 class="ror-title">
	<?php echo __('Setting-用于B站', 'ror'); ?>
</h2>
<div class="ror-tab">
	<div class="tab-item active" data-target="tab-add-rule">
		<?php echo __('Common', 'ror'); ?>
	</div>
</div>

<div class="ror-cont">
	<div class="ror-cont-tab tab-add-rule active">
		<form class="ror-form">
			<!--
			<div class="ror-form-item">
				<label><?php echo __('callback host', 'ror'); ?></label>
				<input type="text" name="ror_host" placeholder="<?php echo __('https://google.com', 'ror'); ?>" value="<?php echo $host_val; ?>">
			</div>
-->
			<div class="ror-form-item">
				<label><?php echo __('api key', 'ror'); ?></label>
				<input type="text" name="ror_api_key" id="ror_api_key" value="<?php echo $api_key; ?>">
			</div>
			<div class="ror-form-item">
				<button class="ror-btn" id="ror-btn-save" type="button"><?php echo __('Save', 'ror'); ?></button>
			</div>
		</form>
	</div>
	
</div>
<div class="ror-loading" id="ror-loading"></div>