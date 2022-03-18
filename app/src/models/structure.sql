-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema mestrado
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mestrado
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mestrado` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `mestrado` ;

-- -----------------------------------------------------
-- Table `mestrado`.`rider`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mestrado`.`rider` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mestrado`.`ride`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mestrado`.`ride` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `dataset` VARCHAR(255) NOT NULL,
  `datetime` VARCHAR(255) NOT NULL,
  `totaltime` VARCHAR(255) NULL DEFAULT NULL,
  `distance` VARCHAR(255) NULL DEFAULT NULL,
  `avgspeed` VARCHAR(255) NULL,
  `minspeed` VARCHAR(255) NULL,
  `maxspeed` VARCHAR(255) NULL DEFAULT NULL,
  `calories` VARCHAR(255) NULL DEFAULT NULL,
  `avgheart` VARCHAR(255) NULL DEFAULT NULL,
  `minheart` VARCHAR(255) NULL,
  `maxheart` VARCHAR(255) NULL DEFAULT NULL,
  `temperature` VARCHAR(255) NULL,
  `avgcadence` VARCHAR(255) NULL,
  `mincadence` VARCHAR(255) NULL,
  `maxcadence` VARCHAR(255) NULL,
  `elevetion` VARCHAR(255) NULL,
  `rider_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_biking_rider_idx` (`rider_id` ASC) VISIBLE,
  CONSTRAINT `fk_biking_rider`
    FOREIGN KEY (`rider_id`)
    REFERENCES `mestrado`.`rider` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mestrado`.`trackpoint`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mestrado`.`trackpoint` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `datetime` VARCHAR(255) NULL DEFAULT NULL,
  `altitude` VARCHAR(255) NULL DEFAULT NULL,
  `distance` VARCHAR(255) NULL DEFAULT NULL,
  `heartrate` VARCHAR(255) NULL DEFAULT NULL,
  `cadence` VARCHAR(255) NULL DEFAULT NULL,
  `latitude` VARCHAR(255) NULL,
  `longitude` VARCHAR(255) NULL,
  `elevation` VARCHAR(255) NULL,
  `speed` VARCHAR(255) NULL,
  `ride_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_segment_biking1_idx` (`ride_id` ASC) VISIBLE,
  CONSTRAINT `fk_segment_biking1`
    FOREIGN KEY (`ride_id`)
    REFERENCES `mestrado`.`ride` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
