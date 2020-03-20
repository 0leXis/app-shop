use appliancesshop;
drop trigger if exists SupplyAddToWarehouse;
delimiter $$
create trigger SupplyAddToWarehouse after insert on suppliesappliances
for each row
begin
	/*Добавить на склад товары из поставки*/
	declare row_id int;
    declare wh int;
    select id into wh from supplies as s where s.id = new.supply;
    select id into row_id from warehousesappliances where product = new.product and warehouse = wh;
    if(row_id is null) then
		insert into warehousesappliances values(null, wh, new.product, new.count);
	else
		update warehousesappliances set count = count + new.count where id = row_id;
	end if;
end$$
delimiter ;

drop trigger if exists UpdateProductStateInsert;
delimiter $$
create trigger UpdateProductStateInsert after insert on warehousesappliances
for each row
begin
    /*Обновить статус товара*/    
	update appliances set stockAvailability = true where id = new.product;
end$$
delimiter ;

drop trigger if exists UpdateProductStateDelete;
delimiter $$
create trigger UpdateProductStateDelete after delete on warehousesappliances
for each row
begin
    /*Обновить статус товара*/
    if ((select Count(*) from warehousesappliances where product = old.product) = 0) then
		update appliances set stockAvailability = false where id = old.product;
	end if;
end$$
delimiter ;

drop trigger if exists AddProductsToOrder;
delimiter $$
create trigger AddProductsToOrder after insert on orders
for each row
begin
    /*Скопировать товары из корзины и добавить их в заказ*/
    insert into ordersappliances select null, new.id, product, count from carts where customer = new.customer;
    delete from carts where customer = new.customer;
end$$
delimiter ;