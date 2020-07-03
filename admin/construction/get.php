<?php
//MEDIA UPLOADS
if (isset($_GET["media"])) {
    $gal_id    = $_GET["media"];
    $module_id = find_module('media')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        include(ADMIN_PATH . '/modules/media/pages/media_library.php');
    }
} //GALERIES
elseif (isset($_GET["galleries"])) {
    $module_id = find_module('media')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["galleries"])) {
            $instance_id = $_GET["galleries"];
            include(ADMIN_PATH . '/modules/media/pages/edit_gallery.php');
        } else {
            include(ADMIN_PATH . '/modules/media/pages/galleries.php');
        }
    }
} //VIDEO
elseif (isset($_GET["video"])) {
    $module_id = find_module('video')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["video"])) {
            $video_id = $_GET["video"];
            include(ADMIN_PATH . '/modules/video/pages/video.php');
        } else {
            include(ADMIN_PATH . '/modules/video/pages/video_list.php');
        }
    }
} //SLIDER (category)
elseif (isset($_GET["slides"])) {
    $module_id = find_module('slides')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["slides"])) {
            $slider_id = $_GET["slides"];
            include(ADMIN_PATH . '/modules/sliders/pages/slides_list.php');
        }
    }
} //SLIDE
elseif (isset($_GET["slide"]) && is_numeric($_GET["slide"])) {
    $module_id = find_module('slide')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        $slide_id = $_GET["slide"];
        include(ADMIN_PATH . '/modules/sliders/pages/slide.php');
    }
} //TESTIMONIAL (category)
elseif (isset($_GET["testimonial"])) {
    $module_id = find_module('testimonial')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["testimonial"])) {
            $testimonial_list_id = $_GET["testimonial"];
            include(ADMIN_PATH . '/modules/testimonials/pages/testimonial_list.php');
        }
    }
} //TESTIMONIAL
elseif (isset($_GET["testimonial_item"]) && is_numeric($_GET["testimonial_item"])) {
    $module_id = find_module('testimonial_item')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        $testimonial_id = $_GET["testimonial_item"];
        include(ADMIN_PATH . '/modules/testimonials/pages/testimonial.php');
    }
} //SITE SETUP
elseif (isset($_GET["site_setup"])) {
    $get_var     = 'site_setup';
    $module_slug = 'site_setup';
    $module_id   = find_module($get_var)['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        include(ADMIN_PATH . '/modules/' . $module_slug . '/pages/' . $module_slug . '.php');
    }
} //EVOLVE SOCIAL
elseif (isset($_GET["sprofile"])) {
    $get_var   = 'sprofile';
    $module_id = find_module($get_var)['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["sprofile"])) {
            $instance_id = $_GET["sprofile"];
            include(ADMIN_PATH . '/modules/evolve_social/pages/profile.php');
        }
    }
} //DIMENSIONS
elseif (isset($_GET["dimensions"])) {
    $module_id = find_module('dimensions')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["dimensions"])) {
            $dim_id = $_GET["dimensions"];
            include(ADMIN_PATH . '/modules/dimensions/pages/dimensions.php');
        } else {
            include(ADMIN_PATH . '/modules/dimensions/pages/dimensions_list.php');
        }
    }
} //ADS
elseif (isset($_GET["ads"])) {
    $module_id = find_module('ads')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["ads"])) {
            $instance_id = $_GET["ads"];
            include(ADMIN_PATH . '/modules/ads/pages/ads.php');
        } else {
            include(ADMIN_PATH . '/modules/ads/pages/ads_list.php');
        }
    }
} //USERS
elseif (isset($_GET["users"])) {
    $module_id = find_module('users')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["users"])) {
            $usr_id = $_GET["users"];
            include(ADMIN_PATH . '/modules/users/pages/users.php');
        } else {
            include(ADMIN_PATH . '/modules/users/pages/users_list.php');
        }
    }
} elseif (isset($_GET["user_groups"])) {
    $module_id = find_module('user_groups')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["user_groups"])) {
            $instance_id = $_GET["user_groups"];
            include(ADMIN_PATH . '/modules/user_groups/pages/user_groups.php');
        } else {
            include(ADMIN_PATH . '/modules/user_groups/pages/user_groups_list.php');
        }
    }
} //LANGUAGES
elseif (isset($_GET["languages"])) {
    $module_id = find_module('languages')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        include(ADMIN_PATH . 'modules/languages/pages/languages_strings.php');
    }
} //MENU
elseif (isset($_GET["menu"])) {
    $module_id = find_module('menu')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        include(ADMIN_PATH . 'modules/menu/pages/menu.php');
    }
}
/*  SHOP  */

//PRODUCT CATEGORY
elseif (isset($_GET["product_category"])) {
    $module_id = find_module('product_category')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["product_category"])) {
            $instance_id = $_GET["product_category"];
            include(ADMIN_PATH . '/modules/shop/pages/product_category.php');
        } else {
            include(ADMIN_PATH . '/modules/shop/pages/product_category_list.php');
        }
    }
} //PRODUCT
elseif (isset($_GET["product"])) {
    $module_id = find_module('product')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["product"])) {
            $instance_id = $_GET["product"];
            include(ADMIN_PATH . '/modules/shop/pages/product.php');
        }
    }
} //PRODUCT LIST
elseif (isset($_GET["product_list"]) && is_numeric($_GET["product_list"])) {
    $module_id = find_module('product_list')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        $instance_id = $_GET["product_list"];
        include(ADMIN_PATH . '/modules/shop/pages/product_list.php');
    }
}
/*  /SHOP  */

/*  TOP TEN  */
//TOP TEN CATEGORY
elseif (isset($_GET["topten_category"])) {
    $module_id = find_module('topten_category')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["topten_category"])) {
            $instance_id = $_GET["topten_category"];
            include(ADMIN_PATH . '/modules/topten/pages/topten_category.php');
        } else {
            include(ADMIN_PATH . '/modules/topten/pages/topten_category_list.php');
        }
    }
} //TOP TEN ITEM
elseif (isset($_GET["topten_item"])) {
    $module_id = find_module('topten_item')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["topten_item"])) {
            $instance_id = $_GET["topten_item"];
            include(ADMIN_PATH . '/modules/topten/pages/topten_item.php');
        }
    }
} //TOP TEN LIST
elseif (isset($_GET["topten_item_list"]) && is_numeric($_GET["topten_item_list"])) {
    $module_id = find_module('topten_item_list')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        $instance_id = $_GET["topten_item_list"];
        include(ADMIN_PATH . '/modules/topten/pages/topten_item_list.php');
    }
}
/*  /TOP TEN  */

/*  ESTATE  */
elseif (isset($_GET["estate"])) {
    $module_id = find_module('estate')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["estate"])) {
            $instance_id = $_GET["estate"];
            include(ADMIN_PATH . '/modules/estate/pages/estate.php');
        } else {
            include(ADMIN_PATH . '/modules/estate/pages/estate_list.php');
        }
    }
} //ROOM
elseif (isset($_GET["cd_cody_licence_edit"])) {
    $module_id = find_module('cd_cody_licence_edit')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["cd_cody_licence_edit"])) {
            $instance_id = $_GET["cd_cody_licence_edit"];
            include(ADMIN_PATH . '/modules/estate/pages/cd_cody_licence_edit.php');
        }
    }
} //cd_cody_licence_edit LIST
elseif (isset($_GET["cd_cody_licence_list"]) && is_numeric($_GET["cd_cody_licence_list"])) {
    $module_id = find_module('cd_cody_licence_list')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        $instance_id = $_GET["cd_cody_licence_list"];
        include(ADMIN_PATH . '/modules/estate/pages/cd_cody_licence_list.php');
    }
}
/*  /ESTATE  */

/*  ARTICLES  */
//ARTICLE CATEGORIES
elseif (isset($_GET["article_rubrics"])) {
    $module_id = find_module('article_rubrics')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["article_rubrics"])) {
            $instance_id = $_GET["article_rubrics"];
            include(ADMIN_PATH . '/modules/articles/pages/rubric.php');
        } else {
            include(ADMIN_PATH . '/modules/articles/pages/rubrics_list.php');
        }
    }
} //ARTICLE
elseif (isset($_GET["article"])) {
    $module_id = find_module('article')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["article"])) {
            $instance_id = $_GET["article"];
            include(ADMIN_PATH . '/modules/articles/pages/article.php');
        }
    }
} //ARTICLE LIST
elseif (isset($_GET["article_list"]) && is_numeric($_GET["article_list"])) {
    $module_id = find_module('article_list')['id'];
    if (evolveAllow($data_user_id, $module_id)) {
        $instance_id = $_GET["article_list"];
        include(ADMIN_PATH . '/modules/articles/pages/article_list.php');
    }
}
/*  /ARTICLES  */

//WEBCAM CATEGORIES
elseif (isset($_GET["webcam_cat"])) {
    $module_id = module_enabled('webcams');
    if (evolveAllow($data_user_id, $module_id)) {
        if (is_numeric($_GET["webcam_cat"])) {
            $wcat = $_GET["webcam_cat"];
            include(ADMIN_PATH . '/modules/webcams/pages/webcam_cat.php');
        } else {
            include(ADMIN_PATH . '/modules/webcams/pages/webcam_cat_list.php');
        }
    }
} //WEBCAMS
elseif (isset($_GET["webcam"])) {
    $module_id = module_enabled('webcams');
    if (evolveAllow($data_user_id, $module_id)) {
        include(ADMIN_PATH . '/modules/webcams/functions/functions.php');

        if (is_numeric($_GET["webcam"])) {
            $webcam_id = $_GET["webcam"];
            include(ADMIN_PATH . '/modules/webcams/pages/webcam.php');
        } else {
            include(ADMIN_PATH . '/modules/webcams/pages/webcams_list.php');
        }
    }
}
elseif (isset($_GET["profile"])) {
    include(ADMIN_PATH . '/system/profile/pages/profile.php');
}
elseif (isset($_GET["test"])) {
    include(ADMIN_PATH . '/pages/test.php');
}
else {
    include(ADMIN_PATH . '/pages/home.php');
}
?>
