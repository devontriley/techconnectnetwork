<?php

if (!function_exists('techconnect_enqueue_styles')) :
    function techconnect_enqueue_styles() {
        wp_enqueue_style('adobe-fonts-como', 'https://use.typekit.net/oah5mho.css' );
        wp_enqueue_style( 'techconnect-style', get_stylesheet_uri(), array( 'heretic-style' ), filemtime(get_stylesheet_directory() . '/style.css') );
    }
endif;
add_action( 'wp_enqueue_scripts', 'techconnect_enqueue_styles' );

if (!function_exists('techconnect_scripts')) :
    function techconnect_scripts() {
        wp_enqueue_script( 'techconnect-script', get_stylesheet_directory_uri().'/main.js', array('jquery'), filemtime(get_stylesheet_directory() . '/main.js'), true );
    }
endif;
add_action( 'wp_enqueue_scripts', 'techconnect_scripts' );

// Register custom post types
function techconnect_register_custom_post_types() {
    register_post_type('resources',
        array(
            'labels' => array(
                'name'          => 'Resources',
                'singular_name' => 'Resource'
            ),
            'menu_icon' => 'dashicons-list-view',
            'public' => true,
            'publicly_queryable' => true,
            'has_archive' => false,
            'taxonomies' => array(),
            'hierarchical' => true,
            'supports' => array( 'title', 'thumbnail', 'slug' )
        )
    );
}
add_action('init', 'techconnect_register_custom_post_types');

// Register custom taxonomies
function techconnect_register_custom_taxonomies() {
    $labels = array(
        'name'              => 'Resource Categories',
        'singular_name'     => 'Resource Category',
        'search_items'      => 'Search Resource Categories',
        'all_items'         => 'All Resource Categories',
        'parent_item'       => 'Parent Resource Category',
        'parent_item_colon' => 'Parent Resource Category:',
        'edit_item'         => 'Edit Resource Category',
        'update_item'       => 'Update Resource Category',
        'add_new_item'      => 'Add New Resource Category',
        'new_item_name'     => 'New Resource Category Name',
        'menu_name'         => 'Resource Categories',
    );
    $args   = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true
    );
    register_taxonomy( 'resource-categories', [ 'resources' ], $args );
}
add_action( 'init', 'techconnect_register_custom_taxonomies' );

// Add user role to access Resources
function techconnect_add_role() {
    $role_name = 'resource_access'; // Replace with your desired role name
    $role_label = 'Resource Access'; // Replace with your desired role label

    add_role(
        $role_name,
        $role_label,
        array() // Add capabilities
    );
}
add_action('init', 'techconnect_add_role');

// Modify the login form html for the Resources page
function techconnect_login_form() {
    ob_start();
    $error = $_GET['login_error'];
    $userLogin = $_GET['user_login'] ?: ''; ?>

    <div class="login-form-wrapper">

        <?php if ( $error ) :
            $errorMessage = 'There was an error. Please try again.';
            switch ( $error ) :
                case 'empty_username':
                    $errorMessage = 'Please enter your username.';
                    break;
                case 'empty_password':
                    $errorMessage = 'Please enter your password.';
                    break;
                case 'incorrect_password':
                    $errorMessage = 'Please enter the correct password.';
                    break;
                case 'invalid_username':
                    $errorMessage = 'Please enter a valid username.';
                    break;
            endswitch; ?>
            <div class="error-message mb-3">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <form name="loginform" id="login-form" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post">
            <input type="hidden" name="custom_login" value="true">

            <div class="mb-3">
                <input class="form-control" name="log" id="user_login" type="text" value="<?php echo $userLogin; ?>" aria-label="Email" placeholder="Email" />
            </div>
            <div class="mb-3">
                <input class="form-control" name="pwd" id="user_pass" type="password" aria-label="Password" placeholder="Password" />
            </div>
            <button class="btn btn-primary" id="wp-submit" type="submit">Log In</button>
        </form>
    </div>
<?php echo ob_get_clean(); }

function custom_login_form_submission() {
    if ( isset( $_POST['custom_login'] ) && $_POST['custom_login'] === 'true' ) {
        $credentials = array();
        $credentials['user_login'] = $_POST['log'];
        $credentials['user_password'] = $_POST['pwd'];
        $credentials['remember'] = true;

        $user = wp_signon( $credentials, false );

        if ( is_wp_error( $user ) ) {
            // Error occurred during login
            $queryArgs = array(
                'login_error' => $user->get_error_code()
            );
            if ( $credentials['user_login'] ) {
                $queryArgs['user_login'] = $credentials['user_login'];
            }
            if ( $credentials['user_password'] ) {
                $queryArgs['user_password'] = $credentials['user_password'];
            }
            $login_url = add_query_arg( $queryArgs, $_SERVER['REQUEST_URI'] );
            wp_safe_redirect( $login_url );
            exit;
        } else {
            // Successful login
            $redirect_url = remove_query_arg( 'login_error', $_SERVER['REQUEST_URI'] );
            wp_safe_redirect( $redirect_url );
            exit;
        }
    }
}
add_action( 'init', 'custom_login_form_submission' );
