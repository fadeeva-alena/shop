<?php
/**
 * Created by PhpStorm.
 * User: Алёна
 * Date: 11.08.2018
 * Time: 12:50
 */
return array(
    'product/([0-9]+)'=>'product/view/$1', //actionView in ProductController

    'catalog/*' => 'catalog/index', //actionIndex in CatalogController

    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2',
    'category/([0-9]+)' => 'catalog/category/$1',

    //Корзина
    'cart/add/([0-9]+)'=>'cart/add/$1',
    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1', // actionAddAjax в CartController
    'cart/*' => 'cart/index', // actionIndex в CartController
    'cart/checkout'=>'cart/checkout',
    'cart/delete/([0-9]+)'=>'cart/delete/$1',

    //Пользователь
    'user/register/*'=>'user/register',
    'user/login/*'=>'user/login',
    'user/logout/*'=>'user/logout',
    'cabinet/edit/*'=>'cabinet/edit',
    'cabinet/*'=>'cabinet/index',

    // Управление товарами:
    'admin/product/create' => 'adminProduct/create',
    'admin/product/update/([0-9]+)' => 'adminProduct/update/$1',
    'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1',
    'admin/product' => 'adminProduct/index',

    // Управление категориями:
    'admin/category/create/*' => 'adminCategory/create',
    'admin/category/update/([0-9]+)/*' => 'adminCategory/update/$1',
    'admin/category/delete/([0-9]+)/*' => 'adminCategory/delete/$1',
    'admin/category/*' => 'adminCategory/index',

    // Управление заказами:
    'admin/order/update/([0-9]+)/*' => 'adminOrder/update/$1',
    'admin/order/delete/([0-9]+)/*' => 'adminOrder/delete/$1',
    'admin/order/view/([0-9]+)/*' => 'adminOrder/view/$1',
    'admin/order/*' => 'adminOrder/index',

    //Админпанель
    'admin'=>'admin/index',

    'contacts/*'=>'site/contact',
    'page-([0-9]+)'=>'site/index/$1',
    ''=>'site/index', //actionIndex in SiteController
);