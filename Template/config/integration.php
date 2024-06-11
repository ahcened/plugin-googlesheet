<h3><img src="<?= $this->url->dir() ?>plugins/GoogleSheet/googlesheet-icon.png"/>&nbsp;Google Sheet</h3>
<div class="panel">
    <?= $this->form->label(t('Webhook URL profile configuration'), 'googlesheet_webhook_url') ?>
    <?= $this->form->text('googlesheet_webhook_url', $values) ?>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>
