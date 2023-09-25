<h2 class="por-title">
	<?php echo __('Setting-用于A站', 'por'); ?>
</h2>
<div class="por-tab">
	<div class="tab-item active" data-target="tab-add-rule">
		<?php echo __('Common', 'por'); ?>
	</div>
</div>

<div class="por-cont">
	<div class="por-cont-tab tab-add-rule active">
		<form class="por-form">
			<div class="por-form-item">
				<label><?php echo __('target host', 'por'); ?></label>
				<input type="text" name="por_host" placeholder="<?php echo __('https://google.com', 'por'); ?>" value="<?php echo $host_val; ?>">
			</div>
			<div class="por-form-item">
				<label><?php echo __('api key', 'por'); ?></label>
				<input type="text" name="por_api_key" id="por_api_key" value="<?php echo $api_key; ?>">
				<input type="button" class="por-btn" style="margin-left: 10px; " id="por-gen-api" value="generate key">
			</div>
			<div class="por-form-item">
				<button class="por-btn" id="por-btn-save" type="button"><?php echo __('Save', 'por'); ?></button>
			</div>
		</form>
	</div>
	
</div>
<div class="por-loading" id="por-loading"></div>