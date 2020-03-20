use appliancesshop;
drop procedure if exists GetLoginInfo;
delimiter $$
create procedure GetLoginInfo(in user_email varchar(50))
begin
	SELECT id, email, password, salt, true as admin FROM workers WHERE email = user_email UNION SELECT id, email, password, salt, false as admin FROM customers WHERE email = user_email;
end$$
delimiter ;

drop procedure if exists CreateCountry;
delimiter $$
create procedure CreateCountry(in name varchar(30))
begin
	INSERT INTO countries VALUES(null, name);
end$$
delimiter ;

drop procedure if exists ChangeCountry;
delimiter $$
create procedure ChangeCountry(in c_id int, in c_name varchar(30))
begin
	UPDATE countries SET name = c_name WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists DeleteCountry;
delimiter $$
create procedure DeleteCountry(in c_id int)
begin
	DELETE FROM countries WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists CreateCategory;
delimiter $$
create procedure CreateCategory(in name varchar(30))
begin
	INSERT INTO typecategories VALUES(null, name);
end$$
delimiter ;

drop procedure if exists ChangeCategory;
delimiter $$
create procedure ChangeCategory(in c_id int, in c_name varchar(30))
begin
	UPDATE typecategories SET name = c_name WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists DeleteCategory;
delimiter $$
create procedure DeleteCategory(in c_id int)
begin
	DELETE FROM typecategories WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists CreateType;
delimiter $$
create procedure CreateType(in name varchar(30), in category_id int)
begin
	INSERT INTO appliancestypes VALUES(null, name, category_id);
end$$
delimiter ;

drop procedure if exists ChangeType;
delimiter $$
create procedure ChangeType(in c_id int, in c_name varchar(30), in category_id int)
begin
	UPDATE appliancestypes SET name = c_name, typecategory = category_id WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists DeleteType;
delimiter $$
create procedure DeleteType(in c_id int)
begin
	DELETE FROM appliancestypes WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists CreateRole;
delimiter $$
create procedure CreateRole(in name varchar(30))
begin
	INSERT INTO positions VALUES(null, name);
end$$
delimiter ;

drop procedure if exists ChangeRole;
delimiter $$
create procedure ChangeRole(in c_id int, in c_name varchar(30))
begin
	UPDATE positions SET name = c_name WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists DeleteRole;
delimiter $$
create procedure DeleteRole(in c_id int)
begin
	DELETE FROM positions WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists CreateStatus;
delimiter $$
create procedure CreateStatus(in name varchar(30))
begin
	INSERT INTO orderstatuses VALUES(null, name);
end$$
delimiter ;

drop procedure if exists ChangeStatus;
delimiter $$
create procedure ChangeStatus(in c_id int, in c_name varchar(30))
begin
	UPDATE orderstatuses SET name = c_name WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists DeleteStatus;
delimiter $$
create procedure DeleteStatus(in c_id int)
begin
	DELETE FROM orderstatuses WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists CreateMethod;
delimiter $$
create procedure CreateMethod(in name varchar(30))
begin
	INSERT INTO paymentmethods VALUES(null, name);
end$$
delimiter ;

drop procedure if exists ChangeMethod;
delimiter $$
create procedure ChangeMethod(in c_id int, in c_name varchar(30))
begin
	UPDATE paymentmethods SET name = c_name WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists DeleteMethod;
delimiter $$
create procedure DeleteMethod(in c_id int)
begin
	DELETE FROM paymentmethods WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists CreateWorker;
delimiter $$
create procedure CreateWorker(in name varchar(20), in surname varchar(20), in lastname varchar(20), in position int, in salary decimal(17,2), in email varchar(50), in password varchar(130), in salt varchar(50))
begin
	INSERT INTO workers VALUES(null, name, surname, lastname, position, salary, email, password, salt);
end$$
delimiter ;

drop procedure if exists ChangeWorker;
delimiter $$
create procedure ChangeWorker(in c_id int, in c_name varchar(20), in c_surname varchar(20), in c_lastname varchar(20), in c_position int, in c_salary decimal(17,2), in c_email varchar(50), in c_password varchar(130), in c_salt varchar(50))
begin
	UPDATE workers SET name = c_name, surname = c_surname, lastname = c_lastname, position = c_position, salary = c_salary, email = c_email, password = c_password, salt = c_salt WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists DeleteWorker;
delimiter $$
create procedure DeleteWorker(in c_id int)
begin
	DELETE FROM workers WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists CreateManufacturer;
delimiter $$
create procedure CreateManufacturer(in name varchar(100), in description varchar(1000), in email varchar(50), in country int)
begin
	INSERT INTO manufacturers VALUES(null, name, description, email, country);
end$$
delimiter ;

drop procedure if exists ChangeManufacturer;
delimiter $$
create procedure ChangeManufacturer(in c_id int, in c_name varchar(100), in c_description varchar(1000), in c_email varchar(50), in c_country int)
begin
	UPDATE manufacturers SET name = c_name, description = c_description, email = c_email, country = c_country WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists DeleteManufacturer;
delimiter $$
create procedure DeleteManufacturer(in c_id int)
begin
	DELETE FROM manufacturers WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists CreateSupplier;
delimiter $$
create procedure CreateSupplier(in name varchar(100), in description varchar(1000), in email varchar(50))
begin
	INSERT INTO suppliers VALUES(null, name, description, email);
end$$
delimiter ;

drop procedure if exists ChangeSupplier;
delimiter $$
create procedure ChangeSupplier(in c_id int, in c_name varchar(100), in c_description varchar(1000), in c_email varchar(50))
begin
	UPDATE suppliers SET name = c_name, description = c_description, email = c_email, country = c_country WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists DeleteSupplier;
delimiter $$
create procedure DeleteSupplier(in c_id int)
begin
	DELETE FROM suppliers WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists CreateProduct;
delimiter $$
create procedure CreateProduct(in id int, in name varchar(100), in description varchar(1000), in manufacturer int, in type int, in cost decimal(17,2), in discount_cost decimal(17,2), in image varchar(100))
begin
	INSERT INTO appliances VALUES(id, name, description, manufacturer, false, type, cost, discount_cost, image);
end$$
delimiter ;

drop procedure if exists ChangeProduct;
delimiter $$
create procedure ChangeProduct(in c_id int, in c_name varchar(100), in c_description varchar(1000), in c_manufacturer int, in с_type int, in c_cost decimal(17,2), in c_discount_cost decimal(17,2), in c_image varchar(100))
begin
	IF(c_image = null) THEN
		UPDATE appliances SET name = c_name, description = c_description, manufacturer = c_manufacturer, type = c_type, cost = c_cost, discount_cost = c_discount_cost, image = (SELECT image from appliances WHERE id = c_id) WHERE id = c_id;
	ELSE
		UPDATE appliances SET name = c_name, description = c_description, manufacturer = c_manufacturer, type = c_type, cost = c_cost, discount_cost = c_discount_cost, image = c_image WHERE id = c_id;
	END IF;
end$$
delimiter ;

drop procedure if exists DeleteProduct;
delimiter $$
create procedure DeleteProduct(in c_id int)
begin
	DELETE FROM warehousesappliances WHERE product = c_id;
    DELETE FROM suppliesappliances WHERE product = c_id;
	DELETE FROM appliances WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists CreateWarehouse;
delimiter $$
create procedure CreateWarehouse(in id int, in address varchar(50), in manager int)
begin
	INSERT INTO warehouses VALUES(id, address, manager);
end$$
delimiter ;

drop procedure if exists ChangeWarehouse;
delimiter $$
create procedure ChangeWarehouse(in c_id int, in c_address varchar(50), in c_manager int)
begin
	UPDATE warehouses SET address = c_address, warehousemanager = c_manager WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists DeleteWarehouse;
delimiter $$
create procedure DeleteWarehouse(in c_id int)
begin
	DELETE FROM warehousesappliances WHERE warehouse = c_id;
	DELETE FROM warehouses WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists ChangeWarehouseProduct;
delimiter $$
create procedure ChangeWarehouseProduct(in c_id int, in c_warehouse int, in c_count int)
proc:begin
	declare row_id int;
    select id into row_id from warehousesappliances where product = c_id and warehouse = c_warehouse;
    if(row_id is null) then
		if(c_count = 0) then
			leave proc;
		else
			INSERT INTO warehousesappliances VALUES(null, c_warehouse, c_id, c_count);
		end if;
	else
		if(c_count = 0) then
			Delete from warehousesappliances where id = row_id;
		else
			UPDATE warehousesappliances SET count = c_count WHERE id = row_id;
		end if;
	end if;
end$$
delimiter ;

drop procedure if exists CreateSupply;
delimiter $$
create procedure CreateSupply(in date date, in warehouse int, in supplier int)
begin
	INSERT INTO supplies VALUES(null, date, warehouse, supplier);
end$$
delimiter ;

drop procedure if exists ChangeSupply;
delimiter $$
create procedure ChangeSupply(in c_id int, in c_date date, in c_warehouse int, in c_supplier int)
begin
	UPDATE supplies SET date = c_date, warehouse = c_warehouse, supplier = c_supplier WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists DeleteSupply;
delimiter $$
create procedure DeleteSupply(in c_id int)
begin
	DELETE FROM suppliesappliances WHERE supply = c_id;
	DELETE FROM supplies WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists ChangeSupplyProduct;
delimiter $$
create procedure ChangeSupplyProduct(in c_id int, in c_supply int, in c_count int)
proc:begin
	declare row_id int;
    select id into row_id from suppliesappliances where product = c_id and supply = c_supply;
    if(row_id is null) then
		if(c_count = 0) then
			leave proc;
		else
			INSERT INTO suppliesappliances VALUES(null, c_supply, c_id, c_count);
		end if;
	else
		if(c_count = 0) then
			Delete from suppliesappliances where id = row_id;
		else
			UPDATE suppliesappliances SET count = c_count WHERE id = row_id;
		end if;
	end if;
end$$
delimiter ;

drop procedure if exists AddMessage;
delimiter $$
create procedure AddMessage(in name varchar(50), in email varchar(50), in title varchar(50), in text varchar(1000))
begin
	INSERT INTO contactmessage VALUES(null, name, email, title, text);
end$$
delimiter ;

drop procedure if exists DeleteMessage;
delimiter $$
create procedure DeleteMessage(in c_id int)
begin
	DELETE FROM contactmessage WHERE id = c_id;
end$$
delimiter ;

drop procedure if exists AddCustomer;
delimiter $$
create procedure AddCustomer(in name varchar(20), in surname varchar(20), in lastname varchar(20), in email varchar(50), in password varchar(130), in salt varchar(50))
begin
	INSERT INTO customers VALUES(null, name, surname, lastname, email, password, salt);
end$$
delimiter ;

drop procedure if exists AddReview;
delimiter $$
create procedure AddReview(in product int, in customer int, in score int, in date date, in comment varchar(300))
begin
	INSERT INTO reviews VALUES(null, product, customer, score, date, comment);
end$$
delimiter ;

drop procedure if exists AddToCart;
delimiter $$
create procedure AddToCart(in customer int, in product int, in count int)
begin
	INSERT INTO reviews VALUES(null, customer, product, count);
end$$
delimiter ;

drop procedure if exists DeleteFromCart;
delimiter $$
create procedure DeleteFromCart(in user_id int, in product_id int)
begin
	DELETE FROM carts WHERE customer = user_id and product = product_id;
end$$
delimiter ;

drop procedure if exists AddOrder;
delimiter $$
create procedure AddOrder(in customer int, in status int, in manager int, in date date, in phone varchar(20), in deliveryCountry int, in deliveryCity varchar(50), in deliveryAddress varchar(100), in postCode int, in paymentMethod int, in cardNumber varchar(20))
begin
	if(status is null) then
		INSERT INTO orders VALUES(null, customer, 1, manager, date, phone, deliveryCountry, deliveryCity, deliveryAddress, postCode, paymentMethod, cardNumber);
	else
		INSERT INTO orders VALUES(null, customer, status, manager, date, phone, deliveryCountry, deliveryCity, deliveryAddress, postCode, paymentMethod, cardNumber);
	end if;
end$$
delimiter ;

drop procedure if exists ChangeOrderStatus;
delimiter $$
create procedure ChangeOrderStatus(in c_id int, in c_status int, in c_manager int)
begin
	UPDATE orders SET status = c_status, manager = c_manager WHERE id = c_id;
end$$
delimiter ;
