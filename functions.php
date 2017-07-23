<?php
/* Load harmonica theme framework. */
require ( trailingslashit( get_template_directory() ) . 'lib/framework.php' );
new harmonica();

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function harmonica_theme_setup() {

	//remove_theme_mods();

	/* Load harmonica functions */
	require get_template_directory() . '/lib/functions/hooks.php';

	add_theme_support( 'title-tag' ); 
	
	/* Load scripts. */
	add_theme_support( 
		'harmonica-scripts', 
		array( 'comment-reply' ) 
	);
	
	add_theme_support( 'post-thumbnails' );
	
	add_theme_support( 'harmonica-theme-settings' );

	add_theme_support( 'harmonica-content-archives' );
		
	/* implement editor styling, so as to make the editor content match the resulting post output in the theme. */
	add_editor_style();

	/* Support pagination instead of prev/next links. */
	add_theme_support( 'loop-pagination' );	

	/* Add default posts and comments RSS feed links to <head>.  */
	add_theme_support( 'automatic-feed-links' );

	/* Enable wraps */
	add_theme_support( 'harmonica-wraps' );

	/* Enable custom post */
	add_theme_support( 'harmonica-custom-post' );
	
	/* Enable custom css */
	add_theme_support( 'harmonica-custom-css' );
	
	/* Enable custom logo */
	add_theme_support( 'harmonica-custom-logo' );

	add_theme_support( 'woocommerce' );

	/* Handle content width for embeds and images. */
	harmonica_set_content_width( 700 );

}

add_action( 'after_setup_theme', 'harmonica_theme_setup' );

//Add Font Awesome
wp_enqueue_style( 'harmonica-fontawesome', get_theme_file_uri( '/lib/css/font-awesome.css' ), array( 'harmonica-style' ), '1.0' );

/**
 * Add widgets.
 *
 * @since Harmonica 1.0
 */
 
// Add theme widgets
require_once (get_template_directory() . "/lib/widgets/recent-comments.php");


// Delist the default WordPress widgets replaced by custom theme widgets
add_action('widgets_init', 'harmonica_unregister_default_widgets', 11);
 
function harmonica_unregister_default_widgets() {
	unregister_widget('WP_Widget_Recent_Comments');
}

/**
 * Get Page ID
 *
 * @since Harmonica 1.0
 */

function

get_page_id($page_name){

    global

$wpdb;

    $page_name

= $wpdb->get_var("SELECT
 ID FROM $wpdb->posts WHERE post_name = '".$page_name."'
 AND post_status = 'publish' AND post_type = 'page'");

    return

$page_name;

}

/**
 * Prism.js.
 *
 * @since Harmonica 1.0
 */

 function add_prism() {
        wp_register_style(
            'prismCSS', 
            get_stylesheet_directory_uri() . '/lib/css/prism.css' //自定义路径
         );
          wp_register_script(
            'prismJS',
            get_stylesheet_directory_uri() . '/lib/js/prism.js'   //自定义路径
         );
        wp_enqueue_style('prismCSS');
        wp_enqueue_script('prismJS');
    }
add_action('wp_enqueue_scripts', 'add_prism');

        $list = array(
            1 => array('id' => 'markup', 'name' => 'Markup', 'file' => 'prism-markup', 'require' => '', 'in_popup' => 1),
            2 => array('id' => 'css', 'name' => 'CSS', 'file' => 'prism-css', 'require' => '', 'in_popup' => 1),
            3 => array('id' => 'css-extras', 'name' => 'CSS Extras', 'file' => 'prism-css-extras', 'require' => 'css', 'in_popup' => 0),
            4 => array('id' => 'clike', 'name' => 'C-Like', 'file' => 'prism-clike', 'require' => '', 'in_popup' => 1),
            5 => array('id' => 'javascript', 'name' => 'Java-Script', 'file' => 'prism-javascript', 'require' => 'clike', 'in_popup' => 1),
            6 => array('id' => 'php', 'name' => 'PHP', 'file' => 'prism-php', 'require' => 'clike', 'in_popup' => 1),
            7 => array('id' => 'php-extras', 'name' => 'PHP Extras', 'file' => 'prism-php-extras', 'require' => 'php', 'in_popup' => 0),
            8 => array('id' => 'ruby', 'name' => 'Ruby', 'file' => 'prism-ruby', 'require' => 'clike', 'in_popup' => 1),
            9 => array('id' => 'sql', 'name' => 'SQL', 'file' => 'prism-sql', 'require' => '', 'in_popup' => 1),
            10 => array('id' => 'c', 'name' => 'C', 'file' => 'prism-c', 'require' => 'clike', 'in_popup' => 1),
            11 => array('id' => 'abap', 'name' => 'ABAP', 'file' => 'prism-abap', 'require' => '', 'in_popup' => 1),
            12 => array('id' => 'actionscript', 'name' => 'ActionScript', 'file' => 'prism-actionscript', 'require' => 'javascript', 'in_popup' => 1),
            13 => array('id' => 'ada', 'name' => 'Ada', 'file' => 'prism-ada', 'require' => '', 'in_popup' => 1),
            14 => array('id' => 'apacheconf', 'name' => 'Apache Configuration', 'file' => 'prism-apacheconf', 'require' => '', 'in_popup' => 1),
            15 => array('id' => 'apl', 'name' => 'APL', 'file' => 'prism-apl', 'require' => '', 'in_popup' => 1),
            16 => array('id' => 'applescript', 'name' => 'Applescript', 'file' => 'prism-applescript', 'require' => '', 'in_popup' => 1),
            17 => array('id' => 'asciidoc', 'name' => 'AsciiDoc', 'file' => 'prism-asciidoc', 'require' => '', 'in_popup' => 1),
            18 => array('id' => 'aspnet', 'name' => 'ASP.NET (C#)', 'file' => 'prism-aspnet', 'require' => 'markup', 'in_popup' => 1),
            19 => array('id' => 'autoit', 'name' => 'AutoIt', 'file' => 'prism-autoit', 'require' => '', 'in_popup' => 1),
            20 => array('id' => 'autohotkey', 'name' => 'AutoHotkey', 'file' => 'prism-autohotkey', 'require' => '', 'in_popup' => 1),
            21 => array('id' => 'bash', 'name' => 'Bash', 'file' => 'prism-bash', 'require' => '', 'in_popup' => 1),
            22 => array('id' => 'basic', 'name' => 'BASIC', 'file' => 'prism-basic', 'require' => '', 'in_popup' => 1),
            23 => array('id' => 'batch', 'name' => 'Batch', 'file' => 'prism-batch', 'require' => '', 'in_popup' => 1),
            24 => array('id' => 'bison', 'name' => 'Bison', 'file' => 'prism-bison', 'require' => 'c', 'in_popup' => 1),
            25 => array('id' => 'brainfuck', 'name' => 'Brainfuck', 'file' => 'prism-brainfuck', 'require' => '', 'in_popup' => 1),
            26 => array('id' => 'bro', 'name' => 'Bro', 'file' => 'prism-bro', 'require' => '', 'in_popup' => 1),
            27 => array('id' => 'csharp', 'name' => 'C#', 'file' => 'prism-csharp', 'require' => 'c', 'in_popup' => 1),
            28 => array('id' => 'cpp', 'name' => 'C++', 'file' => 'prism-cpp', 'require' => 'c', 'in_popup' => 1),
            29 => array('id' => 'coffeescript', 'name' => 'CoffeeScript', 'file' => 'prism-coffeescript', 'require' => 'javascript', 'in_popup' => 1),
            30 => array('id' => 'crystal', 'name' => 'Crystal', 'file' => 'prism-crystal', 'require' => 'ruby', 'in_popup' => 1),
            31 => array('id' => 'd', 'name' => 'D', 'file' => 'prism-d', 'require' => 'clike', 'in_popup' => 1),
            32 => array('id' => 'dart', 'name' => 'Dart', 'file' => 'prism-dart', 'require' => 'clike', 'in_popup' => 1),
            33 => array('id' => 'diff', 'name' => 'Diff', 'file' => 'prism-diff', 'require' => '', 'in_popup' => 1),
            34 => array('id' => 'django', 'name' => 'Django/Jinja2', 'file' => 'prism-django', 'require' => 'markup', 'in_popup' => 1),
            35 => array('id' => 'docker', 'name' => 'Docker', 'file' => 'prism-docker', 'require' => '', 'in_popup' => 1),
            36 => array('id' => 'eiffel', 'name' => 'Eiffel', 'file' => 'prism-eiffel', 'require' => '', 'in_popup' => 1),
            37 => array('id' => 'elixir', 'name' => 'Elixir', 'file' => 'prism-elixir', 'require' => '', 'in_popup' => 1),
            38 => array('id' => 'erlang', 'name' => 'Erlang', 'file' => 'prism-erlang', 'require' => '', 'in_popup' => 1),
            39 => array('id' => 'fsharp', 'name' => 'F#', 'file' => 'prism-fsharp', 'require' => 'clike', 'in_popup' => 1),
            40 => array('id' => 'fortran', 'name' => 'Fortran', 'file' => 'prism-fortran', 'require' => '', 'in_popup' => 1),
            41 => array('id' => 'gherkin', 'name' => 'Gherkin', 'file' => 'prism-gherkin', 'require' => '', 'in_popup' => 1),
            42 => array('id' => 'git', 'name' => 'Git', 'file' => 'prism-git', 'require' => '', 'in_popup' => 1),
            43 => array('id' => 'glsl', 'name' => 'GLSL', 'file' => 'prism-glsl', 'require' => 'clike', 'in_popup' => 1),
            44 => array('id' => 'go', 'name' => 'Go', 'file' => 'prism-go', 'require' => 'clike', 'in_popup' => 1),
            45 => array('id' => 'graphql', 'name' => 'GraphQL', 'file' => 'prism-graphql', 'require' => '', 'in_popup' => 1),
            46 => array('id' => 'groovy', 'name' => 'Groovy', 'file' => 'prism-groovy', 'require' => 'clike', 'in_popup' => 1),
            47 => array('id' => 'haml', 'name' => 'Haml', 'file' => 'prism-haml', 'require' => 'ruby', 'in_popup' => 1),
            48 => array('id' => 'handlebars', 'name' => 'Handlebars', 'file' => 'prism-handlebars', 'require' => 'markup', 'in_popup' => 1),
            49 => array('id' => 'haskell', 'name' => 'Haskell', 'file' => 'prism-haskell', 'require' => '', 'in_popup' => 1),
            50 => array('id' => 'haxe', 'name' => 'Haxe', 'file' => 'prism-haxe', 'require' => 'clike', 'in_popup' => 1),
            51 => array('id' => 'http', 'name' => 'HTTP', 'file' => 'prism-http', 'require' => '', 'in_popup' => 1),
            52 => array('id' => 'icon', 'name' => 'Icon', 'file' => 'prism-icon', 'require' => '', 'in_popup' => 1),
            53 => array('id' => 'inform7', 'name' => 'Inform 7', 'file' => 'prism-inform7', 'require' => '', 'in_popup' => 1),
            54 => array('id' => 'ini', 'name' => 'Ini', 'file' => 'prism-ini', 'require' => '', 'in_popup' => 1),
            55 => array('id' => 'j', 'name' => 'J', 'file' => 'prism-j', 'require' => '', 'in_popup' => 1),
            56 => array('id' => 'jade', 'name' => 'Jade', 'file' => 'prism-jade', 'require' => 'javascript', 'in_popup' => 1),
            57 => array('id' => 'java', 'name' => 'Java', 'file' => 'prism-java', 'require' => 'clike', 'in_popup' => 1),
            58 => array('id' => 'jolie', 'name' => 'Jolie', 'file' => 'prism-jolie', 'require' => 'clike', 'in_popup' => 1),
            59 => array('id' => 'json', 'name' => 'JSON', 'file' => 'prism-json', 'require' => '', 'in_popup' => 1),
            60 => array('id' => 'julia', 'name' => 'Julia', 'file' => 'prism-julia', 'require' => '', 'in_popup' => 1),
            61 => array('id' => 'keyman', 'name' => 'Keyman', 'file' => 'prism-keyman', 'require' => '', 'in_popup' => 1),
            62 => array('id' => 'kotlin', 'name' => 'Kotlin', 'file' => 'prism-kotlin', 'require' => 'clike', 'in_popup' => 1),
            63 => array('id' => 'latex', 'name' => 'LaTex', 'file' => 'prism-latex', 'require' => '', 'in_popup' => 1),
            64 => array('id' => 'less', 'name' => 'Less', 'file' => 'prism-less', 'require' => 'css', 'in_popup' => 1),
            65 => array('id' => 'livescript', 'name' => 'LiveScript', 'file' => 'prism-livescript', 'require' => '', 'in_popup' => 1),
            66 => array('id' => 'lolcode', 'name' => 'LOLCODE', 'file' => 'prism-lolcode', 'require' => '', 'in_popup' => 1),
            67 => array('id' => 'lua', 'name' => 'Lua', 'file' => 'prism-lua', 'require' => '', 'in_popup' => 1),
            68 => array('id' => 'makefile', 'name' => 'Makefile', 'file' => 'prism-makefile', 'require' => '', 'in_popup' => 1),
            69 => array('id' => 'markdown', 'name' => 'Markdown', 'file' => 'prism-markdown', 'require' => 'markup', 'in_popup' => 1),
            70 => array('id' => 'matlab', 'name' => 'MATLAB', 'file' => 'prism-matlab', 'require' => '', 'in_popup' => 1),
            71 => array('id' => 'mel', 'name' => 'MEL', 'file' => 'prism-mel', 'require' => '', 'in_popup' => 1),
            72 => array('id' => 'mizar', 'name' => 'Mizar', 'file' => 'prism-mizar', 'require' => '', 'in_popup' => 1),
            73 => array('id' => 'monkey', 'name' => 'Monkey', 'file' => 'prism-monkey', 'require' => '', 'in_popup' => 1),
            74 => array('id' => 'nasm', 'name' => 'NASM', 'file' => 'prism-nasm', 'require' => '', 'in_popup' => 1),
            75 => array('id' => 'nginx', 'name' => 'nginx', 'file' => 'prism-nginx', 'require' => 'clike', 'in_popup' => 1),
            76 => array('id' => 'nim', 'name' => 'Nim', 'file' => 'prism-nim', 'require' => '', 'in_popup' => 1),
            77 => array('id' => 'nix', 'name' => 'Nix', 'file' => 'prism-nix', 'require' => '', 'in_popup' => 1),
            78 => array('id' => 'objectivec', 'name' => 'Objective-C', 'file' => 'prism-objectivec', 'require' => 'c', 'in_popup' => 1),
            79 => array('id' => 'ocaml', 'name' => 'OCaml', 'file' => 'prism-ocaml', 'require' => '', 'in_popup' => 1),
            80 => array('id' => 'oz', 'name' => 'Oz', 'file' => 'prism-oz', 'require' => '', 'in_popup' => 1),
            81 => array('id' => 'parigp', 'name' => 'PARI/GP', 'file' => 'prism-parigp', 'require' => '', 'in_popup' => 1),
            82 => array('id' => 'parser', 'name' => 'Parser', 'file' => 'prism-parser', 'require' => 'markup', 'in_popup' => 1),
            83 => array('id' => 'pascal', 'name' => 'Pascal', 'file' => 'prism-pascal', 'require' => '', 'in_popup' => 1),
            84 => array('id' => 'perl', 'name' => 'Perl', 'file' => 'prism-perl', 'require' => '', 'in_popup' => 1),
            85 => array('id' => 'powershell', 'name' => 'PowerShell', 'file' => 'prism-powershell', 'require' => '', 'in_popup' => 1),
            86 => array('id' => 'processing', 'name' => 'Processing', 'file' => 'prism-processing', 'require' => 'clike', 'in_popup' => 1),
            87 => array('id' => 'prolog', 'name' => 'Prolog', 'file' => 'prism-prolog', 'require' => '', 'in_popup' => 1),
            88 => array('id' => 'properties', 'name' => '.properties', 'file' => 'prism-properties', 'require' => '', 'in_popup' => 1),
            89 => array('id' => 'protobuf', 'name' => 'Protocol Buffers', 'file' => 'prism-protobuf', 'require' => 'clike', 'in_popup' => 1),
            90 => array('id' => 'puppet', 'name' => 'Puppet', 'file' => 'prism-puppet', 'require' => '', 'in_popup' => 1),
            91 => array('id' => 'pure', 'name' => 'Pure', 'file' => 'prism-pure', 'require' => '', 'in_popup' => 1),
            92 => array('id' => 'python', 'name' => 'Python', 'file' => 'prism-python', 'require' => '', 'in_popup' => 1),
            93 => array('id' => 'q', 'name' => 'Q', 'file' => 'prism-q', 'require' => '', 'in_popup' => 1),
            94 => array('id' => 'qore', 'name' => 'Qore', 'file' => 'prism-qore', 'require' => 'clike', 'in_popup' => 1),
            95 => array('id' => 'r', 'name' => 'R', 'file' => 'prism-r', 'require' => '', 'in_popup' => 1),
            96 => array('id' => 'jsx', 'name' => 'React JSX', 'file' => 'prism-jsx', 'require' => 'markup', 'in_popup' => 1),
            97 => array('id' => 'reason', 'name' => 'Reason', 'file' => 'prism-reason', 'require' => 'clike', 'in_popup' => 1),
            98 => array('id' => 'rest', 'name' => 'reST (reStructuredText)', 'file' => 'prism-rest', 'require' => '', 'in_popup' => 1),
            99 => array('id' => 'rip', 'name' => 'Rip', 'file' => 'prism-rip', 'require' => '', 'in_popup' => 1),
            100 => array('id' => 'roboconf', 'name' => 'Roboconf', 'file' => 'prism-roboconf', 'require' => '', 'in_popup' => 1),
            101 => array('id' => 'rust', 'name' => 'Rust', 'file' => 'prism-rust', 'require' => '', 'in_popup' => 1),
            102 => array('id' => 'sas', 'name' => 'SAS', 'file' => 'prism-sas', 'require' => '', 'in_popup' => 1),
            103 => array('id' => 'sass', 'name' => 'Sass (Sass)', 'file' => 'prism-sass', 'require' => 'css', 'in_popup' => 1),
            104 => array('id' => 'scss', 'name' => 'Sass (Scss)', 'file' => 'prism-scss', 'require' => 'css', 'in_popup' => 1),
            105 => array('id' => 'scala', 'name' => 'Scala', 'file' => 'prism-scala', 'require' => 'clike', 'in_popup' => 1),
            106 => array('id' => 'scheme', 'name' => 'Scheme', 'file' => 'prism-scheme', 'require' => '', 'in_popup' => 1),
            107 => array('id' => 'smalltalk', 'name' => 'Smalltalk', 'file' => 'prism-smalltalk', 'require' => '', 'in_popup' => 1),
            108 => array('id' => 'smarty', 'name' => 'Smarty', 'file' => 'prism-smarty', 'require' => 'markup', 'in_popup' => 1),
            109 => array('id' => 'stylus', 'name' => 'Stylus', 'file' => 'prism-stylus', 'require' => '', 'in_popup' => 1),
            110 => array('id' => 'swift', 'name' => 'Swift', 'file' => 'prism-swift', 'require' => 'clike', 'in_popup' => 1),
            111 => array('id' => 'tcl', 'name' => 'Tcl', 'file' => 'prism-tcl', 'require' => '', 'in_popup' => 1),
            112 => array('id' => 'textile', 'name' => 'Textile', 'file' => 'prism-textile', 'require' => 'markup', 'in_popup' => 1),
            113 => array('id' => 'twig', 'name' => 'Twig', 'file' => 'prism-twig', 'require' => 'markup', 'in_popup' => 1),
            114 => array('id' => 'typescript', 'name' => 'TypeScript', 'file' => 'prism-typescript', 'require' => 'javascript', 'in_popup' => 1),
            115 => array('id' => 'verilog', 'name' => 'Verilog', 'file' => 'prism-verilog', 'require' => '', 'in_popup' => 1),
            116 => array('id' => 'vhdl', 'name' => 'VHDL', 'file' => 'prism-vhdl', 'require' => '', 'in_popup' => 1),
            117 => array('id' => 'vim', 'name' => 'vim', 'file' => 'prism-vim', 'require' => '', 'in_popup' => 1),
            118 => array('id' => 'wiki', 'name' => 'Wiki markup', 'file' => 'prism-wiki', 'require' => 'markup', 'in_popup' => 1),
            119 => array('id' => 'xojo', 'name' => 'Xojo (REALbasic)', 'file' => 'prism-xojo', 'require' => '', 'in_popup' => 1),
            120 => array('id' => 'yaml', 'name' => 'YAML', 'file' => 'prism-yaml', 'require' => '', 'in_popup' => 1),

        );
function should_add_button()
    {
        // check for user permissions
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return false;
        }

        // check if WYSIWYG is enabled
        if (get_user_option('rich_editing') == 'true') {
            return true;
        }
        return false;
    }
/*if (should_add_button() == true) {
	echo "<script type='text/javascript'> /* <![CDATA[ *//*";
	echo 'var prismLangs=[';
	for ($i = 1; $i <= count($list); $i++) {
		if ($list[$i]['in_popup'] == 1)
		echo '{text:"' . esc_attr(ucwords($list[$i]['id'])) . '", value:"' . esc_attr($list[$i]['id']) . '"},';
	}
	echo "]; /* ]]> *//*</script>";
}*/
	//初始化时执行myadvert_button函数   
add_action('init', 'prism_quick_button');   
function prism_quick_button() {   
    //判断用户是否有编辑文章和页面的权限   
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {   
        return;   
    }   
    //判断用户是否使用可视化编辑器   
    if ( get_user_option('rich_editing') == 'true' ) {   
  
        add_filter( 'mce_external_plugins', 'add_plugin' );   
        add_filter( 'mce_buttons', 'register_button' );   
    }   
}  

function register_button( $buttons ) {   
    array_push( $buttons, "|", "prism" ); //添加 一个myadvert按钮   
    //array_push( $buttons, "|", "mylink" ); //添加一个mylink按钮   
  
    return $buttons;   
}   
function add_plugin( $plugin_array ) {   
   $plugin_array['prism'] = get_stylesheet_directory_uri() . '/lib/js/prism_quick_button.js'; //myadvert按钮的js路径   
   //$plugin_array['mylink'] = get_bloginfo( 'template_url' ) . '/js/mylink.js'; //mylink按钮的js路径   
   return $plugin_array;   
}  

/**
 * Get Comment numbers.
 *
 * @since Harmonica 1.0
 */
 
function harmonica_comments_users($postid=0,$which=0) {
	$comments = get_comments('status=approve&type=comment&post_id='.$postid); //获取文章的所有评论
	if ($comments) {
		$i=0; $j=0; $commentusers=array();
		foreach ($comments as $comment) {
			++$i;
			if ($i==1) { $commentusers[] = $comment->comment_author_email; ++$j; }
			if ( !in_array($comment->comment_author_email, $commentusers) ) {
				$commentusers[] = $comment->comment_author_email;
				++$j;
			}
		}
		$output = array($j,$i);
		$which = ($which == 0) ? 0 : 1;
		return $output[$which]; //返回评论人数
	}
	return 0; //没有评论返回0
}

/**
 * Get view numbers.
 *
 * @since Harmonica 1.0
 */
 


/**
* getPostViews()函数
* 功能：获取阅读数量
* 在需要显示浏览次数的位置，调用此函数
* @Param object|int $postID   文章的id
* @Return string $count          文章阅读数量
*/
function getPostViews( $postID ) {
     $count_key = 'post_views_count';
     $count = get_post_meta( $postID, $count_key, true );
     if( $count=='' ) {
         delete_post_meta( $postID, $count_key );
         add_post_meta( $postID, $count_key, '0' );
         return "0";
     }
    return $count;
 }


/**
* setPostViews()函数  
* 功能：设置或更新阅读数量
* 在内容页(single.php，或page.php )调用此函数
* @Param object|int $postID   文章的id
* @Return string $count          文章阅读数量
*/
 function setPostViews( $postID ) {
     $count_key = 'post_views_count';
     $count = get_post_meta( $postID, $count_key, true );
     if( $count=='' ) {
         $count = 0;
         delete_post_meta( $postID, $count_key );
         add_post_meta( $postID, $count_key, '0' );
     } else {
         $count++;
         update_post_meta( $postID, $count_key, $count );
     }
 }
 
 /**
 * Add ajax comments
 *
 * @since Harmonica 1.0
 */
require get_template_directory() . '/lib/ajax-comment/main.php';
