<?php get_header(); ?>

<main id="main" class="grid-container single">

    <?php

    if (have_posts()) {
        while (have_posts()) {
            the_post(); ?>

            <h2 class="text-right"> <?php the_title(); ?> </h2>

            <i class="fi-comments"></i>

            <?php the_content() ?>

            <?php edit_post_link(); ?>

            <nav>
                <ul>
                    <li><?php previous_post_link(); ?></li>
                    <li>|</li>
                    <li><?php next_post_link(); ?></li>
                </ul>
            </nav>

            <p>
                By:&nbsp;
                <?php the_author(); ?>
                ,
                <?php echo get_the_date(); ?>
            </p>

        <?php } ?>

    <?php } ?>

    <br />

    <?php the_category();  ?>

    <?php the_tags(); ?>

    <br />

    <br />

    <?php if (comments_open() || get_comments_number()) {
        comments_template();
    } ?>

</main>

<?php get_footer(); ?>