</div>

<div id="footer">Copyright <?php echo date("Y", time()); ?>, Nathan Scherneck
</div>

</body>
</html>
<?php if(isset($database->connection)) { $database->close_connection(); } ?>
