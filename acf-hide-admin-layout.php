<?php
/**
 * Plugin Name:  ACF Hide Admin Layout Control
 * Plugin URI:
 * Description:  Hide Layouts with prefix ADMIN if curren user has other role than admin
 * Version:      0.1.0
 * Author:       Januar Designbüro GmbH
 * Author URI:   https://github.com/januardesignbuero
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  acf-hide-admin-layout
 * Domain Path:  /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function janHideAdminLayouts() {

	$user = wp_get_current_user();
	if ( ! in_array( 'administrator', (array) $user->roles ) ) {
		?>
		<script type="text/javascript">
			jQuery(document).ready(function () {
				var $popupMenu = null,
				    popupMenuNativeTop = null,
				    $entries = null,
				    itemHeight = 26, // = px
				    addToOrSubtractFromTop = 0, // = px
					finalTop = 0;

				var hideAdminLayoutEntries = function () {
					setTimeout(function () {
						$popupMenu = jQuery('.acf-fc-popup');
						$entries = jQuery("a:contains('ADMIN')");
						popupMenuNativeTop = parseInt($popupMenu.css('top').replace('px',''));
						addToOrSubtractFromTop = parseInt($entries.length * itemHeight);

						if ($popupMenu.hasClass('top')) {
							finalTop = popupMenuNativeTop + addToOrSubtractFromTop;
						} else if ($popupMenu.hasClass('bottom')) {
							finalTop = popupMenuNativeTop;
						}

						$popupMenu.css({
							top: finalTop + 'px',
							width: $popupMenu.width() + 'px'
						});

						$entries.parent('li').css('display', 'none');
					}, 0);
				};

				jQuery('*[data-name="add-layout"]').on('click', function () {
					hideAdminLayoutEntries();
				});

			});
		</script>
		<?php
	}
}

add_action( 'admin_footer', 'janHideAdminLayouts' );
