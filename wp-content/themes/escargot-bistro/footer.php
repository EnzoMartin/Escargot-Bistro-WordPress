		<?php if(!is_home() && !is_front_page()){ ?>
			<footer class="footer container" role="contentinfo">
				<div class="row">
					<div class="col-xs-12">
						<div id="inner-footer">
							<div class="row">
								<div class="col-xs-12 col-md-4 center">
									<h3>ADDRESS</h3>
									<a href="https://www.google.com/maps/place/Escargot+Bistro/@26.1886258,-80.1304127,17z/data=!4m2!3m1!1s0x0000000000000000:0x0da6a02deb22bddf?hl=en" target="_blank">
										<address>1506 E. Commercial Blvd<br/>Oakland Park, FL, 33334</address>
									</a>
								</div>
								<div class="col-xs-12 col-md-4 center">
									<h3>HOURS</h3>
									<?php echo apply_filters( 'the_content',get_option('hours_of_operation')); ?>
								</div>
								<div class="col-xs-12 col-md-4 center">
									<h3>CONTACT</h3>
									<a href="tel:(754)-206-4116">(754)-206-4116</a>
									<a href="mailto:info@escargotbistro.com">info@escargotbistro.com</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</footer>
		<?php } ?>
		</div>
		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>
	</body>
</html>
