<?php
class logo_in_nav_Walker extends Walker_Nav_Menu {
    // from https://wordpress.stackexchange.com/questions/256868/walker-nav-menu-put-custom-code-between-a-particular-li
    public $site_title;
    public $site_url;
    function __construct() {
        $this->menu_location = 'primary';
        $this->site_title = get_bloginfo( 'name' );
        $this->site_url = get_bloginfo( 'url' );
    }

    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $locations = get_nav_menu_locations(); //get all menu locations
        $menu = wp_get_nav_menu_object($this->menu_location); //one menu for one location so lets get the menu of this location
        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $top_lvl_menu_items_count = 0; //we need this to work with a menu with children too so we dont use simply $menu->count here
        foreach ($menu_items as $menu_item) {
            if ($menu_item->menu_item_parent == "0") {
                $top_lvl_menu_items_count++;
            }
        }

        $total_menu_items = $top_lvl_menu_items_count;

        $item_position = $item->menu_order;

        $position_to_have_the_logo = ceil($total_menu_items / 2); // here is where you set the position.

        if ($item_position == $position_to_have_the_logo && $item->menu_item_parent == "0") { //make sure we output for top level only
            $output .= "</li>"; 
            //here we add the logo
            $output .= "</li>";
            $output .= "<li><h1><a href=" . $this->site_url  . ">" . $this->site_title . "</a></h1></li>";
        } else {
            $output .= "</li>\n";
        }
    }
}