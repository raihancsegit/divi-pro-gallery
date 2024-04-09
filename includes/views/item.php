<?php

use Divi_Pro_Gallery\Includes\Helper;

$link_classes    = $image_data['link_classes'];
$item_classes    = $image_data['item_classes'];
$item_attributes = $image_data['item_attributes'];
$link_attributes = $image_data['link_attributes'];
$img_attributes  = $image_data['img_attributes'];
$img_classes     = $image_data['img_classes'];

?>

<div class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>" <?php echo wp_kses_data( Helper::render_attributes( $item_attributes ) ); ?> >
    <div class="dpg-item-overlay"></div>
    <div class="dpg-item-content">
        <?php if ( 'no-link' !== $image_data['click_action'] ): ?>
            <a <?php echo wp_kses_data( Helper::render_attributes( $link_attributes ) ); ?> class="<?php echo esc_attr( implode( ' ', $link_classes ) ); ?>" /></a>
		<?php endif?>
        <img <?php echo wp_kses_data( Helper::render_attributes( $img_attributes ) ); ?> class="<?php echo esc_attr( implode( ' ', $img_classes ) ); ?>" />

        <div class="dpg-caption">
			<div class="dpg-caption-inner">
				<?php if ( 'on' !== $this->props['hide_caption'] && 'on' !== $this->props['hide_title'] ): ?>
					<h2 class='dpg-title'><?php echo wp_kses_post( $image_data['title'] ); ?></h2>
				<?php endif?>
				<?php if ( 'on' !== $this->props['hide_caption'] && 'on' !== $this->props['hide_description'] ): ?>
					<p class="dpg-description"><?php echo wp_kses_post( $image_data['description'] ); ?></p>
				<?php endif?>
            </div>
        </div>
    </div>
</div>