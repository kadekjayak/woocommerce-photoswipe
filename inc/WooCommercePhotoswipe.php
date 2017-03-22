<?php
/**
 * Main Woocommerce Photoswipe plugin
 *
 * @author 		kadekjayak
 * @version     0.1
 */
class WooCommercePhotoswipe {
	
	
	/**
	 * Run !!
	 *
	 * if The class not visible on product, try to increase the filter priority
	 * This plugin not remove any class that added by other plugin
	 */
	 
	public function run() 
	{
		add_action('wp_enqueue_scripts', array($this, 'add_assets') );
		add_filter('woocommerce_single_product_image_thumbnail_html', array($this, 'filter_single_thumbnail_image_html'), 999,4 );
		add_filter('woocommerce_single_product_image_html', array($this, 'filter_single__main_image_html'), 999, 2 ); //if Class got overrided increase this Priority
	}
	
	
	/**
	 * Enqueue All Plugin assets
	 */
	 
	public function add_assets()
	{
		$this->enqueue_script();
		$this->enqueue_style();
	}
	
	
	/**
	 * JavaScript Assets
	 */
	 
	protected function enqueue_script() 
	{
		wp_register_script('photoswipe', WC_Photowipe_URL . 'assets/js/photoswipe.min.js', array(), false, true);
		wp_register_script('photoswipe-theme', WC_Photowipe_URL . 'assets/js/photoswipe-ui-default.min.js', array(), false, true);
		wp_register_script('photoswipe-jquery', WC_Photowipe_URL . 'assets/js/jquery.photoSwipe.js', array(), false, true);
		
		wp_register_script('owl-carousel', WC_Photowipe_URL . 'assets/js/owl.carousel.min.js', array(), false, false);
		wp_register_script('photoswipe-woocmmerce', WC_Photowipe_URL . 'assets/js/woocommerce-photowipe.js', array(), false, false);
		
		wp_enqueue_script('photoswipe');
		wp_enqueue_script('photoswipe-theme');
		wp_enqueue_script('photoswipe-jquery');
		wp_enqueue_script('owl-carousel');
		wp_enqueue_script('photoswipe-woocmmerce');
	}
	
	/**
	 * CSS Assets
	 */
	 
	protected function enqueue_style() 
	{
		wp_register_style('photoswipe-skin', WC_Photowipe_URL . 'assets/css/default-skin/default-skin.css');
		wp_register_style('photoswipe-css', WC_Photowipe_URL . 'assets/css/photoswipe.css');
		wp_register_style('owl-carousel-css', WC_Photowipe_URL . 'assets/css/owl.carousel.min.css');
		wp_register_style('owl-carousel-theme-css', WC_Photowipe_URL . 'assets/css/owl.theme.default.css');
		wp_register_style('woocommerce-photowipe', WC_Photowipe_URL . 'assets/css/woocommerce-photoswipe.css');
		
		wp_enqueue_style('photoswipe-skin');
		wp_enqueue_style('photoswipe-css');
		wp_enqueue_style('owl-carousel-css');
		wp_enqueue_style('owl-carousel-theme-css');
		wp_enqueue_style('woocommerce-photowipe');
	}
	
	
	/**
	 * Modify WooCommerce default Thumbnail Image Class
	 */
	 
	public function filter_single_thumbnail_image_html($html, $attachment_id, $post_id, $image_class)
	{
		
		$image_src = wp_get_attachment_image_src($attachment_id, 'full');
		return $this->apply_custom_html_attribute($html, $image_src);

	}
	
	
	/**
	 * Modify WooCommerce default thumbnail image
	 */
	 
	public function filter_single__main_image_html($html, $post_id)
	{
	
		if ( ! has_post_thumbnail( $post_id ) ) {
			return $html;
		}
	
		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
		return $this->apply_custom_html_attribute($html, $image_src);
		
	}
	
	
	/**
	 * Inject custom attribute that required for JavaScript plugin
	 */
	 
	private function apply_custom_html_attribute($html, $image_src)
	{
		
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$x = new DOMXPath($dom);

		foreach($x->query("//a") as $node) {   
			$node->setAttribute("data-original-url", $image_src[0] );
			$node->setAttribute("data-original-width", $image_src[1] );
			$node->setAttribute("data-original-height", $image_src[2] );
			
			$class = $node->getAttribute('class');
			$node->setAttribute('class', $class . ' ' . 'wc-photoswipe item');
			
			return $node->c14n();
		}
		
		return $html;
		
	}
	
	
}