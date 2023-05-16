<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<div class="pokemon-description">
			<h4><?php esc_html_e('Pokémon Description', 'understrap'); ?></h4>
			<?php
			the_content();
			?>
		</div>

		<div class="pokemon-types">
			<h4><?php esc_html_e('Pokémon Types', 'understrap'); ?></h4>
			<?php
			$primary_types = get_the_terms( $post->ID, 'primary-type' );
			if ( ! empty( $primary_types ) && ! is_wp_error( $primary_types ) ) {
				echo '<ul>';
				foreach ( $primary_types as $primary_type ) {
					echo '<li><a href="' . esc_url( get_term_link( $primary_type ) ) . '">' . esc_html( $primary_type->name ) . '</a></li>';
				}
				echo '</ul>';
			}
			$secondary_types = get_the_terms( $post->ID, 'secondary-type' );
			if ( ! empty( $secondary_types ) && ! is_wp_error( $secondary_types ) ) {
				echo '<ul>';
				foreach ( $secondary_types as $secondary_type ) {
					echo '<li><a href="' . esc_url( get_term_link( $secondary_type ) ) . '">' . esc_html( $secondary_type->name ) . '</a></li>';
				}
				echo '</ul>';
			}
			?>
		</div>

		<div class="pokedex-numbers">
			<h4><?php esc_html_e('Pokédex Numbers', 'understrap'); ?></h4>
			<?php
			  $pokemon_new_pokedex_number = get_post_meta( $post->ID, 'pokemon_new_pokedex_number', true );
			?>
			<ul>
				<li>
					<?php esc_html_e('New Pokédex Number', 'understrap'); ?>: <?php echo '0' === $pokemon_new_pokedex_number ? 'This Pokémon does not exist in the New version.' : esc_html( $pokemon_new_pokedex_number ); ?>
				</li>
				<!-- Button for getting the Pokédex number in the Old Version of the game by AJAX -->
				<li>
					<button type="button" class="btn btn-info" id="getOldPokedexNumber" data-pokemon-id="<?php echo get_the_ID(); ?>">
						<?php esc_html_e('Get Pokédex Number in Old Version', 'understrap'); ?>
					</button>
				</li>
			</ul>
		</div>

		<div class="pokedex-attacks">
			<h4><?php esc_html_e('Pokémon Attacks', 'understrap'); ?></h4>
			<table class="table">
				<thead>
					<tr>
						<th scope="col">Name</th>
						<th scope="col">Description</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$attacks = get_the_terms( $post->ID, 'attack' );
					foreach ($attacks as $attack) :
						?>
						<tr>
							<th scope="row"><?php echo esc_html( $attack->name ); ?></th>
							<td><?php echo esc_html( $attack->description ); ?></td>
						</tr>
						<?php
					endforeach;
					?>
				</tbody>
			</table>
		</div>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
