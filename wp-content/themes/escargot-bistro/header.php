<!doctype html>
<?php
$useragent = $_SERVER['HTTP_USER_AGENT'];
$GLOBALS['is_mobile'] = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));
$mobile = $GLOBALS['is_mobile'] ? 'use-mobile' : 'use-desktop';
?>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php wp_title('|',true,'right'); ?></title>
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui"/>
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="description" content="<?= bloginfo('description') ?>" />
        <meta name="keywords" content="bistro,french,fort lauderdale,oakland park,french cuisine,french bistro,french restaurant,escargot,lunch,dinner,takeout,pickup" />
        <link rel="apple-touch-icon" type="image/png" href="<?= get_template_directory_uri(); ?>/library/images/apple-touch-icon.png?v=1">
        <link rel="icon" type="image/png" href="<?= get_template_directory_uri(); ?>/favicon.ico?v=1">
        <!--[if IE]>
            <link rel="shortcut icon" href="<?= get_template_directory_uri(); ?>/favicon.ico?v=1">
        <![endif]-->
        <meta name="msapplication-TileColor" content="#f01d4f">
        <meta name="msapplication-TileImage" content="<?= get_template_directory_uri(); ?>/library/images/win8-tile-icon.png?v=1">
        <meta name="theme-color" content="#00897b">
        <link rel="alternate" href="https://www.escargotbistro.com<?= $_SERVER['REQUEST_URI'] ?>" hreflang="en-us" />
        <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "WebSite",
          "name": "Escargot Bistro",
          "url": "https://www.escargotbistro.com/"
        }
        </script>

        <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "Organization",
          "url": "https://www.escargotbistro.com/",
          "logo": "https://www.escargotbistro.com/wp-content/themes/escargot-bistro/library/images/logo_img.png",
          "sameAs":[
            "https://plus.google.com/+EscargotbistroFlorida/",
            "https://www.facebook.com/EscargotBistroFL",
            "https://www.yelp.com/biz/escargot-bistro-oakland-park",
            "https://www.tripadvisor.com/Restaurant_Review-g34495-d8848376-Reviews-Escargot_Bistro-Oakland_Park_Florida.html"
          ],
          "contactPoint": [{
            "@type": "ContactPoint",
            "telephone": "+17542064116",
            "contactType": "reservations",
            "areaServed":"US",
            "availableLanguage": ["French","English"]
          }]
        }
        </script>

        <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@id":"https://www.escargotbistro.com/",
          "@type": "Restaurant",
          "acceptsReservations": "True",
          "logo":"https://www.escargotbistro.com/wp-content/themes/escargot-bistro/library/images/logo_img.png",
          "description":"<?= bloginfo('description') ?>",
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "Oakland Park",
            "addressRegion": "FL",
            "postalCode": "33334",
            "addressCountry": "US",
            "streetAddress": "1506 East Commercial Blvd"
          },
          "geo": {
            "@type": "GeoCoordinates",
            "latitude": 26.1886258,
            "longitude": -80.1304127
          },
          "image":"https://www.escargotbistro.com/wp-content/uploads/2016/05/Interior2.jpg",
          "menu": "https://www.escargotbistro.com/menu/dinner-menu/",
          "smokingAllowed": "False",
          "currenciesAccepted": "USD",
          "email":"contact@parisbakerycafe.com",
          "paymentAccepted": "Cash, credit card, debit card, gift card",
          "name": "Escargot Bistro",
          "openingHours": [
            "Tu-Sa 11:45-16:30",
            "Tu-Sa 16:30-21:00"
          ],
          "openingHoursSpecification": [
            {
              "@type": "OpeningHoursSpecification",
              "dayOfWeek": [
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday"
              ],
              "opens": "11:45",
              "closes": "16:30"
            },
            {
              "@type": "OpeningHoursSpecification",
              "dayOfWeek": [
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday"
              ],
              "opens": "16:30",
              "closes": "21:00"
            }
          ],
          "priceRange": "$$",
          "servesCuisine": [
            "French",
            "Bistro",
            "Mediterranean"
          ],
          "telephone": "+17542064116",
          "url": "https://www.escargotbistro.com",
          "sameAs":[
            "https://plus.google.com/+EscargotbistroFlorida/",
            "https://www.facebook.com/EscargotBistroFL",
            "https://www.yelp.com/biz/escargot-bistro-oakland-park",
            "https://www.tripadvisor.com/Restaurant_Review-g34495-d8848376-Reviews-Escargot_Bistro-Oakland_Park_Florida.html"
          ],
          "potentialAction": {
            "@type": "ViewAction",
            "target": [
              {
                "@type": "EntryPoint",
                "url":"https://www.yelp.com/biz/escargot-bistro-oakland-park",
                "description":"Yelp",
                "contentType": "text/html"
              },
              {
                "@type": "EntryPoint",
                "url":"https://www.facebook.com/EscargotBistroFL",
                "description":"Facebook",
                "contentType": "text/html"
              },
              {
                "@type": "EntryPoint",
                "url":"https://plus.google.com/+EscargotbistroFlorida/about",
                "description":"Google+",
                "contentType": "text/html"
              },
              {
                "@type": "EntryPoint",
                "url":"https://www.tripadvisor.com/Restaurant_Review-g34495-d8848376-Reviews-Escargot_Bistro-Oakland_Park_Florida.html",
                "description":"TripAdvisor",
                "contentType": "text/html"
              }
            ]
          }
        }
        </script>
        <?php wp_head(); ?>
        <script type="text/javascript" defer="defer" src="https://www.google-analytics.com/analytics.js"></script>
        <script type="text/javascript" defer="defer" src="<?= get_template_directory_uri(); ?>/library/google.js"></script>
    </head>
    <body <?php body_class($mobile); ?>>
        <?php if ($GLOBALS['is_mobile']) { ?>
            <input type="checkbox" id="nav-trigger" name="nav-trigger" class="nav-trigger hidden-print" title="Open Navigation"/>
            <label id="nav-trigger-label" for="nav-trigger" class="hidden-print">
                <img
                    src="<?= get_template_directory_uri(); ?>/library/images/1x/menu_white_24dp.png"
                    srcset="<?= get_template_directory_uri(); ?>/library/images/2x/menu_white_24dp.png 2x"
                    alt="" aria-hidden="true">
            </label>
            <div id="mobile-nav-menu-container" class="hidden-print">
                <div id="mobile-nav-menu">
                    <?php wp_nav_menu(array(
                        'container' => false,
                        'container_class' => 'menu cf',
                        'menu' => __( 'Menu Left', 'bonestheme' ),
                        'menu_class' => 'nav top-nav cf',
                        'theme_location' => 'main-nav-left',
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'depth' => 0,
                        'fallback_cb' => ''
                    )); ?>
                    <?php wp_nav_menu(array(
                        'container' => false,
                        'container_class' => 'menu cf',
                        'menu' => __( 'Menu Right', 'bonestheme' ),
                        'menu_class' => 'nav top-nav cf',
                        'theme_location' => 'main-nav-right',
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'depth' => 0,
                        'fallback_cb' => ''
                    )); ?>
                </div>
            </div>
        <?php } ?>
        <div id="container">
            <?php
            if(get_option('notice_active', false)){
                $notice = get_option( 'notice_message', '' );
                if($notice){
                    ?><div id="notice"><?= $notice ?></div><?php
                }
            }
            ?>
            <header class="header container" role="banner">
                <div id="inner-header" class="row">
                    <nav role="navigation" class="col-xs-12">
                        <?php if ($GLOBALS['is_mobile']) { ?>
                            <table id="mobile-nav" cellpadding="0" cellspacing="0" border="0">
                                <tbody>
                                <tr>
                                    <td id="nav-trigger-td"></td>
                                    <td>
                                        <div id="logo" class="h1">
                                            <a href="<?= home_url(); ?>" rel="nofollow">
                                                Escargot Bistro
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        <?php } else { ?>
                        <table id="nav" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                            <tr>
                                <td id="nav-left">
                                    <?php wp_nav_menu(array(
                                             'container' => false,                           // remove nav container
                                             'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                                             'menu' => __( 'Menu Left', 'bonestheme' ),  // nav name
                                             'menu_class' => 'nav top-nav cf',               // adding custom nav class
                                             'theme_location' => 'main-nav-left',                 // where it's located in the theme
                                             'before' => '',                                 // before the menu
                                               'after' => '',                                  // after the menu
                                               'link_before' => '',                            // before each link
                                               'link_after' => '',                             // after each link
                                               'depth' => 0,                                   // limit the depth of the nav
                                             'fallback_cb' => ''                             // fallback function (if there is one)
                                    )); ?>
                                </td>
                                <td id="nav-center">
                                    <div id="logo" class="h1">
                                        <a href="<?= home_url(); ?>" rel="nofollow">
                                            <img src="<?= get_template_directory_uri(); ?>/library/images/logo-o-s.png"/>
                                        </a>
                                    </div>
                                </td>
                                <td id="nav-right">
                                    <?php wp_nav_menu(array(
                                             'container' => false,                           // remove nav container
                                             'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                                             'menu' => __( 'Menu Right', 'bonestheme' ),  // nav name
                                             'menu_class' => 'nav top-nav cf',               // adding custom nav class
                                             'theme_location' => 'main-nav-right',                 // where it's located in the theme
                                             'before' => '',                                 // before the menu
                                               'after' => '',                                  // after the menu
                                               'link_before' => '',                            // before each link
                                               'link_after' => '',                             // after each link
                                               'depth' => 0,                                   // limit the depth of the nav
                                             'fallback_cb' => ''                             // fallback function (if there is one)
                                    )); ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <?php } ?>
                    </nav>
                </div>
            </header>
            <div id="print-logo-container" class="container">
                <div class="row">
                    <div class="col-xs-12 center">
                        <img id="print-logo" src="<?= get_template_directory_uri(); ?>/library/images/logo-o-s.png"/>
                        <span><strong>(754)-206-4116</strong></span>
                        <span> - 1506 E. Commercial Blvd, Oakland Park, FL, 33334 - </span>
                        <span><em>escargotbistro.com</em></span>
                    </div>
                </div>
            </div>
