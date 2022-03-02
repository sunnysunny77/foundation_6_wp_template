<?php get_header(); ?>

<main id="main" class="grid-container">

    <?php

    if (have_posts()) {
        while (have_posts()) {
            the_post(); ?>

            <h1 class="text-right"> <?php the_title(); ?> </h1>

            <i class="fi-comments"></i>

            <?php the_content() ?>

            <?php edit_post_link(); ?>

            <?php  the_post_navigation( array(
            'prev_text'                  => __( '← %title' ),
            'next_text'                  => __( '→ %title' ),
            'screen_reader_text' => __( 'Continue Reading' ),
        ) ); ?>

            <p>
                By:&nbsp;
                <?php the_author(); ?>
                ,
                <?php echo get_the_date(); ?>
            </p>

        <?php } ?>

    <?php } ?>

    <?php the_category();  ?>

    <p>

        <?php the_tags(); ?>

    </p>

    <?php if (comments_open() || get_comments_number()) {
        comments_template();
    } ?>

</main>

<?php get_footer(); ?>