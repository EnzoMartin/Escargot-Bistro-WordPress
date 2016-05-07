<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
	<header class="article-header entry-header">
		<h1 class="entry-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>
	</header>
	<section class="entry-content cf sub" itemprop="articleBody">
		<?php
		the_content();

		$menuId = get_the_ID();
		$menuField = 'category_menu_' . $menuId;

		$itemsQuery = "
			SELECT p.post_title AS title,
				MAX(IF(m.meta_key='items_description',m.meta_value,0)) AS description,
				MAX(IF(m.meta_key='items_text_order',m.meta_value,0)) AS sorting,
				MAX(IF(m.meta_key='items_price',m.meta_value,0)) AS price,
				MAX(IF(m.meta_key='items_category',m.meta_value,0)) AS category,
				MAX(IF(m.meta_key='items_menu',m.meta_value,0)) AS menu,
				MAX(IF(m.meta_key='items_vegetarian',m.meta_value = 'on',0)) AS vegetarian,
				MAX(IF(m.meta_key='items_vegan',m.meta_value = 'on',0)) AS vegan,
				MAX(IF(m.meta_key='items_glutenfree',m.meta_value = 'on',0)) AS glutenfree,
				MAX(IF(m.meta_key='items_andrearecipe',m.meta_value = 'on',0)) AS andrearecipe,
				MAX(IF(m.meta_key='items_jacquerecipe',m.meta_value = 'on',0)) AS jacquerecipe,
				MAX(IF(m.meta_key='items_newitem',m.meta_value = 'on',0)) AS newitem
			FROM $wpdb->postmeta m
			INNER JOIN $wpdb->posts p ON m.post_id = p.id
			WHERE p.post_type = 'item'
				AND p.post_status = 'publish'
				AND p.post_date < NOW()
			GROUP BY m.post_id
			HAVING menu = $menuId
		";

		$categoriesQuery = "
			SELECT p.post_title AS title,
				p.ID AS id,
				p.post_content as content,
				MAX(IF(m.meta_key='category_text_order',m.meta_value,0)) AS sorting,
				MAX(IF(m.meta_key='$menuField',m.meta_value = 'on',0)) AS pinned
			FROM $wpdb->postmeta m
			INNER JOIN $wpdb->posts p ON m.post_id = p.id
			WHERE p.post_type = 'category'
				AND p.post_status = 'publish'
				AND p.post_date < NOW()
			GROUP BY m.post_id
		";

		$categories = $wpdb->get_results($categoriesQuery, OBJECT);
		$items = $wpdb->get_results($itemsQuery, OBJECT);

		$menu = array();
		
		foreach ($categories as $cat){
			$id = $cat->id;

			$cat_items = array_filter($items, function ($v) {
				global $id;
				return $v->category == $id;
			});

			if(count($cat_items) > 0 || $cat->pinned){
				usort($cat_items, function($a, $b) {
					return $a->sorting > $b->sorting;
				});

				$category = array(
					'id' => $cat->id,
					'title' => $cat->title,
					'content' => $cat->content,
					'sorting' => $cat->sorting,
					'items' => $cat_items
				);

				array_push($menu, $category);
			}
		}

		usort($menu, function($a, $b) {
			return $a->sorting > $b->sorting;
		});

		foreach ($menu as $category){
		?>
			<div class="menu-category">
				<h3><?= $category['title'] ?></h3>
				<div><?= $category['content'] ?></div>
				<?php
				$item_count = count($category['items']);
				if ($item_count > 0) {
				?>
				<div class="menu-items cf">
					<?php
					$i = 1;
					$item_count = $item_count / 2;
					foreach ($category['items'] as $item){
						$odd = $i % 2;
						$row_classes = array(
							'menu-row cf',
							$i === 1 ? 'first' : '',
							$i >= $item_count ? 'last' : ''
						);

						$item_classes = array(
							'menu-item m-all t-1of2 d-1of2',
							$item->vegetarian ? 'vegetarian' : '',
		                    $item->vegan ? 'vegan' : '',
		                    $item->glutenfree ? 'gluten' : '',
		                    $item->andrearecipe ? 'andrea' : '',
		                    $item->jacquerecipe ? 'jacque' : '',
		                    $item->newitem ? 'new' : ''
						);

						echo $odd ? '<div class="' . implode($row_classes, ' ') . '">' : '';
					?>
						<div class="<?= implode($item_classes, ' ') ?>">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tbody>
								<tr>
									<th class="name"><?= $item->title ?></th>
									<td class="price" rowspan="2">$<?= $item->price ?></td>
								</tr>
								<tr>
									<td class="description"><?= $item->description ?></td>
								</tr>
								</tbody>
							</table>
						</div>
					<?php
						echo !$odd ? '</div>' : '';
						$i++;
					}
					?>
				</div>
				<?php } ?>
			</div>
		<?php } ?>
	</section>
	<footer class="article-footer">

	</footer>
</article>
