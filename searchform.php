<?php
/**
 * Search form.
 *
 * @package Innovare
 */
?>
<form role="search" method="get" class="innovare-search-form input-group" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="visually-hidden" for="innovare-s"><?php esc_html_e( 'Search', 'innovare' ); ?></label>
	<input type="search" id="innovare-s" class="form-control" placeholder="<?php esc_attr_e( 'Search insights, services, products…', 'innovare' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	<button type="submit" class="btn btn-primary">
		<i class="bi bi-search" aria-hidden="true"></i>
		<span class="visually-hidden"><?php esc_html_e( 'Search', 'innovare' ); ?></span>
	</button>
</form>
