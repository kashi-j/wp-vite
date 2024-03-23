<?php get_header(); ?>
<div class="hoge">
  <div class="hoge1">
    <p class="hoge2">Currently in <strong>
    <?php echo (IS_VITE_DEVELOPMENT) ? "development" : "production" ?></strong> mode.</p>
    <img src="<?php echo esc_url(get_theme_file_uri(ENV_DIR . "assets/images/mail1.svg")); ?>" alt="" width="660" height="420" loading="lazy">
  </div>
</div>
<?php get_footer(); ?>