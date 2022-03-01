<?php if (have_posts()) {
  while (have_posts()) {
    the_post(); ?>
    
    <h1 class="text-right">
      <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
    </h1>

    <i class="fi-pencil"></i>

    <?php the_content() ?>

  <?php } ?>

<?php } else { ?>

  <p>Sorry, we cant find anything</p>

<?php } ?>