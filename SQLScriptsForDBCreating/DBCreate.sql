-- MySQL Script generated by MySQL Workbench
-- Fri Mar 20 21:38:05 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema appliancesshop
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `appliancesshop` ;

-- -----------------------------------------------------
-- Schema appliancesshop
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `appliancesshop` DEFAULT CHARACTER SET utf8 ;
USE `appliancesshop` ;

-- -----------------------------------------------------
-- Table `appliancesshop`.`countries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`countries` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`countries` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(30) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`manufacturers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`manufacturers` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`manufacturers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `Description` VARCHAR(1000) CHARACTER SET 'utf8' NOT NULL,
  `Email` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Country` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `ManufCount_idx` (`Country` ASC) VISIBLE,
  CONSTRAINT `ManufCount`
    FOREIGN KEY (`Country`)
    REFERENCES `appliancesshop`.`countries` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`typecategories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`typecategories` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`typecategories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(30) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`appliancestypes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`appliancestypes` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`appliancestypes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(30) CHARACTER SET 'utf8' NOT NULL,
  `TypeCategory` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `TypeCategory_idx` (`TypeCategory` ASC) VISIBLE,
  CONSTRAINT `TypeCategory`
    FOREIGN KEY (`TypeCategory`)
    REFERENCES `appliancesshop`.`typecategories` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 18
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`appliances`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`appliances` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`appliances` (
  `id` INT NOT NULL,
  `Name` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `Description` VARCHAR(1000) CHARACTER SET 'utf8' NOT NULL,
  `Manufacturer` INT NOT NULL,
  `StockAvailability` TINYINT NOT NULL,
  `Type` INT NOT NULL,
  `Cost` DECIMAL(17,2) NOT NULL,
  `Discount_Cost` DECIMAL(17,2) NULL DEFAULT NULL,
  `Image` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `AppType_idx` (`Type` ASC) VISIBLE,
  INDEX `AppManuf_idx` (`Manufacturer` ASC) VISIBLE,
  CONSTRAINT `AppManuf`
    FOREIGN KEY (`Manufacturer`)
    REFERENCES `appliancesshop`.`manufacturers` (`id`),
  CONSTRAINT `AppType`
    FOREIGN KEY (`Type`)
    REFERENCES `appliancesshop`.`appliancestypes` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`customers` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`customers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(20) CHARACTER SET 'utf8' NOT NULL,
  `Surname` VARCHAR(20) CHARACTER SET 'utf8' NOT NULL,
  `Lastname` VARCHAR(20) CHARACTER SET 'utf8' NOT NULL,
  `Email` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `Password` VARCHAR(130) NOT NULL,
  `Salt` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `Email` (`Email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`carts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`carts` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`carts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Customer` INT NOT NULL,
  `Product` INT NOT NULL,
  `Count` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `CartCustom_idx` (`Customer` ASC) VISIBLE,
  INDEX `CartApp_idx` (`Product` ASC) VISIBLE,
  CONSTRAINT `CartApp`
    FOREIGN KEY (`Product`)
    REFERENCES `appliancesshop`.`appliances` (`id`),
  CONSTRAINT `CartCustom`
    FOREIGN KEY (`Customer`)
    REFERENCES `appliancesshop`.`customers` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`contactmessage`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`contactmessage` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`contactmessage` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Email` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Title` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `Text` VARCHAR(1000) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`paymentmethods`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`paymentmethods` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`paymentmethods` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(30) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`orderstatuses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`orderstatuses` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`orderstatuses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`positions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`positions` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`positions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`workers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`workers` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`workers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(20) CHARACTER SET 'utf8' NOT NULL,
  `Surname` VARCHAR(20) CHARACTER SET 'utf8' NOT NULL,
  `Lastname` VARCHAR(20) CHARACTER SET 'utf8' NOT NULL,
  `Position` INT NOT NULL,
  `Salary` DECIMAL(17,2) NOT NULL,
  `Email` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `Password` VARCHAR(130) NOT NULL,
  `Salt` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `Email` (`Email` ASC) VISIBLE,
  INDEX `SupplPosit_idx` (`Position` ASC) VISIBLE,
  CONSTRAINT `SupplPosit`
    FOREIGN KEY (`Position`)
    REFERENCES `appliancesshop`.`positions` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`orders` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Customer` INT NOT NULL,
  `Status` INT NOT NULL,
  `Manager` INT NULL DEFAULT NULL,
  `Date` DATE NOT NULL,
  `Phone` VARCHAR(20) NOT NULL,
  `DeliveryCountry` INT NOT NULL,
  `DeliveryCity` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `DeliveryAddress` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `PostCode` INT NOT NULL,
  `PaymentMethod` INT NOT NULL,
  `CardNumber` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `OrderCustom_idx` (`Customer` ASC) VISIBLE,
  INDEX `OrderStatus_idx` (`Status` ASC) VISIBLE,
  INDEX `OrderWorker_idx` (`Manager` ASC) VISIBLE,
  INDEX `OrderCountry_idx` (`DeliveryCountry` ASC) VISIBLE,
  INDEX `OrderMethod_idx` (`PaymentMethod` ASC) VISIBLE,
  CONSTRAINT `OrderCountry`
    FOREIGN KEY (`DeliveryCountry`)
    REFERENCES `appliancesshop`.`countries` (`id`),
  CONSTRAINT `OrderCustom`
    FOREIGN KEY (`Customer`)
    REFERENCES `appliancesshop`.`customers` (`id`),
  CONSTRAINT `OrderMethod`
    FOREIGN KEY (`PaymentMethod`)
    REFERENCES `appliancesshop`.`paymentmethods` (`id`),
  CONSTRAINT `OrderStatus`
    FOREIGN KEY (`Status`)
    REFERENCES `appliancesshop`.`orderstatuses` (`id`),
  CONSTRAINT `OrderWorker`
    FOREIGN KEY (`Manager`)
    REFERENCES `appliancesshop`.`workers` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`ordersappliances`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`ordersappliances` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`ordersappliances` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Order` INT NOT NULL,
  `Product` INT NOT NULL,
  `Count` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `OrdAppOrder_idx` (`Order` ASC) VISIBLE,
  INDEX `OrdAppApp_idx` (`Product` ASC) VISIBLE,
  CONSTRAINT `OrdAppApp`
    FOREIGN KEY (`Product`)
    REFERENCES `appliancesshop`.`appliances` (`id`),
  CONSTRAINT `OrdAppOrder`
    FOREIGN KEY (`Order`)
    REFERENCES `appliancesshop`.`orders` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`reviews`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`reviews` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`reviews` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Product` INT NOT NULL,
  `Customer` INT NOT NULL,
  `Score` INT NOT NULL,
  `Date` DATE NOT NULL,
  `Comment` VARCHAR(300) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `ProductReview_idx` (`Product` ASC) VISIBLE,
  INDEX `CustomerReview_idx` (`Customer` ASC) VISIBLE,
  CONSTRAINT `CustomerReview`
    FOREIGN KEY (`Customer`)
    REFERENCES `appliancesshop`.`customers` (`id`),
  CONSTRAINT `ProductReview`
    FOREIGN KEY (`Product`)
    REFERENCES `appliancesshop`.`appliances` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`suppliers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`suppliers` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`suppliers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `Description` VARCHAR(1000) CHARACTER SET 'utf8' NOT NULL,
  `Email` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`warehouses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`warehouses` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`warehouses` (
  `id` INT NOT NULL,
  `Address` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `WarehouseManager` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `WarehWorker_idx` (`WarehouseManager` ASC) VISIBLE,
  CONSTRAINT `WarehWorker`
    FOREIGN KEY (`WarehouseManager`)
    REFERENCES `appliancesshop`.`workers` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`supplies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`supplies` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`supplies` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Date` DATE NOT NULL,
  `Warehouse` INT NOT NULL,
  `Supplier` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `SuppWare_idx` (`Warehouse` ASC) VISIBLE,
  INDEX `SuppSupp_idx` (`Supplier` ASC) VISIBLE,
  CONSTRAINT `SuppSupp`
    FOREIGN KEY (`Supplier`)
    REFERENCES `appliancesshop`.`suppliers` (`id`),
  CONSTRAINT `SuppWare`
    FOREIGN KEY (`Warehouse`)
    REFERENCES `appliancesshop`.`warehouses` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`suppliesappliances`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`suppliesappliances` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`suppliesappliances` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Supply` INT NOT NULL,
  `Product` INT NOT NULL,
  `Count` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `SupAppApp_idx` (`Product` ASC) VISIBLE,
  INDEX `SupAppSup_idx` (`Supply` ASC) VISIBLE,
  CONSTRAINT `SupAppApp`
    FOREIGN KEY (`Product`)
    REFERENCES `appliancesshop`.`appliances` (`id`),
  CONSTRAINT `SupAppSup`
    FOREIGN KEY (`Supply`)
    REFERENCES `appliancesshop`.`supplies` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `appliancesshop`.`warehousesappliances`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `appliancesshop`.`warehousesappliances` ;

CREATE TABLE IF NOT EXISTS `appliancesshop`.`warehousesappliances` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Warehouse` INT NOT NULL,
  `Product` INT NOT NULL,
  `Count` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `WareAppWare_idx` (`Warehouse` ASC) VISIBLE,
  INDEX `WareAppApp_idx` (`Product` ASC) VISIBLE,
  CONSTRAINT `WareAppApp`
    FOREIGN KEY (`Product`)
    REFERENCES `appliancesshop`.`appliances` (`id`),
  CONSTRAINT `WareAppWare`
    FOREIGN KEY (`Warehouse`)
    REFERENCES `appliancesshop`.`warehouses` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
