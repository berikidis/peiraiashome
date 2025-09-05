<?php
// SOURCE
$SOURCE_PLATFORM = "feed";			// file, feed, cscart, woocommerce, opencart, magento
$SOURCE_TYPE = "xml";				// API, database, xml, json, csv, xls

$SOURCE_FOLDER = dirname(__FILE__) . "/upload/adahome/";
$SOURCE_FILENAME = "";

$SOURCE_FEED  = "https://adamhome.gr/index.php?route=extension/feed/adamhome_feed";
// $SOURCE_FEED2 = "https://adamhome.gr/index.php?route=extension/feed/adamhome_feed_separated";


$SOURCE_DBHOST = 'localhost';
$SOURCE_DBNAME = '';
$SOURCE_DBUSER = '';
$SOURCE_DBPASS = '';


// DESTINATION
$DEST_PLATFORM = "opencart";		// file, cscart, woocommerce, opencart, magento
$DEST_TYPE = "database";			// API, database, xml, json, csv, xls

$DEST_DBHOST = 'localhost';
$DEST_DBNAME = 'lefkaeid_db2';
$DEST_DBUSER = 'lefkaeid_db2';
$DEST_DBPASS = 'gt,ZnzvQxK+K';
$DEST_TBPREFIX = '1c0p_';


// DEMO
$DEST_API_URL = "";
$DEST_API_USER = "";
$DEST_API_KEY = "";


// JOB
$JOB_TYPE = "insert/update/disable";// insert, update, disable, insert/update, Default: insert/update
$JOB_MODE = "live";					// demo or live. In Demo only first n records are processed. Default: live
$JOB_DEMO_RECORDS = 10;				// Default: 10
$JOB_UPDATE_PRODUCT_NAME = false;	// Update Product Name. If true the current name will be replaced by import. Default: false
$JOB_UPDATE_DESCRIPTION = false;	// Update Product Description. If true the current description will be replaced by import. Default: false
$JOB_UPDATE_PRICE = true;			// Update Product Status. Default: true
$JOB_UPDATE_STATUS = true;			// Update Product Status. Default: false
$JOB_UPDATE_MAIN_IMAGE = false;		// Update Product Main Image. Default: false
$JOB_UPDATE_EXTRA_IMAGES = false;	// Update Product Extra Images. Default: false
$JOB_UPDATE_ATTRIBUTES = false;		// Update Product Attributes
$JOB_SKIP_OUT_OF_STOCK = true;      // Skip Products that are out of stock

// DEFAULT VALUES
$DEFAULT_COMPANY_ID = 1;			// Default Company ID. Default: 1
$DEFAULT_LANG_CODE = '';			// Default Language Code. Default 'el'
$DEFAULT_LANG_ID = 2;				// Default Language ID. Default: 1
$DEFAULT_MAIN_CATEGORY_ID = 217;	// Default category for new products
$DEFAULT_STATUS = 1;				// Default product status. Can be 1=active, 0=inactive.  Default: 1
$DEFAULT_VAT_ID = 9;				// Default VAT ID
$DEFAULT_IN_STOCK_AMOUNT = 199;		// Default Instock Amount
$DEFAULT_IN_STOCK_STATUS_ID = 7;	// Default In Stock Status ID
$DEFAULT_OUT_OF_STOCK_STATUS_ID = 5;// Default Out of Stock Status ID
$DEFAULT_MANUFACTURER_ID = 12;		// Default Manufacturer
$DEFAULT_CUSTOMER_GROUP_ID	= 1;	// Default Customer Group ID
$DEFAULT_SUPPLIER_FEATURE_ID = 0;
$DEFAULT_SUPPLIER_VARIANT_ID = 0;

// PRODUCT OPTIONS
$COLOR_OPTION_ID = 13;
$COLOR_OPTION_NAME = "Χρώμα";
$SIZE_OPTION_ID = 14;
$SIZE_OPTION_NAME = "Μέγεθος";
$DIMENSIONS_OPTION_ID = 15;
$DIMENSIONS_OPTION_NAME = "Διαστάσεις";

// DATA MAPPING
$TAX_IDS = array (6 => '24%', 7 => '13%');

// IMAGE UPLOADING
$IMAGES_LOCAL_DIR = "../image/catalog/products/adamhome/";
$IMAGES_PATH = "catalog/products/adamhome/";
$IMAGES_MAX_UPLOAD = 50;

// DEBUGGUING
$DEBUG = false;

?>