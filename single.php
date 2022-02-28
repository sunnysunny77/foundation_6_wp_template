<?php get_header(); ?>

    <main id="main" class="grid-container">

        <?php
        
        if (have_posts()) {
            while (have_posts()) {
                the_post(); ?>

                <h2 class="text-right"> <?php the_title(); ?> </h2>

                <i class="fi-comments"></i>

                <?php if (has_post_thumbnail()) { ?>

                    <div>

                        <?php the_post_thumbnail(); ?>

                    </div>

                <?php } ?>

                <?php echo get_the_date(); ?>

                <?php the_content() ?>

                <?php the_author(); ?>

            <?php } ?>

        <?php }
        
        edit_post_link();

        the_category();

        the_tags();

        ?>

        <div id="prevpost"><?php previous_post_link(); ?></div>

        <div id="nextpost"><?php next_post_link(); ?> </div>

        <?php
        if (comments_open() || get_comments_number()) :
             comments_template();
        endif;

        ?>

    </main>

<?php get_footer(); ?>