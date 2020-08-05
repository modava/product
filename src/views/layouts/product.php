<?php

\modava\product\assets\ProductAsset::register($this);
\modava\product\assets\ProductCustomAsset::register($this);
?>
<?php $this->beginContent('@backend/views/layouts/main.php'); ?>
<?php echo $content ?>
<?php $this->endContent(); ?>