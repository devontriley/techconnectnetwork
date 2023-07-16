<?php
$title = $args['title'];
$excerpt = $args['excerpt'];
$thumbnail = $args['thumbnail'];
$file = $args['file'];
$video = $args['video'];
$downloadURL = $file ?: $video;
?>

<div class="resource-card card">
    <?php echo $thumbnail; ?>
    <div class="card-body">
        <h5 class="card-title"><?php echo $title; ?></h5>
        <?php if ( $excerpt ) : ?>
            <p class="card-text"><?php echo $excerpt; ?></p>
        <?php endif; ?>
        <?php if ( $downloadURL ) : ?>
            <a href="<?php echo $downloadURL; ?>" target="_blank" class="btn btn-primary btn-sm">View Resource</a>
        <?php endif; ?>
    </div>
</div>