<?php
new customizer();

class customizer
{
    public function __construct()
    {
        add_action( 'customize_register', array(&$this, 'customizer_setup' ));
    }

    public function customizer_setup( $wp_manager )
    {
        $this->header_options_section( $wp_manager );
		$this->socials_links_section( $wp_manager );
    }

    public function header_options_section( $wp_manager )
    {
        $wp_manager->add_section( 'header_options_section', array(
            'title'          => 'Header Options',
            'priority'       => 35,
        ) );

        $wp_manager->add_setting( 'order_online_url', array(
            'default'        => '#',
        ) );

        $wp_manager->add_control( 'order_online_url', array(
            'label'   => 'Order Online Link',
            'section' => 'header_options_section',
            'type'    => 'text',
            'priority' => 1
        ) );
		
		$wp_manager->add_setting( 'specials_url', array(
            'default'        => '#',
        ) );

        $wp_manager->add_control( 'specials_url', array(
            'label'   => 'Specials Link',
            'section' => 'header_options_section',
            'type'    => 'text',
            'priority' => 1
        ) );
		
		$wp_manager->add_setting( 'phone', array(
            'default'        => '',
        ) );

        $wp_manager->add_control( 'phone', array(
            'label'   => 'Phone',
            'section' => 'header_options_section',
            'type'    => 'text',
            'priority' => 1
        ) );
		
		$wp_manager->add_setting( 'address', array(
            'default'        => '',
        ) );

        $wp_manager->add_control( 'address', array(
            'label'   => 'Address',
            'section' => 'header_options_section',
            'type'    => 'text',
            'priority' => 1
        ) );

        
    }
	 public function socials_links_section( $wp_manager )
    {
        $wp_manager->add_section( 'socials_links_section', array(
            'title'          => 'Socials Links',
            'priority'       => 35,
        ) );
		
		$wp_manager->add_setting( 'facebook_link', array(
            'default'        => '#',
        ) );
		$wp_manager->add_control( 'facebook_link', array(
            'label'   => 'Facebook Link',
            'section' => 'socials_links_section',
            'type'    => 'text',
            'priority' => 1
        ) );
		
		$wp_manager->add_setting( 'twitter_link', array(
            'default'        => '#',
        ) );
		$wp_manager->add_control( 'twitter_link', array(
            'label'   => 'Twitter Link',
            'section' => 'socials_links_section',
            'type'    => 'text',
            'priority' => 1
        ) );
		
		$wp_manager->add_setting( 'yelp_link', array(
            'default'        => '#',
        ) );
		$wp_manager->add_control( 'yelp_link', array(
            'label'   => 'Yelp Link',
            'section' => 'socials_links_section',
            'type'    => 'text',
            'priority' => 1
        ) );
	}
}

?>