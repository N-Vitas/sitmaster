<?php
use frontend\widgets\Alert;

$this->beginContent('@frontend/views/layouts/structure.php') ?>
<section class="content-section padding-top">

    <?= Alert::widget() ?>
    <?=$content?>

</section>
<?php $this->endContent(); ?>