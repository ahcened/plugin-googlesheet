<h3><img src="<?= $this->url->dir() ?>plugins/plugin-googlesheet/googlesheet-icon.png"/>&nbsp;GoogleSheet</h3>
<div class="panel">
    <?= $this->form->label(t('Webhook URL'), 'googlesheet_webhook_url') ?>
    <?= $this->form->text('googlesheet_webhook_url', $values) ?>

    <?= $this->form->label(t('Channel (Optional)'), 'googlesheet_webhook_channel') ?>
    <?= $this->form->text('googlesheet_webhook_channel', $values, array(), array('placeholder="#channel"')) ?>
    <p class="form-help"><a href="https://github.com/kanboard/plugin-rocketchat#configuration" target="_blank"><?= t('Help on Google Sheet integration') ?></a></p>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue">
    </div>
</div>