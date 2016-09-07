<?php
if(isset($error) && !empty($error)):
?>

<script type="text/javascript">
  write_error('<?php echo addslashes($error);?>');
</script>

<?php endif;?>
