<?php get_header(); ?>
<div class="container">
  <div class="contents">
    <?php while (have_posts()): the_post(); ?>
      <h2><?php the_title(); ?></h2>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </div><!--end contents-->
</div><!--end container-->
<?php get_footer(); ?>
