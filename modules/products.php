<?php
	function formProduct($product_id, $product_img, $product_name, $product_price, $product_new_price, $product_stars){
		echo '<div class="products-block-product">';
		echo '<div class="product-container" onclick="window.location = \'product.php?id=' . $product_id . '\'">';
		echo '<img src="' . $product_img . '" alt="TV" />';
		echo '<span class="product-name">' . $product_name . '</span>';
		if(is_null($product_new_price)){
			echo '<span class="product-price">$' . $product_price . '</span>';
		}
		else{
			echo '<span class="product-price old">$' . $product_price . '</span>';
			echo '<span class="product-price">$' . $product_new_price . '</span>';
		}
		if(is_null($product_stars)){
			echo '<span class="product-stars">Нет отзывов</span>';
		}
		else{
			echo '<ul class="product-stars">';
			for($star = 0; $star < 5; $star++)
				if($star < $product_stars)
					echo '<li class="yellow-star"></li>';
				else
					echo '<li class="dark-star"></li>';
			echo '</ul>';
		}
		echo '</div>';
		echo '<button name="to_cart" data-id="' . $product_id . '">В корзину</button>';
		echo '</div>';
	}

	function formProductsForPBlock($type_id){
		require("connection.php");
		echo '<div class="products-block-products">';
		$result = $mysqli->query("SELECT a.id, a.image, a.name, a.cost, a.discount_cost, (SELECT ROUND(SUM(score) / COUNT(score)) FROM reviews WHERE product = a.id) as score FROM appliances as a where a.type = $type_id order by a.id desc limit 0, 6");
		while($row = mysqli_fetch_array($result)){
			formProduct($row['id'], $row['image'], $row['name'], $row['cost'], $row['discount_cost'], $row['score']);
		}
		mysqli_free_result($result);
		echo '</div>';
	}

	function formProductsBlock($category_id, $category_img, $color_class){
		require("connection.php");
		//Sidebar
		echo '<div class="products-block ' . $color_class . '">';
		echo '<div class="products-sidebar">';
		echo '<div class="products-sidebar-header">';
		echo '<img src="' . $category_img . '" alt="Category" />';

		require('modules/connection.php');
        $result = $mysqli->query("SELECT name FROM typecategories where id = $category_id");
        if ($mysqli->errno){
            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
        }
        if($row = mysqli_fetch_array($result)){
			echo '<span class="big-txt white-txt">' . $row['name'] . '</span>';
		}
		else{
			die('Incorrect category id');
		}
		mysqli_free_result($result);
		echo '</div>';
		echo '<ul class="products-sidebar-categories">';
		$first_type_id = 0;
		$result = $mysqli->query("SELECT id, name FROM appliancestypes where typecategory = $category_id");
		while($row = mysqli_fetch_array($result)){
			if($first_type_id == 0)
				$first_type_id = $row['id'];
			echo '<li data-id="' . $row['id'] . '">' . $row['name'] . '</li>';
		}
		mysqli_free_result($result);
		echo '</ul>';
		echo '</div>';
		//ProductBlock
		formProductsForPBlock($first_type_id);
		//Banner
		require_once("banners.php");
		productBlockBanner();
		echo '</div>';
	}
?>