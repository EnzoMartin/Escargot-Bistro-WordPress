		<?php if(!is_home() && !is_front_page()){ ?>
			<footer class="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
				<div id="inner-footer" class="wrap cf">
					<table cellpadding="0" cellspacing="0" border="0">
						<thead>
						<tr>
							<th><h3>ADDRESS</h3></th>
							<th><h3>HOURS</h3></th>
							<th><h3>CONTACT</h3></th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								<a href="https://www.google.com/maps/place/Escargot+Bistro/@26.1886258,-80.1304127,17z/data=!4m2!3m1!1s0x0000000000000000:0x0da6a02deb22bddf?hl=en" target="_blank">
									<address>1506 E. Commercial Blvd<br/>Oakland Park, FL, 33334</address>
								</a>
							</td>
							<td><?php the_field('opening_hours'); ?></td>
							<td>
								<a href="tel:(754)-206-4116">(754)-206-4116</a>
								<a href="mailto:info@escargotbistro.com">info@escargotbistro.com</a>
							</td>
						</tr>
						<tr>
							<td colspan="3"><p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p></td>
						</tr>
						</tbody>
					</table>
				</div>
			</footer>
		<?php } ?>
		</div>
		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>
	</body>
</html> <!-- end of site. what a ride! -->
