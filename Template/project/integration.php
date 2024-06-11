<h3><img src="<?= $this->url->dir() ?>plugins/GoogleSheet/googlesheet-icon.png"/>&nbsp;Google Sheet</h3>
<div class="panel">
    <?= $this->form->label(t('Webhook URL for project'), 'googlesheet_webhook_url') ?>
    <?= $this->form->text('googlesheet_webhook_url', $values) ?>

    <?= $this->form->label(t('Channel (Optional)'), 'googlesheet_webhook_channel') ?>
    <?= $this->form->text('googlesheet_webhook_channel', $values, array(), array('placeholder="#channel"')) ?>
    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue">
    </div>
</div>
