<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home/main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// CONTROL ROUTES

# --- Sign-in page ----------------------------
$route['control/sign_in']['get'] = 'home/auth/control_signin_page';

# --- Payments --------------------------------
$route['control/payments/?'] = 'control/payments/index';
$route['control/payments/(orderby\/((created_at|paid)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/payments/index/$1';


# --- Dashboard --------------------------------
$route['control(/dashboard)?'] = 'control/dashboard';
$route['control/dashboard/refresh_items_count']['post'] = 'control/dashboard/refresh_items_count';
$route['control/dashboard/refresh_traffic_data']['post'] = 'control/dashboard/refresh_traffic_data';
$route['control/dashboard/traffic_by_month']['post'] = 'control/dashboard/traffic_by_month';
$route['control/dashboard/popular_posts']['post'] = 'control/dashboard/popular_posts';
$route['control/dashboard/recent_users_subscribers']['post'] = 'control/dashboard/recent_users_subscribers';

# --- Post(s) --------------------------------

$route['control/posts/(orderby\/((title|views|recommended|created_at|visible|pinned)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/posts/index/$1';
$route['control/posts/(id\/(\d+)\/category\/([\w_-]+)(\/page\/\d+)?)/?']['get'] = 'control/posts/get_by_category/$1';
$route['control/posts/(search\/(:any)(\/page\/\d+)?)/?']['get'] = 'control/posts/search/$1';
$route['control/posts/add'] = 'control/posts/add';
$route['control/posts/update_visibility']['post'] = 'control/posts/update_visibility';
$route['control/posts/update_pin_status']['post'] = 'control/posts/update_pin';
$route['control/posts/update_recommendation']['post'] = 'control/posts/update_recommendation';
$route['control/posts/edit/(:num)'] = 'control/posts/update/$1';
$route['control/posts/delete/(\[[\d,]+\])']['get'] = 'control/posts/delete/$1';


# --- Pages -----------------------------------

$route['control/pages/(orderby\/((title|views|created_at|visible)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/pages/index/$1';
$route['control/pages/(id\/(\d+)\/author\/([\w_-]+)(\/page\/\d+)?)/?']['get'] = 'control/pages/get_by_author/$1';
$route['control/pages/(search\/(:any)(\/page\/\d+)?)/?']['get'] = 'control/pages/search/$1';
$route['control/pages/add'] = 'control/pages/add';
$route['control/pages/update_visibility'] = 'control/pages/update_visibility';
$route['control/pages/edit/(:num)'] = 'control/pages/update/$1';
$route['control/pages/delete/(\[[\d,]+\])']['get'] = 'control/pages/delete/$1';


# --- Compaigns -----------------------------------
$route['control/compaigns/(orderby\/((id|views|active)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/compaigns/index/$1';
$route['control/compaigns/update'] = 'control/compaigns/update';


# --- Categories | Subcategories --------------

$route['control/(categories|subcategories)']['get'] = 'control/$1/index';
$route['control/(categories|subcategories)/delete/(\[[\d,]+\])']['get'] = 'control/$1/delete/$2';
$route['control/(categories|subcategories)/(add|update)']['post'] = 'control/$c1/$2';
$route['control/(categories|subcategories)/update_visibility']['post'] = 'control/$1/update_visibility';
$route['control/subcategories/(orderby\/((name|created_at|order|parent_id|visible)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/subcategories/index/$1';
$route['control/categories/(orderby\/((name|created_at|order|visible)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/categories/index/$1';


# --- Users -----------------------------------

$route['control/users/(administrators|moderators|authors|members)']['get'] = 'control/users/index/$1';
$route['control/users/(administrators)/(orderby\/((name|email|posts_count|country|created_at)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/users/index/$1/$2';
$route['control/users/(members)/(orderby\/((name|email|posts_count|country|created_at|active|blocked)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/users/index/$1/$2';
$route['control/users/(authors|moderators)/(orderby\/((name|email|posts_count|country|created_at|blocked)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/users/index/$1/$2';
$route['control/users/add'] = 'control/users/add';
$route['control/users/edit/(:num)'] = 'control/users/update/$1';
$route['control/users/update_active/(:num)/active/(0|1)']['post'] = 'control/users/update_active/$1/$2';
$route['control/users/update_blocked/(:num)/blocked/(0|1)']['post'] = 'control/users/update_blocked/$1/$2';
$route['control/users/update_role/(:num)/(administrator|moderator|author|member)']['post'] = 'control/users/update_role/$1/$2';
$route['control/users/delete/(\[[\d,]+\])/(administrators|moderators|authors|members)']['get'] = 'control/users/delete/$1/$2';

# --- Comments -------------------------------

$route['control/comments/(orderby\/((post_title|user_name|user_email|created_at|visible)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/comments/index/$1';
$route['control/comments/update_visibility'] = 'control/comments/update_visibility';
$route['control/comments/delete/(\[[\d,]+\])']['get'] = 'control/comments/delete/$1';

# --- Profile --------------------------------

$route['control/profile']['get'] 		 = 'control/profile/index';
$route['control/profile/update']['post'] = 'control/profile/update';


# --- Trash -------------------------------

$route['control/trash/(posts|pages|users|categories|subcategories|comments)/?'] = 'control/trash/$1';

$route['control/trash/(posts|pages)/(orderby\/((title|created_at|deleted_at)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/trash/$1/$2';

$route['control/trash/(posts|pages)/(search\/(:any)(\/page\/\d+)?)/?']['get'] = 'control/trash/$1/$2';

$route['control/trash/posts/(id\/(\d+)\/category\/([\w_-]+)(\/page\/\d+)?)/?']['get'] = 'control/trash/posts/$1';

$route['control/trash/users/(orderby\/((name|email|created_at|deleted_at)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/trash/users/$1';

$route['control/trash/(categories|subcategories)/(orderby\/((name|created_at|deleted_at)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/trash/$1/$2';

$route['control/trash/comments/(orderby\/((post_title|user_name|user_email|created_at|deleted_at)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/trash/comments/$1';


# --- Newsletter -------------------------------
$route['control/newsletter/subscribers/?']['get'] = 'control/subscribers/index';
$route['control/newsletter/subscribers/(orderby\/((email|country|created_at|visible)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'control/subscribers/index';
$route['control/newsletter/send'] = 'control/subscribers/add';


# --- Settings ---------------------------------
$route['control/settings/(general|search_engines|advertisement|email|permissions|points_and_withdrawals)']['get'] = 'control/settings/index/$1';
$route['control/settings/update/(search_engines|advertisement|email|permissions|points_and_withdrawals)']['post'] = 'control/settings/update/$1';
$route['control/settings/update/general']['post'] = 'control/settings/update_general';



# --- Ads --------------------------------------
$route['control/ads']['get'] = 'control/ads/index';
$route['control/ads/update']['post'] = 'control/ads/update';



# --- Sitemaps -------------------------------
$route['control/sitemaps/?']['get'] = 'control/sitemaps/index';
$route['control/sitemaps/generate/?']['post'] = 'control/sitemaps/generate';
$route['control/sitemaps/(posts|pages|categories|subcategories)-sitemap\.xml/(download|read)']['get'] = 'control/sitemaps/$2/$1';


# --- Global routes --------------------------

$route['control/(dashboard|posts|pages|[sub]?categories|comments|compaigns)'] = 'control/$1/index';



# HOME CONTROllERS ---------------------------------
$route['post/([\w-]+)']['get'] = 'home/main/post/$1';
$route['post/([\w-]+)/comment']['post'] = 'home/comments/add';
$route['posts/(category\/([\w_-]+)(\/page\/\d+)?)/?']['get'] = 'home/main/get_posts_by_category/$1';
$route['posts/(subcategory\/([\w_-]+)(\/page\/\d+)?)/?']['get'] = 'home/main/get_posts_by_subcategory/$1';
$route['posts/(year\/(:num)(\/page\/\d+)?)/?']['get'] = 'home/main/get_posts_by_year/$1';
$route['posts/search/?']['post'] = 'home/main/search';
$route['posts/(search\/(:any)(\/page\/\d+)?)/?']['get'] = 'home/main/get_posts_by_keywords/$1';
$route['post/update_rating']['post'] = 'home/main/update_rating';

$route['posts/(author\/([\w_-]+)(\/page\/\d+)?)/?']['get'] = 'home/main/get_posts_by_author/$1';

$route['(page|user)/([\w-]+)']['get'] = 'home/main/$1/$2';

$route['user/(\d+)/posts']['post'] = 'home/main/get_posts_by_author_ajax';
$route['user/(\d+)/comments']['post'] = 'home/main/get_comments_by_author_ajax';


$route['author/dashboard']['get'] = 'home/author/index';
$route['author/posts'] = 'home/author/posts';
$route['author/posts/(orderby\/((title|views|created_at|visible|rating)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'home/author/posts/$1';
$route['author/posts/(id\/(\d+)\/category\/([\w_-]+)(\/page\/\d+)?)/?']['get'] = 'home/author/posts_by_category/$1';
$route['author/posts/(search\/(:any)(\/page\/\d+)?)/?']['get'] = 'home/author/search_posts/$1';
$route['author/posts/create']['get'] = 'home/author/create_post';
$route['author/posts/store']['post'] = 'home/author/store_post';
$route['author/posts/update_visibility']['post'] = 'home/author/update_post_visibility';
$route['author/posts/edit/(:num)']['get'] = 'home/author/edit_post/$1';
$route['author/posts/update/(\d+)']['post'] = 'home/author/update_post/$1';
$route['author/posts/delete/([\d,]+)']['get'] = 'home/author/delete_posts/$1';
$route['author/add_subcategory/?']['post'] = 'home/author/add_subcategory';
$route['author/add_category/?']['post'] = 'home/author/add_category';

$route['author/posts/trash/?'] = 'home/author/trash';
$route['author/posts/trash/(orderby\/((title|views|created_at|visible|rating)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'home/author/trash/$1';
$route['author/posts/trash/(search\/(:any)(\/page\/\d+)?)/?']['get'] = 'home/author/search_trash/$1';
$route['author/posts/trash/(id\/(\d+)\/category\/([\w_-]+)(\/page\/\d+)?)/?']['get'] = 'home/author/trash_by_category/$1';
$route['author/posts/trash/restore/([\d,]+)']['get'] = 'home/author/restore_posts/$1';


$route['author/comments']['get'] = 'home/author/comments';
$route['author/comments/(orderby\/((post_title|user_name|user_email|created_at|visible)\/order\/(asc|desc)(\/page\/\d+)?)|(page\/\d+))/?']['get'] = 'home/author/comments/$1';
$route['author/comments/update_visibility']['post'] = 'home/author/update_comment_visibility';
$route['author/comments/delete/(\[[\d,]+\])']['get'] = 'home/author/delete_comments/$1';

$route['author/settings'] = 'home/author/settings';
$route['author/withdrawal'] = 'home/author/withdrawal';


$route['kontributor']['get'] = 'home/main/contributor_form';
$route['kontributor-submit']['post'] = 'home/main/contributor_form_store';

$route['subscriber/add']['post'] = 'home/subscribers/add';
$route['subscriber/add_async']['post'] = 'home/subscribers/add_async';
$route['((.+)\/)?contact']['post'] = 'home/main/contact';
$route['analytics']['post'] = 'home/main/update_analytics';
$route['toggle_style(/.+)?']['post'] = 'home/main/toggle_style';


$route['advertiser']['get'] = 'home/advertiser/index';
$route['advertiser/compaigns'] = 'home/advertiser/compaigns';
$route['advertiser/advertise'] = 'home/advertiser/advertise';


$route['save_reaction/?']['post'] = 'home/main/save_reaction';
$route['message_author/?']['post'] = 'home/main/message_author';
$route['mark_payment_as_paid/?']['post'] = 'home/main/mark_payment_as_paid';

# --- Auth ---------------------------------

$route['((.+)\/)?sign_up']['post'] = 'home/auth/sign_up';
$route['((.+)\/)?sign_in']['post'] = 'home/auth/sign_in';
$route['((.+)\/)?logout']['get']   = 'home/auth/logout';

$route['((.+)\/)?prepare_reset_password']['post'] = 'home/auth/prepare_reset_password';

$route['reset_password/(:any)']['get'] = 'home/auth/reset_password_page/$1';

$route['reset_password']['post'] = 'home/auth/reset_password_action';

$route['activate_account/([\w]+_[\w]+)']['get'] = 'home/auth/activate_account/$1';


# --- Language -----------------------------
$route['change_lang(/.+)?']['post'] = 'home/main/change_lang';
