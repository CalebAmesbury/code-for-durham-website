<?php get_header(); ?>

<div>

  <div class="page-banner">
    <div class="overlay"></div>
    <div class="durham" style="background-image: url(<?php the_post_thumbnail_url('homepage-banner'); ?>);">
      <?php $speakers = get_field('speaker');
        if ($speakers && sizeof($speakers) > 0) { ?>
          <div class="speakers">
            <h2>Our Next Speaker<?php if (sizeof($speakers) > 1) { echo 's'; } ?></h2>
            <div class="speaker-list">
              <?php foreach ($speakers as $speaker) {
                $img_url = $speaker["profile_picture"]["sizes"]["profile-picture"]; 
                if (!$img_url) { $img_url = get_theme_file_uri('images/user/user@2x.png');}?>
                <a class="speaker" <?php if ($speaker["link"]) echo 'href="' . $speaker["link"] . '"'; ?> target="_blank">
                  <img src="<?php echo $img_url; ?>" alt="<?php echo $speaker["name"] . "profile picture"; ?>">
                  <div class="name"><?php echo $speaker["name"]; ?></div>
                  <div><?php echo $speaker["organization"]; ?></div>
                </a>
              <?php }
              ?>
            </div>
          </div>
        <?php }
      ?>
    </div>
  </div>

  <section class="boxes">
    <div class="box">
      <?php 
        $next_meetup = get_next_meetup(); 
        $start_datetime = date("l, M j, g:i", ($next_meetup->time + $next_meetup->utc_offset)/1000);
        $end_time = date("g:ia", ($next_meetup->time + $next_meetup->utc_offset + $next_meetup->duration)/1000);
        $full_address = $next_meetup->venue->address_1 . ', ' . $next_meetup->venue->city . ', ' . $next_meetup->venue->state;
      ?>
      <a class="box-header next_meetup" href="<?php echo $next_meetup->link; ?>" target="_blank">
        <h2>NEXT MEETUP</h2>
      </a>
      <div class="box-body meetup">
        <div class="meetup_info">
          <div class="meetup_datetime">
            <img src="<?php echo get_theme_file_uri('images/calendar.svg'); ?>" alt="">
            <?php echo $start_datetime . ' - ' . $end_time ?>
          </div>

          <div class="meetup_title"><?php echo $next_meetup->name ?></div>
          
          <div class="meetup_location"><a href="https://www.google.com/maps/search/?api=1&query=<?php echo $full_address; ?>" target="_blank">
            @ <?php echo $next_meetup->venue->name ?>
          </a></div>

        </div>

        <div class="cta">
          <div class="meetup_rsvps">( <?php echo $next_meetup->yes_rsvp_count; ?> so far )</div>

          <a href="<?php echo $next_meetup->link; ?>" target="_blank">JOIN</a>
        </div>
      </div>
    </div>
    <div class="box">
      <a class="box-header get_started" href="<?php echo site_url('/getting-started'); ?>">
        <h2>GET STARTED</h2>
      </a>
      <div class="box-body faq">
        <ul>
          <li>
            <a href="<?php echo site_url('/about#what-is-cfd'); ?>">
              <img src="<?php echo get_theme_file_uri('images/question-icon.svg'); ?>" alt="">
              What is Code for America?
            </a>
          </li>
          <li>
            <a href="<?php echo site_url('/about#civic-hacking'); ?>">
              <img src="<?php echo get_theme_file_uri('images/question-icon.svg'); ?>" alt="">
              What is Civic Hacking?
            </a>
          </li>
          <li>
            <a href="<?php echo site_url('/getting-started#how-to-help'); ?>">
              <img src="<?php echo get_theme_file_uri('images/question-icon.svg'); ?>" alt="">
              How can I help?
            </a>
          </li>
        </ul>
        <div class="cta">
          <a href="<?php echo site_url('/getting-started'); ?>">LEARN MORE</a>
        </div>
      </div>
    </div>
  </section>

  <section class="projects" id="projects">
    <h2>WHAT WE ARE DOING</h2>

    <div class="project-list">

      <?php

        $projects = new WP_Query(array(
          'post_type' => 'project',
        ));

        if ($projects->have_posts()) {

          while ($projects->have_posts()) {
            $projects->the_post(); ?>

            <div class="project hover-zoom" style="background-image: url(<?php the_post_thumbnail_url('project-thumbnail'); ?>);">
              <div class="overlay"></div>
              
              <a class="project-description" href="<?php the_permalink(); ?>">
                <h3><?php the_title(); ?></h3>

                <button class="status <?php echo strtolower(get_field('project_status')); ?>">
                  <?php echo strtoupper(get_field('project_status'));?>
                </button>
              </a>
            </div>

        <?php } 

        }
      ?>

      <div class="project">
        <a class="project-description submit" href="https://docs.google.com/forms/d/e/1FAIpQLSd72N1G209t4k-F51mu61SZMSqXMeObKjJKJSjl_ZL0K23bsw/viewform" target="_blank">
          <h3>Submit your own idea</h3>
        </a>
      </div>

    </div>

  </section>

  <?php 
    $project_spotlight = new WP_Query(array(
      'pagename' => 'project-spotlight'
    ));
    if ( $project_spotlight->have_posts() ) {

      while ( $project_spotlight->have_posts() ) {
    
        $project_spotlight->the_post(); ?>

        <section class="spotlight">

          <h2>Project Spotlight</h2>

          <div class="spotlight-project">

            <div class="spotlight-image">
              <img src="<?php the_post_thumbnail_url('project-spotlight'); ?>" alt="">
            </div>

            <div class="spotlight-content">
              <h3 class="project-title">
                <?php $url = get_permalink(get_field('project_title')->ID); ?>
                <a href="<?php echo $url ?>">
                  <?php echo get_field('project_title')->post_title ; ?>
                </a>
              </h3>

              <div class="content"><?php echo shorten_text(get_field('description'), 330); ?></div>
              
              <a class="read-more" href="<?php the_field('link')?>">READ MORE</a>
            </div>

          </div>

        </section>
            
      <?php } 
       
    }
  ?>
</div>

<?php get_footer(); ?>
