<footer>

<p align="center">If you have questions or comments about this website, please send them to the <a href="mailto:travis@travisreeder.com">Webmaster</a></p>
<div class="footer gradient">Copyright <?php echo date("Y"); ?>, Surrey Ridge HOA</div>
</footer>

<!-- javascript -->
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="script/bootstrap.min.js"></script>
    <script src="script/script.js"></script>

	</body>
</html>
<?php if (isset($connection)) { mysqli_close($connection); }?>