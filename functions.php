<?php

/*スタイルシート読み込み*/
function add_my_stylesheet() {

  wp_enqueue_style('add-my-stylesheet', get_theme_file_uri('style.css'));

}

add_action( 'wp_enqueue_scripts', 'add_my_stylesheet' );

/*js読み込み(jQueryのバージョンはwordpress基準)*/
function add_my_scripts() {

  wp_enqueue_script(
      'base-script',
      get_theme_file_uri( 'test.js' ),
      array( 'jquery' ), //依存ファイルは上記の jquery
      filemtime( get_theme_file_path( 'test.js' ) ),
      true
    );
}

add_action('wp_enqueue_scripts', 'add_my_scripts');

/*メニュー登録*/
function register_my_menus() {
  register_nav_menus( array(
    'header-menu' => 'ヘッダーメニュー',
    'footer-menu'  => 'フッターメニュー',
  ) );
}
add_action( 'after_setup_theme', 'register_my_menus' );

/*メニュー内のid削除*/
function remove_menu_id( $id ){
	return $id = array();
}
add_filter('nav_menu_item_id', 'remove_menu_id', 10);

/*メニュー内のaria-current削除*/
function remove_menu_aria_current( $atts, $item, $args ){
	unset ( $atts['aria-current'] );
	return $atts;
}
add_filter('nav_menu_link_attributes', 'remove_menu_aria_current', 11, 5);

// エディターCSS追加
add_action( 'after_setup_theme', 'nxw_setup_theme' );
function nxw_setup_theme() {
  add_theme_support( 'editor-styles' );
  add_editor_style( 'editor-style.css' );
}

?>
