<?php
class ControllerFeedBestprice extends Controller {

	public function index() {

		// config
		$CDN_URL = "https://cdn.peiraiashome.gr/";
		$COLOR_OPTION_ID = 13;
		$SIZE_OPTION_ID = 14;
		$CREATE_ZIP = true;

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('extension/feed/bestprice');

		$products = $this->model_extension_feed_bestprice->getProducts();
		$categories = $this->model_extension_feed_bestprice->getCategories();
		$categories_path = $this->model_extension_feed_bestprice->getCategoriesPath();
		$manufacturers = $this->model_extension_feed_bestprice->getManufacturers();
		$stock_statuses = $this->model_extension_feed_bestprice->getStockStatuses();
		$color_options = $this->model_extension_feed_bestprice->getProductOptions($COLOR_OPTION_ID);
		$size_options = $this->model_extension_feed_bestprice->getProductOptions($SIZE_OPTION_ID);
	
		$output  = '<?xml version="1.0" encoding="utf-8"?>';
		$output .= '<mywebstore>';
		$output .= '<created_at>' . date('Y-d-m h:i:s') . '</created_at>';
		$output .= '<products>';

		$count=0;

		foreach ($products as $product) {
			$count++;

			$price = $product['special'] ? $product['special'] : $product['price'];
			$final_vat_price = $this->tax->calculate($price, $product['tax_class_id'], $this->config->get('config_tax'));
			
			$manuf_index = array_search($product['manufacturer_id'], array_column($manufacturers, 'manufacturer_id'), true);
			$product['manufacturer'] = $manuf_index > 0 ? $manufacturers[$manuf_index]['name'] : 'OEM';
			
			$category_path = '';
			foreach ($categories_path as $cat) {
				if ($cat['category_id'] ==  $product['category_id']) {
					foreach ($categories as $category) {
						if ($cat['path_id'] == $category['category_id']) {
							$category_path .= $category['name'] . ' > ';
						}
					}
				}
			}
			$category_path = substr($category_path, 0, -3);
			

			$in_stock = '';
			$availability = '';

			if ($product['quantity'] > 0) {
				$in_stock = 'Y';
				$availability = 'Άμεση παραλαβή / Παράδοση 1 έως 3 ημέρες';
			} else {
				$in_stock = 'N';
				$availability = 'Παράδοση σε 4 έως 10 ημέρες'; // $stock_statuses[array_search($product['stock_status_id'], array_column($stock_statuses, 'stock_status_id'))]['name'];
			}

			$color_index = array_search($product['product_id'], array_column($color_options, 'product_id'), true);
			$product['color'] = $color_index > 0 ? $color_options[$color_index]['options'] : false;

			$size_index = array_search($product['product_id'], array_column($size_options, 'product_id'), true);
			$product['size'] = $size_index > 0 ? $size_options[$size_index]['options'] : false;
						
			$output .= '<product>';
			$output .= '<id>' . $product['product_id'] . '</id>';
			$output .= '<name><![CDATA[' . $product['name'] . ']]></name>';
			
			// use friendly URLs
			// $output .= '<link><![CDATA[' . $this->url->link('product/product', 'path=' . $path . '&product_id=' . $product['product_id']) . ']]></link>';
			// use default URLs
			$output .= '<link><![CDATA[' . HTTPS_SERVER . 'index.php?route=product/product&product_id=' . $product['product_id'] . ']]></link>';

			$output .= '<image><![CDATA[' . $CDN_URL . 'image/' .$product['image'] . ']]></image>';
			$output .= '<category id="' . $product['category_id'] . '"><![CDATA[' . $category_path . ']]></category>';
			$output .= '<price_with_vat>' . number_format($final_vat_price, 2, '.', '') . '</price_with_vat>';
			$output .= '<manufacturer><![CDATA[' . $product['manufacturer'] . ']]></manufacturer>';
			
			if ($product['mpn']) $output .= '<mpn>' . $product['mpn'] . '</mpn>';
			if ($product['ean']) $output .= '<ean>' . $product['ean'] . '</ean>';
			
			$output .= '<instock>' . $in_stock . '</instock>';
			$output .= '<availability>' . $availability . '</availability>';

			if ($product['color']) $output .= '<color>' . $product['color'] . '</color>';
			if ($product['size']) $output .= '<size>' . $product['size'] . '</size>';
			
			if ($product['weight'] > 0) $output .= '<weight>' . round($product['weight'], 2) . '</weight>';

			$output .= '<description><![CDATA[' . $this->fix_description($product['description']) . ']]></description>';
			
			$output .= '</product>';

			// if ($count == 1000) break;
		}
		
		$output .= '</products>';
		$output .= '</mywebstore>';

		// OPEN OUTPUT FILE
		$fs = fopen("xml_feeds/bestprice.xml", "wb");
		fwrite($fs, $output);
		fclose($fs);

		// COMPRESS FILE
		if ($CREATE_ZIP) {
			$zip_file = "xml_feeds/bestprice.zip";
			if (is_file($zip_file)) unlink($zip_file);
			$zip = new ZipArchive;
			if ($zip->open("xml_feeds/bestprice.zip", ZipArchive::CREATE) === TRUE) {
				$zip->addFile("xml_feeds/bestprice.xml");
				$zip->close();
			}
		}

		$this->response->setOutput('<p>Create bestprice.xml...OK<br/>Products in bestprice XML: ' . $count . '<br/><a href="/xml_feeds/bestprice.xml" target="_blank">View XML</a> or <a href="/xml_feeds/bestprice.zip">Download Zip</a></p>');
	}

	public function fix_description($desc){

		$desc_utf8 = trim($desc);
		$desc_utf8 = str_replace('</p>', '</p> ', $desc_utf8);
		$desc_utf8 = str_replace('<br>', ' ', $desc_utf8);
		$desc_utf8 = str_replace('<br/>', ' ', $desc_utf8);
		$desc_utf8 = str_replace('<br />', ' ', $desc_utf8);
		$desc_utf8 = str_replace('<ul>', '<ul> ', $desc_utf8);
		$desc_utf8 = str_replace('<ol>', '<ol>, ', $desc_utf8);
		$desc_utf8 = str_replace('<li>', '<li>, ', $desc_utf8);
		$desc_utf8 = html_entity_decode($desc_utf8, ENT_NOQUOTES, "UTF-8");
		$desc_utf8 = strip_tags($desc_utf8);
		$desc_utf8 = str_replace('&nbsp;', ' ', $desc_utf8);
		$desc_utf8 = str_replace('&times;', 'x', $desc_utf8);
		$desc_utf8 = preg_replace('/\s+/', ' ', $desc_utf8);
		$desc_utf8 = mb_substr($desc_utf8, 0, 1000);

		return $desc_utf8;
	}
}