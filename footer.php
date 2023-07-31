<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
?>

<?php
$logo = get_field( 'logo', 'option' );
$footerLogo = get_field( 'footer_logo', 'options' );
$footerMenu1 = wp_get_nav_menu_items( 'footer-menu' );
$footerMenuHeader1 = get_field( 'footer_menu_header', wp_get_nav_menu_object( 'footer-menu' ) );
$newsletterFormEmbed = get_field( 'newsletter_form_embed', 'option' );
$socialLinks = get_field( 'social_media_links', 'option' );
$privacyPolicyURL = get_field( 'privacy_policy_url', 'option' );
$footerAddressContact = get_field( 'footer_address_&_contact', 'option' );
$donateURL = get_field( 'donate_url', 'option' );
?>

<div class="primary-footer">
    <div class="container-lg">
        <div class="row footer-top">
            <div class="col-lg-8 offset-lg-2 text-center">

                <a href="<?php echo get_home_url() ?>" class="footer-logo">
                    <?php echo apply_filters( 'heretic_footer_logo', wp_get_attachment_image( ($footerLogo ? $footerLogo['ID'] : $logo['ID']), 'full' ) ) ?>
                </a>

                <?php if ( $footerMenu1 ) : ?>
                    <ul class="footer-links">
                        <?php foreach ( $footerMenu1 as $key => $menuItem ) : ?>
                            <li>
                                <a href="<?php echo $menuItem->url ?>" target="<?php echo $menuItem->target ?>" class="btn btn-primary btn-sm">
                                    <?php echo $menuItem->title ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( $newsletterFormEmbed ) : ?>
                    <div class="newsletter-form">
                        <h4>SUBSCRIBE TO OUR NEWSLETTER</h4>
                        <?php echo $newsletterFormEmbed ?>
                    </div>
                <?php endif; ?>

                <?php if ( $footerAddressContact ) { ?>
                    <h4><?php echo get_bloginfo( 'name' ); ?></h4>
                    <?php echo $footerAddressContact ?>
                <?php } ?>

                <?php if ( $socialLinks ) : ?>
                    <div class="social col-auto">
                        <ul class="social-links">
                            <?php foreach ( $socialLinks as $link ) : ?>
                                <li>
                                    <a href="<?php echo $link['url'] ?>" target="_blank">
                                        <div class="icon"><?php echo $link['icon'] ?></div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <p class="copyright">
                    © <?php echo date('Y') ?> <?php echo get_bloginfo( 'site_name' ) ?>, All Rights Reserved.
                    <?php if( $privacyPolicyURL ) { ?>
                        <a href="<?php echo $privacyPolicyURL ?>" class="privacy-policy">Privacy Policy</a>
                    <?php } ?>
                </p>

            </div>
        </div>
    </div>
</div>

<!-- Team Members Bio Drawer -->
<?php
global $allGridTeamMembers;
if ( $allGridTeamMembers ) : ?>
    <dialog id="team-members-dialog" data-modal>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="close-team-members-dialog bi bi-x-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>

        <?php foreach ( $allGridTeamMembers as $key => $teamMember ) : ?>
            <div class="team-member" data-id="<?php echo $key ?>">
                <h3><?php echo $teamMember['name'] ?></h3>
                <?php echo $teamMember['bio'] ?>
            </div>
        <?php endforeach; ?>
    </dialog>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>