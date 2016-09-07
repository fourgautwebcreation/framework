
<?php
if(isset($GLOBALS['error']) && !empty($GLOBALS['error'])):
?>

<script type="text/javascript">
  write_error('<?php echo addslashes($GLOBALS['error']);?>');
</script>

<?php endif;?>
