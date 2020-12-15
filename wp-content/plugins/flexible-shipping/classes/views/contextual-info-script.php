<?php
/**
 * Display contextual info script.
 *
 * @package Contextual Info.
 *
 * @var $html_elements_ids string
 * @var $info_id string
 * @var $phrases array
 * @var $info_html string
 */
?><script type="text/javascript">
	jQuery( document ).ready(
		function(){
			jQuery( "<?php echo esc_attr( $html_elements_ids ); ?>" ).contextualInfo(
				{
					'id': '<?php echo esc_attr( $info_id ); ?>',
					'phrases': <?php echo json_encode( $phrases ); // phpcs:ignore ?>,
					'info_html': <?php echo json_encode( $info_html ); // phpcs:ignore ?>
				}
			);
		}
	);
</script>
