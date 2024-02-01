<?php if($session->has('success')): ?>
    <div class="alert alert-success">
        <?= $session->get('success') ?>
        <?php $session->remove('success') ?>
    </div>
<?php endif?>