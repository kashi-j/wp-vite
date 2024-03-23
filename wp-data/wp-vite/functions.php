<?php
/*****************************
 * develop mode config
 *****************************/
define( 'IS_VITE_DEVELOPMENT', false );
if (IS_VITE_DEVELOPMENT):
  define('ENV_DIR', '/public/');
else:
  define('ENV_DIR', '/dist/');
endif;

//define
define( 'DIST_DEF', 'dist' );
define( 'DIST_URI',  get_template_directory_uri() . '/' . DIST_DEF );
define( 'DIST_PATH', get_template_directory()     . '/' . DIST_DEF );

define( 'JS_DEPENDENCY', array() ) ; // array( 'jquery' ) as example
define( 'JS_LOAD_IN_FOOTER', true ) ; // load scripts in footer?

define('VITE_SERVER', 'http://localhost:3006');
define('VITE_ENTRY_POINT', '/main.js');

/**********************
 * 外部ファイルの読み込み
 **********************/ 
add_action( 'wp_enqueue_scripts', function() {
  if ( defined( 'IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT === true ) {
    //develop mode
    function vite_head_module_hook() {
      echo '<script type="module" crossorigin src="' . VITE_SERVER . VITE_ENTRY_POINT . '"></script>';
    }
    add_action( 'wp_footer', 'vite_head_module_hook' );
  } else {
    // production mode
    // 'npm run build' must be executed in order to generate assets
    // read manifest.json to figure out what to enqueue
    $manifest = json_decode( file_get_contents( DIST_PATH . '/.vite/manifest.json'), true );
    
    // is ok
    if ( is_array( $manifest ) ) {
      // get first key, by default is 'main.js'
      $manifest_key = array_keys( $manifest );
      if ( isset( $manifest_key[0] ) ) {
        // enqueue CSS files
        foreach( @$manifest["main.js"]['css'] as $css_file ) {
          wp_enqueue_style( 'main', DIST_URI . '/' . $css_file );
        }
        // enqueue main JS file
        $js_file = @$manifest["main.js"]['file'];
        if ( ! empty( $js_file ) ) {
          wp_enqueue_script( 'main', DIST_URI . '/' . $js_file, JS_DEPENDENCY, '', JS_LOAD_IN_FOOTER );
        }
      }
    }
  }
} );

/*****************************
 * theme support
 *****************************/
function eduhub_theme_support() {
  add_theme_support( 'html5', array (
    'comment-form',
    'comment-list',
    'search-form',
    'gallery',
    'caption',
    'style',
    'script'
  ) );
  add_theme_support( "post-thumbnails" );
  add_theme_support( 'title-tag' );
  add_theme_support( 'editor-styles' );
  // add_editor_style( get_theme_file_uri('/dist/assets/css/main.css') ); 
  add_theme_support( 'custom-logo' );
  add_theme_support( 'automatic-feed-links' );
  register_nav_menus( array (
    'main-menu' => __( 'mainmenu', 'eduhub' )
  ) );
}
add_action( 'after_setup_theme', 'eduhub_theme_support' );

/*****************************
 * タイトルタグのセパレーター変更
 *****************************/
function change_title_separator( $sep ){
  $sep = ' | ';
  return $sep;
}
add_filter( 'document_title_separator', 'change_title_separator' );


/*****************************
 * メインクエリの変更
 *****************************/
function change_set_post($query){
	if(is_admin() || !$query->is_main_query()){
    return;
	}
  if($query->is_home()){
    $query->set( 'order', 'DESC' );
    $query->set( 'orderby', 'date' );
  }
}
add_action('pre_get_posts','change_set_post');

/***************************************
 * デフォルト投稿タイプの設定
 ***************************************/ 
function post_has_archive($args, $post_type){
  if ('post' == $post_type) {
    $args['rewrite'] = true;
    $args['labels'] = array(
      'name' => 'お知らせ',
      'singular_name' => 'お知らせ',
    );
  }
  return $args;
}
add_filter('register_post_type_args', 'post_has_archive', 10, 2);


/***************************************
 * CSS＆JSの読み込み
 ***************************************/
function my_theme_scripts(){
  // wp_enqueue_script('webp', get_theme_file_uri(ENV_DIR . 'vender/js/modernizr-custom.js'));
  // wp_enqueue_style('swiper-css', get_theme_file_uri(ENV_DIR . 'vender/css/swiper-bundle.min.css'));
  // wp_enqueue_script('swiper-js', get_theme_file_uri(ENV_DIR . 'vender/js/swiper-bundle.min.js'));
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');
