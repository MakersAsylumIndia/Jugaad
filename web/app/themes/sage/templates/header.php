<header class="banner">
  <div class="container">
    <a class="brand hidden-xs hidden-sm" alt="Jugaad Magazine" href="<?= esc_url(home_url('/')); ?>"><h1 class="jugaad-brand"><?php bloginfo('name'); ?></h1></a>

    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
           <!-- Brand and toggle get grouped for better mobile display -->
           <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                   <span class="sr-only">Toggle navigation</span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </button>
               <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
               <a class="navbar-brand hidden-md hidden-lg" href="<?= esc_url(home_url('/')); ?>"></a>
           </div>
           <!-- Collect the nav links, forms, and other content for toggling -->
           <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
             <?php
             if (has_nav_menu('primary_navigation')) :
               wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav']);
             endif;
             ?>
           </div>
           <!-- /.navbar-collapse -->
     </nav>
  </div>
</header>
