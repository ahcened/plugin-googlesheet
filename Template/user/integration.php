<h3><img src="<?= $this->url->dir() ?>plugins/plugin-googlesheet/googlesheet-icon.png"/>&nbsp;RocketChat</h3>
<div class="panel">
    <?= $this->form->label(t('Webhook URL user'), 'googlesheet_webhook_url') ?>
    <?= $this->form->text('googlesheet_webhook_url', $values) ?>

    <?= $this->form->label(t('User (Optional)'), 'googlesheet_webhook_channel') ?>
    <?= $this->form->text('googlesheet_webhook_channel', $values, array(), array('placeholder="@username"')) ?>

    <!-- <p class="form-help"><a href="https://github.com/kanboard/plugin-rocketchat#configuration" target="_blank"><?= t('Help on RocketChat integration') ?></a></p> -->

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue">
    </div>
</div>
