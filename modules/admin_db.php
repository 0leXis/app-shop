<?php
    session_start();
    if(!isset($_SESSION['user_isadmin']))
        error401();
    if($_SESSION['user_isadmin'] != true)
        error403();
    define('PRODUCT_IMAGES_DIR', '..\images\products');
    define('USER_PRODUCT_IMAGES_DIR', '\images\products');
    //TODO: валидация на клиенте и сервере
    require_once("error_pages.php");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require_once("DB_utils.php");
        if(isset($_POST['form'])){
            switch($_POST['form']){
                case 'country_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if(searchID('countries', $_POST['id']))
                            execProcedure('ChangeCountry', $_POST['id'], $_POST['name']);
                        else
                            execProcedure('CreateCountry', $_POST['name']);
                    }
                    else{
                        execProcedure('CreateCountry', $_POST['name']);
                    }
                    echo 'REFRESH';
                    die();
                case 'category_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if(searchID('typecategories', $_POST['id']))
                            execProcedure('ChangeCategory', $_POST['id'], $_POST['name']);
                        else
                            execProcedure('CreateCategory', $_POST['name']);
                    }
                    else{
                        execProcedure('CreateCategory', $_POST['name']);
                    }
                    echo 'REFRESH';
                    die();
                case 'type_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if(searchID('appliancestypes', $_POST['id']))
                            execProcedure('ChangeType', $_POST['id'], $_POST['name'], $_POST['category']);
                        else
                            execProcedure('CreateType', $_POST['name'], $_POST['category']);
                    }
                    else{
                        execProcedure('CreateType', $_POST['name'], $_POST['category']);
                    }
                    echo 'REFRESH';
                    die();
                case 'role_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if(searchID('positions', $_POST['id']))
                            execProcedure('ChangeRole', $_POST['id'], $_POST['name']);
                        else
                            execProcedure('CreateRole', $_POST['name']);
                    }
                    else{
                        execProcedure('CreateRole', $_POST['name']);
                    }
                    echo 'REFRESH';
                    die();
                case 'status_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if(searchID('orderstatuses', $_POST['id']))
                            execProcedure('ChangeStatus', $_POST['id'], $_POST['name']);
                        else
                            execProcedure('CreateStatus', $_POST['name']);
                    }
                    else{
                        execProcedure('CreateStatus', $_POST['name']);
                    }
                    echo 'REFRESH';
                    die();
                case 'method_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if(searchID('paymentmethods', $_POST['id']))
                            execProcedure('ChangeMethod', $_POST['id'], $_POST['name']);
                        else
                            execProcedure('CreateMethod', $_POST['name']);
                    }
                    else{
                        execProcedure('CreateMethod', $_POST['name']);
                    }
                    echo 'REFRESH';
                    die();
                case 'staff_form':
                    require("hash.php");
                    if($_POST['pass'] != $_POST['pass_conf']){
                        echo 'Пароли не совпадают';
                        die();
                    }
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if($user = searchID('workers', $_POST['id'])){
                            if($_POST['pass'] == "")
                                $password = getHash($_POST['pass']);
                            else
                                $password = getHash($user[7]);
                            execProcedure('ChangeWorker', $_POST['id'], $_POST['name'], $_POST['surname'], $_POST['lastname'], $_POST['role'], $_POST['salary'], $_POST['email'], $password['hash'], $password['salt']);
                        }
                        else{
                            if($_POST['pass'] == ""){
                                echo 'Для добавления пользователя ввод пароля обязателен!';
                                die();
                            }
                            $password = getHash($_POST['pass']);
                            execProcedure('CreateWorker', $_POST['name'], $_POST['surname'], $_POST['lastname'], $_POST['rolen'], $_POST['salary'], $_POST['email'], $password['hash'], $password['salt']);
                        }
                    }
                    else{
                        if($_POST['pass'] == ""){
                            echo 'Для добавления пользователя ввод пароля обязателен!';
                            die();
                        }
                        $password = getHash($_POST['pass']);
                        execProcedure('CreateWorker', $_POST['name'], $_POST['surname'], $_POST['lastname'], $_POST['role'], $_POST['salary'], $_POST['email'], $password['hash'], $password['salt']);
                    }
                    echo 'REFRESH';
                    die();
                case 'manufacturer_form':
                    if($_POST['email'] == "")
                        $_POST['email'] = null;
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if(searchID('manufacturers', $_POST['id']))
                            execProcedure('ChangeManufacturer', $_POST['id'], $_POST['name'], $_POST['desc'], $_POST['email'], $_POST['country']);
                        else
                            execProcedure('CreateManufacturer', $_POST['name'], $_POST['desc'], $_POST['email'], $_POST['country']);
                    }
                    else{
                        execProcedure('CreateManufacturer', $_POST['name'], $_POST['desc'], $_POST['email'], $_POST['country']);
                    }
                    echo 'REFRESH';
                    die();
                case 'supplier_form':
                    if($_POST['email'] == "")
                        $_POST['email'] = null;
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if(searchID('suppliers', $_POST['id']))
                            execProcedure('ChangeSupplier', $_POST['id'], $_POST['name'], $_POST['desc'], $_POST['email']);
                        else
                            execProcedure('CreateSupplier', $_POST['name'], $_POST['desc'], $_POST['email']);
                    }
                    else{
                        execProcedure('CreateSupplier', $_POST['name'], $_POST['desc'], $_POST['email']);
                    }
                    echo 'REFRESH';
                    die();
                case 'product_form':
                    if($_POST['discount_price'] == "")
                        $_POST['discount_price'] = null;
                    if(!isset($_FILES['image']) || !is_uploaded_file($_FILES['image']['tmp_name']))
                        $_POST['image'] = null;
                    else{
                        if($_FILES['image']['size'] > 10485760){
                            echo 'Слишком большой размер файла!';
                            die();
                        }
                        if(exif_imagetype($_FILES['image']['tmp_name']) == false){
                            echo 'Недопустимый тип файла!';
                            die();
                        }
                        $files = scandir(PRODUCT_IMAGES_DIR);
                        $file_no = 0;
                        while(in_array($file_no . '.img', $files))
                            $file_no++;
                        $_POST['image'] = USER_PRODUCT_IMAGES_DIR . '/' . $file_no . '.img';
                    }
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if(searchID('appliances', $_POST['id']))
                            execProcedure('ChangeProduct', $_POST['id'], $_POST['name'], $_POST['description'], $_POST['manufacturer'], $_POST['type'], $_POST['price'], $_POST['discount_price'], $_POST['image']);
                        else{
                            if($_POST['image'] == null){
                                echo 'Для добавления продукта необходимо прикрепить изображение!';
                                die();
                            }
                            execProcedure('CreateProduct', $_POST['id'], $_POST['name'], $_POST['description'], $_POST['manufacturer'], $_POST['type'], $_POST['price'], $_POST['discount_price'], $_POST['image']);
                        }
                    }
                    else{
                        if($_POST['image'] == null){
                            echo 'Для добавления продукта необходимо прикрепить изображение!';
                            die();
                        }
                        execProcedure('CreateProduct', $_POST['id'], $_POST['name'], $_POST['description'], $_POST['manufacturer'], $_POST['type'], $_POST['price'], $_POST['discount_price'], $_POST['image']);
                    }
                    if(!move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGES_DIR . '/' . $file_no . '.img')){
                        echo 'Не удалось переместить файл!';
                        die();
                    }
                    echo 'REFRESH';
                    die();
                case 'warehouse_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if(searchID('warehouses', $_POST['id']))
                            execProcedure('ChangeWarehouse', $_POST['id'], $_POST['address'], $_POST['manager']);
                        else
                            execProcedure('CreateWarehouse', $_POST['id'], $_POST['address'], $_POST['manager']);
                    }
                    else{
                        execProcedure('CreateWarehouse', $_POST['id'], $_POST['address'], $_POST['manager']);
                    }
                    echo 'REFRESH';
                    die();
                case 'warehouse_product_form':
                    execProcedure('ChangeWarehouseProduct', $_POST['id'], $_POST['warehouse'], $_POST['count']);
                    echo 'REFRESH';
                    die();
                case 'supply_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        if(searchID('supplies', $_POST['id']))
                            execProcedure('ChangeSupply', $_POST['id'], $_POST['date'], $_POST['warehouse'], $_POST['supplier']);
                        else
                            execProcedure('CreateSupply', $_POST['date'], $_POST['warehouse'], $_POST['supplier']);
                    }
                    else{
                        execProcedure('CreateSupply', $_POST['date'], $_POST['warehouse'], $_POST['supplier']);
                    }
                    echo 'REFRESH';
                    die();
                case 'supply_product_form':
                    execProcedure('ChangeSupplyProduct', $_POST['id'], $_POST['supply'], $_POST['count']);
                    echo 'REFRESH';
                    die();
                case 'order_form':
                    execProcedure('ChangeOrderStatus', $_POST['id'], $_POST['status'], $_SESSION['user_id']);
                    echo 'REFRESH';
                    die();
                default:
                    error400(true);
            }
        }
        elseif(isset($_POST['delete_form'])){
            switch($_POST['delete_form']){
                case 'country_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteCountry', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'category_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteCategory', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'type_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteType', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'role_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteRole', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'status_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteStatus', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'method_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteMethod', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'staff_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteWorker', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'manufacturer_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteManufacturer', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'supplier_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteSupplier', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'product_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        $row = searchID('appliances', $_POST['id']);
                        if($row != null)
                            unlink('..' . $row[8]);
                        execProcedure('DeleteProduct', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'warehouse_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteWarehouse', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'supply_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteSupply', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                case 'message_form':
                    if(isset($_POST['id']) && $_POST['id'] != ""){
                        execProcedure('DeleteMessage', $_POST['id']);
                    }
                    echo 'REFRESH';
                    die();
                default:
                    error400(true);
            }
        }   
        else{
            error400(true);
        }
    }
	else
		error400(true);
?>