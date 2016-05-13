<div id="campaign-choice">
	<div class="row-fluid">
		<div class="span12">
			<h3>{vtranslate('LBL_WHAT_TYPE_OF_CAMPAIGN', $MODULE)}</h3>
		</div>
	</div>
	<div id="campaign-type-buttons" class="row-fluid">
		<div class="span6">
			<div class="campaign-type">
				<h3>{vtranslate('LBL_EMAILING_CAMPAIGN', $MODULE)}</h3>
				
				<p>{vtranslate('LBL_EMAILING_CAMPAIGN_DESCRIPTION', $MODULE)}</p>
				
				<a class="btn btn-primary" href="index.php?module={$MODULE}&view=Edit&record={$RECORD_ID}&type=email">
					{vtranslate('LBL_CREATE_CAMPAIGN', $MODULE)}
				</a>
			</div>
		</div>
		
		<div class="span6">
			<div class="campaign-type">
				<h3>{vtranslate('LBL_SMS_CAMPAIGN', $MODULE)}</h3>
				
				<p>{vtranslate('LBL_SMS_CAMPAIGN_DESCRIPTION', $MODULE)}</p>
				
				<a class="btn btn-primary" href="javascript:void(0)">
					{vtranslate('LBL_SOON', $MODULE)}
				</a>
			</div>
		</div>
	</div>
</div>