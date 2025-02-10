<?php

/**
 * Menu tabs Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */


// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'menu-tabs-block my-4';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}
if ( ! empty( $block['backgroundColor'] ) ) {
	$class_name .= ' has-background';
	$class_name .= ' has-' . $block['backgroundColor'] . '-background-color';
}
if ( ! empty( $block['textColor'] ) ) {
	$class_name .= ' has-text-color';
	$class_name .= ' has-' . $block['textColor'] . '-color';
}

if ( have_rows( 'menu-tab' ) ) : ?>

	<?php $tabs = []; ?>

	<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">

		<?php while ( have_rows( 'menu-tab' ) ) : the_row(); ?>

			<?php
			$tab_title = get_sub_field( 'menu-tab-title' );
			$tab_image_id = get_sub_field( 'menu-tab-image' );
			$tab_content = get_sub_field( 'menu-tab-list' );

			$tabs[] = [
				'tab_title' => $tab_title,
				'image_id' =>$tab_image_id,
				'title' => $tab_title,
				'content' => smn_get_lista_de_precios( $tab_content ),
			];

		endwhile; ?>
						

		<?php if ( count( $tabs ) > 1 ) : ?>

			<!-- Nav tabs -->
			<ul class="nav nav-tabs ps-2" id="myTab" role="tablist">
				<?php foreach ($tabs as $index => $tab): ?>
					<li class="nav-item" role="presentation">
						<button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" id="tab-<?php echo $index; ?>-tab" data-bs-toggle="tab" data-bs-target="#tab-<?php echo $index; ?>" type="button" role="tab" aria-controls="tab-<?php echo $index; ?>" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
							<?php echo $tab['tab_title']; ?>
						</button>
					</li>
				<?php endforeach; ?>
			</ul>

		<?php endif; ?>

		<!-- Tab panes -->
		<div class="tab-content" id="myTabContent">
			<?php foreach ($tabs as $index => $tab): ?>
				<div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" id="tab-<?php echo $index; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $index; ?>-tab">
					<div class="row mt-3">
						<?php if ( $tab['image_id'] ) : ?>
							<div class="col-md-3">
								<?php echo wp_get_attachment_image( $tab['image_id'], 'thumbnail', false, array( 'class' => 'img-fluid rounded-circle' ) ); ?>
							</div>
						<?php endif; ?>
						<div class="col-md-9">
							<h3><?php echo $tab['title']; ?></h3>
							<p><?php echo $tab['content']; ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>

<?php endif;