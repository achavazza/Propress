<?php
namespace Elementor;

class Prop_List extends Widget_Base {

	public function get_name() {
		return 'prop-list';
	}

	public function get_title() {
		return 'Properties List';
	}

	public function get_icon() {
		return 'fa fa-home';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Content', 'elementor' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your title', 'elementor' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => __( 'Sub-title', 'elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter your sub-title', 'elementor' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'elementor' ),
				'default' => [
					'url' => '',
				]
			]
		);

		$this->end_controls_section();
	}



	protected function render() {

        //$settings = $this->get_settings_for_display();
        //$url = $settings['link']['url'];
		//echo  "<a href='$url'><div class='title'>$settings[title]</div> <div class='subtitle'>$settings[subtitle]</div></a>";

		// Showing multiple post types in Posts Widget
		/*$args  = [
	   'posts_per_page'  => 1,
	   'post_type'   => 'propiedad',
   ];
  $query = new \WP_Query($args);
   if ( $query->have_posts() ) {
	   while ( $query->have_posts() ) {
		   $query->the_title();
	   }
   }*/
		/*
		$args = array(
			'post_type'      => 'propiedad',
			'posts_per_page' => 12,
		);
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) :
			while ( $loop->have_posts() ) : $loop->the_post();
				echo the_title();
			endwhile;
		endif;
		*/


	}

	protected function _content_template() {

    }


}
?>
