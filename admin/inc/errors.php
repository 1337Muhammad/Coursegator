
<?php if($session->has('errors')): ?>
    <?php if(!empty($session->get('errors'))): ?>
        <div class="alert alert-danger">
            <?php foreach($session->get('errors') as $error): ?>
                <p class="mb-0"> <?= $error ?> </p>
            <?php endforeach; ?>
            <?php $session->remove('errors'); ?>
        </div>
    <?php endif ?>
<?php endif ?>