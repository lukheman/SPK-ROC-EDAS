/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.1.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: spk_roc_edas
-- ------------------------------------------------------
-- Server version	12.1.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id_admin` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL DEFAULT '$2y$12$1oshLTvSTYDMWUUmjxdV8.dGeEbixrheXHdfrEufY3TXuhF3PBH2O',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `admin_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `admin` VALUES
(1,'Admin','admin@gmail.com',NULL,'$2y$12$1oshLTvSTYDMWUUmjxdV8.dGeEbixrheXHdfrEufY3TXuhF3PBH2O',NULL,'2026-05-07 07:01:31','2026-05-07 07:01:31');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `alternatif`
--

DROP TABLE IF EXISTS `alternatif`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `alternatif` (
  `id_alternatif` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_siswa` bigint(20) unsigned NOT NULL,
  `id_kriteria` bigint(20) unsigned NOT NULL,
  `nilai` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_alternatif`),
  UNIQUE KEY `alternatif_id_siswa_id_kriteria_unique` (`id_siswa`,`id_kriteria`),
  KEY `alternatif_id_kriteria_foreign` (`id_kriteria`),
  CONSTRAINT `alternatif_id_kriteria_foreign` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE,
  CONSTRAINT `alternatif_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alternatif`
--

LOCK TABLES `alternatif` WRITE;
/*!40000 ALTER TABLE `alternatif` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `alternatif` VALUES
(1,1,1,2,'2026-05-07 07:01:30','2026-05-07 07:01:30'),
(2,1,2,2500000,'2026-05-07 07:01:30','2026-05-07 07:01:30'),
(3,1,3,1,'2026-05-07 07:01:30','2026-05-07 07:01:30'),
(4,1,4,0,'2026-05-07 07:01:30','2026-05-07 07:01:30'),
(5,1,5,50,'2026-05-07 07:01:30','2026-05-07 07:01:30'),
(6,1,6,10,'2026-05-07 07:01:30','2026-05-07 07:01:30'),
(7,2,1,3,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(8,2,2,3000000,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(9,2,3,2,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(10,2,4,1000000,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(11,2,5,100,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(12,2,6,8,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(13,3,1,1,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(14,3,2,4000000,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(15,3,3,1,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(16,3,4,0,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(17,3,5,100,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(18,3,6,1,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(19,4,1,2,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(20,4,2,5000000,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(21,4,3,2,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(22,4,4,2000000,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(23,4,5,50,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(24,4,6,8,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(25,5,1,4,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(26,5,2,2500000,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(27,5,3,1,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(28,5,4,0,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(29,5,5,50,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(30,5,6,4,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(31,6,1,3,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(32,6,2,5000000,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(33,6,3,2,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(34,6,4,1500000,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(35,6,5,100,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(36,6,6,8,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(37,7,1,5,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(38,7,2,3000000,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(39,7,3,1,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(40,7,4,0,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(41,7,5,100,'2026-05-07 07:01:31','2026-05-07 07:01:31'),
(42,7,6,6,'2026-05-07 07:01:31','2026-05-07 07:01:31');
/*!40000 ALTER TABLE `alternatif` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `kepala_sekolah`
--

DROP TABLE IF EXISTS `kepala_sekolah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kepala_sekolah` (
  `id_kepala_sekolah` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL DEFAULT '$2y$12$0bnqRNudHSlRWKDvCLj6Aun.VVQWeKCOldpTfntbLIItOF9CSUPne',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kepala_sekolah`),
  UNIQUE KEY `kepala_sekolah_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kepala_sekolah`
--

LOCK TABLES `kepala_sekolah` WRITE;
/*!40000 ALTER TABLE `kepala_sekolah` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `kepala_sekolah` VALUES
(1,'Kepala Sekolah','kepalasekolah@gmail.com',NULL,'$2y$12$0bnqRNudHSlRWKDvCLj6Aun.VVQWeKCOldpTfntbLIItOF9CSUPne',NULL,'2026-05-07 07:01:31','2026-05-07 07:01:31');
/*!40000 ALTER TABLE `kepala_sekolah` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `kriteria`
--

DROP TABLE IF EXISTS `kriteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kriteria` (
  `id_kriteria` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tipe` enum('benefit','cost') NOT NULL DEFAULT 'benefit',
  `urutan` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kriteria`),
  UNIQUE KEY `kriteria_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kriteria`
--

LOCK TABLES `kriteria` WRITE;
/*!40000 ALTER TABLE `kriteria` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `kriteria` VALUES
(1,'pekerjaan_ayah','Pekerjaan Ayah','benefit',1,'2026-05-07 07:01:30','2026-05-07 07:01:30'),
(2,'penghasilan_ayah','Penghasilan Ayah','benefit',2,'2026-05-07 07:01:30','2026-05-07 07:01:30'),
(3,'pekerjaan_ibu','Pekerjaan Ibu','benefit',3,'2026-05-07 07:01:30','2026-05-07 07:01:30'),
(4,'penghasilan_ibu','Penghasilan Ibu','benefit',4,'2026-05-07 07:01:30','2026-05-07 07:01:30'),
(5,'yatim_piatu','Yatim/Piatu','benefit',5,'2026-05-07 07:01:30','2026-05-07 07:01:30'),
(6,'peringkat_kelas','Peringkat Kelas','benefit',6,'2026-05-07 07:01:30','2026-05-07 07:01:30');
/*!40000 ALTER TABLE `kriteria` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_09_24_060253_create_siswa_table',1),
(5,'2025_09_25_000000_create_kriteria_table',1),
(6,'2025_09_26_000000_create_sub_kriteria_table',1),
(7,'2025_09_27_085640_create_alternatifs_table',1),
(8,'2026_04_01_051907_create_admin_table',1),
(9,'2026_04_01_052313_create_kepala_sekolah_table',1),
(10,'2026_04_01_060055_drop_users_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `siswa`
--

DROP TABLE IF EXISTS `siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `siswa` (
  `id_siswa` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nisn` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `password` varchar(255) DEFAULT '$2y$12$W3e6iS5tTG6d8KzecNDIQ.8C5EZBR7PjiDg8o6DaKgRkJYaUyNa3e',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_siswa`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siswa`
--

LOCK TABLES `siswa` WRITE;
/*!40000 ALTER TABLE `siswa` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `siswa` VALUES
(1,'32019115','Afni','P','Alamat Afni','1977-01-10','$2y$12$/ubevhVPzeKfJ066R2Yv6ePVjDMknl9pmwMIPkdYpEcJaUJfj1os.','2026-05-07 07:01:30','2026-05-07 07:01:30'),
(2,'32014867','Suci Ramadani','P','Alamat Suci Ramadani','2007-08-10','$2y$12$ogBq1mGuiOlDY4wmJylKv..o.3trHvspxMJz.xUu.icgJBGfL3ZfC','2026-05-07 07:01:31','2026-05-07 07:01:31'),
(3,'32015627','Budi','P','Alamat Budi','2007-04-19','$2y$12$pDmO1D63KNLOY1Qg2LhCjeUQZ.NNuIx8Drz3h2quv4dDTc1jlDAHG','2026-05-07 07:01:31','2026-05-07 07:01:31'),
(4,'32015380','Izty','P','Alamat Izty','1971-10-26','$2y$12$iXhOKr7U.BECWiEKNzMlFOJ77EhdWok29DYRX6ZaWMPllTkEYjEOG','2026-05-07 07:01:31','2026-05-07 07:01:31'),
(5,'32016761','Putri','P','Alamat Putri','2001-09-24','$2y$12$yapemhM.7mlP7XRuAF4GnOHKgS6DItGGH.gLGaHvQeA77.zQKykE2','2026-05-07 07:01:31','2026-05-07 07:01:31'),
(6,'32011628','Arisa','P','Alamat Arisa','2002-10-03','$2y$12$hItSQiVqcrfncJ5pMcuwCuRiqRvy3YLG1JC5puHHvkCu42JZfGyYu','2026-05-07 07:01:31','2026-05-07 07:01:31'),
(7,'32014927','Dewi','P','Alamat Dewi','1997-01-02','$2y$12$ASi/GM2UeBrQMeVP/NsNIODOX9RkJJtQM0clbUilq8r6hkhxb392m','2026-05-07 07:01:31','2026-05-07 07:01:31');
/*!40000 ALTER TABLE `siswa` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sub_kriteria`
--

DROP TABLE IF EXISTS `sub_kriteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_kriteria` bigint(20) unsigned NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nilai` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_sub_kriteria`),
  KEY `sub_kriteria_id_kriteria_foreign` (`id_kriteria`),
  CONSTRAINT `sub_kriteria_id_kriteria_foreign` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_kriteria`
--

LOCK TABLES `sub_kriteria` WRITE;
/*!40000 ALTER TABLE `sub_kriteria` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `sub_kriteria` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-05-07 23:05:16
