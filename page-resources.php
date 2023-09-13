<?php
// Template Name: Resources
get_header(); ?>

<?php
$bodyCopy = get_field( 'body_copy' );
$user = wp_get_current_user();
$userRoles = $user->roles;
$categories = get_terms([
    'taxonomy' => 'resource-categories',
    'hide_empty' => 'true'
]);
?>

<div class="resources-page layout-vertical-spacing">
    <div class="container">

            <?php if ( ! is_user_logged_in() ) : ?>
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                            <h1>Resources</h1>
                            <?php techconnect_login_form(); ?>
                        </div>
                </div>
            <?php endif; ?>

            <?php
            if ( is_user_logged_in() ) : ?>

                <h1>Resources</h1>

                <?php if ( $bodyCopy ) : ?>
                    <div class="row">
                        <div class="col col-lg-8">
                            <?php echo $bodyCopy; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-md-4">
                    <select class="resource-select form-select">
                        <option selected disabled>Choose a category</option>
                        <?php foreach ( $categories as $cat ) : ?>
                            <option value="<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php
                $resourceQuery = new WP_Query([
                    'post_type' => 'resources',
                    'posts_per_page' => -1,
                    'orderby' => array( 'meta_value' => 'DESC', 'menu_order' => 'ASC' ),
                    'meta_key' => 'resource_category'
                ]);

                if( $resourceQuery->found_posts ) : ?>

                    <?php
                    $previousCategory = '';

                    $counter = 0;
                    foreach ( $resourceQuery->posts as $resource ) :
                        $id = $resource->ID;
                        $title = $resource->post_title;
                        $excerpt = get_field( 'excerpt', $id );
                        $thumbnail = get_the_post_thumbnail( $id );
                        $file = get_field( 'resource', $id );
                        $video = get_field( 'video' , $id );
                        $category = get_field( 'resource_category', $id );
                        $categorySlug = $category->slug;
                        $categoryName = $category->name;

                        if ( $previousCategory !== $categoryName ) : ?>
                            <?php if ( $previousCategory !== '' ) : ?>
                            </div><!-- .row -->
                            <?php endif; ?>
                            <div class="row">
                            <h2 id="<?php echo $categorySlug; ?>" class="mt-5 mb-4"><?php echo $categoryName; ?></h2>
                        <?php endif; ?>

                        <div class="col-sm-6 col-md-4 mb-4">
                            <?php
                            get_template_part( 'inc/resource-card', null, [
                                'title' => $title,
                                'excerpt' => $excerpt,
                                'thumbnail' => $thumbnail,
                                'file' => $file,
                                'video' => $video
                            ] ); ?>
                        </div>

                        <?php if ( $counter == $resourceQuery->found_posts - 1 ) : ?>
                            </div><!-- .row -->
                        <?php endif; ?>

                    <?php
                    $previousCategory = $categoryName;
                    $counter++;
                    endforeach;
                    ?>

                <?php
                endif;
            endif;
            ?>

    </div>
</div>

    <?php if ( get_edit_post_link() ) : ?>
        <footer class="entry-footer default-max-width">
            <div class="container-lg">
                <div class="row">
                    <?php
                    edit_post_link(
                        sprintf(
                        /* translators: %s: Post title. Only visible to screen readers. */
                            esc_html__( 'Edit %s', 'heretic' ),
                            '<span class="screen-reader-text">' . get_the_title() . '</span>'
                        ),
                        '<span class="edit-link">',
                        '</span>'
                    );
                    ?>
                </div>
            </div>
        </footer><!-- .entry-footer -->
    <?php endif; ?>

<?php get_footer(); ?>
