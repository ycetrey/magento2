<?php

namespace Wealthsystems\Mastertheme\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function getTheme($attr)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Wealthsystems\Mastertheme\Model\Themecustom');

        $collection = $model->getCollection()
            ->addFieldToSelect('element')
            ->addFieldToSelect('value')
            ->addFieldToFilter('element',$attr)
            ->getFirstItem();

        if($collection->getValue()){
            return $collection->getValue();     
        } else {
            return null;     
        }           
    }

    public function createCSS()
    {
        $header = "
        .page-wrapper .page-header .panel.wrapper {
            border: none !important;
        }
        .page-header{
            background: ".$this->getTheme('header_background')." !important;
        }
        .page-wrapper .page-header .panel.wrapper {
            border-bottom: none;
            background-color: ".$this->getTheme('header_background')." !important;
            height: 0;
            z-index: 15;
            position: relative;
        }        
        .page-wrapper .page-header .panel.wrapper .panel.header .header.links > li.customer-welcome .action.switch:after,
        .page-wrapper .page-header .panel.wrapper .panel.header .header.links > li > span,
        .page-wrapper .page-header .panel.wrapper .panel.header .header.links > li > a {
            color: ".$this->getTheme('header_text')." !important;
        }
        .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart .counter.qty .counter-number,
        .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart:before {
            color: ".$this->getTheme('header_cart_text')." !important;
        }
        .page-wrapper .page-header .header.content .minicart-wrapper {
            background: ".$this->getTheme('header_cart_background')." !important;
            z-index: 15;
        }        
        .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart {
            border: 1px solid ".$this->getTheme('header_cart_background')." !important;
        }
        .page-wrapper .page-header .header.content .block-search .field.search .control .input-text {
            border-color: ".$this->getTheme('header_search_background')." !important;
            background: ".$this->getTheme('header_search_background')." !important;
            color: ".$this->getTheme('header_search_text')." !important;
        }
        .page-wrapper .page-header .header.content .block-search .field.search .control .input-text::placeholder {
            color: ".$this->getTheme('header_search_text')." !important;
        }
        .page-wrapper .page-header .panel.wrapper .panel.header .header.links > li .customer-menu .header.links {
            border: 1px solid ".$this->getTheme('header_account_background')." !important;
            background: ".$this->getTheme('header_account_background')." !important;
        }
        .page-wrapper .page-header .panel.wrapper .panel.header .header.links > li .customer-menu .header.links > li > a {
            color: ".$this->getTheme('header_account_text')." !important;
        }
        .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart {
            padding: 0 17px 0 14px !important;
        }
        .creditlimit{
            width: 220px;
            background: ".$this->getTheme('header_cart_background')." !important;
            display: table !important;
            padding: 2px 0;
            text-align: center;
        }
        .creditlimit + .authorization-link{
            display: none !important;    
        }
        ".$this->getTheme('header_css');

        $menu = "
        .nav-sections {
            background: ".$this->getTheme('menu_background')." !important;
        }        
        .navigation .level0.active > .level-top, 
        .navigation .level0.has-active > .level-top{
            background: ".$this->getTheme('menu_item_background')." !important;
        }
        .nav-sections .navigation > ul > li.level0 > a.level-top.ui-state-active,
        .nav-sections .navigation > ul > li.level0 > a.level-top.ui-state-focus{
            background: ".$this->getTheme('menu_item_background_hover')." !important;
        }
        .navigation .level0 .submenu a:hover,
        .navigation .level0 .submenu a.ui-state-focus,
        .navigation .level0 .submenu .active > a {
            color: ".$this->getTheme('menu_submenu_text')." !important;
        }
        .nav-sections .navigation > ul > li.level0 .submenu {
            background: ".$this->getTheme('menu_submenu_background')." !important;
            border: none;
            -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.3);
        }
        .navigation .level0 .submenu a {
            color: ".$this->getTheme('menu_submenu_text')." !important;
        }
        .navigation .level0 .submenu a:hover {
            color: ".$this->getTheme('menu_submenu_text_hover')." !important;
        }
        .nav-sections .navigation > ul > li.level0 .submenu {
            padding: 0 !important; 
        }
        ";

        $button = "
        .sidebar-additional .action.primary,
        .action.primary {
            background: ".$this->getTheme('button_background')." !important;
            border: 1px solid ".$this->getTheme('button_background')." !important;
            color: ".$this->getTheme('button_text')." !important;
        }
        .sidebar-additional .action.primary:hover,
        .action.primary:hover {
            background: ".$this->getTheme('button_background_hover')." !important;
            border: 1px solid ".$this->getTheme('button_background_hover')." !important;
            color: ".$this->getTheme('button_text_hover')." !important;
        }

        .sidebar-additional .action.primary span{
            color: ".$this->getTheme('button_text')." !important;
        }
        .sidebar-additional .action.primary:hover span{
            color: ".$this->getTheme('button_text_hover')." !important;
        }
        ";
        
        
        $content = "   
        .products-grid .product-item .product-item-info .product-item-details .product-item-name .product-item-link { 
            color: ".$this->getTheme('content_card_name')." !important;         
        }

        .products .product-item .product-item-sku {
            color: ".$this->getTheme('content_text_color')." !important;    
            opacity: 0.7;
        }
        .products-grid .product-item .product-item-info .product-item-details .price-box .old-price .price{
            color: ".$this->getTheme('content_text_color')." !important;    
            opacity: 0.8;
        }

        .products-grid .product-item .product-item-info .product-item-details .price-box .price,
        .rating-summary .rating-result > span:before {
            color: ".$this->getTheme('content_card_details')." !important;    
        }
        
        #minicart-content-wrapper .actions .viewcart span,
        .product-info-main .product-social-links a.action,
        .sidebar-additional .product-item-name > a,
        .sidebar-additional .product.name a > a,
        .sidebar-additional .abs-product-link > a:visited,
        .sidebar-additional .product-item-name > a:visited,
        .sidebar-additional .product.name a > a:visited,
        .sidebar-main .product-item-name > a,
        .sidebar-main .product.name a > a,
        .sidebar-main .abs-product-link > a:visited,
        .sidebar-main .product-item-name > a:visited,
        .sidebar-main .product.name a > a:visited,
        .sidebar.sidebar-main .block .block-content.filter-content .filter-options .filter-options-content .items .item > a,
        .sidebar-main .action span,
        .sidebar-additional .action span,        
        .minicart-items .product-item-name a,
        .breadcrumbs a:visited,
        .breadcrumbs a:hover,
        .breadcrumbs a:active,
        .breadcrumbs a {
            color: ".$this->getTheme('content_link_color')." !important;
        }        

        #minicart-content-wrapper .actions .viewcart span:hover,
        .sidebar.sidebar-main .block .block-content.filter-content .filter-options .filter-options-content .items .item > a:hover,
        .sidebar-main .action span:hover,
        .sidebar-additional .action span:hover,        
        .minicart-items .product-item-name a:hover,
        .sidebar-additional .product-item-name > a:hover,
        .sidebar-additional .product.name a > a:hover,
        .sidebar-main .product-item-name > a:hover,
        .sidebar-main .product.name a > a:hover,
        .product-info-main .product-social-links a.action:hover {
            color: ".$this->getTheme('content_link_color_hover')." !important;        
        }

        .discount-label,
        .pages strong.page,
        .pages a.page:hover,
        .pages .action.next:hover,
        .catalog-category-view .toolbar.toolbar-products .modes .modes-mode.active {
            border-color: ".$this->getTheme('content_icon_color')." !important;
            background: ".$this->getTheme('content_icon_color')." !important;
            color: ".$this->getTheme('content_link_text')." !important;
        }

        .products-grid .product-item .product-item-info .product-img-main .product-item-inner .product-item-actions .actions-secondary a.action.towishlist, 
        .products-grid .product-item .product-item-info .product-img-main .product-item-inner .product-item-actions .actions-secondary a.action.tocompare{
            background: ".$this->getTheme('button_background')." !important;
            color: ".$this->getTheme('button_text')." !important;
        }
        .products-grid .product-item .product-item-info .product-img-main .product-item-inner .product-item-actions .actions-secondary a.action.towishlist:hover, 
        .products-grid .product-item .product-item-info .product-img-main .product-item-inner .product-item-actions .actions-secondary a.action.tocompare:hover{
            background: ".$this->getTheme('content_icon_color')." !important;
            color: ".$this->getTheme('content_icon_text')." !important;
        }

        .toolbar-products .item span{
            color: #333333 !important;
        }

        .toolbar-products .item:hover span,
        .toolbar-products .current span{
            color: ".$this->getTheme('content_link_text')." !important;
        }

        ".$this->getTheme('content_css');
        
        $fixed = "
        .stock-info{
            font-size: 13px;
            font-style: italic;
        }
        .out{
            color: #dc2323 !important;
        }

        .cart .product-image-container {
            width: 80px !important;
        }
        .cart.table-wrapper .item .col.item {
            padding: 15px 8px 10px 0 !important;
        }

        .product-info-main .product-info-price .product-info-stock-sku .stock.unavailable {
            background: #d61e1e;           
        }
        .out-of-stock{
            background: #333;
            color: #fff;
            width: calc(100% + 20px);
            text-align: center;
            padding: 5px 0px;
            font-size: 13px;
            position: relative;
            z-index: 2;
            top: -4px;
            border-bottom: 4px solid #ce1e1e;
            left: -10px;
        }
        .out-of-stock-alert{
            padding: 2px 6px;
            position: absolute;
            z-index: 2;
            font-size: 17px;
            opacity: 0.3;
            color: #333;
            transition: 0.3s;
        }  

        .arrival-forecast{
            color: #717171;
            margin-top: 32px;
            margin-bottom: 7px;
            padding: 1px 5px;
            font-weight: 500;
            float: right;
            margin-right: -115px;
            line-height: 17px;
        }
        .arrival-forecast span:last-child{
            font-weight: 600;
        }

        .available-quantity{
            color: #717171;
            margin-top: 32px;
            margin-bottom: 7px;
            padding: 1px 5px;
            font-weight: 500;
            float: right;
            margin-right: -104px;
            line-height: 17px;
        }
        .available-quantity span:last-child{
            font-weight: 600;
        }

        .product-info-main .product-info-price .product-info-stock-sku .stock.unavailable {
            background: #d63232 !important;
        }

        .low-stock{
            background: #333;
            color: #fff;
            width: calc(100% + 20px);
            text-align: center;
            padding: 5px 0px;
            font-size: 13px;
            position: relative;
            z-index: 2;
            top: -4px;
            border-bottom: 4px solid #ffc800;
            left: -10px;
        }

        .discount-product{
            display: inline;
            margin-right: 17px;
        }
        .products-grid .product-item .product-item-info .product-item-details .product-item-name {
            height: 38px;
        }
        .header-content-info{
            display: none;
        }
        .price-unavailable{
            opacity: 0;
        }
        .product-disable{
            filter: grayscale(1) !important;
            opacity: 0.6;
        }
        .product-item-actions button{
            width: 100%;
        }
        .page-wrapper .page-header .header.content {
            padding: 20px 15px 25px;
        }
        .products-grid .product-item .product-item-info .product-item-details .price-box {
            margin-top: -10px;
        }
        .page-wrapper .page-header .header.content .block-search {
            z-index: 15;
        }
        .product-item-inner-tags{
            width: max-content !important;
        }
        .tocart-mobile{
            display: none;
        }
        .discount-label .percentage{
            display: inline-block;
            position: relative;
            top: 9px;
            left: auto;
        }
        .discount-label .off{
            font-size: 11.5px;
            display: inline-block;
            font-style: italic;
            margin-left: -1px;
            font-weight: 400;
            position: relative;
            top: 9px;
            left: auto;
        }
        .products .product-item{
            border: 1px solid #ececec;
            border-bottom: none;
            border-radius: 3px;
            padding: 5px 0 !important;
            transition: 0.5s;
        }
        .product-slider{
            border: none !important;
        }
        .product-slider .product-item-info{
            border: none !important;
        }        
        .products .product-item:hover {
            border: 1px solid #d3d3d3;
            border-bottom: none;
            transition: 0.5s;
        }
        .main .carousel-container{
            margin-top: -5px;
        }        
        .main .carousel-container{
            width: 100vw;
            margin-left: calc(-50vw + 50% - 8px);
        }
        .main .owl-carousel .owl-stage{
            left: calc(50% - 4800px);
        }
        .opc-progress-bar {
            text-align: center;
            margin-top: 25px;
        }        
        @media only screen and (min-width : 768px) and (max-width : 1131px) {
            .page-wrapper .page-header .header.content .block-search {
                width: auto;
            }
        }        
        @media only screen and (max-width : 992px) {
            .header.panel > .header.links > li.welcome{
                display: none;
            }
        }        
        @media only screen and (min-width : 767px) and (max-width : 782px) {
            .page-wrapper .page-header .header.content .block-search {
                float: left;
                padding-left: 0;
                margin-left: 0;
                top: -45px;
            }
        }
        @media only screen and (min-width : 782px) and (max-width : 797px) {
            .page-wrapper .page-header .header.content .block-search {
                float: left;
                padding-left: 0;
                margin-left: 0;
                top: 0px;
            }
        }  
        @media only screen and (max-width: 480px) {
            .products .product-item{
                margin-bottom: 5px;
                border: 1px solid #ececec;
            }
            .tocart-mobile{
                position: absolute;
                bottom: 0;
                z-index: 99;
                left: 50%;
                display: block;
            }
            .tocart-mobile button{
                left: -50%;
                position: relative;
                padding: 7px 14px 8px 12px !important;
            }
            .tocart-mobile button i{
                font-size: 21px;
            } 
            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart .counter.qty {
                background: #333333 !important;
                top: 11px !important;
            }
        }   
        
        @media only screen and (min-width : 972px) and (max-width : 1026px) {
            .page-wrapper .page-header .header.content .block-search {
                width: 320px;
            }
        }
        
        @media only screen and (min-width : 900px) and (max-width : 972px) {
            .page-wrapper .page-header .header.content .block-search {
                width: 248px;
            }
        }
        
        @media only screen and (min-width : 782px) and (max-width : 900px) {
            .page-wrapper .page-header .header.content .block-search {
                margin-top: 8px;
                margin-bottom: -8px;
            }
        }
        
        @media only screen and (min-width : 769px) and (max-width : 781px) {
            .page-wrapper .page-header .header.content .block-search {
                margin-top: 55px;
                margin-bottom: -55px;
            }
        }
        
        @media only screen and (min-width : 768px) and (max-width : 768px) {
            .page-wrapper .page-header .header.content .block-search {
                margin-top: 50px;
            }
            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart {
                margin-top: 0px;
            }
            .page-wrapper .page-header .header.content .minicart-wrapper {
                margin-top: 30px;
            }
            .page-wrapper .page-header .header.content .block-search {
                margin-top: 12px;
                margin-bottom: -25px;
                width: 200px;
            }
            .page-wrapper .page-header .header.content .logo {
                width: 240px;
                margin-top: 20px;
                margin-bottom: -13px;
            }
            .nav-toggle {
                top: 2px;
            }
        }
        
        @media only screen and (min-width : 468px) and (max-width : 767px) {
            .page-wrapper .page-header .header.content {
                padding: 15px 10px 0px 10px !important;
            }
            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart {
                margin-top: 0px;
            }
            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart .counter.qty {
                background: #333333 !important;
                top: 11px !important;
            }
            .block-search .label {
                margin: -60px 85px 15px 0;
            }
            .nav-toggle {
                top: 25px;
            }
            .page-wrapper .page-header .header.content .logo {
                margin-top: -4px;
                margin-bottom: 12px;
            }
        }
        
        @media only screen and (min-width : 468px) and (max-width : 766px) {
            .block-search .label {
                margin: 12px 55px 15px 0;
            }
        }        
        
        .block-search .label:before {
            color: #fff !important;
        }
        ";

        //Layout - Header

        $l_header = $this->getTheme('header');

        if($l_header == 'header1'){
            $l_header_css = "
            .page-wrapper .page-header .panel.wrapper {
                height: 0 !important;
            }
            ";
        } else if($l_header == 'header2'){
            $l_header_css = "
            .page-title-wrapper{
                margin-top: 25px !important;
            }
            .page-wrapper .page-header .panel.wrapper {
                height: 0 !important;
            }

            @media only screen and (min-width: 768px) { 
                .nav-sections .navigation > ul > li.level0 .submenu {
                    top: 2px !important;
                    left: 350px !important;
                }
                
                .nav-sections .navigation .category-item .level1 .submenu {
                    top: 0px !important;
                    left: 230px !important;
                }
                
                .navigation .level0.parent > .level-top > .ui-menu-icon:after {
                    display: none !important;
                    content: none !important;
                }
                .page-wrapper > .breadcrumbs{
                    box-sizing: border-box;
                    width: 100%;
                    margin-top: 10px;
                }
                .nav-visible{
                    display: initial !important;
                }   

                .nav-sections{
                    display: none;
                    width: 350px;
                    min-height: 250px !important;
                    max-height: 400px !important;
                    position: absolute !important;
                    z-index: 9999 !important;
                    margin-top: 123px !important;
                    left: 20px !important;
                    padding: 12px 0 18px 0 !important;
                }
                .nav-sections .navigation > ul > li.level0 {
                    float: left !important;
                    width: 100% !important;
                    height: 37px !important;
                }
                .nav-sections .navigation > ul > li.level0.parent > a.level-top {
                    padding: 9px 28px 18px 20px !important;
                }
                .nav-sections .navigation > ul > li.level0 > a.level-top{
                    padding: 9px 28px 18px 20px !important;
                    height: 37px !important;
                    margin-top: 2px !important;
                }
                
                .navigation ul {
                    padding: 0 !important;
                }
            
                .nav-toggle {
                    display: inline-block !important;
                    z-index: 999 !important;
                    margin-top: 27px !important;
                    padding-right: 15px;
                }

                .nav-toggle:before {
                    color: ".$this->getTheme('header_text')." !important;               
                }  
                
                .page-wrapper .nav-sections .navigation > ul li.level0 {
                    border: none !important;
                }
            }    
            @media only screen and (max-width: 480px) {               
                @media only screen and (max-width: 400px) {
                    .minicart-wrapper {
                      padding-bottom: 3px !important;
                    }
                }
                .logo img {
                    margin-top: 3px !important;
                    margin-bottom: -3px !important;
                }
                .page-footer .footer-top .footer-links .footer-links-main .footer-links-column .footer-colum-title > h3 {
                    margin-bottom: 8px !important;
                    margin-top: 20px !important;
                }
                .block-search .control {
                    border: none !important;
                }
                .nav-toggle:before,
                .block-search .label:before {
                    color: ".$this->getTheme('header_cart_text')." !important;
                }
            }

            .page-wrapper .nav-sections .nav-sections-item-title .nav-sections-item-switch, 
            .page-wrapper .nav-sections .nav-sections-item-title.active .nav-sections-item-switch,
            .page-wrapper .nav-sections .navigation > ul li.level0 > a.level-top {
                color: ".$this->getTheme('menu_item_text')." !important;
            }
            
            .nav-sections-item-title {
                background: ".$this->getTheme('menu_item_background')." !important;
                border: none;
                border-right: 1px solid ".$this->getTheme('menu_background')."  !important;
                width: 50%;
            }
            ";
        } 

        //Layout - Card

        $l_card = $this->getTheme('card');

        if($l_card == 'card1'){
            $l_card_css = "
            .product-item-desc{
                display: none;
            }
            ";
        } else if($l_card == 'card2'){
            $l_card_css = "
            .products .product-item .product-item-sku {
                margin-bottom: -3px !important;
            }
            .products-grid .product-items .product-item .product-item-info .product-item-details .product-reviews-summary {
                margin-bottom: -6px !important;
            }
            .products-grid .product-item .product-item-info .product-item-details .product-item-name .product-item-link {
                font-weight: 600 !important;
                margin-top: -15px !important;
                display: block !important;
            }
            .product-item-desc{
                margin-bottom: 11px;
                margin-top: -2px;
                display: block;
                font-size: 13px;
                line-height: 14px;
                color: #555;
                padding: 0 5px;
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
            }
            ";
        } else if($l_card == 'card3') {
            $l_card_css = "
            .products-grid .product-item .product-item-info .product-item-details .product-item-inner {
                display: none !important;
            }
            .products .product-item{
                border-bottom: 1px solid #ececec !important;
            }
            .products .product-item:hover{
                border-bottom: 1px solid #dadada !important;
            }
            .products .product-item .product-item-sku {
                margin-bottom: -3px !important;
            }
            .products-grid .product-items .product-item .product-item-info .product-item-details .product-reviews-summary {
                margin-bottom: -6px !important;
            }
            .products-grid .product-item .product-item-info .product-item-details .product-item-name .product-item-link {
                font-weight: 600 !important;
                margin-top: -15px !important;
                display: block !important;
            }
            .product-item-desc{
                display: none;
            }
            ";
        }

        $l_cart = $this->getTheme('cart');

        if($l_cart == 'cart1'){
            $l_cart_css = "
            @media all and (min-width: 768px) {
                .cart.table-wrapper .product-item-name {
                    display: inline-block;
                    font-weight: 600;
                    margin-top: 4px;
                }
                .cart.table-wrapper .item-actions td {
                    padding: 0;
                    border: none;
                }
                .cart.table-wrapper .actions-toolbar > .action:hover,
                .cart.table-wrapper .actions-toolbar > .action {               
                    padding: 2px;
                    background: transparent;
                    border: none;
                    font-weight: 400;
                }
                .price-including-tax .price, .price-excluding-tax .price {
                    font-weight: 600;
                }
            }
            ";
        } else if($l_cart == 'cart2'){
            $l_cart_css = "
            @media all and (min-width: 768px) {
                .cart.table-wrapper .product-item-name {
                    display: inline-block;
                    font-weight: 600;
                    margin-top: 4px;
                }
                .cart.table-wrapper .item-actions td {
                    padding: 0;
                    border: none;
                }
                .cart.table-wrapper .actions-toolbar > .action:hover,
                .cart.table-wrapper .actions-toolbar > .action {               
                    padding: 2px;
                    background: transparent;
                    border: none;
                    font-weight: 400;
                }
                .price-including-tax .price, .price-excluding-tax .price {
                    font-weight: 600;
                }           
                .cart.table-wrapper .items {
                    display: block;
                }
                .cart.table-wrapper .items > .item {
                    width: 100%;
                    display: inline-flex;
                }

                .cart.table-wrapper .items > .item tr:first-child{
                    display: flex;
                    width: calc(100% - 180px);
                }  
                .cart.table-wrapper .items > .item tr:last-child{
                    display: flex;
                    width: 180px;
                }    
                .cart.table-wrapper .items > .item tr:last-child .action{
                    text-align: right !important;
                    width: 100%;
                }   
                .cart.table-wrapper .item .col.item {
                    padding: 15px 8px 2px 0 !important;
                    border: none !important;
                }     
                .table > tbody > tr > th,
                .table > tbody > tr > td {                
                  border: none !important;
                }   
                .table > tbody > .item-info > td {                
                    width: 100px;
                    text-align: center;
                    display: block;
                    margin: 0 auto;
                } 
                .table > tbody > .item-info > .item {                
                    width: calc(100% - 300px);
                    text-align: left;
                } 
                .table > tbody > .item-info > td span,
                .table > tbody > .item-info > td .qty {     
                    text-align: center;
                } 
            }
            ";        
        }
    

        $css = $header.$menu.$button.$content.$fixed;

        $css .= $l_header_css.$l_card_css.$l_cart_css;

        $path = $_SERVER['DOCUMENT_ROOT']."/app/code/Hiddentechies/Bizkick/view/frontend/web/css";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        
        $fp = fopen($path."/wscustom.css", "wb");
        fwrite($fp, $css);
        fclose($fp);
    }
}
