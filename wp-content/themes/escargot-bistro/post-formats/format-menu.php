<?php
$menuId = $post->ID;
$menuField = 'category_menu_' . $menuId;
$menu_meta = get_post_meta($post->ID);
$image_url = get_template_directory_uri();

$itemsQuery = "
    SELECT p.post_title AS title,
        MAX(IF(m.meta_key='items_description',m.meta_value,'')) AS description,
        MAX(IF(m.meta_key='items_text_order',m.meta_value,0)) AS sorting,
        MAX(IF(m.meta_key='items_price',m.meta_value,0)) AS price,
        MAX(IF(m.meta_key='items_is_wine',m.meta_value,0)) AS is_wine,
        MAX(IF(m.meta_key='items_bottle_price',m.meta_value,0)) AS bottle_price,
        MAX(IF(m.meta_key='items_glass_price',m.meta_value,0)) AS glass_price,
        MAX(IF(m.meta_key='items_category',m.meta_value,0)) AS category,
        MAX(IF(m.meta_key='items_menu',m.meta_value,0)) AS menu,
        MAX(IF(m.meta_key='items_vegetarian',m.meta_value = 'on',0)) AS vegetarian,
        MAX(IF(m.meta_key='items_vegan',m.meta_value = 'on',0)) AS vegan,
        MAX(IF(m.meta_key='items_glutenfree',m.meta_value = 'on',0)) AS glutenfree,
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
        MAX(IF(m.meta_key='category_text_order_$menuId',m.meta_value,0)) AS sorting,
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

$vegan = false;
$new = false;
$gluten = false;
$vegetarian = false;

foreach ($items as $item){
    if($item->vegetarian){
        $vegetarian = true;
        $item->vegetarian = '<div class="food-icon-container"><span class="food-icon vegetarian"><img title="Vegetarian" alt="Vegetarian" src="'. $image_url . '/library/images/food-icons/vegetarian.png"/></span></div>';
    } else {
        $item->vegetarian = '';
    }

    if($item->vegan){
        $vegan = true;
        $item->vegan = '<div class="food-icon-container"><span class="food-icon vegan"><img title="Vegan" alt="Vegan" src="'. $image_url . '/library/images/food-icons/vegan.png"/></span></div>';
    } else {
        $item->vegan = '';
    }

    if($item->glutenfree){
        $gluten = true;
        $item->glutenfree = '<div class="food-icon-container"><span class="food-icon gluten"><img title="Gluten free" alt="Gluten free" src="'. $image_url . '/library/images/food-icons/gluten.png"/></span></div>';
    } else {
        $item->glutenfree = '';
    }

    if($item->newitem){
        $new = true;
        $item->newitem = '<div class="food-icon-container"><span class="food-icon new"><img title="New item" alt="New item" src="'. $image_url . '/library/images/food-icons/new.png"/></span></div>';
    } else {
        $item->newitem = '';
    }
}

$menu = array();

foreach ($categories as $cat){
    $id = $cat->id;

    $menu_items = array_filter($items, function ($v) {
        global $id;
        return $v->category == $id;
    });

    if(count($menu_items) > 0 || $cat->pinned){
        usort($menu_items, function($a, $b) {
            return $a->sorting > $b->sorting;
        });

        $cat_items = array_filter($menu_items, function ($v) {
            return !$v->is_wine;
        });

        $cat_wines = array_filter($menu_items, function ($v) {
            return $v->is_wine;
        });

        $category = array(
            'id' => $cat->id,
            'title' => $cat->title,
            'content' => $cat->content,
            'sorting' => intval($cat->sorting),
            'items' => $cat_items,
            'wines' => $cat_wines
        );

        array_push($menu, $category);
    }
}
?>

<article id="post-<?php $menuId; ?>" <?php post_class( 'cf' ); ?>>
    <header class="article-header entry-header">
        <table cellspacing="0" cellpadding="0" border="0">
            <tbody>
            <tr>
                <td><h1 class="entry-title single-title" rel="bookmark"><?php the_title(); ?></h1></td>
                <td class="subtitle"><h2 class="entry-title single-title"><?= $menu_meta['menus_hours'][0] ?></h2></td>
            </tr>
            </tbody>
        </table>
    </header>
    <section class="entry-content cf sub">
        <?php get_template_part('social'); ?>
        <div class="row">
            <div class="col-xs-12 food-icons center">
                <?php if($vegan){?>
                <div class="food-icon-container">
                    <span class="food-icon vegan"><img src="<?= $image_url ?>/library/images/food-icons/vegan.png"/></span><span>Vegan</span>
                </div>
                <?php } ?>
                <?php if($vegetarian){?>
                <div class="food-icon-container">
                    <span class="food-icon vegetarian"><img src="<?= $image_url ?>/library/images/food-icons/vegetarian.png"/></span><span>Vegetarian</span>
                </div>
                <?php } ?>
                <?php if($gluten){?>
                <div class="food-icon-container">
                    <span class="food-icon gluten"><img src="<?= $image_url ?>/library/images/food-icons/gluten.png"/></span><span>Gluten free</span>
                </div>
                <?php } ?>
                <?php if($new){?>
                <div class="food-icon-container">
                    <span class="food-icon new"><img src="<?= $image_url ?>/library/images/food-icons/new.png"/></span><span>Newly added</span>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php
        usort($menu, function($a, $b) {
            if($a['sorting'] == $b['sorting']){ return 0 ; }
            return ($a['sorting'] < $b['sorting']) ? -1 : 1;
        });

        the_content();

        foreach ($menu as $category){
        ?>
            <div class="menu-category">
                <h3 class="menu-category-title"><span><?= $category['title'] ?></span></h3>
                <div class="menu-category-content"><?= $category['content'] ?></div>
                <div class="menu-items cf">
                <?php
                $item_count = count($category['wines']);
                if ($item_count > 0) {
                    $i = 1;
                    foreach ($category['wines'] as $item){
                        $row_classes = array(
                            'menu-row wine-row row cf',
                            $i === 1 ? 'first' : '',
                            $i >= $item_count ? 'last' : ''
                        );

                        $item_classes = array(
                            'menu-item col-xs-12',
                            $item->newitem ? 'new' : ''
                        );

                        ?>
                        <div class="<?= implode( $row_classes, ' ' ) ?>">
                            <div class="<?= implode( $item_classes, ' ' ) ?>">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tbody>
                                    <tr>
                                        <th class="name"><h4><?= $item->title ?></h4></th>
                                        <td class="price glass"><?= $item->glass_price > 0 ? ('$' . $item->glass_price . '<small>glass</small>') : '-'; ?></td>
                                        <td class="price bottle"><?= $item->bottle_price > 0 ? ('$' . $item->bottle_price . '<small>bottle</small>') : '-'; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                }

                $item_count = count($category['items']);
                if ($item_count > 0) {
                    $i = 1;
                    $row = 0;
                    $row_count = round($item_count / 2);
                    foreach ($category['items'] as $item){
                        $odd = $i % 2;
                        if($odd){
                            $row++;
                        }

                        $row_classes = array(
                            'menu-row row cf',
                            $row === 1 ? 'first' : '',
                            $row >= $row_count ? 'last' : ''
                        );

                        $icons = array(
                            $item->vegetarian,
                            $item->vegan,
                            $item->glutenfree,
                            $item->newitem
                        );

                        $item_classes = array(
                            'menu-item col-xs-12 col-sm-6',
                        );

                        echo $odd ? '<div class="' . implode($row_classes, ' ') . '">' : '';
                    ?>
                        <div class="<?= implode($item_classes, ' ') ?>">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tbody>
                                <tr>
                                    <th class="name"><h4><?= $item->title ?> <?= implode($icons, ' ') ?></h4></th>
                                    <td class="price" rowspan="2"><?= is_numeric($item->price) ? '$' : '' ?><?= $item->price ?></td>
                                </tr>
                                <tr>
                                    <td class="description"><?= $item->description ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php
                        echo !$odd || ($row == $row_count && $i == $item_count) ? '</div>' : '';
                        $i++;
                    }
                    ?>
                <?php } ?>
                </div>
            </div>
        <?php }
        $content = $menu_meta['menus_fixed_price'][0];
        if ($content) { ?>
            <div class="menu-content menu-category"><?= urldecode(apply_filters( 'the_content', $content )) ?></div>
        <?php }
        if($menu_meta['menus_season'][0]){ ?>
            <div class="menu-season menu-category"><em><?= $menu_meta['menus_season'][0] ?></em></div>
        <?php } ?>
        <div class="menu-disclaimer menu-category">
            <div class="row">
                <div class="col-xs-12 center"><strong>Any allergy? Let us know!</strong> &mdash; Tax &amp; Gratuities are not included</div>
            </div>
            <div class="row">
                <div class="col-xs-12 center">Eating raw or undercooked fish, seafood, eggs or meat increases the risk of food illnesses</div>
            </div>
            <div class="row">
                <div class="col-xs-12 center">A 20% service charge will automatically be added to parties of 5 or more people</div>
            </div>
            <div class="row">
                <div class="col-xs-12 center"><strong>For any split order: $6.00 extra</strong></div>
            </div>
        </div>
    </section>
</article>
