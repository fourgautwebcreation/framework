<?php
echo $rooter->head;
?>

<script type="text/javascript" src="<?php $rooter->dossier;?>js/documentation.js"></script>
<link rel="stylesheet" type="text/css" href="<?php $rooter->dossier;?>css/documentation.css" />

<div class="documentation">
  <?php echo documentation();?>
</div>

<?php
echo $rooter->footer;
?>
