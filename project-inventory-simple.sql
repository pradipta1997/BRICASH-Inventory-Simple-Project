/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : project-inventory-simple

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 22/03/2021 18:55:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_barang
-- ----------------------------
DROP TABLE IF EXISTS `tbl_barang`;
CREATE TABLE `tbl_barang`  (
  `no_urut` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipe_barang` int(11) NULL DEFAULT NULL,
  `kode_barang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_barang` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `barang_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `barang_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `barang_updated_date` datetime(0) NULL DEFAULT NULL,
  `barang_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`no_urut`) USING BTREE,
  INDEX `id_tipe_barang`(`id_tipe_barang`) USING BTREE,
  CONSTRAINT `tbl_barang_ibfk_2` FOREIGN KEY (`id_tipe_barang`) REFERENCES `tbl_tipe_barang` (`id_tipe_barang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_barang
-- ----------------------------
INSERT INTO `tbl_barang` VALUES (2, 1, '4', 'BMW 120', 1, NULL, 'superadmin', '2021-03-20 00:00:00', 'superadmin');
INSERT INTO `tbl_barang` VALUES (12, 5, '1', 'Hyosung 5600S', 1, '2021-03-19 16:12:20', 'CB_cemput', '2021-03-20 00:00:00', 'superadmin');
INSERT INTO `tbl_barang` VALUES (13, 5, '5', 'MOTOR ', 1, '2021-03-20 18:53:56', 'superadmin', NULL, NULL);

-- ----------------------------
-- Table structure for tbl_gbarang
-- ----------------------------
DROP TABLE IF EXISTS `tbl_gbarang`;
CREATE TABLE `tbl_gbarang`  (
  `id_gbarang` int(11) NOT NULL AUTO_INCREMENT,
  `nama_gbarang` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `gbarang_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `gbarang_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `gbarang_updated_date` datetime(0) NULL DEFAULT NULL,
  `gbarang_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_gbarang`) USING BTREE,
  UNIQUE INDEX `unik_gbarang`(`nama_gbarang`) USING BTREE,
  INDEX `index_tipe`(`id_gbarang`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_gbarang
-- ----------------------------
INSERT INTO `tbl_gbarang` VALUES (1, 'Sparepart', 1, '2021-02-19 09:55:00', 'superadmin', '2021-02-24 11:24:21', 'superadmin');
INSERT INTO `tbl_gbarang` VALUES (2, 'Inventaris', 1, '2021-02-19 09:55:09', 'superadmin', '2021-02-19 09:55:47', 'superadmin');

-- ----------------------------
-- Table structure for tbl_jtran
-- ----------------------------
DROP TABLE IF EXISTS `tbl_jtran`;
CREATE TABLE `tbl_jtran`  (
  `id_jtran` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jtran` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `jtran_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `jtran_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jtran_updated_date` datetime(0) NULL DEFAULT NULL,
  `jtran_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_jtran`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_jtran
-- ----------------------------
INSERT INTO `tbl_jtran` VALUES (1, 'Pengeluaran Barang', 1, '2021-03-19 08:36:34', 'superadmin', NULL, NULL);
INSERT INTO `tbl_jtran` VALUES (2, 'Penerimaan Barang Vendor', 1, '2021-03-19 08:36:43', 'superadmin', NULL, NULL);

-- ----------------------------
-- Table structure for tbl_log_login
-- ----------------------------
DROP TABLE IF EXISTS `tbl_log_login`;
CREATE TABLE `tbl_log_login`  (
  `id_log_login` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NULL DEFAULT NULL,
  `date_log` datetime(0) NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_pc` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `ip_address` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_log_login`) USING BTREE,
  INDEX `id_user`(`id_user`) USING BTREE,
  CONSTRAINT `tbl_log_login_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_log_login
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_merek
-- ----------------------------
DROP TABLE IF EXISTS `tbl_merek`;
CREATE TABLE `tbl_merek`  (
  `id_merek` int(11) NOT NULL AUTO_INCREMENT,
  `id_sgbarang` int(11) NULL DEFAULT NULL,
  `nama_merek` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `merek_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `merek_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `merek_updated_date` datetime(0) NULL DEFAULT NULL,
  `merek_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_merek`) USING BTREE,
  UNIQUE INDEX `uniq_merek`(`id_sgbarang`, `nama_merek`) USING BTREE,
  CONSTRAINT `tbl_merek_ibfk_1` FOREIGN KEY (`id_sgbarang`) REFERENCES `tbl_sgbarang` (`id_sgbarang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_merek
-- ----------------------------
INSERT INTO `tbl_merek` VALUES (1, 1, 'NCR', 1, '2021-02-19 09:56:38', 'superadmin', NULL, NULL);
INSERT INTO `tbl_merek` VALUES (2, 1, 'Hyousung', 1, '2021-02-19 09:56:48', 'superadmin', NULL, NULL);
INSERT INTO `tbl_merek` VALUES (3, 1, 'Wincore', 1, '2021-02-19 09:56:55', 'superadmin', NULL, NULL);
INSERT INTO `tbl_merek` VALUES (4, 2, 'Oki', 1, '2021-02-19 09:57:19', 'superadmin', NULL, NULL);
INSERT INTO `tbl_merek` VALUES (5, 2, 'Hyousung', 1, '2021-02-19 09:57:33', 'superadmin', NULL, NULL);
INSERT INTO `tbl_merek` VALUES (6, 3, 'BMW', 1, '2021-02-19 09:57:51', 'superadmin', NULL, NULL);
INSERT INTO `tbl_merek` VALUES (7, 4, 'Honda', 1, '2021-02-19 09:58:01', 'superadmin', NULL, NULL);
INSERT INTO `tbl_merek` VALUES (8, 4, 'Yamaha', 1, '2021-02-19 09:58:09', 'superadmin', NULL, NULL);
INSERT INTO `tbl_merek` VALUES (9, 1, 'Diebold', 1, '2021-02-24 11:31:55', 'superadmin', NULL, NULL);
INSERT INTO `tbl_merek` VALUES (10, 6, 'Hyousung', 1, '2021-02-24 11:32:34', 'superadmin', NULL, NULL);
INSERT INTO `tbl_merek` VALUES (11, 7, 'Hyousung', 0, '2021-02-24 11:32:49', 'superadmin', NULL, NULL);

-- ----------------------------
-- Table structure for tbl_sgbarang
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sgbarang`;
CREATE TABLE `tbl_sgbarang`  (
  `id_sgbarang` int(11) NOT NULL AUTO_INCREMENT,
  `id_gbarang` int(11) NULL DEFAULT NULL,
  `nama_sgbarang` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `sgbarang_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `sgbarang_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sgbarang_updated_date` datetime(0) NULL DEFAULT NULL,
  `sgbarang_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_sgbarang`) USING BTREE,
  UNIQUE INDEX `uniq_sgbarang`(`id_gbarang`, `nama_sgbarang`) USING BTREE,
  CONSTRAINT `tbl_sgbarang_ibfk_1` FOREIGN KEY (`id_gbarang`) REFERENCES `tbl_gbarang` (`id_gbarang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_sgbarang
-- ----------------------------
INSERT INTO `tbl_sgbarang` VALUES (1, 1, 'ATM', 1, '2021-02-19 09:55:59', 'superadmin', NULL, NULL);
INSERT INTO `tbl_sgbarang` VALUES (2, 1, 'CRM', 1, '2021-02-19 09:56:05', 'superadmin', NULL, NULL);
INSERT INTO `tbl_sgbarang` VALUES (3, 2, 'Mobil', 1, '2021-02-19 09:56:15', 'superadmin', NULL, NULL);
INSERT INTO `tbl_sgbarang` VALUES (4, 2, 'Motor', 1, '2021-02-19 09:56:20', 'superadmin', NULL, NULL);
INSERT INTO `tbl_sgbarang` VALUES (5, 1, 'Mesin', 1, '2021-02-24 11:29:53', 'superadmin', NULL, NULL);
INSERT INTO `tbl_sgbarang` VALUES (6, 1, 'SSB', 1, '2021-02-24 11:30:12', 'superadmin', NULL, NULL);
INSERT INTO `tbl_sgbarang` VALUES (7, 1, 'Hybrid', 1, '2021-02-24 11:30:43', 'superadmin', NULL, NULL);

-- ----------------------------
-- Table structure for tbl_stock
-- ----------------------------
DROP TABLE IF EXISTS `tbl_stock`;
CREATE TABLE `tbl_stock`  (
  `id_stock` int(11) NOT NULL AUTO_INCREMENT,
  `no_urut` int(11) NULL DEFAULT NULL,
  `id_uker` int(11) NULL DEFAULT NULL,
  `qty` int(11) NULL DEFAULT NULL,
  `stock_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `stock_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `stock_updated_date` datetime(0) NULL DEFAULT NULL,
  `stock_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_stock`) USING BTREE,
  INDEX `no_urut`(`no_urut`) USING BTREE,
  INDEX `id_uker`(`id_uker`) USING BTREE,
  CONSTRAINT `tbl_stock_ibfk_1` FOREIGN KEY (`no_urut`) REFERENCES `tbl_barang` (`no_urut`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_stock_ibfk_2` FOREIGN KEY (`id_uker`) REFERENCES `tbl_unit_kerja` (`id_uker`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_stock
-- ----------------------------
INSERT INTO `tbl_stock` VALUES (10, 2, 1, 1, '2021-03-22 17:18:42', 'superadmin', NULL, NULL);
INSERT INTO `tbl_stock` VALUES (11, 2, 22, 1, '2021-03-22 17:19:11', 'superadmin', NULL, NULL);

-- ----------------------------
-- Table structure for tbl_tipe_barang
-- ----------------------------
DROP TABLE IF EXISTS `tbl_tipe_barang`;
CREATE TABLE `tbl_tipe_barang`  (
  `id_tipe_barang` int(11) NOT NULL AUTO_INCREMENT,
  `id_merek` int(11) NULL DEFAULT NULL,
  `tipe_barang` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `tbarang_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `tbarang_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tbarang_updated_date` datetime(0) NULL DEFAULT NULL,
  `tbarang_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipe_barang`) USING BTREE,
  UNIQUE INDEX `uniq_tipe`(`id_merek`, `tipe_barang`) USING BTREE,
  INDEX `index`(`id_tipe_barang`, `tipe_barang`) USING BTREE,
  CONSTRAINT `tbl_tipe_barang_ibfk_1` FOREIGN KEY (`id_merek`) REFERENCES `tbl_merek` (`id_merek`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_tipe_barang
-- ----------------------------
INSERT INTO `tbl_tipe_barang` VALUES (1, 6, 'BMW 100', 1, '2021-02-19 09:59:21', 'superadmin', '2021-03-19 09:39:38', 'superadmin');
INSERT INTO `tbl_tipe_barang` VALUES (2, 7, 'Honda Beat', 1, '2021-02-19 09:59:35', 'superadmin', '2021-03-19 09:39:31', 'superadmin');
INSERT INTO `tbl_tipe_barang` VALUES (3, 7, 'Honda Drokdok', 1, '2021-02-19 09:59:56', 'superadmin', '2021-03-19 09:39:27', 'superadmin');
INSERT INTO `tbl_tipe_barang` VALUES (4, 8, 'Yamaha Mio', 1, '2021-02-19 10:00:11', 'superadmin', '2021-03-19 09:39:23', 'superadmin');
INSERT INTO `tbl_tipe_barang` VALUES (5, 2, 'Hyosung 5600', 1, '2021-02-24 11:33:43', 'superadmin', '2021-03-19 09:39:19', 'superadmin');
INSERT INTO `tbl_tipe_barang` VALUES (6, 7, 'Honda Yamaha', 1, '2021-03-20 18:36:05', 'superadmin', NULL, NULL);

-- ----------------------------
-- Table structure for tbl_transaksi
-- ----------------------------
DROP TABLE IF EXISTS `tbl_transaksi`;
CREATE TABLE `tbl_transaksi`  (
  `id_tran` int(11) NOT NULL AUTO_INCREMENT,
  `id_jtran` int(11) NULL DEFAULT NULL,
  `id_vendor` int(11) NULL DEFAULT NULL,
  `id_uker` int(11) NULL DEFAULT NULL COMMENT 'ke uker',
  `dari_uker` int(11) NULL DEFAULT NULL,
  `no_urut` int(11) NULL DEFAULT NULL,
  `no_referensi` int(11) NULL DEFAULT NULL,
  `tgl_terima_barang` date NULL DEFAULT NULL,
  `tgl_kirim_barang` date NULL DEFAULT NULL,
  `no_sn` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kon_barang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `qty` int(11) NULL DEFAULT NULL,
  `harga_barang` int(11) NULL DEFAULT NULL,
  `remark` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `is_have` int(1) NULL DEFAULT NULL COMMENT 'sudah di terima = 1,0 = belum',
  `tran_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `tran_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tran_updated_date` datetime(0) NULL DEFAULT NULL,
  `tran_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_tran`) USING BTREE,
  INDEX `id_jtran`(`id_jtran`) USING BTREE,
  INDEX `id_vendor`(`id_vendor`) USING BTREE,
  INDEX `no_urut`(`no_urut`) USING BTREE,
  INDEX `id_uker`(`id_uker`) USING BTREE,
  CONSTRAINT `tbl_transaksi_ibfk_1` FOREIGN KEY (`id_jtran`) REFERENCES `tbl_jtran` (`id_jtran`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_transaksi_ibfk_3` FOREIGN KEY (`id_vendor`) REFERENCES `tbl_vendor` (`id_vendor`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_transaksi_ibfk_4` FOREIGN KEY (`no_urut`) REFERENCES `tbl_barang` (`no_urut`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_transaksi_ibfk_5` FOREIGN KEY (`id_uker`) REFERENCES `tbl_unit_kerja` (`id_uker`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_transaksi
-- ----------------------------
INSERT INTO `tbl_transaksi` VALUES (1, 2, 2, 1, NULL, 2, 123, '2021-03-22', NULL, '123', 'Bagus', 1, 100, '-', 1, NULL, '2021-03-22 17:18:42', 'superadmin', NULL, NULL);
INSERT INTO `tbl_transaksi` VALUES (2, 2, 2, 1, NULL, 2, 321, '2021-03-22', NULL, '321', 'Bagus', 1, 100, '-', 1, NULL, '2021-03-22 17:18:57', 'superadmin', NULL, NULL);
INSERT INTO `tbl_transaksi` VALUES (3, 1, 1, 22, 1, 2, NULL, '2021-03-22', '2021-03-22', '123', 'Bagus', 1, 100, 'Done !', 1, 1, '2021-03-22 17:19:11', 'superadmin', '2021-03-22 00:00:00', 'CB_cemput');

-- ----------------------------
-- Table structure for tbl_unit_kerja
-- ----------------------------
DROP TABLE IF EXISTS `tbl_unit_kerja`;
CREATE TABLE `tbl_unit_kerja`  (
  `id_uker` int(11) NOT NULL AUTO_INCREMENT,
  `kode_uker` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_uker` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ket_uker` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `uker_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `uker_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `uker_updated_date` datetime(0) NULL DEFAULT NULL,
  `uker_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_uker`) USING BTREE,
  UNIQUE INDEX `uniq_uker`(`kode_uker`, `nama_uker`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_unit_kerja
-- ----------------------------
INSERT INTO `tbl_unit_kerja` VALUES (1, '9', 'Pengadaan', '', 1, '2021-02-19 09:34:01', 'superadmin', NULL, NULL);
INSERT INTO `tbl_unit_kerja` VALUES (2, '0037', 'Cabang Banda Aceh', '', NULL, '2021-02-24 11:50:10', 'superadmin', '2021-02-24 11:51:39', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (3, '0042', 'Cabang Langsa', '', NULL, '2021-02-24 11:51:52', 'superadmin', NULL, NULL);
INSERT INTO `tbl_unit_kerja` VALUES (4, '0043', 'Cabang Lhok Seumawe (Aceh Utara)', '', NULL, '2021-02-24 11:52:15', 'superadmin', NULL, NULL);
INSERT INTO `tbl_unit_kerja` VALUES (5, '0087', 'Cabang Sigli (Aceh Pidie)', '', NULL, '2021-02-24 11:52:26', 'superadmin', '2021-02-24 12:46:40', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (6, '0145', 'Cabang Takengon (Aceh Tengah/Gayo)', '', NULL, '2021-02-24 11:52:39', 'superadmin', '2021-02-24 12:46:46', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (7, '0178', 'Cabang Meulaboh (Aceh Barat)', '', NULL, '2021-02-24 11:52:53', 'superadmin', '2021-02-24 12:46:51', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (8, '0234', 'Cabang Bireun (Aceh Jeumpa)', '', NULL, '2021-02-24 11:53:14', 'superadmin', '2021-02-24 12:46:56', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (9, '0263', 'Cabang Kutacane', '', NULL, '2021-02-24 11:53:34', 'superadmin', '2021-02-24 12:47:02', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (10, '0264', 'Cabang Tapak Tuan (Aceh Selatan)', '', NULL, '2021-02-24 11:53:46', 'superadmin', '2021-02-24 12:47:13', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (11, '0264', 'Cabang Tapak Tuan(Aceh Selatan)', '', NULL, '2021-02-24 11:54:00', 'superadmin', '2021-02-24 12:49:44', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (12, '0265', 'Cabang Blang Pidie (Aceh Barat)', '', NULL, '2021-02-24 11:54:17', 'superadmin', '2021-02-24 12:48:27', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (13, '657', 'Cabang Kuala Simpang', '', NULL, '2021-02-24 11:54:34', 'superadmin', '2021-02-24 12:47:49', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (14, '0607', 'Cabang KC Rimbo Bujang', '', NULL, '2021-02-24 12:45:26', 'superadmin', '2021-02-24 12:48:51', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (15, '0626', 'Cabang KC SENDAWAR', '', 1, '2021-02-24 12:45:44', 'superadmin', '2021-02-24 12:49:10', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (16, '0001', 'Cabang KCK TiMOR LESTE', '', 1, '2021-02-24 12:45:54', 'superadmin', '2021-02-24 12:49:19', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (21, '2', '2', '2', 1, '2021-03-15 17:05:06', 'superadmin', '2021-03-15 17:05:12', 'superadmin');
INSERT INTO `tbl_unit_kerja` VALUES (22, '0087', 'Cempaka Putih', '-', 1, '2021-03-15 17:08:18', 'superadmin', '2021-03-15 17:08:24', 'superadmin');

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user`  (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_sgroup` int(11) NULL DEFAULT NULL,
  `id_uker` int(11) NULL DEFAULT NULL,
  `nama_user` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `user_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `user_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_updated_date` datetime(0) NULL DEFAULT NULL,
  `user_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  UNIQUE INDEX `uniq_user`(`id_sgroup`, `username`) USING BTREE,
  INDEX `id_group`(`id_sgroup`) USING BTREE,
  INDEX `id_uker`(`id_uker`) USING BTREE,
  CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`id_sgroup`) REFERENCES `tbl_user_subgroup` (`id_subgroup`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_user_ibfk_2` FOREIGN KEY (`id_uker`) REFERENCES `tbl_unit_kerja` (`id_uker`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES (1, 1, 1, 'Superadmin', 'superadmin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, '2021-02-18 14:33:49', 'Superadmin', NULL, NULL);
INSERT INTO `tbl_user` VALUES (12, 8, 22, 'Cabang Cempaka Putih', 'CB_cemput', 'adcd7048512e64b48da55b027577886ee5a36350', 1, '2021-03-15 17:09:04', 'superadmin', '2021-03-15 19:19:52', 'superadmin');

-- ----------------------------
-- Table structure for tbl_user_group
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_group`;
CREATE TABLE `tbl_user_group`  (
  `id_group` int(11) NOT NULL AUTO_INCREMENT,
  `nama_group` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `group_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `group_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `group_updated_date` datetime(0) NULL DEFAULT NULL,
  `group_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_group`) USING BTREE,
  UNIQUE INDEX `index_tipe`(`nama_group`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_user_group
-- ----------------------------
INSERT INTO `tbl_user_group` VALUES (1, 'Superadmin', 1, '2021-02-18 14:34:13', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_group` VALUES (3, 'Admin', 1, '2021-02-22 19:14:46', 'superadmin', '2021-03-15 17:09:32', 'superadmin');

-- ----------------------------
-- Table structure for tbl_user_log
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_log`;
CREATE TABLE `tbl_user_log`  (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NULL DEFAULT NULL,
  `query` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id_log`) USING BTREE,
  INDEX `id_user`(`id_user`) USING BTREE,
  CONSTRAINT `tbl_user_log_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_user_log
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_user_menu
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_menu`;
CREATE TABLE `tbl_user_menu`  (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `url_menu` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `parent_id` int(11) NULL DEFAULT NULL,
  `sort_order` int(11) NULL DEFAULT NULL,
  `show_in_menu` int(1) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL COMMENT '0 = not, 1 = aktif',
  `menu_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `menu_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `menu_updated_date` datetime(0) NULL DEFAULT NULL,
  `menu_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_menu`) USING BTREE,
  INDEX `uniq`(`nama_menu`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 104 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_user_menu
-- ----------------------------
INSERT INTO `tbl_user_menu` VALUES (1, 'Dashboard', 'Dashboard', 0, 1, 1, 1, '2021-02-24 16:10:39', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (2, 'Master Data', '#', 0, 2, 1, 1, '2021-02-24 16:11:17', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (3, 'Master Menu', 'Menu', 2, 1, 1, 1, '2021-02-24 16:11:44', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (4, 'Master Group User', 'Groupuser', 2, 2, 1, 1, '2021-02-24 16:16:41', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (5, 'Master Subgroup User', 'Subgroupuser', 2, 3, 1, 1, '2021-02-24 16:17:19', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (6, 'Master User', 'User', 2, 4, 1, 1, '2021-02-24 16:26:34', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (7, 'Master Unit Kerja', 'Unitkerja', 2, 5, 1, 1, '2021-02-24 16:43:33', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (59, 'Gudang', '#', 0, 4, 1, 1, '2021-03-05 09:54:38', 'superadmin', '2021-03-05 09:55:06', 'superadmin');
INSERT INTO `tbl_user_menu` VALUES (60, 'Master Barang', 'Barang', 2, 11, 1, 1, '2021-03-05 09:56:22', 'superadmin', '2021-03-20 18:56:33', 'superadmin');
INSERT INTO `tbl_user_menu` VALUES (88, 'Penerimaan Barang Vendor', 'Penbar', 59, 5, 1, 1, '2021-03-15 16:43:55', 'superadmin', '2021-03-20 18:55:24', 'superadmin');
INSERT INTO `tbl_user_menu` VALUES (89, 'Pengeluaran Barang', 'Pengbar', 59, 5, 1, 1, '2021-03-15 16:44:47', 'superadmin', '2021-03-20 18:54:48', 'superadmin');
INSERT INTO `tbl_user_menu` VALUES (91, 'Master Group Barang', 'Groupbarang', 2, 6, 1, 1, '2021-03-16 08:11:28', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (92, 'Master Subgroup Barang', 'Subgroupbarang', 2, 7, 1, 1, '2021-03-16 08:12:08', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (93, 'Master Merek Barang', 'Merekbarang', 2, 8, 1, 1, '2021-03-16 08:12:37', 'superadmin', '2021-03-16 08:13:19', 'superadmin');
INSERT INTO `tbl_user_menu` VALUES (94, 'Master Tipe Barang', 'Tipebarang', 2, 9, 1, 1, '2021-03-16 08:13:11', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (95, 'Penerimaan Barang Cabang', 'Penbarcab', 59, 4, 1, 1, '2021-03-18 20:47:11', 'superadmin', '2021-03-20 18:54:43', 'superadmin');
INSERT INTO `tbl_user_menu` VALUES (96, 'Master Vendor', 'Vendor', 2, 10, 1, 1, '2021-03-19 08:05:55', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (97, 'Master Jenis Transaksi', 'Jtran', 2, 11, 1, 1, '2021-03-19 08:25:08', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (98, 'Stock Barang', 'Stockbarang', 59, 2, 1, 1, '2021-03-20 18:54:21', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (99, 'Stock Global', 'Stockglobal', 59, 7, 1, 1, '2021-03-20 21:02:12', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (100, 'Laporan', '#', 0, 4, 1, 1, '2021-03-22 10:07:52', 'superadmin', NULL, NULL);
INSERT INTO `tbl_user_menu` VALUES (101, 'Laporan Pengeluaran Barang', 'Laporanbarang', 100, 1, 1, 1, '2021-03-22 10:08:40', 'superadmin', '2021-03-22 18:38:49', 'superadmin');
INSERT INTO `tbl_user_menu` VALUES (102, 'Laporan Penerimaan Barang <br> Vendor', 'Laporanbarang/Penbarven', 100, 2, 1, 1, '2021-03-22 13:32:43', 'superadmin', '2021-03-22 13:36:43', 'superadmin');

-- ----------------------------
-- Table structure for tbl_user_permission
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_permission`;
CREATE TABLE `tbl_user_permission`  (
  `id_per` int(11) NOT NULL AUTO_INCREMENT,
  `id_sgroup` int(11) NULL DEFAULT NULL,
  `id_menu` int(11) NULL DEFAULT NULL,
  `per_select` int(1) NULL DEFAULT NULL,
  `per_insert` int(1) NULL DEFAULT NULL,
  `per_update` int(1) NULL DEFAULT NULL,
  `per_delete` int(1) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `per_created_date` datetime(0) NULL DEFAULT NULL,
  `per_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `per_updated_date` datetime(0) NULL DEFAULT NULL,
  `per_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_per`) USING BTREE,
  INDEX `id_group`(`id_sgroup`) USING BTREE,
  INDEX `id_menu`(`id_menu`) USING BTREE,
  CONSTRAINT `tbl_user_permission_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `tbl_user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_user_permission_ibfk_3` FOREIGN KEY (`id_sgroup`) REFERENCES `tbl_user_subgroup` (`id_subgroup`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 82 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_user_permission
-- ----------------------------
INSERT INTO `tbl_user_permission` VALUES (1, 1, 1, 1, 0, 0, 0, 1, '2021-02-24 16:13:43', 'superadmin', '2021-03-22 10:08:06', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (2, 1, 2, 1, 0, 0, 0, 1, '2021-02-24 16:13:55', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (3, 1, 3, 1, 1, 1, 1, 1, '2021-02-24 16:14:26', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (4, 1, 4, 1, 1, 1, 1, NULL, '2021-02-24 16:29:21', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (5, 1, 5, 1, 1, 1, 1, NULL, '2021-02-24 16:29:21', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (6, 1, 6, 1, 1, 1, 1, NULL, '2021-02-24 16:29:21', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (7, 1, 7, 0, 0, 0, 0, NULL, '2021-02-24 19:02:46', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (39, 1, 59, 1, 0, 0, 0, NULL, '2021-03-05 09:55:16', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (40, 1, 60, 0, 0, 0, 0, NULL, '2021-03-08 09:12:24', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (49, 8, 1, 1, 0, 0, 0, NULL, '2021-03-15 19:19:17', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (50, 8, 2, 0, 0, 0, 0, NULL, '2021-03-15 19:19:17', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (51, 8, 3, 0, 0, 0, 0, NULL, '2021-03-15 19:19:17', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (52, 8, 4, 0, 0, 0, 0, NULL, '2021-03-15 19:19:17', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (53, 8, 5, 0, 0, 0, 0, NULL, '2021-03-15 19:19:17', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (54, 8, 6, 0, 0, 0, 0, NULL, '2021-03-15 19:19:17', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (55, 8, 7, 0, 0, 0, 0, NULL, '2021-03-15 19:19:17', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (56, 8, 59, 1, 0, 0, 0, NULL, '2021-03-15 19:19:17', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (57, 8, 60, 1, 1, 1, 1, NULL, '2021-03-15 19:19:17', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (58, 8, 88, 0, 0, 0, 0, NULL, '2021-03-15 19:19:17', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (59, 8, 89, 1, 1, 0, 0, NULL, '2021-03-15 19:19:17', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (61, 8, 91, 0, 0, 0, 0, NULL, '2021-03-19 13:32:50', 'superadmin', '2021-03-21 10:09:31', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (62, 8, 92, 0, 0, 0, 0, NULL, '2021-03-19 13:32:50', 'superadmin', '2021-03-21 10:09:32', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (63, 8, 93, 0, 0, 0, 0, NULL, '2021-03-19 13:32:50', 'superadmin', '2021-03-21 10:09:32', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (64, 8, 94, 0, 0, 0, 0, NULL, '2021-03-19 13:32:50', 'superadmin', '2021-03-21 10:09:32', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (65, 8, 95, 1, 0, 1, 0, NULL, '2021-03-19 13:32:50', 'superadmin', '2021-03-21 10:09:32', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (66, 8, 96, 0, 0, 0, 0, NULL, '2021-03-19 13:32:50', 'superadmin', '2021-03-21 10:09:32', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (67, 8, 97, 0, 0, 0, 0, NULL, '2021-03-19 13:32:51', 'superadmin', '2021-03-21 10:09:32', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (68, 8, 98, 1, 0, 0, 0, NULL, '2021-03-20 20:32:57', 'superadmin', '2021-03-21 10:09:32', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (69, 8, 99, 1, 0, 0, 0, NULL, '2021-03-20 23:31:52', 'superadmin', '2021-03-21 10:09:32', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (70, 1, 88, 0, 0, 0, 0, NULL, '2021-03-21 10:08:54', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (71, 1, 89, 0, 0, 0, 0, NULL, '2021-03-21 10:08:54', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (72, 1, 91, 0, 0, 0, 0, NULL, '2021-03-21 10:08:54', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (73, 1, 92, 0, 0, 0, 0, NULL, '2021-03-21 10:08:54', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (74, 1, 93, 0, 0, 0, 0, NULL, '2021-03-21 10:08:54', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (75, 1, 94, 0, 0, 0, 0, NULL, '2021-03-21 10:08:54', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (76, 1, 95, 0, 0, 0, 0, NULL, '2021-03-21 10:08:54', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (77, 1, 96, 0, 0, 0, 0, NULL, '2021-03-21 10:08:54', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (78, 1, 97, 0, 0, 0, 0, NULL, '2021-03-21 10:08:54', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (79, 1, 98, 0, 0, 0, 0, NULL, '2021-03-21 10:08:54', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (80, 1, 99, 1, 0, 0, 0, NULL, '2021-03-21 10:08:54', 'superadmin', '2021-03-22 10:08:07', 'superadmin');
INSERT INTO `tbl_user_permission` VALUES (81, 1, 100, 1, 0, 0, 0, NULL, '2021-03-22 10:08:07', 'superadmin', NULL, NULL);

-- ----------------------------
-- Table structure for tbl_user_subgroup
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_subgroup`;
CREATE TABLE `tbl_user_subgroup`  (
  `id_subgroup` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` int(11) NULL DEFAULT NULL,
  `nama_subgroup` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `usubgroup_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `usubgroup_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `usubgroup_updated_date` datetime(0) NULL DEFAULT NULL,
  `usubgroup_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_subgroup`) USING BTREE,
  UNIQUE INDEX `index_tipe`(`id_group`, `nama_subgroup`) USING BTREE,
  INDEX `id_group`(`id_group`) USING BTREE,
  CONSTRAINT `tbl_user_subgroup_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `tbl_user_group` (`id_group`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tbl_user_subgroup
-- ----------------------------
INSERT INTO `tbl_user_subgroup` VALUES (1, 1, 'Superadmin Pusat', 1, '2021-02-18 14:34:32', 'Superadmin', NULL, NULL);
INSERT INTO `tbl_user_subgroup` VALUES (8, 3, 'Cabang Cempaka Putih', 1, '2021-03-15 17:01:17', 'superadmin', NULL, NULL);

-- ----------------------------
-- Table structure for tbl_vendor
-- ----------------------------
DROP TABLE IF EXISTS `tbl_vendor`;
CREATE TABLE `tbl_vendor`  (
  `id_vendor` int(11) NOT NULL AUTO_INCREMENT,
  `nama_vendor` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telp_vendor` char(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_vendor` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `nama_pic` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telp_pic` char(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ket` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `is_active` int(1) NULL DEFAULT NULL,
  `vendor_created_date` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `vendor_created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `vendor_updated_date` datetime(0) NULL DEFAULT NULL,
  `vendor_updated_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_vendor`) USING BTREE,
  UNIQUE INDEX `uniq_sup`(`nama_vendor`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_vendor
-- ----------------------------
INSERT INTO `tbl_vendor` VALUES (1, '-', '-', '-', '-', '-', '-', 1, '2021-03-19 08:47:53', 'superadmin', NULL, NULL);
INSERT INTO `tbl_vendor` VALUES (2, '89 ELEKTRONIK', '', 'Komp. Citra Garden 2 Ext BH7 No. 18 (Pos 8) Kalideres, Pengadugan, Jakarta Barat 11830', '', '08567577877', NULL, 1, '2021-02-24 13:28:17', 'superadmin', NULL, NULL);
INSERT INTO `tbl_vendor` VALUES (4, 'ACE HARDWARE', '', 'Living Plaza, Jalan Jend Soedirman, Purwokerto Timur, Kabupaten Banyumas, Jawa Tengah, 53116\r\nPURWOKERTO', '', '', NULL, NULL, '2021-02-24 13:40:42', 'superadmin', NULL, NULL);
INSERT INTO `tbl_vendor` VALUES (5, 'ACE HARDWARE -JATINEGARA', '', 'Jl. Matraman Raya No. 173-175 RT.02 / RW.06 Jatinegara - Jakarta Timur\r\nJakarta Timur', '', '', NULL, 1, '2021-02-24 13:41:09', 'superadmin', NULL, NULL);
INSERT INTO `tbl_vendor` VALUES (6, 'ACE HARDWARE SOLO', '02717891262', 'Hartono Lifestyle Mall, Jl.Solo-Wonogiri, Madegondo, Grogol, Kab.Sukoharjo, Jateng 57552\r\nSukoharjo', '', '', NULL, 1, '2021-02-24 13:41:38', 'superadmin', NULL, NULL);
INSERT INTO `tbl_vendor` VALUES (7, 'ACE HARDWARE SURABAYA', '03151205488', 'Jl.Walikota Mustajab & Kusuma Bangsa 60272 Surabaya - Jawa Timur', '', '', NULL, NULL, '2021-02-24 13:42:13', 'superadmin', NULL, NULL);
INSERT INTO `tbl_vendor` VALUES (8, 'ACE HARDWARE YOGYAKARTA', '02744331422', 'Jl. Laksda Adi Sucipto No.80 Ambarukmo Plaza Lt.3 Yogyakarta\r\nYogyakarta', '', '', NULL, NULL, '2021-02-24 13:42:39', 'superadmin', NULL, NULL);
INSERT INTO `tbl_vendor` VALUES (9, 'ARIOS CELLULAR', '', 'Plaza Kalibata Lt.Dasar No.30 ( Depan KFC ) Telp.021-7980122, 7993634\r\nJAKARTA', 'Bpk.Irwan', '082297667808', NULL, NULL, '2021-02-24 13:43:40', 'superadmin', NULL, NULL);
INSERT INTO `tbl_vendor` VALUES (10, 'ARS PANEL ELECTRIC', '0213902805', 'Pasar Kenari Lama Lt. Dasar AKS 154 Jl. Salemba Raya - Jakarta Pusat', 'WIDODO', '081807141481', 'Battery Lithium Power CR123-3V', 1, '2021-02-24 13:47:53', 'superadmin', NULL, NULL);

-- ----------------------------
-- View structure for v_barang
-- ----------------------------
DROP VIEW IF EXISTS `v_barang`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_barang` AS select `tbl_gbarang`.`id_gbarang` AS `id_gbarang`,`tbl_gbarang`.`nama_gbarang` AS `nama_gbarang`,`tbl_sgbarang`.`id_sgbarang` AS `id_sgbarang`,`tbl_sgbarang`.`nama_sgbarang` AS `nama_sgbarang`,`tbl_merek`.`id_merek` AS `id_merek`,`tbl_merek`.`nama_merek` AS `nama_merek`,`tbl_tipe_barang`.`id_tipe_barang` AS `id_tipe_barang`,`tbl_tipe_barang`.`tipe_barang` AS `tipe_barang`,`tbl_barang`.`no_urut` AS `no_urut`,`tbl_barang`.`kode_barang` AS `kode_barang`,`tbl_barang`.`nama_barang` AS `nama_barang`,`tbl_barang`.`is_active` AS `is_active` from ((((`tbl_gbarang` join `tbl_sgbarang` on((`tbl_gbarang`.`id_gbarang` = `tbl_sgbarang`.`id_gbarang`))) join `tbl_merek` on((`tbl_sgbarang`.`id_sgbarang` = `tbl_merek`.`id_sgbarang`))) join `tbl_tipe_barang` on((`tbl_merek`.`id_merek` = `tbl_tipe_barang`.`id_merek`))) join `tbl_barang` on((`tbl_tipe_barang`.`id_tipe_barang` = `tbl_barang`.`id_tipe_barang`)));

-- ----------------------------
-- View structure for v_detailstock
-- ----------------------------
DROP VIEW IF EXISTS `v_detailstock`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_detailstock` AS select `tbl_barang`.`no_urut` AS `no_urut`,`tbl_unit_kerja`.`nama_uker` AS `nama_uker`,`tbl_barang`.`nama_barang` AS `nama_barang`,`tbl_stock`.`qty` AS `qty` from ((`tbl_barang` join `tbl_stock` on((`tbl_barang`.`no_urut` = `tbl_stock`.`no_urut`))) join `tbl_unit_kerja` on((`tbl_stock`.`id_uker` = `tbl_unit_kerja`.`id_uker`)));

-- ----------------------------
-- View structure for v_merek
-- ----------------------------
DROP VIEW IF EXISTS `v_merek`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_merek` AS select `tbl_merek`.`id_merek` AS `id_merek`,`tbl_merek`.`id_sgbarang` AS `id_sgbarang`,`tbl_merek`.`nama_merek` AS `nama_merek`,`tbl_merek`.`is_active` AS `is_active`,`tbl_merek`.`merek_created_date` AS `merek_created_date`,`tbl_merek`.`merek_created_by` AS `merek_created_by`,`tbl_merek`.`merek_updated_date` AS `merek_updated_date`,`tbl_merek`.`merek_updated_by` AS `merek_updated_by`,`tbl_sgbarang`.`id_gbarang` AS `id_gbarang`,`tbl_sgbarang`.`nama_sgbarang` AS `nama_sgbarang`,`tbl_gbarang`.`nama_gbarang` AS `nama_gbarang` from ((`tbl_merek` join `tbl_sgbarang` on((`tbl_merek`.`id_sgbarang` = `tbl_sgbarang`.`id_sgbarang`))) join `tbl_gbarang` on((`tbl_sgbarang`.`id_gbarang` = `tbl_gbarang`.`id_gbarang`)));

-- ----------------------------
-- View structure for v_nosn
-- ----------------------------
DROP VIEW IF EXISTS `v_nosn`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_nosn` AS select `tbl_transaksi`.`no_sn` AS `no_sn`,`tbl_transaksi`.`no_urut` AS `no_urut`,`tbl_barang`.`nama_barang` AS `nama_barang`,`tbl_barang`.`id_tipe_barang` AS `id_tipe_barang`,`tbl_tipe_barang`.`id_merek` AS `id_merek`,`tbl_tipe_barang`.`tipe_barang` AS `tipe_barang`,`tbl_merek`.`nama_merek` AS `nama_merek`,`tbl_merek`.`id_sgbarang` AS `id_sgbarang`,`tbl_sgbarang`.`nama_sgbarang` AS `nama_sgbarang`,`tbl_sgbarang`.`id_gbarang` AS `id_gbarang`,`tbl_gbarang`.`nama_gbarang` AS `nama_gbarang`,`tbl_transaksi`.`harga_barang` AS `harga_barang`,`tbl_barang`.`kode_barang` AS `kode_barang` from (((((`tbl_transaksi` join `tbl_barang` on((`tbl_transaksi`.`no_urut` = `tbl_barang`.`no_urut`))) join `tbl_tipe_barang` on((`tbl_barang`.`id_tipe_barang` = `tbl_tipe_barang`.`id_tipe_barang`))) join `tbl_merek` on((`tbl_tipe_barang`.`id_merek` = `tbl_merek`.`id_merek`))) join `tbl_sgbarang` on((`tbl_merek`.`id_sgbarang` = `tbl_sgbarang`.`id_sgbarang`))) join `tbl_gbarang` on((`tbl_sgbarang`.`id_gbarang` = `tbl_gbarang`.`id_gbarang`)));

-- ----------------------------
-- View structure for v_penbarcab
-- ----------------------------
DROP VIEW IF EXISTS `v_penbarcab`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_penbarcab` AS select `tbl_gbarang`.`id_gbarang` AS `id_gbarang`,`tbl_gbarang`.`nama_gbarang` AS `nama_gbarang`,`tbl_sgbarang`.`id_sgbarang` AS `id_sgbarang`,`tbl_sgbarang`.`nama_sgbarang` AS `nama_sgbarang`,`tbl_merek`.`id_merek` AS `id_merek`,`tbl_merek`.`nama_merek` AS `nama_merek`,`tbl_tipe_barang`.`id_tipe_barang` AS `id_tipe_barang`,`tbl_tipe_barang`.`tipe_barang` AS `tipe_barang`,`tbl_barang`.`no_urut` AS `no_urut`,`tbl_barang`.`kode_barang` AS `kode_barang`,`tbl_barang`.`nama_barang` AS `nama_barang`,`tbl_transaksi`.`id_tran` AS `id_tran`,`tbl_transaksi`.`id_jtran` AS `id_jtran`,`tbl_transaksi`.`id_uker` AS `id_uker`,`tbl_transaksi`.`dari_uker` AS `dari_uker`,`tbl_transaksi`.`no_sn` AS `no_sn`,`tbl_transaksi`.`kon_barang` AS `kon_barang`,`tbl_transaksi`.`qty` AS `qty`,`tbl_transaksi`.`harga_barang` AS `harga_barang`,`tbl_transaksi`.`remark` AS `remark`,`tbl_transaksi`.`is_active` AS `is_active`,`tbl_transaksi`.`is_have` AS `is_have`,`tbl_unit_kerja`.`nama_uker` AS `nama_uker`,`tbl_transaksi`.`tgl_terima_barang` AS `tgl_terima_barang`,`tbl_transaksi`.`tgl_kirim_barang` AS `tgl_kirim_barang` from ((((((`tbl_gbarang` join `tbl_sgbarang` on((`tbl_gbarang`.`id_gbarang` = `tbl_sgbarang`.`id_gbarang`))) join `tbl_merek` on((`tbl_sgbarang`.`id_sgbarang` = `tbl_merek`.`id_sgbarang`))) join `tbl_tipe_barang` on((`tbl_merek`.`id_merek` = `tbl_tipe_barang`.`id_merek`))) join `tbl_barang` on((`tbl_tipe_barang`.`id_tipe_barang` = `tbl_barang`.`id_tipe_barang`))) join `tbl_transaksi` on((`tbl_barang`.`no_urut` = `tbl_transaksi`.`no_urut`))) join `tbl_unit_kerja` on((`tbl_transaksi`.`id_uker` = `tbl_unit_kerja`.`id_uker`))) where (`tbl_transaksi`.`id_jtran` = 1);

-- ----------------------------
-- View structure for v_penbarven
-- ----------------------------
DROP VIEW IF EXISTS `v_penbarven`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_penbarven` AS select `tbl_tipe_barang`.`id_tipe_barang` AS `id_tipe_barang`,`tbl_tipe_barang`.`tipe_barang` AS `tipe_barang`,`tbl_barang`.`no_urut` AS `no_urut`,`tbl_barang`.`kode_barang` AS `kode_barang`,`tbl_barang`.`nama_barang` AS `nama_barang`,`tbl_transaksi`.`id_tran` AS `id_tran`,`tbl_transaksi`.`id_vendor` AS `id_vendor`,`tbl_transaksi`.`id_uker` AS `id_uker`,`tbl_transaksi`.`no_sn` AS `no_sn`,`tbl_transaksi`.`kon_barang` AS `kon_barang`,`tbl_transaksi`.`qty` AS `qty`,`tbl_transaksi`.`harga_barang` AS `harga_barang`,`tbl_transaksi`.`remark` AS `remark`,`tbl_transaksi`.`is_active` AS `is_active`,`tbl_vendor`.`nama_vendor` AS `nama_vendor`,`tbl_unit_kerja`.`nama_uker` AS `nama_uker`,`tbl_transaksi`.`id_jtran` AS `id_jtran`,`tbl_transaksi`.`no_referensi` AS `no_referensi`,`tbl_transaksi`.`tgl_terima_barang` AS `tgl_terima_barang` from ((((`tbl_tipe_barang` join `tbl_barang` on((`tbl_tipe_barang`.`id_tipe_barang` = `tbl_barang`.`id_tipe_barang`))) join `tbl_transaksi` on((`tbl_barang`.`no_urut` = `tbl_transaksi`.`no_urut`))) join `tbl_vendor` on((`tbl_transaksi`.`id_vendor` = `tbl_vendor`.`id_vendor`))) join `tbl_unit_kerja` on((`tbl_transaksi`.`id_uker` = `tbl_unit_kerja`.`id_uker`))) where (`tbl_transaksi`.`id_jtran` = 2);

-- ----------------------------
-- View structure for v_pengbar
-- ----------------------------
DROP VIEW IF EXISTS `v_pengbar`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_pengbar` AS select `tbl_tipe_barang`.`id_tipe_barang` AS `id_tipe_barang`,`tbl_tipe_barang`.`tipe_barang` AS `tipe_barang`,`tbl_barang`.`no_urut` AS `no_urut`,`tbl_barang`.`nama_barang` AS `nama_barang`,`tbl_barang`.`kode_barang` AS `kode_barang`,`tbl_transaksi`.`id_tran` AS `id_tran`,`tbl_transaksi`.`id_jtran` AS `id_jtran`,`tbl_transaksi`.`id_uker` AS `id_uker`,`tbl_transaksi`.`no_sn` AS `no_sn`,`tbl_transaksi`.`kon_barang` AS `kon_barang`,`tbl_transaksi`.`qty` AS `qty`,`tbl_transaksi`.`harga_barang` AS `harga_barang`,`tbl_transaksi`.`remark` AS `remark`,`tbl_transaksi`.`is_active` AS `is_active`,`tbl_transaksi`.`is_have` AS `is_have`,`tbl_unit_kerja`.`nama_uker` AS `nama_uker`,`tbl_gbarang`.`nama_gbarang` AS `nama_gbarang`,`tbl_gbarang`.`id_gbarang` AS `id_gbarang`,`tbl_sgbarang`.`id_sgbarang` AS `id_sgbarang`,`tbl_sgbarang`.`nama_sgbarang` AS `nama_sgbarang`,`tbl_merek`.`id_merek` AS `id_merek`,`tbl_merek`.`nama_merek` AS `nama_merek`,`tbl_transaksi`.`tgl_kirim_barang` AS `tgl_kirim_barang` from ((((((`tbl_tipe_barang` join `tbl_barang` on((`tbl_tipe_barang`.`id_tipe_barang` = `tbl_barang`.`id_tipe_barang`))) join `tbl_transaksi` on((`tbl_barang`.`no_urut` = `tbl_transaksi`.`no_urut`))) join `tbl_unit_kerja` on((`tbl_transaksi`.`id_uker` = `tbl_unit_kerja`.`id_uker`))) join `tbl_merek` on((`tbl_tipe_barang`.`id_merek` = `tbl_merek`.`id_merek`))) join `tbl_gbarang`) join `tbl_sgbarang` on(((`tbl_gbarang`.`id_gbarang` = `tbl_sgbarang`.`id_gbarang`) and (`tbl_merek`.`id_sgbarang` = `tbl_sgbarang`.`id_sgbarang`)))) where (`tbl_transaksi`.`id_jtran` = 1);

-- ----------------------------
-- View structure for v_sgbarang
-- ----------------------------
DROP VIEW IF EXISTS `v_sgbarang`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_sgbarang` AS select `tbl_sgbarang`.`id_sgbarang` AS `id_sgbarang`,`tbl_sgbarang`.`id_gbarang` AS `id_gbarang`,`tbl_sgbarang`.`nama_sgbarang` AS `nama_sgbarang`,`tbl_sgbarang`.`is_active` AS `is_active`,`tbl_sgbarang`.`sgbarang_created_date` AS `sgbarang_created_date`,`tbl_sgbarang`.`sgbarang_created_by` AS `sgbarang_created_by`,`tbl_sgbarang`.`sgbarang_updated_date` AS `sgbarang_updated_date`,`tbl_sgbarang`.`sgbarang_updated_by` AS `sgbarang_updated_by`,`tbl_gbarang`.`nama_gbarang` AS `nama_gbarang` from (`tbl_gbarang` join `tbl_sgbarang` on((`tbl_gbarang`.`id_gbarang` = `tbl_sgbarang`.`id_gbarang`)));

-- ----------------------------
-- View structure for v_stockbarang
-- ----------------------------
DROP VIEW IF EXISTS `v_stockbarang`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_stockbarang` AS select `tbl_gbarang`.`id_gbarang` AS `id_gbarang`,`tbl_gbarang`.`nama_gbarang` AS `nama_gbarang`,`tbl_sgbarang`.`id_sgbarang` AS `id_sgbarang`,`tbl_sgbarang`.`nama_sgbarang` AS `nama_sgbarang`,`tbl_merek`.`id_merek` AS `id_merek`,`tbl_merek`.`nama_merek` AS `nama_merek`,`tbl_tipe_barang`.`id_tipe_barang` AS `id_tipe_barang`,`tbl_tipe_barang`.`tipe_barang` AS `tipe_barang`,`tbl_barang`.`no_urut` AS `no_urut`,`tbl_barang`.`kode_barang` AS `kode_barang`,`tbl_barang`.`nama_barang` AS `nama_barang`,`tbl_stock`.`id_stock` AS `id_stock`,`tbl_stock`.`id_uker` AS `id_uker`,`tbl_stock`.`qty` AS `qty`,`tbl_unit_kerja`.`nama_uker` AS `nama_uker` from ((((((`tbl_gbarang` join `tbl_sgbarang` on((`tbl_gbarang`.`id_gbarang` = `tbl_sgbarang`.`id_gbarang`))) join `tbl_merek` on((`tbl_sgbarang`.`id_sgbarang` = `tbl_merek`.`id_sgbarang`))) join `tbl_tipe_barang` on((`tbl_merek`.`id_merek` = `tbl_tipe_barang`.`id_merek`))) join `tbl_barang` on((`tbl_tipe_barang`.`id_tipe_barang` = `tbl_barang`.`id_tipe_barang`))) join `tbl_stock` on((`tbl_barang`.`no_urut` = `tbl_stock`.`no_urut`))) join `tbl_unit_kerja` on((`tbl_stock`.`id_uker` = `tbl_unit_kerja`.`id_uker`)));

-- ----------------------------
-- View structure for v_stockglobal
-- ----------------------------
DROP VIEW IF EXISTS `v_stockglobal`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_stockglobal` AS select `tbl_gbarang`.`id_gbarang` AS `id_gbarang`,`tbl_gbarang`.`nama_gbarang` AS `nama_gbarang`,`tbl_sgbarang`.`id_sgbarang` AS `id_sgbarang`,`tbl_sgbarang`.`nama_sgbarang` AS `nama_sgbarang`,`tbl_merek`.`id_merek` AS `id_merek`,`tbl_merek`.`nama_merek` AS `nama_merek`,`tbl_tipe_barang`.`id_tipe_barang` AS `id_tipe_barang`,`tbl_tipe_barang`.`tipe_barang` AS `tipe_barang`,`tbl_barang`.`no_urut` AS `no_urut`,`tbl_barang`.`kode_barang` AS `kode_barang`,`tbl_barang`.`nama_barang` AS `nama_barang`,`tbl_stock`.`id_stock` AS `id_stock`,sum(`tbl_stock`.`qty`) AS `Qty` from (((((`tbl_gbarang` join `tbl_sgbarang` on((`tbl_gbarang`.`id_gbarang` = `tbl_sgbarang`.`id_gbarang`))) join `tbl_merek` on((`tbl_sgbarang`.`id_sgbarang` = `tbl_merek`.`id_sgbarang`))) join `tbl_tipe_barang` on((`tbl_merek`.`id_merek` = `tbl_tipe_barang`.`id_merek`))) join `tbl_barang` on((`tbl_tipe_barang`.`id_tipe_barang` = `tbl_barang`.`id_tipe_barang`))) join `tbl_stock` on((`tbl_barang`.`no_urut` = `tbl_stock`.`no_urut`))) group by `tbl_barang`.`nama_barang`;

-- ----------------------------
-- View structure for v_subgroupuser
-- ----------------------------
DROP VIEW IF EXISTS `v_subgroupuser`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_subgroupuser` AS select `tbl_user_subgroup`.`id_subgroup` AS `id_subgroup`,`tbl_user_subgroup`.`id_group` AS `id_group`,`tbl_user_subgroup`.`nama_subgroup` AS `nama_subgroup`,`tbl_user_subgroup`.`is_active` AS `is_active`,`tbl_user_subgroup`.`usubgroup_created_date` AS `usubgroup_created_date`,`tbl_user_subgroup`.`usubgroup_created_by` AS `usubgroup_created_by`,`tbl_user_subgroup`.`usubgroup_updated_date` AS `usubgroup_updated_date`,`tbl_user_subgroup`.`usubgroup_updated_by` AS `usubgroup_updated_by`,`tbl_user_group`.`nama_group` AS `nama_group` from (`tbl_user_group` join `tbl_user_subgroup` on((`tbl_user_group`.`id_group` = `tbl_user_subgroup`.`id_group`)));

-- ----------------------------
-- View structure for v_tipe_barang
-- ----------------------------
DROP VIEW IF EXISTS `v_tipe_barang`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_tipe_barang` AS select `tbl_tipe_barang`.`id_tipe_barang` AS `id_tipe_barang`,`tbl_tipe_barang`.`id_merek` AS `id_merek`,`tbl_tipe_barang`.`tipe_barang` AS `tipe_barang`,`tbl_tipe_barang`.`is_active` AS `is_active`,`tbl_tipe_barang`.`tbarang_created_date` AS `tbarang_created_date`,`tbl_tipe_barang`.`tbarang_created_by` AS `tbarang_created_by`,`tbl_tipe_barang`.`tbarang_updated_date` AS `tbarang_updated_date`,`tbl_tipe_barang`.`tbarang_updated_by` AS `tbarang_updated_by`,`tbl_merek`.`nama_merek` AS `nama_merek`,`tbl_merek`.`id_sgbarang` AS `id_sgbarang`,`tbl_sgbarang`.`nama_sgbarang` AS `nama_sgbarang`,`tbl_sgbarang`.`id_gbarang` AS `id_gbarang`,`tbl_gbarang`.`nama_gbarang` AS `nama_gbarang` from (((`tbl_tipe_barang` join `tbl_merek` on((`tbl_tipe_barang`.`id_merek` = `tbl_merek`.`id_merek`))) join `tbl_sgbarang` on((`tbl_merek`.`id_sgbarang` = `tbl_sgbarang`.`id_sgbarang`))) join `tbl_gbarang` on((`tbl_sgbarang`.`id_gbarang` = `tbl_gbarang`.`id_gbarang`)));

-- ----------------------------
-- View structure for v_user
-- ----------------------------
DROP VIEW IF EXISTS `v_user`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_user` AS select `tbl_user`.`id_user` AS `id_user`,`tbl_user`.`id_sgroup` AS `id_sgroup`,`tbl_user`.`id_uker` AS `id_uker`,`tbl_user`.`nama_user` AS `nama_user`,`tbl_user`.`username` AS `username`,`tbl_user`.`password` AS `password`,`tbl_user`.`is_active` AS `is_active`,`tbl_user`.`user_created_date` AS `user_created_date`,`tbl_user`.`user_created_by` AS `user_created_by`,`tbl_user`.`user_updated_date` AS `user_updated_date`,`tbl_user`.`user_updated_by` AS `user_updated_by`,`tbl_user_subgroup`.`nama_subgroup` AS `nama_subgroup`,`tbl_unit_kerja`.`nama_uker` AS `nama_uker` from ((`tbl_user` join `tbl_user_subgroup` on((`tbl_user`.`id_sgroup` = `tbl_user_subgroup`.`id_subgroup`))) join `tbl_unit_kerja` on((`tbl_user`.`id_uker` = `tbl_unit_kerja`.`id_uker`)));

-- ----------------------------
-- Triggers structure for table tbl_transaksi
-- ----------------------------
DROP TRIGGER IF EXISTS `tran_insert`;
delimiter ;;
CREATE TRIGGER `tran_insert` AFTER INSERT ON `tbl_transaksi` FOR EACH ROW BEGIN
	IF (NEW.id_jtran = 1) THEN
		IF ((SELECT COUNT(*) as jumlah FROM tbl_stock WHERE no_urut = NEW.no_urut AND id_uker = NEW.id_uker) = 0) THEN
			INSERT INTO tbl_stock (no_urut, id_uker, qty, stock_created_by) VALUES (NEW.no_urut, NEW.id_uker, 0, 'superadmin');
		END IF;
	ELSE
		IF ((SELECT COUNT(*) as jumlah FROM tbl_stock WHERE no_urut = NEW.no_urut AND id_uker = NEW.id_uker) = 0) THEN
			INSERT INTO tbl_stock (no_urut, id_uker, qty, stock_created_by) VALUES (NEW.no_urut, NEW.id_uker, NEW.qty, 'superadmin');
		ELSE 
			UPDATE tbl_stock SET qty = qty + 1 WHERE no_urut = NEW.no_urut AND id_uker = NEW.id_uker;
		END IF;
	END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbl_transaksi
-- ----------------------------
DROP TRIGGER IF EXISTS `tran_update`;
delimiter ;;
CREATE TRIGGER `tran_update` AFTER UPDATE ON `tbl_transaksi` FOR EACH ROW BEGIN
	IF (NEW.id_jtran = 1) THEN
		IF ((SELECT COUNT(*) as jumlah FROM tbl_stock WHERE no_urut = NEW.no_urut AND id_uker = NEW.id_uker) = 0) THEN
				INSERT INTO tbl_stock (no_urut, id_uker, qty, stock_created_by) VALUES (NEW.no_urut, NEW.id_uker, 0, 'superadmin');
		END IF;
		
		IF(NEW.is_have = 1) THEN
				UPDATE tbl_stock SET qty = qty - 1 WHERE no_urut = OLD.no_urut AND id_uker = OLD.dari_uker;
				UPDATE tbl_stock SET qty = qty + 1 WHERE no_urut = OLD.no_urut AND id_uker = OLD.id_uker;
		END IF;
	ELSE
		IF ((SELECT COUNT(*) as jumlah FROM tbl_stock WHERE no_urut = NEW.no_urut AND id_uker = NEW.id_uker) = 0) THEN
				UPDATE tbl_stock SET qty = qty - 1 WHERE no_urut = OLD.no_urut AND id_uker = OLD.id_uker;
				INSERT INTO tbl_stock (no_urut, id_uker, qty, stock_created_by) VALUES (NEW.no_urut, NEW.id_uker, NEW.qty, 'superadmin');
		ELSE 
				UPDATE tbl_stock SET qty = qty - 1 WHERE no_urut = OLD.no_urut AND id_uker = OLD.id_uker;
				UPDATE tbl_stock SET qty = qty + 1 WHERE no_urut = NEW.no_urut AND id_uker = NEW.id_uker;
		END IF;
	END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbl_transaksi
-- ----------------------------
DROP TRIGGER IF EXISTS `tran_delete`;
delimiter ;;
CREATE TRIGGER `tran_delete` AFTER DELETE ON `tbl_transaksi` FOR EACH ROW BEGIN
	UPDATE tbl_stock SET qty = qty - 1 WHERE no_urut = OLD.no_urut AND id_uker = OLD.id_uker;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
