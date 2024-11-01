<?php get_header(); ?>


<?php 


		while(have_posts()) : the_post(); ?>
		<div class="single-member">
			<div class="member-image">
				<?php the_post_thumbnail(); ?>
			</div>
			<div class="member-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
			<div class="member-description"><?php the_content(); ?></div>
			<div class="member-social-profiles">
				<ul>
					<li><a href="#"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#"><i class="fa fa-twitter"></i></a></li>
				</ul>
			</div>
		</div>

		<?php endwhile; wp_reset_postdata(); ?>


<?php get_footer(); ?>