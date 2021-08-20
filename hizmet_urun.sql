-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 03 Ağu 2021, 14:54:34
-- Sunucu sürümü: 10.4.20-MariaDB
-- PHP Sürümü: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `satis_takip`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hizmet_urun`
--

CREATE TABLE `hizmet_urun` (
  `id` int(11) NOT NULL,
  `adi` varchar(225) NOT NULL,
  `tam_urun_adi` varchar(550) NOT NULL,
  `birim` varchar(225) NOT NULL,
  `urun_kodu` varchar(225) NOT NULL,
  `barkod_no` varchar(225) NOT NULL,
  `kategori` varchar(225) NOT NULL,
  `alis_fiyat` varchar(225) NOT NULL,
  `alis_fiyat_6_tk` varchar(225) NOT NULL,
  `alis_fiyat_9_tk` varchar(225) NOT NULL,
  `vergi` varchar(225) NOT NULL,
  `satis_fiyat` varchar(225) NOT NULL,
  `satis_fiyat_6_tk` varchar(225) NOT NULL,
  `satis_fiyat_9_tk` varchar(225) NOT NULL,
  `bas_stok` int(11) NOT NULL,
  `demirbas` int(11) NOT NULL,
  `demirbas_adet` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `durum` int(11) NOT NULL,
  `urun_grubu` int(11) NOT NULL,
  `urun_hedef_grubu` int(11) DEFAULT NULL,
  `is_upgrade` int(11) NOT NULL,
  `is_vkn_obligatory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `hizmet_urun`
--

INSERT INTO `hizmet_urun` (`id`, `adi`, `tam_urun_adi`, `birim`, `urun_kodu`, `barkod_no`, `kategori`, `alis_fiyat`, `alis_fiyat_6_tk`, `alis_fiyat_9_tk`, `vergi`, `satis_fiyat`, `satis_fiyat_6_tk`, `satis_fiyat_9_tk`, `bas_stok`, `demirbas`, `demirbas_adet`, `kullanici_id`, `durum`, `urun_grubu`, `urun_hedef_grubu`, `is_upgrade`, `is_vkn_obligatory`) VALUES
(11, 'MÜŞAVİR PAKET KAMPANYA', 'MÜŞAVİR PAKET KAMPANYA', 'adet', '', '', '2', '1', '2', '3', '18', '2337.5', '2501.38', '2571.25', 100000, 0, 0, 17, 1, 1, 0, 0, 0),
(12, 'NOVA MÜŞAVİR ABONELİK', 'NOVA MÜŞAVİR ABONELİK', 'adet', '', '', '3', '960', '1027', '1056', '0', '960', '1027', '1056', 100000, 0, 0, 17, 1, 1, 2, 0, 0),
(13, 'MÜŞAVİR', 'MÜŞAVİR', 'adet', '', '', '4', '2550', '2729', '2805', '0', '2550', '2729', '2805', 100000, 0, 0, 17, 1, 1, 1, 0, 0),
(14, 'TİCARİ', 'TİCARİ', 'adet', '', '', '4', '2750', '2943', '3025', '0', '2750', '2943', '3025', 100000, 0, 0, 17, 1, 1, 1, 0, 0),
(15, 'FİNANSMAN', 'FİNANSMAN', 'adet', '', '', '4', '4450', '4762', '4895', '0', '4450', '4762', '4895', 100000, 0, 0, 17, 1, 1, 1, 0, 0),
(16, 'ÜRETİM', 'ÜRETİM', 'adet', '', '', '4', '8050', '8614', '8855', '0', '8050', '8614', '8855', 100000, 0, 0, 17, 1, 1, 1, 0, 0),
(17, 'BORDRO', 'BORDRO', 'adet', '', '', '4', '2450', '2622', '2695', '0', '2450', '2622', '2695', 100000, 0, 0, 17, 1, 1, 1, 0, 0),
(18, 'MUHASEBE', 'MUHASEBE', 'adet', '', '', '4', '2150', '2301', '2365', '0', '2150', '2301', '2365', 100000, 0, 0, 17, 1, 1, 1, 0, 0),
(19, 'KOLAY E SMM ABONELİK', 'KOLAY E SMM ABONELİK', 'adet', '', '', '5', '350', '375', '385', '0', '350', '375', '385', 100000, 0, 0, 17, 1, 1, 0, 0, 0),
(20, 'Nova Müşavir Abone (+2) Kullanıcı', 'Nova Müşavir Abone (+2) Kullanıcı', 'adet', '', '', '6', '1', '2', '3', '18', '2', '2', '3', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(21, 'Nova Müşavir Abone (+25) Firma', 'Nova Müşavir Abone (+25) Firma', 'adet', '', '', '7', '1', '2', '3', '18', '2', '2', '3', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(22, 'Drive Yedekleme 5 GB', 'Drive Yedekleme 5 GB', 'adet', '', '', '8', '334.75', '358.47', '368.64', '18', '395', '423', '435', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(23, 'Drive Yedekleme 50 GB', 'Drive Yedekleme 50 GB', 'adet', '', '', '8', '1097.46', '1174.58', '1207.63', '18', '1295', '1386', '1425', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(24, 'Drive Yedekleme 100 GB', 'Drive Yedekleme 100 GB', 'adet', '', '', '8', '1', '2', '3', '18', '1965', '2103', '2162', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(25, 'Drive Yedekleme 200 GB', 'Drive Yedekleme 200 GB', 'adet', '', '', '8', '1', '2', '3', '18', '3535', '3782', '3889', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(26, 'Drive Yedekleme 500 GB', 'Drive Yedekleme 500 GB', 'adet', '', '', '8', '1', '2', '3', '18', '6550', '7009', '7205', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(27, 'Müşavir (+ Kullanıcı)', 'Müşavir (+ Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '255', '273', '281', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(28, 'e-Smmm Abonelik Paketi', 'e-Smmm Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '350', '375', '385', 100000, 0, 0, 17, 1, 2, 3, 0, 1),
(29, 'e-Defter Abonelik Paketi', 'e-Defter Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '820', '877', '902', 100000, 0, 0, 17, 1, 2, 3, 0, 1),
(30, 'e-Defter Beyan Abonelik', 'e-Defter Beyan Abonelik', 'adet', '', '', '11', '1', '2', '3', '0', '350', '375', '385', 100000, 0, 0, 17, 1, 2, 3, 0, 0),
(31, 'Servis Bedeli', 'Servis Bedeli', 'adet', '', '', '12', '1', '2', '3', '18', '180', '192.6', '198', 100000, 0, 0, 17, 0, 2, 0, 0, 0),
(32, 'Özel Teklif/Sipariş Formu Dizaynı', 'Özel Teklif/Sipariş Formu Dizaynı', 'adet', '', '', '12', '1', '2', '3', '18', '480', '514', '528', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(33, 'Standart Teklif/Sipariş Formu Dizaynı', 'Standart Teklif/Sipariş Formu Dizaynı', 'adet', '', '', '12', '1', '2', '3', '18', '360', '385', '396', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(34, 'Barkod Dizaynı', 'Barkod Dizaynı', 'adet', '', '', '12', '1', '2', '3', '18', '480', '514', '528', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(35, 'Yerinde Servis (Evrak Dizaynı)', 'Yerinde Servis (Evrak Dizaynı)', 'adet', '', '', '12', '1', '2', '3', '18', '210', '224.7', '231', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(36, 'Ana Makina Değişimi (Internet Üzerinden)', 'Ana Makina Değişimi (Internet Üzerinden)', 'adet', '', '', '12', '1', '2', '3', '18', '120', '128.4', '132', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(37, 'Ana Makina Değişimi (Yerinde Servis)', 'Ana Makina Değişimi (Yerinde Servis)', 'adet', '', '', '12', '1', '2', '3', '18', '210', '225', '231', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(38, 'Müşavir Paketi Harici Program Desteği', 'Müşavir Paketi Harici Program Desteği', 'adet', '', '', '12', '1', '2', '3', '18', '1000', '1070', '1100', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(39, 'Kantar Modülü', 'Kantar Modülü', 'adet', '', '', '13', '1', '2', '3', '18', '1200', '1284', '1320', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(40, 'Personel Takip (Otomasyonlu)', 'Personel Takip (Otomasyonlu)', 'adet', '', '', '13', '1', '2', '3', '18', '1200', '1284', '1320', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(41, 'Ticari (+Kullanıcı)', 'Ticari (+Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '275', '294', '303', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(42, 'e-Fatura/e-Arşiv Abonelik Paketi', 'e-Fatura/e-Arşiv Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '1350', '1445', '1485', 100000, 0, 0, 17, 1, 2, 3, 0, 1),
(43, 'e-İrsaliye Abonelik Paketi', 'e-İrsaliye Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '850', '910', '935', 100000, 0, 0, 17, 0, 2, 3, 0, 1),
(44, 'e-Müstahsil Abonelik Paketi', 'e-Müstahsil Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '350', '375', '385', 100000, 0, 0, 17, 1, 2, 3, 0, 1),
(45, 'e-Fatura Dizaynı (İlk Dizayn)', 'e-Fatura Dizaynı (İlk Dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '660', '706', '726', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(46, 'e-Fatura Dizaynı (1\'den sonraki dizayn)', 'e-Fatura Dizaynı (1\'den sonraki dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '300', '321', '330', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(47, 'e-Fatura Dizaynı + (İhracat)', 'e-Fatura Dizaynı + (İhracat)', 'adet', '', '', '12', '1', '2', '3', '18', '960', '1027', '1056', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(48, 'e-Fatura Dizaynı + (Dövizli)', 'e-Fatura Dizaynı + (Dövizli)', 'adet', '', '', '12', '1', '2', '3', '18', '960', '1027', '1056', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(49, 'e-Fatura Dizaynı + (Dövizli) +  (İhracat)', 'e-Fatura Dizaynı + (Dövizli) +  (İhracat)', 'adet', '', '', '12', '1', '2', '3', '18', '1260', '1348', '1386', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(50, 'e-Fatura Dizayn Düzenleme', 'e-Fatura Dizayn Düzenleme', 'adet', '', '', '12', '1', '2', '3', '18', '120', '128.4', '132', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(51, 'e-Arşiv Fatura Dizaynı (İlk Dizayn)', 'e-Arşiv Fatura Dizaynı (İlk Dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '660', '706', '726', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(52, 'e-Arşiv Fatura Dizaynı (1\'den sonraki dizayn)', 'e-Arşiv Fatura Dizaynı (1\'den sonraki dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '300', '321', '330', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(53, 'e-Arşiv Fatura Dizaynı + (Dövizli)', 'e-Arşiv Fatura Dizaynı + (Dövizli)', 'adet', '', '', '12', '1', '2', '3', '18', '960', '1027', '1056', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(54, 'e-Arşiv Fatura Dizaynı + (Dövizli) + (İhracat)', 'e-Arşiv Fatura Dizaynı + (Dövizli) + (İhracat)', 'adet', '', '', '12', '1', '2', '3', '18', '1260', '1348', '1386', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(55, 'e-Arşiv Fatura Dizayn Düzenleme', 'e-Arşiv Fatura Dizayn Düzenleme', 'adet', '', '', '12', '1', '2', '3', '18', '120', '128.4', '132', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(56, 'Ticari Paket Harici Program Desteği', 'Ticari Paket Harici Program Desteği', 'adet', '', '', '12', '1', '2', '3', '18', '1000', '1070', '1100', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(57, 'e-İrsaliye Dizaynı (İlk Dizayn)', 'e-İrsaliye Dizaynı (İlk Dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '660', '706', '726', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(58, 'e-İrsaliye Dizaynı (1\'den sonraki dizayn)', 'e-İrsaliye Dizaynı (1\'den sonraki dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '300', '321', '330', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(59, 'e-İrsaliye Dizaynı + (Dövizli)', 'e-İrsaliye Dizaynı + (Dövizli)', 'adet', '', '', '12', '1', '2', '3', '18', '960', '1027', '1056', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(60, 'e-İrsaliye Dizayn Düzenleme', 'e-İrsaliye Dizayn Düzenleme', 'adet', '', '', '12', '1', '2', '3', '18', '120', '128.4', '132', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(61, 'Finansman (+ Kullanıcı)', 'Finansman (+ Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '445', '476', '490', 100000, 0, 0, 17, 1, 2, NULL, 0, 0),
(62, 'Üretim (+Kullanıcı)', 'Üretim (+Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '805', '861', '886', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(63, 'Bordro (+Kullanıcı)', 'Bordro (+Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '245', '262', '270', 100000, 0, 0, 17, 1, 2, 0, 0, 0),
(64, 'Muhasebe Paketi (+Kullanıcı)', 'Muhasebe Paketi (+Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '215', '230', '237', 0, 0, 0, 17, 1, 2, 0, 0, 0),
(66, 'E-Kontör', 'E-Kontör', 'adet', '', '', '', '1', '2', '3', '18', '2', '2', '3', 100000, 0, 0, 17, 1, 2, 3, 0, 0),
(67, 'E-Kontör (100)', 'E-Kontör (100)', 'adet', '', '', '', '1', '2', '3', '18', '210', '235', '231', 100000, 0, 0, 17, 1, 2, 3, 0, 0),
(68, '', '', '', '', '', '', '', '2', '3', '18', '', '2', '3', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(69, 'e-Fatura/e-Arşiv Abonelik Paketi EK (VKN)', 'e-Fatura/e-Arşiv Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '350', '375', '385', 100000, 0, 0, 17, 1, 2, 3, 0, 1),
(70, 'e-Defter Abonelik Paketi EK (VKN)', 'e-Defter Abonelik Paketi EK (VKN)', 'adet', '', '', '10', '1', '2', '3', '0', '120', '128', '132', 100000, 0, 0, 17, 1, 2, 3, 0, 1),
(71, 'e-İrsaliye Abonelik Paketi EK (VKN)', 'e-İrsaliye Abonelik Paketi EK (VKN)', 'adet', '', '', '10', '1', '2', '3', '0', '150', '161', '165', 100000, 0, 0, 17, 0, 2, 3, 0, 1),
(72, 'e-Müstahsil Abonelik Paketi EK (VKN)', 'e-Müstahsil Abonelik Paketi EK (VKN)', 'adet', '', '', '10', '1', '2', '3', '0', '150', '161', '165', 100000, 0, 0, 17, 1, 2, 3, 0, 1),
(73, 'ZİRVE FİNANSMAN SQL.NET 7.01(MÜŞAVİR SQL \'DEN GEÇİŞ)', 'ZİRVE FİNANSMAN SQL.NET 7.01(MÜŞAVİR SQL \'DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '2620', '2803', '2882', 100000, 0, 0, 17, 1, 2, NULL, 15, 0),
(74, 'ZİRVE FİNANSMAN SQL.NET 7.01 (TİCARİ SQL\'DEN GEÇİŞ)', 'ZİRVE FİNANSMAN SQL.NET 7.01 (TİCARİ SQL\'DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '2620', '2803', '2882', 100000, 0, 0, 17, 1, 2, NULL, 15, 0),
(75, 'ZİRVE FİNANSMAN SQL.NET 7.01 (BORDRODAN SQL\'DEN GEÇİŞ)', 'ZİRVE FİNANSMAN SQL.NET 7.01 (BORDRODAN SQL\'DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '3420', '3659', '3762', 100000, 0, 0, 17, 1, 2, NULL, 15, 0),
(76, 'ZİRVE MÜŞAVİR SQL .NET 7.01 (BORDRO SQL DEN GEÇİŞ)', 'ZİRVE MÜŞAVİR SQL .NET 7.01 (BORDRO SQL DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '1420', '1519', '1562', 100000, 0, 0, 17, 1, 2, NULL, 13, 0),
(77, 'ZİRVE MÜŞAVİR SQL .NET 7.01 (MUHASEBE SQL DEN GEÇİŞ)', 'ZİRVE MÜŞAVİR SQL .NET 7.01 (MUHASEBE SQL DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '1420', '1519', '1562', 100000, 0, 0, 17, 1, 2, NULL, 13, 0),
(78, 'ZİRVE MÜŞAVİR SQL .NET 7.01 (İŞLETME SQL DEN GEÇİŞ)', 'ZİRVE MÜŞAVİR SQL .NET 7.01 (İŞLETME SQL DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '1420', '1519', '1562', 10000, 0, 0, 17, 1, 2, NULL, 13, 0),
(79, 'ZİRVE ÜRETIM SQL .NET 7.01 (FİNANS 7.01 DEN GEÇİŞ)', 'ZİRVE ÜRETIM SQL .NET 7.01 (FİNANS 7.01 DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '4120', '4408', '4532', 10000, 0, 0, 17, 1, 2, NULL, 16, 0),
(80, 'ZİRVE ÜRETİM SQL .NET 7,01 (MÜŞAVİR 7,01 DEN GEÇİŞ)', 'ZİRVE ÜRETİM SQL .NET 7,01 (MÜŞAVİR 7,01 DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '6320', '6762', '6952', 10000, 0, 0, 17, 1, 2, NULL, 16, 0),
(81, 'ZİRVE ÜRETİM SQL .NET 7,01 (TİCARİ 7,01 DEN GEÇİŞ)', 'ZİRVE ÜRETİM SQL .NET 7,01 (TİCARİ 7,01 DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '6320', '6762', '6952', 10000, 0, 0, 17, 1, 2, NULL, 16, 0),
(82, 'ZİRVE ÜRETİM SQL .NET 7,01 (BORDRO 7,01 DEN GEÇİŞ)', 'ZİRVE ÜRETİM SQL .NET 7,01 (BORDRO 7,01 DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '4120', '4408', '4532', 10000, 0, 0, 17, 1, 2, NULL, 16, 0),
(83, 'E-KONTÖR (100)', 'E-KONTÖR (100)', 'adet', '', '', '15', '1', '2', '3', '18', '210', '225', '231', 10000, 0, 0, 17, 1, 2, NULL, 0, 0),
(84, 'E-KONTÖR (250)', 'E-KONTÖR (250)', 'adet', '', '', '15', '1', '2', '3', '18', '290', '310.3', '319', 10000, 0, 0, 17, 1, 2, NULL, 0, 0),
(85, 'E-KONTÖR (500)', 'E-KONTÖR (500)', 'adet', '', '', '15', '1', '2', '3', '18', '510', '546', '561', 10000, 0, 0, 17, 1, 2, NULL, 0, 0),
(86, 'E-KONTÖR (1000)', 'E-KONTÖR (1000)', 'adet', '', '', '15', '1', '2', '3', '18', '950', '1017', '1045', 10000, 0, 0, 17, 1, 2, NULL, 0, 0),
(87, 'E-KONTÖR (2500)', 'E-KONTÖR (2500)', 'adet', '', '', '15', '1', '2', '3', '18', '2150', '2301', '2365', 10000, 0, 0, 17, 1, 2, NULL, 0, 0),
(88, 'E-KONTÖR (5000)', 'E-KONTÖR (5000)', 'adet', '', '', '15', '1', '2', '3', '18', '3850', '4120', '4235', 10000, 0, 0, 17, 1, 2, NULL, 0, 0),
(89, 'E-KONTÖR (10000)', 'E-KONTÖR (10000)', 'adet', '', '', '15', '1', '2', '3', '18', '6150', '6581', '6765', 10000, 0, 0, 17, 1, 2, NULL, 0, 0),
(90, 'E-KONTÖR (20000)', 'E-KONTÖR (20000)', 'adet', '', '', '15', '1', '2', '3', '18', '10850', '11610', '11935', 10000, 0, 0, 17, 1, 2, NULL, 0, 0),
(91, 'E-KONTÖR (50000)', 'E-KONTÖR (50000)', 'adet', '', '', '15', '1', '2', '3', '18', '20950', '22417', '23045', 10000, 0, 0, 17, 1, 2, NULL, 0, 0),
(92, 'E-KONTÖR (100000)', 'E-KONTÖR (100000)', 'adet', '', '', '15', '1', '2', '3', '18', '30950', '33117', '34045', 10000, 0, 0, 17, 1, 2, NULL, 0, 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `hizmet_urun`
--
ALTER TABLE `hizmet_urun`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `hizmet_urun`
--
ALTER TABLE `hizmet_urun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
