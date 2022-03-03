<?php get_header() ?>

<main id="main" class="grid-container">

    <h1 class="text-right"><?php the_archive_title(); ?></h1>

    <?php if (have_posts()) {
        while (have_posts()) {
            the_post(); ?>

            <h2 class="text-right">
                <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
            </h2>

            <i class="fi-pencil"></i>

            <?php the_excerpt(); ?>
            
            <p>
                By:&nbsp;
                <?php the_author(); ?>
                ,
                <?php echo get_the_date(); ?>
                ,
                <?php the_time(); ?>
            </p>

            <p>

                Comments:

                <?php comments_popup_link(); ?>

            </p>

        <?php } ?>

    <?php } else { ?>

        <p>Sorry, we cant find anything</p>

    <?php } ?>

</main>

<?php get_footer(); ?>