<!-- LazyLoad -->
<script>
    window.lazyLoadOptions = {
        elements_selector: "img"
    };
</script>

<?php
	$smarty = wp_smarty();
	$smarty->display('includes/footer.tpl');

	wp_footer();
?>
    </body>
</html>