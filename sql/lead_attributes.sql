/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 50623
 Source Host           : localhost
 Source Database       : local_leads

 Target Server Type    : MySQL
 Target Server Version : 50623
 File Encoding         : utf-8

 Date: 04/19/2015 07:11:07 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Records of `lead_attributes`
-- ----------------------------
BEGIN;
INSERT INTO `lead_attributes` VALUES ('1', 'firstName', '2015-04-16 08:59:26', '2015-04-16 08:59:29'), ('2', 'lastName', '2015-04-16 08:59:50', '2015-04-16 08:59:52'), ('3', 'address', '2015-04-16 09:00:10', '2015-04-16 09:00:12'), ('4', 'city', '2015-04-16 09:00:21', '2015-04-16 09:00:23'), ('5', 'state', '2015-04-16 09:00:30', '2015-04-16 09:00:32'), ('6', 'postalCode', '2015-04-16 09:00:50', '2015-04-16 09:00:52'), ('7', 'phoneNumber', '2015-04-16 09:01:03', '2015-04-16 09:01:06'), ('8', 'alternatePhoneNumber', '2015-04-16 09:01:21', '2015-04-16 09:01:24'), ('9', 'bestCallTime', '2015-04-16 09:01:41', '2015-04-16 09:01:43'), ('10', 'emailAddress', '2015-04-16 09:02:57', '2015-04-16 09:03:00'), ('11', 'creditRange', '2015-04-16 09:03:42', '2015-04-16 09:03:45'), ('12', 'loanType', '2015-04-16 09:03:54', '2015-04-16 09:03:56'), ('13', 'loanAmount', '2015-04-16 09:04:06', '2015-04-16 09:04:08'), ('14', 'downPayment', '2015-04-16 09:04:22', '2015-04-16 09:04:25'), ('15', 'interestRateType', '2015-04-16 09:05:39', '2015-04-16 09:05:42'), ('16', 'propertyType', '2015-04-16 09:06:00', '2015-04-16 09:06:02'), ('17', 'propertyState', '2015-04-16 09:06:15', '2015-04-16 09:06:17'), ('18', 'propertyPostalCode', '2015-04-16 09:06:28', '2015-04-16 09:06:30'), ('19', 'notes', '2015-04-16 09:06:43', '2015-04-16 09:06:45'), ('20', 'expandedCredit', '2015-04-16 09:06:55', '2015-04-16 09:06:57');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
