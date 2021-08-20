-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 19 Ağu 2021, 17:11:36
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
-- Veritabanı: `satis_takip2`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `arac`
--

CREATE TABLE `arac` (
  `id` int(11) NOT NULL,
  `arac_adi` varchar(225) NOT NULL,
  `marka` varchar(225) NOT NULL,
  `model` varchar(225) NOT NULL,
  `yil` varchar(225) NOT NULL,
  `plaka` varchar(225) NOT NULL,
  `motor` varchar(225) NOT NULL,
  `arac_turu` varchar(225) NOT NULL,
  `ruhsat_sahibi` varchar(225) CHARACTER SET ucs2 NOT NULL,
  `aciklama` text NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `arac`
--

INSERT INTO `arac` (`id`, `arac_adi`, `marka`, `model`, `yil`, `plaka`, `motor`, `arac_turu`, `ruhsat_sahibi`, `aciklama`, `kullanici_id`) VALUES
(1, 'Benim Hyundai', 'Hyundai', 'Accent', '2005', '38 AZ 345', '1.6', '', 'Ali Kaan Özmen', '', 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayar`
--

CREATE TABLE `ayar` (
  `id` int(11) NOT NULL,
  `web_url` varchar(225) DEFAULT NULL,
  `facebook` varchar(225) DEFAULT NULL,
  `twitter` varchar(225) DEFAULT NULL,
  `google` varchar(550) NOT NULL,
  `instagram` varchar(225) NOT NULL,
  `linkedin` varchar(225) NOT NULL,
  `pinterest` varchar(225) NOT NULL,
  `youtube` varchar(225) NOT NULL,
  `email` varchar(225) DEFAULT NULL,
  `email_2` varchar(550) NOT NULL,
  `tel_1` varchar(22) DEFAULT NULL,
  `tel_2` varchar(22) DEFAULT NULL,
  `fax` varchar(22) DEFAULT NULL,
  `adress` varchar(550) DEFAULT NULL,
  `company_name` varchar(500) DEFAULT NULL,
  `seo_keywords` text DEFAULT NULL,
  `maps` varchar(850) NOT NULL,
  `kisa_aciklama` varchar(255) NOT NULL,
  `uzun_aciklama` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ayar`
--

INSERT INTO `ayar` (`id`, `web_url`, `facebook`, `twitter`, `google`, `instagram`, `linkedin`, `pinterest`, `youtube`, `email`, `email_2`, `tel_1`, `tel_2`, `fax`, `adress`, `company_name`, `seo_keywords`, `maps`, `kisa_aciklama`, `uzun_aciklama`) VALUES
(1, 'Bina Yönetimi', 'https://www.facebook.com/Bina', 'https://twitter.com', 'https://www.google.com', 'https://www.instagram.com', 'https://www.linkedin.com', 'https://www.pinterest.com', 'https://www.youtube.com', 'info@blueeyetour.com', '', ' +90 5435052677', NULL, NULL, 'Nevşehir / Türkiye', 'Bina Yönetimi', '<p>\n	Bina Y&ouml;netimiBina Y&ouml;netimiBina Y&ouml;netimiBina Y&ouml;netimiBina Y&ouml;netimi&nbsp;Bina Y&ouml;netimi</p>\n', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3112.7733533618475!2d35.494973515248354!3d38.72301226480962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x152b121382e15555%3A0x9da1ee2a7d4c6380!2sForum+Kayseri!5e0!3m2!1sru!2str!4v1545036384104', 'Bina Yönetimi Bina Yönetimi Bina Yönetimi', '<p>\n	Bina Y&ouml;netimi&nbsp;Bina Y&ouml;netimi&nbsp;Bina Y&ouml;netimi&nbsp;Bina Y&ouml;netimi&nbsp;Bina Y&ouml;netimi</p>\n');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bakim`
--

CREATE TABLE `bakim` (
  `id` int(11) NOT NULL,
  `arac_adi` varchar(225) NOT NULL,
  `bakim_tarihi` date NOT NULL,
  `bakim_adi` varchar(225) NOT NULL,
  `bakim_aciklamasi` text NOT NULL,
  `bakim_yaptiran` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `bakim`
--

INSERT INTO `bakim` (`id`, `arac_adi`, `bakim_tarihi`, `bakim_adi`, `bakim_aciklamasi`, `bakim_yaptiran`, `kullanici_id`) VALUES
(1, '1', '2019-10-22', 'aaaaa', '<p>\n	dadadsd</p>\n', 'sdadassada', 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bina`
--

CREATE TABLE `bina` (
  `id` int(11) NOT NULL,
  `adi` varchar(225) NOT NULL,
  `resmi_adi` varchar(550) NOT NULL,
  `email` varchar(225) NOT NULL,
  `tel` varchar(225) NOT NULL,
  `para_birim` varchar(225) NOT NULL,
  `adres` text NOT NULL,
  `vergi_dairesi` varchar(225) NOT NULL,
  `vergi_no` varchar(225) NOT NULL,
  `fax` varchar(225) NOT NULL,
  `sehir` varchar(225) NOT NULL,
  `ilce` varchar(225) NOT NULL,
  `adres_no` int(11) NOT NULL,
  `faaliyet_kodu` varchar(225) NOT NULL,
  `faaliyet_adi` varchar(225) NOT NULL,
  `ortak_bilgi` text NOT NULL,
  `sgk_iskur_bilgi` text NOT NULL,
  `logo_kase` varchar(225) NOT NULL,
  `blok` int(11) NOT NULL,
  `orkestra_musteri_no` varchar(225) NOT NULL,
  `orkestra_kullanici` varchar(225) NOT NULL,
  `orkestra_sifre` varchar(225) NOT NULL,
  `orkestra_api` varchar(550) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `bina`
--

INSERT INTO `bina` (`id`, `adi`, `resmi_adi`, `email`, `tel`, `para_birim`, `adres`, `vergi_dairesi`, `vergi_no`, `fax`, `sehir`, `ilce`, `adres_no`, `faaliyet_kodu`, `faaliyet_adi`, `ortak_bilgi`, `sgk_iskur_bilgi`, `logo_kase`, `blok`, `orkestra_musteri_no`, `orkestra_kullanici`, `orkestra_sifre`, `orkestra_api`, `kullanici_id`) VALUES
(3, 'Düşler Sitesi', 'Firma resmi adı', '', '', 'TL', '<p>\n	DSDASDASDDDASD</p>\n', 'Gevher Nesibe', '9980743690', '', '', '', 0, '', '', '', '', '', 2, 'zirveinternet', 'zirveinternet', '958162', '93a1683d714b01643de1eca115ca3e5aab43be602f137a6f2a101dc05ffed49851e9607306d6685d8cfc33e9dc98866314b612a88e05c1899123eb5ea3fdcf1d62e3fdc1f5265b813c4da1cf203896c5ce4f369e716be911523cb2d29819a505f2db4e155fe65d4bbb2dbabfe8b29b5b13556856457e554b53e64e8e48f0be07c07bbd798998cc250b2a971307b038d0', 17),
(4, 'Ferah', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 2, '', '', '', '', 19),
(5, 'Deneme 2', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 22),
(6, 'Deneme 3', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 1),
(7, 'Zirve', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 23),
(8, 'Zirve', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 24),
(9, 'Zirve', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 25),
(10, 'burakdenenme', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 26),
(11, 'T.t.a.e', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 27),
(12, 'Deya', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 28),
(13, 'Barış ticaret', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 29),
(14, 'ahmet ltd', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 30),
(15, 'ahmet ltd', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 31),
(16, 'dnmdnmdnm', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 32),
(17, 'Zirve kayseri', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 33),
(18, 'Yyuyyu', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 34),
(19, 'Zirve', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 36),
(20, 'Maysoft', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 37),
(21, 'Kaplan yapı', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 38),
(22, 'H&uuml;seyin', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 39),
(23, 'Uzman genetik', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 40),
(24, 'MURAT  bey', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 41),
(25, 'ucuztelorgu', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 42),
(26, 'ENTEMAK END&Uuml;STRİYEL TEMİZLİK MAKİNELERİ', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 43),
(27, 'Egemengida', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 44),
(28, 'Asıl teknoloji', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 45),
(29, 'Farmaze ila&ccedil; ltd sti', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', 46);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blok`
--

CREATE TABLE `blok` (
  `id` int(11) NOT NULL,
  `adi` varchar(225) NOT NULL,
  `daire_adet` int(11) NOT NULL,
  `blok_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `borc_alacak`
--

CREATE TABLE `borc_alacak` (
  `id` int(11) NOT NULL,
  `fatura_turu` varchar(225) NOT NULL,
  `toplam` varchar(225) NOT NULL,
  `cari_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `vade_tarihi` date NOT NULL,
  `aciklama` text NOT NULL,
  `paylasim_turu` int(11) NOT NULL,
  `ortak_alan_paylasim_turu` varchar(225) NOT NULL,
  `ortak_alan_yuzdesi` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cari`
--

CREATE TABLE `cari` (
  `id` int(11) NOT NULL,
  `adi_soyadi_unvan` varchar(225) NOT NULL,
  `yetkili_kullanici` varchar(225) NOT NULL,
  `tc` varchar(225) NOT NULL,
  `vergi_dairesi` varchar(225) NOT NULL,
  `vergi` varchar(225) NOT NULL,
  `eposta` varchar(225) NOT NULL,
  `cep_tel` varchar(225) NOT NULL,
  `tel` varchar(225) NOT NULL,
  `fax` varchar(225) NOT NULL,
  `adres` text NOT NULL,
  `ilce` varchar(225) NOT NULL,
  `il` varchar(225) NOT NULL,
  `posta_kodu` varchar(225) DEFAULT NULL,
  `ulke` varchar(225) DEFAULT NULL,
  `gorev` varchar(225) DEFAULT NULL,
  `maas` varchar(225) DEFAULT NULL,
  `baslama_tarihi` date DEFAULT NULL,
  `cikis_tarihi` date DEFAULT NULL,
  `ozluk_dosyalari` varchar(225) DEFAULT NULL,
  `aciklama` text DEFAULT NULL,
  `kisi_turu` varchar(225) DEFAULT NULL,
  `bas_boal_durum` int(11) NOT NULL,
  `bas_borc_alacak` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `durum` int(11) NOT NULL,
  `faaliyet_kodu` varchar(225) DEFAULT NULL,
  `faaliyet_adi` varchar(225) DEFAULT NULL,
  `personel` int(11) NOT NULL,
  `musteri_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `cari`
--

INSERT INTO `cari` (`id`, `adi_soyadi_unvan`, `yetkili_kullanici`, `tc`, `vergi_dairesi`, `vergi`, `eposta`, `cep_tel`, `tel`, `fax`, `adres`, `ilce`, `il`, `posta_kodu`, `ulke`, `gorev`, `maas`, `baslama_tarihi`, `cikis_tarihi`, `ozluk_dosyalari`, `aciklama`, `kisi_turu`, `bas_boal_durum`, `bas_borc_alacak`, `kullanici_id`, `durum`, `faaliyet_kodu`, `faaliyet_adi`, `personel`, `musteri_no`) VALUES
(1, 'dsdsdaad', '', '543535353', '', '', 'ytrt@gregregr', '0', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '2', 1, '0', 17, 1, '', '', 0, 0),
(2, 'Mustafa Yıldırım', '', '45658480910', 'htyhyhyh', '1234563454', 'yusuf@zirvekayseri.com', '0', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '2', 1, '0', 17, 1, '', '', 0, 0),
(3, 'Ahmet Sazak', 'ttertret', '54353455345', 'Gevher Nesibe', '23434545345', 'hyhtrhrh@htrhtrhhhr', '534553', '534545', '', 'aaa', 'KAYSERİ', 'hthrhth', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '0', 0, '0', 17, 1, '54345', 'jjtyjytj', 0, 435678),
(4, 'Ahmet Yılmaz', 'ddsadsad', '23456745645', 'dadasd', '4234234', 'ggtgtrg@hyrhyrgr', '44423324234', '4234324', '', 'fdfdfsd', 'fdsfdsf', 'fefwef', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '0', 0, '0', 17, 1, '4234324', 'ggrtgrg', 0, 4324234),
(9, 'QQQQQQQQQQQQQQQ', '', 'FEFERWFWEFWEFQ54353535Q', '', '', 'WEFRWEFEWFE@SDGDSFSD', '0', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '2', 1, '0', 17, 1, '', '', 0, 0),
(10, 'tyrt', '', '45658480910', '', '', 'ahmet@zirvekayseri.com', '0', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '0', 0, '', 17, 0, '', '', 0, 0),
(11, 'Ali Yılmaz', '5345345', '45658480910', '4543543', '534534545', 'ahmet@zirvekayseri.com', '1', '5435345', '', 'yhtyhyhhtyh', 'htyhyh', 'yhyyth', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '0', 0, '0', 17, 1, '6565465', 'hjhjmyuj', 0, 0),
(13, 'Rasim kaplan ', '', '27859919796', 'Mut', '', 'Rasimkaplan@gmail.com', '1', '', '', '', 'Mut', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '0', 0, '', 38, 0, '', '', 0, 0),
(14, 'Konur ', '', '41218218344', '', '', 'alandelon102710@gmail.com', '0', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '0', 0, '', 42, 0, '', '', 0, 0),
(15, 'Hy', '', '18929439320', '', '', 'info@entemak.net', '0', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '0', 0, '', 43, 1, '', '', 0, 0),
(16, 'Abdullah polat', '', '33814904394', 'Bahcesehir', '879292', 'Egemengida2021@gmail.com', '1', '05396250739', '', '<p>Beyoglu cetin</p>', 'Bahcesehir', '', '', 'Turkiye', '', '', '0000-00-00', '0000-00-00', '', '', '0', 0, '', 44, 0, '', '', 0, 0),
(18, 'rrewrew', 'werewr', '3434324324', 'rewrewr', '34234', 'ggbgbg@gregr', '423423423', '4234324', '', 'gegregre', 'gregregreg', 'gregreg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, '0', 17, 1, '4423432', '4gtrgerge', 9, 54321),
(19, 'ytryty', 'rtyrtyry', '43543545', 'tryyrty', '435435345', 'jjtjty@hthtrh', '465534543', '55355435435', '', 'ythtyhyhyth', 'ythythyth', 'hyhth', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, '0', 17, 1, '345435', 'ttyjjytj', 0, 55555),
(20, 'gdfgfdg', 'fdgfdgf', '5656545464', 'dgfdg', '765775', 'ghtrhttrh@dhtth', 'yhyh', 'ythyth', 'yhthy', 'ythtyhyhyth', 'ythythyth', 'hyhth', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, '0', 17, 1, '345435', 'ttyjjytj', 0, 0),
(37, 'deneme', 'deneme', '45658480910', 'fsfdsfdsf', '43432424324', 'deneme@denemeler.com', '5513453456', '4342342344', '2432434324', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', 0, '', 17, 1, NULL, NULL, 0, 123456),
(38, '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, '0', 17, 1, '', '', 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cari_gecmis`
--

CREATE TABLE `cari_gecmis` (
  `id` int(11) NOT NULL,
  `cari_id` int(11) NOT NULL,
  `islem_tarihi` datetime NOT NULL,
  `baslik` varchar(225) NOT NULL,
  `islem` text NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `cari_gecmis`
--

INSERT INTO `cari_gecmis` (`id`, `cari_id`, `islem_tarihi`, `baslik`, `islem`, `kullanici_id`) VALUES
(1, 2, '2020-06-23 00:00:00', 'oıpoıiğıoiıoıiıi', '<p>şğ,ğğp,ğp,ğp,,,p,hluuuk</p>', 17),
(2, 18, '2021-06-24 12:27:27', 'ythythythythty', '<p>yhythythyhyhth</p>', 17),
(3, 1, '2021-08-19 00:00:00', 'ygd için görüşüldü', '<p>ygd için görüşüldü ama ygd yapmayacağını söyledi.</p>', 17),
(4, 1, '2021-08-21 00:00:00', 'yeni program satın aldı', '<p>yeni program satın aldı</p>', 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cek_senet`
--

CREATE TABLE `cek_senet` (
  `id` int(11) NOT NULL,
  `adi` varchar(225) NOT NULL,
  `cari_id` int(11) NOT NULL,
  `cek_senet_no` varchar(225) NOT NULL,
  `giris_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `vade_tarihi` date NOT NULL,
  `tutar` varchar(225) NOT NULL,
  `banka` varchar(225) NOT NULL,
  `islem_id` int(11) NOT NULL,
  `islem_tah_id` int(11) NOT NULL,
  `fat_id` int(11) NOT NULL,
  `tur` int(11) NOT NULL,
  `durum` int(11) NOT NULL,
  `kasa_banka` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `daire`
--

CREATE TABLE `daire` (
  `id` int(11) NOT NULL,
  `bina_id` int(11) NOT NULL,
  `blok_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `daire_no` int(11) NOT NULL,
  `aciklama` text NOT NULL,
  `sahip_id` int(11) NOT NULL,
  `kiraci_id` int(11) NOT NULL,
  `m2` int(11) NOT NULL,
  `elektrik_tesisat_no` varchar(225) NOT NULL,
  `su_tesisat_no` varchar(225) NOT NULL,
  `gaz_tesisat_no` varchar(225) NOT NULL,
  `elektrik_ilk_okuma` varchar(225) NOT NULL,
  `elektrik_son_okuma` varchar(225) NOT NULL,
  `elektrik_okuma_tarihi` date NOT NULL,
  `su_ilk_okuma` varchar(225) NOT NULL,
  `su_son_okuma` varchar(225) NOT NULL,
  `su_okuma_tarihi` date NOT NULL,
  `gaz_ilk_okuma` varchar(225) NOT NULL,
  `gaz_son_okuma` varchar(225) NOT NULL,
  `gaz_okuma_tarihi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dosyalar`
--

CREATE TABLE `dosyalar` (
  `id` int(11) NOT NULL,
  `dosya_adi` varchar(225) NOT NULL,
  `aciklama` text NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ek_kullanici_takip`
--

CREATE TABLE `ek_kullanici_takip` (
  `ek_kullanici_id` int(11) NOT NULL,
  `fat_id` int(11) NOT NULL,
  `cari_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `ek_vkn` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ek_kullanici_takip`
--

INSERT INTO `ek_kullanici_takip` (`ek_kullanici_id`, `fat_id`, `cari_id`, `item_id`, `urun_id`, `ek_vkn`) VALUES
(5, 72, 4, 134, 42, '4324343424'),
(6, 77, 4, 140, 29, '1234567896'),
(7, 77, 4, 141, 70, '1234567890'),
(8, 78, 4, 142, 29, '1111111111'),
(9, 79, 4, 143, 43, '1234567890');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `etkinlik`
--

CREATE TABLE `etkinlik` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `allday` tinyint(1) NOT NULL,
  `adddate` timestamp NOT NULL DEFAULT current_timestamp(),
  `kim` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `etkinlik`
--

INSERT INTO `etkinlik` (`id`, `title`, `start`, `end`, `allday`, `adddate`, `kim`, `kullanici_id`) VALUES
(1, 'ffff', '2021-03-12 07:00:00', '2021-03-12 07:30:00', 0, '2021-03-16 07:38:41', 17, 17),
(2, 'vgfggbb', '2021-03-10 00:00:00', '2021-03-11 00:00:00', 1, '2021-03-16 07:39:40', 17, 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura`
--

CREATE TABLE `fatura` (
  `id` int(11) NOT NULL,
  `fatura_turu` varchar(225) NOT NULL,
  `tutar` varchar(225) NOT NULL,
  `vergi` varchar(225) CHARACTER SET ucs2 NOT NULL,
  `indirim` varchar(225) NOT NULL,
  `toplam` varchar(225) NOT NULL,
  `cari_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `vade_tarihi` date DEFAULT NULL,
  `seri_no` varchar(225) NOT NULL,
  `fatura_no` varchar(225) DEFAULT NULL,
  `aciklama` varchar(225) NOT NULL,
  `irsaliye_durum` int(11) NOT NULL,
  `gelir_gider_fat` int(11) NOT NULL,
  `iade_fat` int(11) NOT NULL,
  `efatura_durum` int(11) NOT NULL,
  `efatura_kayit_no` varchar(225) NOT NULL,
  `personel` int(11) NOT NULL,
  `is_ygd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `fatura`
--

INSERT INTO `fatura` (`id`, `fatura_turu`, `tutar`, `vergi`, `indirim`, `toplam`, `cari_id`, `kullanici_id`, `tarih`, `vade_tarihi`, `seri_no`, `fatura_no`, `aciklama`, `irsaliye_durum`, `gelir_gider_fat`, `iade_fat`, `efatura_durum`, `efatura_kayit_no`, `personel`, `is_ygd`) VALUES
(69, 'Satış', '1.00', '0.18', '0.00', '1.18', 3, 17, '2021-08-17', '0000-00-00', '43424', '443243', 'retertrt', 0, 0, 0, 0, '', 11, 0),
(70, 'Satış', '2750.00', '0.00', '0.00', '2750.00', 4, 17, '2021-08-09', '0000-00-00', '64565466', '456456', 'yutuyu', 0, 0, 0, 0, '', 11, 0),
(71, 'Satış', '609.75', '60.25', '0.00', '670.00', 4, 17, '2021-08-09', '0000-00-00', '423434', '324324', 'retertet', 0, 0, 0, 0, '', 11, 0),
(72, 'Satış', '1350.00', '0.00', '0.00', '1350.00', 4, 17, '2021-08-10', '0000-00-00', '54545', '4324', 'tytyy', 0, 0, 0, 0, '', 11, 0),
(73, 'Satış', '177.97', '32.03', '0.00', '210.00', 4, 17, '2021-08-18', '0000-00-00', '5345435', '454353', 'ytrytrytytry', 0, 0, 0, 0, '', 11, 0),
(74, 'Satış', '813.56', '146.44', '0.00', '960.00', 4, 17, '2021-08-09', '0000-00-00', '45435345', '345345', 'rytytrytryrtyr', 0, 0, 0, 0, '', 11, 0),
(75, 'Satış', '2620.00', '0.00', '0.00', '2620.00', 4, 17, '2021-08-23', '0000-00-00', '545345', '534534', 'tyhtyjyj tyjty jyjj ty', 0, 0, 0, 0, '', 11, 0),
(76, 'Satış', '961.69', '0.31', '0.00', '962.00', 11, 17, '2021-08-16', '0000-00-00', '64564566', '456564', 'yjytjtyjtyj', 0, 0, 0, 0, '', 11, 0),
(77, 'Satış', '940.00', '0.00', '0.00', '940.00', 4, 17, '2021-08-17', '0000-00-00', '654645', '645645', 'yutyuytuyutyu', 0, 0, 0, 0, '', 11, 0),
(78, 'Satış', '820.00', '0.00', '0.00', '820.00', 4, 17, '2021-08-24', '0000-00-00', '543545', '453454', 'htyhtyhtyh', 0, 0, 0, 0, '', 11, 0),
(79, 'Satış', '850.00', '0.00', '0.00', '850.00', 4, 17, '2021-08-17', '0000-00-00', '645646', '464566', 'kykyukyukyku', 0, 0, 0, 0, '', 11, 0),
(81, 'Satış', '4120.00', '0.00', '0.00', '4120.00', 4, 17, '2021-08-31', '0000-00-00', '34234234', '423434', 'tertretert', 0, 0, 0, 0, '', 11, 0),
(99, 'Satış', '4120.00', '0.00', '0.00', '4120.00', 4, 17, '2021-09-30', '2021-09-30', '765756757', '675676', '54355454', 0, 0, 0, 0, '', 0, 0),
(100, 'Satış', '4120.00', '0.00', '0.00', '4120.00', 4, 17, '2021-10-31', '2021-10-31', '4534534324', '442423', '634564535', 0, 0, 0, 0, '', 0, 0),
(101, 'Satış', '4120.00', '0.00', '0.00', '4120.00', 4, 17, '2021-12-31', '2021-12-31', '34545454', '353453', 'tt5tyyhtyhrt', 0, 0, 0, 0, '', 0, 1),
(102, 'Satış', '9900.99', '99.01', '0.00', '10000.00', 4, 17, '2021-08-24', '2021-08-24', '34545345', '454354', 'tgtrgtr', 0, 0, 0, 0, '', 0, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura_item`
--

CREATE TABLE `fatura_item` (
  `id` int(11) NOT NULL,
  `fatura_id` int(11) NOT NULL,
  `fatura_turu` varchar(225) NOT NULL,
  `hizmet_urun_id` int(11) NOT NULL,
  `adet` int(11) NOT NULL,
  `birim_fiyat` varchar(225) NOT NULL,
  `tutar` varchar(225) NOT NULL,
  `aciklama` varchar(225) NOT NULL,
  `indirim` varchar(225) NOT NULL,
  `vergi` int(11) NOT NULL,
  `baslangic` date DEFAULT NULL,
  `gecerlilik` date DEFAULT NULL,
  `kullanici_id` int(11) NOT NULL,
  `is_ygd` int(11) NOT NULL,
  `is_ygd_item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `fatura_item`
--

INSERT INTO `fatura_item` (`id`, `fatura_id`, `fatura_turu`, `hizmet_urun_id`, `adet`, `birim_fiyat`, `tutar`, `aciklama`, `indirim`, `vergi`, `baslangic`, `gecerlilik`, `kullanici_id`, `is_ygd`, `is_ygd_item_id`) VALUES
(129, 69, 'Satış', 11, 1, '1', '1.18', '', '0', 18, '2021-08-17', '2022-08-17', 17, 0, 0),
(130, 70, 'Satış', 14, 1, '2750.00', '2750.00', '', '0', 0, '2021-08-09', '2022-08-09', 17, 0, 0),
(131, 71, 'Satış', 41, 1, '275.00', '275.00', '', '0', 0, '2021-08-09', '2022-08-09', 17, 0, 0),
(132, 71, 'Satış', 22, 1, '334.75', '395.00', '', '0', 18, '2021-08-09', '2022-08-09', 17, 0, 0),
(134, 72, 'Satış', 41, 1, '1350.00', '1350.00', '', '0', 0, '2021-08-10', '2022-08-10', 17, 0, 0),
(135, 73, 'Satış', 83, 1, '177.97', '210.00', '', '0', 18, '2021-08-18', '2022-08-18', 17, 0, 0),
(136, 74, 'Satış', 47, 1, '813.56', '960.00', '', '0', 18, '2021-08-09', '2022-08-09', 17, 0, 0),
(137, 75, 'Satış', 74, 1, '2620.00', '2620.00', '', '0', 0, '2021-08-23', '2022-08-23', 17, 0, 0),
(138, 76, 'Satış', 12, 1, '960.00', '960.00', '', '0', 0, '2021-08-16', '2022-08-16', 17, 0, 0),
(139, 76, 'Satış', 20, 1, '1.69', '2.00', '', '0', 18, '2021-08-16', '2022-08-16', 17, 0, 0),
(140, 77, 'Satış', 29, 1, '820.00', '820.00', '', '0', 0, '2021-08-17', '2022-08-17', 17, 0, 0),
(141, 77, 'Satış', 70, 1, '120.00', '120.00', '', '0', 0, '2021-08-17', '2022-08-17', 17, 0, 0),
(142, 78, 'Satış', 29, 1, '820.00', '820.00', '', '0', 0, '2021-08-24', '2022-08-24', 17, 0, 0),
(143, 79, 'Satış', 43, 1, '850.00', '850.00', '', '0', 0, '2021-08-17', '2022-08-17', 17, 0, 0),
(144, 81, 'Satış', 79, 1, '4120.00', '4120.00', '', '0', 0, '2021-08-31', '2022-08-31', 17, 0, 0),
(149, 99, 'Satış', 16, 1, '4120.00', '4120.00', '', '0', 0, '2021-09-30', '2022-09-30', 17, 0, 0),
(150, 100, 'Satış', 16, 1, '4120.00', '4120.00', '', '0', 0, '2021-10-31', '2022-10-31', 17, 1, 149),
(151, 101, 'Satış', 16, 1, '4120.00', '4120.00', '', '0', 0, '2021-12-31', '2022-12-31', 17, 1, 150),
(152, 102, 'Satış', 16, 1, '9900.99', '10000.00', '', '0', 1, '2021-08-24', '2022-08-24', 17, 1, 151);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura_not`
--

CREATE TABLE `fatura_not` (
  `id` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `aciklama` text NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `fat_turu` varchar(225) NOT NULL,
  `fat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fat_irs_iliski`
--

CREATE TABLE `fat_irs_iliski` (
  `id` int(11) NOT NULL,
  `fat_id` int(11) NOT NULL,
  `irs_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gider_kategori`
--

CREATE TABLE `gider_kategori` (
  `id` int(11) NOT NULL,
  `adi` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `durum` int(11) NOT NULL,
  `tur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gorusme`
--

CREATE TABLE `gorusme` (
  `id` int(11) NOT NULL,
  `tur` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `saat` varchar(225) NOT NULL,
  `kim` int(11) NOT NULL,
  `kiminle` varchar(225) NOT NULL,
  `konu` varchar(225) NOT NULL,
  `teklif` text NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hedefler`
--

CREATE TABLE `hedefler` (
  `hedef_id` int(11) NOT NULL,
  `bayi_id` int(11) NOT NULL,
  `tarih` varchar(225) NOT NULL,
  `yil` int(11) NOT NULL,
  `masaustu_yeni_satis` varchar(550) NOT NULL,
  `e_modul_yeni_satis` varchar(550) NOT NULL,
  `nova` varchar(550) NOT NULL,
  `e_modul_abonelik_yenileme` varchar(550) NOT NULL,
  `ygd_satis` varchar(550) NOT NULL,
  `destek_kalitesi` varchar(550) NOT NULL,
  `cevaplama_orani` varchar(550) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `hedefler`
--

INSERT INTO `hedefler` (`hedef_id`, `bayi_id`, `tarih`, `yil`, `masaustu_yeni_satis`, `e_modul_yeni_satis`, `nova`, `e_modul_abonelik_yenileme`, `ygd_satis`, `destek_kalitesi`, `cevaplama_orani`, `kullanici_id`) VALUES
(1, 0, '7', 2021, '18', '30', '5', '150', '200', '', '', 17),
(2, 1, '7', 2021, '5', '4', '4', '4', '3', '3', '3', 17),
(3, 2, '7', 2021, '3', '3', '3', '3', '3', '3', '3', 17),
(4, 3, '7', 2021, '2', '2', '2', '2', '2', '2', '2', 17),
(5, 4, '7', 2021, '1', '3', '1', '1', '1', '1', '1', 17),
(6, 5, '7', 2021, '88', '85', '55', '56', '56', '54', '44', 17);

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
  `is_vkn_obligatory` int(11) NOT NULL,
  `is_transformation` int(11) NOT NULL,
  `add_user_product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `hizmet_urun`
--

INSERT INTO `hizmet_urun` (`id`, `adi`, `tam_urun_adi`, `birim`, `urun_kodu`, `barkod_no`, `kategori`, `alis_fiyat`, `alis_fiyat_6_tk`, `alis_fiyat_9_tk`, `vergi`, `satis_fiyat`, `satis_fiyat_6_tk`, `satis_fiyat_9_tk`, `bas_stok`, `demirbas`, `demirbas_adet`, `kullanici_id`, `durum`, `urun_grubu`, `urun_hedef_grubu`, `is_upgrade`, `is_vkn_obligatory`, `is_transformation`, `add_user_product`) VALUES
(11, 'MÜŞAVİR PAKET KAMPANYA', 'MÜŞAVİR PAKET KAMPANYA', 'adet', '', '', '2', '1', '2', '3', '18', '2337.5', '2501.38', '2571.25', 100000, 0, 0, 17, 1, 1, NULL, 0, 1, 0, 0),
(12, 'NOVA MÜŞAVİR ABONELİK', 'NOVA MÜŞAVİR ABONELİK', 'adet', '', '', '3', '960', '1027', '1056', '0', '960', '1027', '1056', 100000, 0, 0, 17, 1, 1, 2, 0, 0, 0, 0),
(13, 'MÜŞAVİR', 'MÜŞAVİR', 'adet', '', '', '4', '2550', '2729', '2805', '0', '2550', '2729', '2805', 100000, 0, 0, 17, 1, 1, 1, 0, 0, 0, 0),
(14, 'TİCARİ', 'TİCARİ', 'adet', '', '', '4', '2750', '2943', '3025', '0', '2750', '2943', '3025', 100000, 0, 0, 17, 1, 1, 1, 0, 0, 0, 0),
(15, 'FİNANSMAN', 'FİNANSMAN', 'adet', '', '', '4', '4450', '4762', '4895', '0', '4450', '4762', '4895', 100000, 0, 0, 17, 1, 1, 1, 0, 0, 0, 0),
(16, 'ÜRETİM', 'ÜRETİM', 'adet', '', '', '4', '8050', '8614', '8855', '0', '8050', '8614', '8855', 100000, 0, 0, 17, 1, 1, 1, 0, 0, 0, 0),
(17, 'BORDRO', 'BORDRO', 'adet', '', '', '4', '2450', '2622', '2695', '0', '2450', '2622', '2695', 100000, 0, 0, 17, 1, 1, 1, 0, 0, 0, 0),
(18, 'MUHASEBE', 'MUHASEBE', 'adet', '', '', '4', '2150', '2301', '2365', '0', '2150', '2301', '2365', 100000, 0, 0, 17, 1, 1, 1, 0, 0, 0, 0),
(19, 'KOLAY E SMM ABONELİK', 'KOLAY E SMM ABONELİK', 'adet', '', '', '5', '350', '375', '385', '0', '350', '375', '385', 100000, 0, 0, 17, 1, 1, 0, 0, 0, 0, 0),
(20, 'Nova Müşavir Abone (+2) Kullanıcı', 'Nova Müşavir Abone (+2) Kullanıcı', 'adet', '', '', '6', '1', '2', '3', '18', '2', '2', '3', 100000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 12),
(21, 'Nova Müşavir Abone (+25) Firma', 'Nova Müşavir Abone (+25) Firma', 'adet', '', '', '7', '1', '2', '3', '18', '2', '2', '3', 100000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 12),
(22, 'Drive Yedekleme 5 GB', 'Drive Yedekleme 5 GB', 'adet', '', '', '8', '334.75', '358.47', '368.64', '18', '395', '423', '435', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(23, 'Drive Yedekleme 50 GB', 'Drive Yedekleme 50 GB', 'adet', '', '', '8', '1097.46', '1174.58', '1207.63', '18', '1295', '1386', '1425', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(24, 'Drive Yedekleme 100 GB', 'Drive Yedekleme 100 GB', 'adet', '', '', '8', '1', '2', '3', '18', '1965', '2103', '2162', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(25, 'Drive Yedekleme 200 GB', 'Drive Yedekleme 200 GB', 'adet', '', '', '8', '1', '2', '3', '18', '3535', '3782', '3889', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(26, 'Drive Yedekleme 500 GB', 'Drive Yedekleme 500 GB', 'adet', '', '', '8', '1', '2', '3', '18', '6550', '7009', '7205', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(27, 'Müşavir (+ Kullanıcı)', 'Müşavir (+ Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '255', '273', '281', 100000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 13),
(28, 'e-Smmm Abonelik Paketi', 'e-Smmm Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '350', '375', '385', 100000, 0, 0, 17, 1, 2, 3, 0, 1, 0, 0),
(29, 'e-Defter Abonelik Paketi', 'e-Defter Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '820', '877', '902', 100000, 0, 0, 17, 1, 2, 3, 0, 1, 0, 0),
(30, 'e-Defter Beyan Abonelik', 'e-Defter Beyan Abonelik', 'adet', '', '', '11', '1', '2', '3', '0', '350', '375', '385', 100000, 0, 0, 17, 1, 2, 3, 0, 0, 0, 0),
(31, 'Servis Bedeli', 'Servis Bedeli', 'adet', '', '', '12', '1', '2', '3', '18', '180', '192.6', '198', 100000, 0, 0, 17, 0, 2, 0, 0, 0, 0, 0),
(32, 'Özel Teklif/Sipariş Formu Dizaynı', 'Özel Teklif/Sipariş Formu Dizaynı', 'adet', '', '', '12', '1', '2', '3', '18', '480', '514', '528', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(33, 'Standart Teklif/Sipariş Formu Dizaynı', 'Standart Teklif/Sipariş Formu Dizaynı', 'adet', '', '', '12', '1', '2', '3', '18', '360', '385', '396', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(34, 'Barkod Dizaynı', 'Barkod Dizaynı', 'adet', '', '', '12', '1', '2', '3', '18', '480', '514', '528', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(35, 'Yerinde Servis (Evrak Dizaynı)', 'Yerinde Servis (Evrak Dizaynı)', 'adet', '', '', '12', '1', '2', '3', '18', '210', '224.7', '231', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(36, 'Ana Makina Değişimi (Internet Üzerinden)', 'Ana Makina Değişimi (Internet Üzerinden)', 'adet', '', '', '12', '1', '2', '3', '18', '120', '128.4', '132', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(37, 'Ana Makina Değişimi (Yerinde Servis)', 'Ana Makina Değişimi (Yerinde Servis)', 'adet', '', '', '12', '1', '2', '3', '18', '210', '225', '231', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(38, 'Müşavir Paketi Harici Program Desteği', 'Müşavir Paketi Harici Program Desteği', 'adet', '', '', '12', '1', '2', '3', '18', '1000', '1070', '1100', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(39, 'Kantar Modülü', 'Kantar Modülü', 'adet', '', '', '13', '1', '2', '3', '18', '1200', '1284', '1320', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(40, 'Personel Takip (Otomasyonlu)', 'Personel Takip (Otomasyonlu)', 'adet', '', '', '13', '1', '2', '3', '18', '1200', '1284', '1320', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(41, 'Ticari (+Kullanıcı)', 'Ticari (+Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '275', '294', '303', 100000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 14),
(42, 'e-Fatura/e-Arşiv Abonelik Paketi', 'e-Fatura/e-Arşiv Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '1350', '1445', '1485', 100000, 0, 0, 17, 1, 2, 3, 0, 1, 0, 0),
(43, 'e-İrsaliye Abonelik Paketi', 'e-İrsaliye Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '850', '910', '935', 100000, 0, 0, 17, 0, 2, 3, 0, 1, 0, 0),
(44, 'e-Müstahsil Abonelik Paketi', 'e-Müstahsil Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '350', '375', '385', 100000, 0, 0, 17, 1, 2, 3, 0, 1, 0, 0),
(45, 'e-Fatura Dizaynı (İlk Dizayn)', 'e-Fatura Dizaynı (İlk Dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '660', '706', '726', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(46, 'e-Fatura Dizaynı (1\'den sonraki dizayn)', 'e-Fatura Dizaynı (1\'den sonraki dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '300', '321', '330', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(47, 'e-Fatura Dizaynı + (İhracat)', 'e-Fatura Dizaynı + (İhracat)', 'adet', '', '', '12', '1', '2', '3', '18', '960', '1027', '1056', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(48, 'e-Fatura Dizaynı + (Dövizli)', 'e-Fatura Dizaynı + (Dövizli)', 'adet', '', '', '12', '1', '2', '3', '18', '960', '1027', '1056', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(49, 'e-Fatura Dizaynı + (Dövizli) +  (İhracat)', 'e-Fatura Dizaynı + (Dövizli) +  (İhracat)', 'adet', '', '', '12', '1', '2', '3', '18', '1260', '1348', '1386', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(50, 'e-Fatura Dizayn Düzenleme', 'e-Fatura Dizayn Düzenleme', 'adet', '', '', '12', '1', '2', '3', '18', '120', '128.4', '132', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(51, 'e-Arşiv Fatura Dizaynı (İlk Dizayn)', 'e-Arşiv Fatura Dizaynı (İlk Dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '660', '706', '726', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(52, 'e-Arşiv Fatura Dizaynı (1\'den sonraki dizayn)', 'e-Arşiv Fatura Dizaynı (1\'den sonraki dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '300', '321', '330', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(53, 'e-Arşiv Fatura Dizaynı + (Dövizli)', 'e-Arşiv Fatura Dizaynı + (Dövizli)', 'adet', '', '', '12', '1', '2', '3', '18', '960', '1027', '1056', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(54, 'e-Arşiv Fatura Dizaynı + (Dövizli) + (İhracat)', 'e-Arşiv Fatura Dizaynı + (Dövizli) + (İhracat)', 'adet', '', '', '12', '1', '2', '3', '18', '1260', '1348', '1386', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(55, 'e-Arşiv Fatura Dizayn Düzenleme', 'e-Arşiv Fatura Dizayn Düzenleme', 'adet', '', '', '12', '1', '2', '3', '18', '120', '128.4', '132', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(56, 'Ticari Paket Harici Program Desteği', 'Ticari Paket Harici Program Desteği', 'adet', '', '', '12', '1', '2', '3', '18', '1000', '1070', '1100', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(57, 'e-İrsaliye Dizaynı (İlk Dizayn)', 'e-İrsaliye Dizaynı (İlk Dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '660', '706', '726', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(58, 'e-İrsaliye Dizaynı (1\'den sonraki dizayn)', 'e-İrsaliye Dizaynı (1\'den sonraki dizayn)', 'adet', '', '', '12', '1', '2', '3', '18', '300', '321', '330', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(59, 'e-İrsaliye Dizaynı + (Dövizli)', 'e-İrsaliye Dizaynı + (Dövizli)', 'adet', '', '', '12', '1', '2', '3', '18', '960', '1027', '1056', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(60, 'e-İrsaliye Dizayn Düzenleme', 'e-İrsaliye Dizayn Düzenleme', 'adet', '', '', '12', '1', '2', '3', '18', '120', '128.4', '132', 100000, 0, 0, 17, 1, 2, 0, 0, 0, 0, 0),
(61, 'Finansman (+ Kullanıcı)', 'Finansman (+ Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '445', '476', '490', 100000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 15),
(62, 'Üretim (+Kullanıcı)', 'Üretim (+Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '805', '861', '886', 100000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 16),
(63, 'Bordro (+Kullanıcı)', 'Bordro (+Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '245', '262', '270', 100000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 17),
(64, 'Muhasebe Paketi (+Kullanıcı)', 'Muhasebe Paketi (+Kullanıcı)', 'adet', '', '', '9', '1', '2', '3', '0', '215', '230', '237', 0, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 18),
(66, 'E-Kontör', 'E-Kontör', 'adet', '', '', '', '1', '2', '3', '18', '2', '2', '3', 100000, 0, 0, 17, 1, 2, 3, 0, 0, 0, 0),
(67, 'E-Kontör (100)', 'E-Kontör (100)', 'adet', '', '', '', '1', '2', '3', '18', '210', '235', '231', 100000, 0, 0, 17, 1, 2, 3, 0, 0, 0, 0),
(68, '', '', '', '', '', '', '', '2', '3', '18', '', '2', '3', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(69, 'e-Fatura/e-Arşiv Abonelik Paketi EK (VKN)', 'e-Fatura/e-Arşiv Abonelik Paketi', 'adet', '', '', '10', '1', '2', '3', '0', '350', '375', '385', 100000, 0, 0, 17, 1, 2, 3, 0, 1, 42, 0),
(70, 'e-Defter Abonelik Paketi EK (VKN)', 'e-Defter Abonelik Paketi EK (VKN)', 'adet', '', '', '10', '1', '2', '3', '0', '120', '128', '132', 100000, 0, 0, 17, 1, 2, 3, 0, 1, 29, 0),
(71, 'e-İrsaliye Abonelik Paketi EK (VKN)', 'e-İrsaliye Abonelik Paketi EK (VKN)', 'adet', '', '', '10', '1', '2', '3', '0', '150', '161', '165', 100000, 0, 0, 17, 0, 2, 3, 0, 1, 43, 0),
(72, 'e-Müstahsil Abonelik Paketi EK (VKN)', 'e-Müstahsil Abonelik Paketi EK (VKN)', 'adet', '', '', '10', '1', '2', '3', '0', '150', '161', '165', 100000, 0, 0, 17, 1, 2, 3, 0, 1, 44, 0),
(73, 'ZİRVE FİNANSMAN SQL.NET 7.01(MÜŞAVİR SQL \'DEN GEÇİŞ)', 'ZİRVE FİNANSMAN SQL.NET 7.01(MÜŞAVİR SQL \'DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '2620', '2803', '2882', 100000, 0, 0, 17, 1, 2, NULL, 15, 0, 0, 0),
(74, 'ZİRVE FİNANSMAN SQL.NET 7.01 (TİCARİ SQL\'DEN GEÇİŞ)', 'ZİRVE FİNANSMAN SQL.NET 7.01 (TİCARİ SQL\'DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '2620', '2803', '2882', 100000, 0, 0, 17, 1, 2, NULL, 15, 0, 0, 0),
(75, 'ZİRVE FİNANSMAN SQL.NET 7.01 (BORDRODAN SQL\'DEN GEÇİŞ)', 'ZİRVE FİNANSMAN SQL.NET 7.01 (BORDRODAN SQL\'DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '3420', '3659', '3762', 100000, 0, 0, 17, 1, 2, NULL, 15, 0, 0, 0),
(76, 'ZİRVE MÜŞAVİR SQL .NET 7.01 (BORDRO SQL DEN GEÇİŞ)', 'ZİRVE MÜŞAVİR SQL .NET 7.01 (BORDRO SQL DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '1420', '1519', '1562', 100000, 0, 0, 17, 1, 2, NULL, 13, 0, 0, 0),
(77, 'ZİRVE MÜŞAVİR SQL .NET 7.01 (MUHASEBE SQL DEN GEÇİŞ)', 'ZİRVE MÜŞAVİR SQL .NET 7.01 (MUHASEBE SQL DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '1420', '1519', '1562', 100000, 0, 0, 17, 1, 2, NULL, 13, 0, 0, 0),
(78, 'ZİRVE MÜŞAVİR SQL .NET 7.01 (İŞLETME SQL DEN GEÇİŞ)', 'ZİRVE MÜŞAVİR SQL .NET 7.01 (İŞLETME SQL DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '1420', '1519', '1562', 10000, 0, 0, 17, 1, 2, NULL, 13, 0, 0, 0),
(79, 'ZİRVE ÜRETIM SQL .NET 7.01 (FİNANS 7.01 DEN GEÇİŞ)', 'ZİRVE ÜRETIM SQL .NET 7.01 (FİNANS 7.01 DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '4120', '4408', '4532', 10000, 0, 0, 17, 1, 2, NULL, 16, 0, 0, 0),
(80, 'ZİRVE ÜRETİM SQL .NET 7,01 (MÜŞAVİR 7,01 DEN GEÇİŞ)', 'ZİRVE ÜRETİM SQL .NET 7,01 (MÜŞAVİR 7,01 DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '6320', '6762', '6952', 10000, 0, 0, 17, 1, 2, NULL, 16, 0, 0, 0),
(81, 'ZİRVE ÜRETİM SQL .NET 7,01 (TİCARİ 7,01 DEN GEÇİŞ)', 'ZİRVE ÜRETİM SQL .NET 7,01 (TİCARİ 7,01 DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '6320', '6762', '6952', 10000, 0, 0, 17, 1, 2, NULL, 16, 0, 0, 0),
(82, 'ZİRVE ÜRETİM SQL .NET 7,01 (BORDRO 7,01 DEN GEÇİŞ)', 'ZİRVE ÜRETİM SQL .NET 7,01 (BORDRO 7,01 DEN GEÇİŞ)', 'adet', '', '', '14', '1', '2', '3', '0', '4120', '4408', '4532', 10000, 0, 0, 17, 1, 2, NULL, 16, 0, 0, 0),
(83, 'E-KONTÖR (100)', 'E-KONTÖR (100)', 'adet', '', '', '15', '1', '2', '3', '18', '210', '225', '231', 10000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 0),
(84, 'E-KONTÖR (250)', 'E-KONTÖR (250)', 'adet', '', '', '15', '1', '2', '3', '18', '290', '310.3', '319', 10000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 0),
(85, 'E-KONTÖR (500)', 'E-KONTÖR (500)', 'adet', '', '', '15', '1', '2', '3', '18', '510', '546', '561', 10000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 0),
(86, 'E-KONTÖR (1000)', 'E-KONTÖR (1000)', 'adet', '', '', '15', '1', '2', '3', '18', '950', '1017', '1045', 10000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 0),
(87, 'E-KONTÖR (2500)', 'E-KONTÖR (2500)', 'adet', '', '', '15', '1', '2', '3', '18', '2150', '2301', '2365', 10000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 0),
(88, 'E-KONTÖR (5000)', 'E-KONTÖR (5000)', 'adet', '', '', '15', '1', '2', '3', '18', '3850', '4120', '4235', 10000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 0),
(89, 'E-KONTÖR (10000)', 'E-KONTÖR (10000)', 'adet', '', '', '15', '1', '2', '3', '18', '6150', '6581', '6765', 10000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 0),
(90, 'E-KONTÖR (20000)', 'E-KONTÖR (20000)', 'adet', '', '', '15', '1', '2', '3', '18', '10850', '11610', '11935', 10000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 0),
(91, 'E-KONTÖR (50000)', 'E-KONTÖR (50000)', 'adet', '', '', '15', '1', '2', '3', '18', '20950', '22417', '23045', 10000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 0),
(92, 'E-KONTÖR (100000)', 'E-KONTÖR (100000)', 'adet', '', '', '15', '1', '2', '3', '18', '30950', '33117', '34045', 10000, 0, 0, 17, 1, 2, NULL, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `irsaliye`
--

CREATE TABLE `irsaliye` (
  `id` int(11) NOT NULL,
  `fatura_turu` varchar(225) NOT NULL,
  `cari_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `vade_tarihi` date NOT NULL,
  `irsaliye_no` varchar(225) NOT NULL,
  `il` varchar(225) NOT NULL,
  `adres` text CHARACTER SET utf32 COLLATE utf32_turkish_ci NOT NULL,
  `aciklama` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `irsaliye_item`
--

CREATE TABLE `irsaliye_item` (
  `id` int(11) NOT NULL,
  `fatura_id` int(11) NOT NULL,
  `hizmet_urun_id` int(11) NOT NULL,
  `adet` int(11) NOT NULL,
  `aktarim` int(11) NOT NULL DEFAULT 0,
  `aciklama` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `islem`
--

CREATE TABLE `islem` (
  `id` int(11) NOT NULL,
  `islem_turu` int(11) NOT NULL,
  `relation_type` varchar(225) NOT NULL,
  `relation_id` int(11) NOT NULL,
  `giris_cikis` int(11) NOT NULL,
  `tutar` varchar(225) NOT NULL,
  `tarih` date NOT NULL,
  `kategori` varchar(225) NOT NULL,
  `aciklama` text NOT NULL,
  `cari_id` int(11) NOT NULL,
  `kasa_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `gelir_gider_fat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `islem`
--

INSERT INTO `islem` (`id`, `islem_turu`, `relation_type`, `relation_id`, `giris_cikis`, `tutar`, `tarih`, `kategori`, `aciklama`, `cari_id`, `kasa_id`, `kullanici_id`, `gelir_gider_fat`) VALUES
(135, 4, 'Fatura', 69, 0, '1.18', '2021-08-17', '', 'retertrt', 3, 0, 17, 0),
(136, 3, 'Tahsilat-Ödeme', 69, 1, '1.18', '2021-08-17', '', 'retertrt', 3, 0, 17, 0),
(137, 4, 'Fatura', 70, 0, '2750.00', '2021-08-09', '', 'yutuyu', 4, 0, 17, 0),
(138, 3, 'Tahsilat-Ödeme', 70, 1, '2750.00', '2021-08-09', '', 'yutuyu', 4, 0, 17, 0),
(139, 4, 'Fatura', 71, 0, '670.00', '2021-08-09', '', 'retertet', 4, 0, 17, 0),
(140, 3, 'Tahsilat-Ödeme', 71, 1, '670.00', '2021-08-09', '', 'retertet', 4, 0, 17, 0),
(141, 4, 'Fatura', 72, 0, '1350.00', '2021-08-10', '', 'tytyy', 4, 0, 17, 0),
(142, 3, 'Tahsilat-Ödeme', 72, 1, '44550.00', '2021-08-10', '', 'tytyy', 4, 0, 17, 0),
(143, 4, 'Fatura', 73, 0, '210.00', '2021-08-18', '', 'ytrytrytytry', 4, 0, 17, 0),
(144, 3, 'Tahsilat-Ödeme', 73, 1, '210.00', '2021-08-18', '', 'ytrytrytytry', 4, 0, 17, 0),
(145, 4, 'Fatura', 74, 0, '960.00', '2021-08-09', '', 'rytytrytryrtyr', 4, 0, 17, 0),
(146, 3, 'Tahsilat-Ödeme', 74, 1, '960.00', '2021-08-09', '', 'rytytrytryrtyr', 4, 0, 17, 0),
(147, 4, 'Fatura', 75, 0, '2620.00', '2021-08-23', '', 'tyhtyjyj tyjty jyjj ty', 4, 0, 17, 0),
(148, 3, 'Tahsilat-Ödeme', 75, 1, '2620.00', '2021-08-23', '', 'tyhtyjyj tyjty jyjj ty', 4, 0, 17, 0),
(149, 4, 'Fatura', 76, 0, '962.00', '2021-08-16', '', 'yjytjtyjtyj', 11, 0, 17, 0),
(150, 3, 'Tahsilat-Ödeme', 76, 1, '962.00', '2021-08-16', '', 'yjytjtyjtyj', 11, 0, 17, 0),
(151, 4, 'Fatura', 77, 0, '940.00', '2021-08-17', '', 'yutyuytuyutyu', 4, 0, 17, 0),
(152, 3, 'Tahsilat-Ödeme', 77, 1, '940.00', '2021-08-17', '', 'yutyuytuyutyu', 4, 0, 17, 0),
(153, 4, 'Fatura', 78, 0, '820.00', '2021-08-24', '', 'htyhtyhtyh', 4, 0, 17, 0),
(154, 3, 'Tahsilat-Ödeme', 78, 1, '820.00', '2021-08-24', '', 'htyhtyhtyh', 4, 0, 17, 0),
(155, 4, 'Fatura', 79, 0, '850.00', '2021-08-17', '', 'kykyukyukyku', 4, 0, 17, 0),
(156, 3, 'Tahsilat-Ödeme', 79, 1, '850.00', '2021-08-17', '', 'kykyukyukyku', 4, 0, 17, 0),
(157, 4, 'Fatura', 81, 0, '4120.00', '2021-08-31', '', 'tertretert', 4, 0, 17, 0),
(158, 3, 'Tahsilat-Ödeme', 81, 1, '4120.00', '2021-08-31', '', 'tertretert', 4, 0, 17, 0),
(159, 4, 'Fatura', 82, 0, '4120.00', '0000-00-00', '', '355454', 4, 0, 17, 0),
(160, 3, 'Tahsilat-Ödeme', 82, 1, '4120.00', '0000-00-00', '', '355454', 4, 0, 17, 0),
(161, 4, 'Fatura', 83, 0, '4120.00', '0000-00-00', '', 'gfhghgfh', 4, 0, 17, 0),
(162, 3, 'Tahsilat-Ödeme', 83, 1, '4120.00', '0000-00-00', '', 'gfhghgfh', 4, 0, 17, 0),
(163, 4, 'Fatura', 85, 0, '4120.00', '0000-00-00', '', 'hhgfhgfhfth', 4, 0, 17, 0),
(164, 3, 'Tahsilat-Ödeme', 85, 1, '4120.00', '0000-00-00', '', 'hhgfhgfhfth', 4, 0, 17, 0),
(165, 4, 'Fatura', 86, 0, '4120.00', '2021-08-25', '', 'yutyuytu', 4, 0, 17, 0),
(166, 3, 'Tahsilat-Ödeme', 86, 1, '4120.00', '2021-08-25', '', 'yutyuytu', 4, 0, 17, 0),
(167, 4, 'Fatura', 87, 0, '4120.00', '2021-08-25', '', 'rtrtert', 4, 0, 17, 0),
(168, 3, 'Tahsilat-Ödeme', 87, 1, '4120.00', '2021-08-25', '', 'rtrtert', 4, 0, 17, 0),
(169, 4, 'Fatura', 88, 0, '4120.00', '0000-00-00', '', 'trhhhrhtrhrh', 4, 0, 17, 0),
(170, 3, 'Tahsilat-Ödeme', 88, 1, '4120.00', '0000-00-00', '', 'trhhhrhtrhrh', 4, 0, 17, 0),
(171, 4, 'Fatura', 89, 0, '4120.00', '2021-08-31', '', 'thtryhrhtr', 4, 0, 17, 0),
(172, 3, 'Tahsilat-Ödeme', 89, 1, '4120.00', '2021-08-31', '', 'thtryhrhtr', 4, 0, 17, 0),
(173, 4, 'Fatura', 90, 0, '4120.00', '2021-08-31', '', 'HUTYHYHTYH', 4, 0, 17, 0),
(174, 3, 'Tahsilat-Ödeme', 90, 1, '4120.00', '2021-08-31', '', 'HUTYHYHTYH', 4, 0, 17, 0),
(175, 4, 'Fatura', 91, 0, '4120.00', '2021-08-31', '', 'HUTYHYHTYH', 4, 0, 17, 0),
(176, 3, 'Tahsilat-Ödeme', 91, 1, '4120.00', '2021-08-31', '', 'HUTYHYHTYH', 4, 0, 17, 0),
(177, 4, 'Fatura', 92, 0, '4120.00', '2021-08-31', '', 'HUTYHYHTYH', 4, 0, 17, 0),
(178, 3, 'Tahsilat-Ödeme', 92, 1, '4120.00', '2021-08-31', '', 'HUTYHYHTYH', 4, 0, 17, 0),
(179, 4, 'Fatura', 93, 0, '4120.00', '2021-08-26', '', 'RTRETRETR', 4, 0, 17, 0),
(180, 3, 'Tahsilat-Ödeme', 93, 1, '4120.00', '2021-08-26', '', 'RTRETRETR', 4, 0, 17, 0),
(181, 4, 'Fatura', 94, 0, '4120.00', '2021-08-25', '', '42344', 4, 0, 17, 0),
(182, 3, 'Tahsilat-Ödeme', 94, 1, '4120.00', '2021-08-25', '', '42344', 4, 0, 17, 0),
(183, 4, 'Fatura', 95, 0, '4120.00', '2021-08-27', '', 'RETGRGR', 4, 0, 17, 0),
(184, 3, 'Tahsilat-Ödeme', 95, 1, '4120.00', '2021-08-27', '', 'RETGRGR', 4, 0, 17, 0),
(185, 4, 'Fatura', 96, 0, '4120.00', '2021-08-30', '', 'trytry', 4, 0, 17, 0),
(186, 3, 'Tahsilat-Ödeme', 96, 1, '4120.00', '2021-08-30', '', 'trytry', 4, 0, 17, 0),
(187, 4, 'Fatura', 97, 0, '4120.00', '2021-08-29', '', 'ttryt', 4, 0, 17, 0),
(188, 3, 'Tahsilat-Ödeme', 97, 1, '4120.00', '2021-08-29', '', 'ttryt', 4, 0, 17, 0),
(189, 4, 'Fatura', 98, 0, '4120.00', '2021-08-28', '', 'gterttrert', 4, 0, 17, 0),
(190, 3, 'Tahsilat-Ödeme', 98, 1, '4120.00', '2021-08-28', '', 'gterttrert', 4, 0, 17, 0),
(191, 4, 'Fatura', 99, 0, '4120.00', '2021-09-30', '', '54355454', 4, 0, 17, 0),
(192, 3, 'Tahsilat-Ödeme', 99, 1, '4120.00', '2021-09-30', '', '54355454', 4, 0, 17, 0),
(193, 4, 'Fatura', 100, 0, '4120.00', '2021-10-31', '', '634564535', 4, 0, 17, 0),
(194, 3, 'Tahsilat-Ödeme', 100, 1, '4120.00', '2021-10-31', '', '634564535', 4, 0, 17, 0),
(195, 4, 'Fatura', 101, 0, '4120.00', '2021-12-31', '', 'tt5tyyhtyhrt', 4, 0, 17, 0),
(196, 3, 'Tahsilat-Ödeme', 101, 1, '4120.00', '2021-12-31', '', 'tt5tyyhtyhrt', 4, 0, 17, 0),
(197, 4, 'Fatura', 102, 0, '10000.00', '2021-08-24', '', 'tgtrgtr', 4, 0, 17, 0),
(198, 3, 'Tahsilat-Ödeme', 102, 1, '10000.00', '2021-08-24', '', 'tgtrgtr', 4, 0, 17, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `izin`
--

CREATE TABLE `izin` (
  `id` int(11) NOT NULL,
  `gun` varchar(225) NOT NULL,
  `baslangic_tarihi` date NOT NULL,
  `bitis_tarihi` date NOT NULL,
  `aciklama` text NOT NULL,
  `cari_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kampanya_urunleri`
--

CREATE TABLE `kampanya_urunleri` (
  `kampanya_urun_id` int(11) NOT NULL,
  `kampanya_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `ana_urun` int(11) NOT NULL,
  `kullanici` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kampanya_urunleri`
--

INSERT INTO `kampanya_urunleri` (`kampanya_urun_id`, `kampanya_id`, `urun_id`, `ana_urun`, `kullanici`) VALUES
(1, 9, 15, 1, 17),
(2, 9, 42, 0, 17),
(3, 9, 66, 0, 17),
(4, 10, 14, 1, 17),
(5, 10, 42, 0, 17),
(6, 10, 66, 0, 17),
(7, 11, 29, 0, 17),
(8, 11, 13, 1, 17),
(9, 11, 22, 0, 17),
(10, 11, 67, 0, 17),
(11, 11, 28, 0, 17),
(12, 11, 30, 0, 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kasa`
--

CREATE TABLE `kasa` (
  `id` int(11) NOT NULL,
  `kodu` varchar(225) NOT NULL,
  `adi` varchar(225) NOT NULL,
  `turu` varchar(225) NOT NULL,
  `bas_kasa` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kasa`
--

INSERT INTO `kasa` (`id`, `kodu`, `adi`, `turu`, `bas_kasa`, `kullanici_id`) VALUES
(1, '01', 'Merkez', '', '', 37);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kategori_adi` varchar(225) NOT NULL,
  `kategori_turu` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kategori`
--

INSERT INTO `kategori` (`id`, `kategori_adi`, `kategori_turu`, `kullanici_id`) VALUES
(1, 'aaaaaaaa', 'urun', 17),
(2, 'Cep Telefonu ', 'urun', 45),
(3, 'Şarj Aleti ', 'urun', 45),
(4, 'Şarj Kablosu', 'urun', 45),
(5, 'Ses Bombası ', 'urun', 45),
(6, 'Güvenlik Kamerası ', 'urun', 45),
(7, 'Klavye', 'urun', 45),
(8, 'Mause', 'urun', 45),
(9, 'Kulaklık  wifi', 'urun', 45),
(10, 'Kulaklık kablolu', 'urun', 45);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `km`
--

CREATE TABLE `km` (
  `id` int(11) NOT NULL,
  `arac_adi` varchar(225) NOT NULL,
  `yol_bas_saat` time NOT NULL,
  `yol_bas_tarih` date NOT NULL,
  `yol_bit_saat` time NOT NULL,
  `yol_bit_tarih` date NOT NULL,
  `km_baslangic` int(11) NOT NULL,
  `km_bitis` int(11) NOT NULL,
  `yol_aciklamasi` varchar(225) NOT NULL,
  `yol_yapan` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `komite`
--

CREATE TABLE `komite` (
  `id` int(11) NOT NULL,
  `cari_id` int(11) NOT NULL,
  `unvan` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `kim` int(11) NOT NULL,
  `nerede` varchar(225) NOT NULL,
  `tablo` varchar(225) NOT NULL,
  `islem` varchar(225) NOT NULL,
  `kayit_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `log`
--

INSERT INTO `log` (`id`, `kim`, `nerede`, `tablo`, `islem`, `kayit_id`, `kullanici_id`, `tarih`) VALUES
(1, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 5, 17, '2020-06-24 08:17:31'),
(2, 17, 'Fatura Silme', 'fatura', 'Silme', 0, 17, '2020-06-24 08:24:50'),
(3, 17, 'Fatura Silme', 'fatura', 'Silme', 0, 17, '2020-06-24 08:25:38'),
(4, 17, 'Fatura Silme', 'fatura', 'Silme', 0, 17, '2020-06-24 08:25:42'),
(5, 17, 'Fatura Silme', 'fatura', 'Silme', 0, 17, '2020-06-24 08:26:05'),
(6, 17, 'Hizmet Ürün Silme', 'hizmet_urun', 'Silme', 0, 17, '2020-06-24 08:51:13'),
(7, 17, 'Hizmet Ürün Silme', 'hizmet_urun', 'Silme', 0, 17, '2020-06-24 08:51:28'),
(8, 17, 'Kategori', 'kategori', 'Ekleme', 1, 17, '2020-06-24 09:02:12'),
(9, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 4, 17, '2020-06-24 13:18:37'),
(10, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 6, 17, '2020-06-24 13:19:38'),
(11, 17, 'Cari', 'cari', 'Güncelleme', 2, 17, '2020-06-24 13:22:23'),
(12, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 2, 17, '2020-06-24 13:35:57'),
(13, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 2, 17, '2020-06-24 13:36:46'),
(14, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 2, 17, '2020-06-24 13:42:56'),
(15, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 2, 17, '2020-06-24 13:52:42'),
(16, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 2, 17, '2020-06-24 13:57:23'),
(17, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 7, 17, '2020-06-24 14:14:56'),
(18, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-06-24 14:15:10'),
(19, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 3, 17, '2020-06-24 14:15:21'),
(20, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 3, 17, '2020-06-24 14:23:24'),
(21, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-06-25 07:53:34'),
(22, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-06-25 07:55:11'),
(23, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 3, 17, '2020-06-25 08:09:58'),
(24, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 3, 17, '2020-06-25 08:11:58'),
(25, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-06-25 08:29:24'),
(26, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-06-25 11:37:26'),
(27, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-06-25 11:38:35'),
(28, 17, 'faturaNot Kaydı', 'notlar', 'Ekleme', 3, 17, '2020-06-25 11:55:00'),
(29, 17, 'fatura Not Silme', 'notlar', 'Silme', 0, 17, '2020-06-25 11:55:05'),
(30, 17, 'Çek Senet', 'cek_senet', 'Silme', 1, 17, '2020-06-26 07:23:28'),
(31, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 3, 17, '2020-06-26 07:52:46'),
(32, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-06-26 07:53:52'),
(33, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 3, 17, '2020-06-26 07:55:52'),
(34, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-06-30 07:19:57'),
(35, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-07-01 08:36:01'),
(36, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-07-01 09:03:33'),
(37, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-07-01 12:32:53'),
(38, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-07-01 12:33:11'),
(39, 17, 'Fatura', 'fatura', 'E-Fatura Gönderildi', 3, 17, '2020-07-01 12:33:43'),
(40, 17, 'Etkinlik', 'etkinlik', 'Ekleme', 1, 17, '2020-07-01 12:58:05'),
(41, 17, 'Zaman', 'zaman', 'Ekleme', 1, 17, '2020-07-01 13:00:25'),
(42, 17, 'tartisma', 'tartisma', 'Ekleme', 1, 17, '2020-07-01 13:07:21'),
(43, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-02 07:37:52'),
(44, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-02 07:41:05'),
(45, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-02 07:44:05'),
(46, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-02 07:48:26'),
(47, 17, 'Mesaj Gönderim', 'mesaj', 'Gönderildi', 0, 17, '2020-07-02 07:51:34'),
(48, 17, 'Mesaj Gönderim', 'mesaj', 'Gönderildi', 0, 17, '2020-07-02 07:52:20'),
(49, 17, 'Mesaj Gönderim', 'mesaj', 'Gönderildi', 0, 17, '2020-07-02 07:53:24'),
(50, 17, 'Mesaj Gönderim', 'mesaj', 'Gönderildi', 0, 17, '2020-07-02 07:53:33'),
(51, 17, 'Mesaj Gönderim', 'mesaj', 'Gönderildi', 0, 17, '2020-07-02 07:53:35'),
(52, 17, 'Mesaj Gönderim', 'mesaj', 'Gönderildi', 0, 17, '2020-07-02 07:53:37'),
(53, 17, 'Mesaj Gönderim', 'mesaj', 'Gönderildi', 0, 17, '2020-07-02 07:53:56'),
(54, 17, 'Mesaj Gönderim', 'mesaj', 'Gönderildi', 0, 17, '2020-07-02 07:53:58'),
(55, 17, 'Etkinlik', 'etkinlik', 'Silme', 0, 17, '2020-07-02 08:07:03'),
(56, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-07-02 14:46:05'),
(57, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-07-02 14:46:27'),
(58, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-07-14 12:42:09'),
(59, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-07-14 13:50:51'),
(60, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-07-21 11:32:48'),
(61, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 8, 17, '2020-07-21 11:34:00'),
(62, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 4, 17, '2020-07-21 11:34:09'),
(63, 17, 'Fatura Güncelle', 'fatura', 'Güncelleme', 4, 17, '2020-07-21 11:34:31'),
(64, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 4, 17, '2020-07-21 11:34:38'),
(65, 17, 'Fatura Güncelle', 'fatura', 'Güncelleme', 4, 17, '2020-07-21 11:35:05'),
(66, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 4, 17, '2020-07-21 11:35:12'),
(67, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 9, 17, '2020-07-21 11:37:09'),
(68, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 5, 17, '2020-07-21 11:37:17'),
(69, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 10, 17, '2020-07-21 11:38:10'),
(70, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 6, 17, '2020-07-21 11:38:19'),
(71, 17, 'Fatura Güncelle', 'fatura', 'Güncelleme', 6, 17, '2020-07-21 11:38:52'),
(72, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 6, 17, '2020-07-21 11:38:59'),
(73, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 6, 17, '2020-07-21 11:39:12'),
(74, 17, 'Fatura Silme', 'fatura', 'Silme', 0, 17, '2020-07-21 11:47:58'),
(75, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 5, 17, '2020-07-21 11:57:22'),
(76, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 5, 17, '2020-07-22 10:06:33'),
(77, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-07-22 10:06:43'),
(78, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 10:07:41'),
(79, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 11:45:27'),
(80, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 11:45:54'),
(81, 17, 'tartisma', 'tartisma', 'Ekleme', 2, 17, '2020-07-22 11:46:19'),
(82, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 11:47:30'),
(83, 17, 'tartisma', 'tartisma', 'Ekleme', 3, 17, '2020-07-22 11:48:09'),
(84, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 11:48:23'),
(85, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 11:48:36'),
(86, 17, 'tartisma', 'tartisma', 'Ekleme', 4, 17, '2020-07-22 11:54:25'),
(87, 17, 'tartisma', 'tartisma', 'Ekleme', 5, 17, '2020-07-22 12:09:25'),
(88, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 12:09:46'),
(89, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 12:12:16'),
(90, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 12:13:12'),
(91, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 12:16:03'),
(92, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 12:17:20'),
(93, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 12:17:39'),
(94, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 12:17:55'),
(95, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2020-07-22 12:18:43'),
(96, 17, 'Bilgi', 'uyeler', 'Güncelleme', 17, 17, '2020-07-23 06:15:35'),
(97, 17, 'Fatura', 'fatura', 'E-Fatura Görüntüleme', 3, 17, '2020-07-24 08:00:36'),
(98, 17, 'Etkinlik', 'etkinlik', 'Ekleme', 1, 17, '2021-03-16 07:38:41'),
(99, 17, 'Etkinlik', 'etkinlik', 'Silme', 0, 17, '2021-03-16 07:39:20'),
(100, 17, 'Etkinlik', 'etkinlik', 'Silme', 0, 17, '2021-03-16 07:39:32'),
(101, 17, 'Etkinlik', 'etkinlik', 'Ekleme', 2, 17, '2021-03-16 07:39:40'),
(102, 17, 'Etkinlik', 'etkinlik', 'Silme', 0, 17, '2021-03-16 07:39:46'),
(103, 17, 'Etkinlik', 'etkinlik', 'Silme', 0, 17, '2021-03-16 07:39:48'),
(104, 34, 'Uyeler', 'uyeler', 'Ekleme', 35, 34, '2021-04-19 07:04:20'),
(105, 37, 'Kasa', 'kasa', 'Ekleme', 1, 37, '2021-04-19 20:37:41'),
(106, 37, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 5, 37, '2021-04-19 20:38:48'),
(107, 17, 'Cari', 'cari', 'Ekleme', 11, 17, '2021-04-20 06:16:54'),
(108, 38, 'Cari', 'cari', 'Ekleme', 12, 38, '2021-04-21 20:49:01'),
(109, 38, 'Cari', 'cari', 'Ekleme', 13, 38, '2021-04-21 20:50:56'),
(110, 38, 'Borç-Alacak', 'borc_alacak', 'Ekleme', 3, 38, '2021-04-21 20:54:03'),
(111, 42, 'Cari', 'cari', 'Ekleme', 14, 42, '2021-05-09 13:18:51'),
(112, 42, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 6, 42, '2021-05-09 13:19:34'),
(113, 41, 'Bilgi', 'uyeler', 'Güncelleme', 41, 41, '2021-05-10 01:48:51'),
(114, 43, 'Bilgi', 'uyeler', 'Güncelleme', 43, 43, '2021-05-13 03:34:09'),
(115, 43, 'Bilgi', 'uyeler', 'Güncelleme', 43, 43, '2021-05-13 03:36:25'),
(116, 43, 'Cari', 'cari', 'Ekleme', 15, 43, '2021-05-13 03:39:00'),
(117, 43, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 7, 43, '2021-05-13 03:40:09'),
(118, 43, 'Teklif Kayıt', 'teklif', 'Ekleme', 1, 43, '2021-05-13 03:42:43'),
(119, 44, 'Cari', 'cari', 'Ekleme', 16, 44, '2021-05-13 19:27:26'),
(120, 45, 'Gider Kategori', 'gider_kategori', 'Ekleme', 2, 45, '2021-05-14 22:46:01'),
(121, 45, 'Gider Kategori', 'gider_kategori', 'Ekleme', 3, 45, '2021-05-14 22:46:47'),
(122, 45, 'Gider Kategori', 'gider_kategori', 'Ekleme', 4, 45, '2021-05-14 22:47:15'),
(123, 45, 'Gider Kategori', 'gider_kategori', 'Ekleme', 5, 45, '2021-05-14 22:47:38'),
(124, 45, 'Gider Kategori', 'gider_kategori', 'Ekleme', 6, 45, '2021-05-14 22:48:00'),
(125, 45, 'Gider Kategori', 'gider_kategori', 'Ekleme', 7, 45, '2021-05-14 22:48:23'),
(126, 45, 'Kategori', 'kategori', 'Ekleme', 2, 45, '2021-05-14 22:52:13'),
(127, 45, 'Kategori', 'kategori', 'Ekleme', 3, 45, '2021-05-14 22:52:34'),
(128, 45, 'Kategori', 'kategori', 'Ekleme', 4, 45, '2021-05-14 22:52:49'),
(129, 45, 'Kategori', 'kategori', 'Ekleme', 5, 45, '2021-05-14 22:53:05'),
(130, 45, 'Kategori', 'kategori', 'Ekleme', 6, 45, '2021-05-14 22:53:23'),
(131, 45, 'Kategori', 'kategori', 'Ekleme', 7, 45, '2021-05-14 22:53:35'),
(132, 45, 'Kategori', 'kategori', 'Ekleme', 8, 45, '2021-05-14 22:53:48'),
(133, 45, 'Kategori', 'kategori', 'Ekleme', 9, 45, '2021-05-14 22:54:12'),
(134, 45, 'Kategori', 'kategori', 'Ekleme', 10, 45, '2021-05-14 22:54:25'),
(135, 45, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 8, 45, '2021-05-14 23:01:21'),
(136, 45, 'Hizmet Ürün Silme', 'hizmet_urun', 'Silme', 0, 45, '2021-05-14 23:03:52'),
(137, 45, 'Hizmet Ürün Silme', 'hizmet_urun', 'Silme', 0, 45, '2021-05-14 23:03:52'),
(138, 17, 'Uyeler', 'uyeler', 'Ekleme', 47, 17, '2021-05-20 11:23:52'),
(139, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 1, 17, '2021-05-26 12:08:57'),
(140, 17, 'Ürün Kategori', 'urun_kategori', 'Silme', 1, 17, '2021-05-27 05:43:22'),
(141, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 2, 17, '2021-05-27 05:43:58'),
(142, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 3, 17, '2021-05-27 05:44:10'),
(143, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 4, 17, '2021-05-27 05:44:20'),
(144, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 5, 17, '2021-05-27 06:34:18'),
(145, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 9, 17, '2021-05-27 07:28:12'),
(146, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 10, 17, '2021-05-27 07:28:40'),
(147, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 11, 17, '2021-05-27 07:29:10'),
(148, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 12, 17, '2021-05-27 07:30:07'),
(149, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 13, 17, '2021-05-27 07:31:21'),
(150, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 14, 17, '2021-05-27 07:31:40'),
(151, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 15, 17, '2021-05-27 07:31:58'),
(152, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 16, 17, '2021-05-27 07:32:17'),
(153, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 17, 17, '2021-05-27 07:32:31'),
(154, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 18, 17, '2021-05-27 07:32:49'),
(155, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 19, 17, '2021-05-27 07:33:54'),
(156, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 6, 17, '2021-05-27 07:57:44'),
(157, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 7, 17, '2021-05-27 07:57:59'),
(158, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 8, 17, '2021-05-27 07:58:29'),
(159, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 20, 17, '2021-05-27 07:59:37'),
(160, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 21, 17, '2021-05-27 08:00:14'),
(161, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 22, 17, '2021-05-27 08:05:19'),
(162, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 23, 17, '2021-05-27 08:05:40'),
(163, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 24, 17, '2021-05-27 08:06:04'),
(164, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 25, 17, '2021-05-27 08:06:21'),
(165, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 26, 17, '2021-05-27 08:06:43'),
(166, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 9, 17, '2021-05-27 08:11:06'),
(167, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 10, 17, '2021-05-27 08:11:42'),
(168, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 11, 17, '2021-05-27 08:21:56'),
(169, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 12, 17, '2021-05-27 08:22:18'),
(170, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 13, 17, '2021-05-27 08:22:36'),
(171, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 27, 17, '2021-05-27 08:58:34'),
(172, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 28, 17, '2021-05-27 08:59:13'),
(173, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 29, 17, '2021-05-27 08:59:35'),
(174, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 28, 17, '2021-05-27 09:23:19'),
(175, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 29, 17, '2021-05-27 09:23:34'),
(176, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 30, 17, '2021-05-27 09:25:05'),
(177, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 31, 17, '2021-05-27 09:25:49'),
(178, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 32, 17, '2021-05-27 09:26:19'),
(179, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 33, 17, '2021-05-27 09:26:38'),
(180, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 34, 17, '2021-05-27 09:26:56'),
(181, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 35, 17, '2021-05-27 09:27:22'),
(182, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 36, 17, '2021-05-27 09:28:09'),
(183, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 37, 17, '2021-05-27 09:28:34'),
(184, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 38, 17, '2021-05-27 09:28:57'),
(185, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 39, 17, '2021-05-27 09:29:30'),
(186, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 40, 17, '2021-05-27 09:29:53'),
(187, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 41, 17, '2021-05-27 09:31:08'),
(188, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 42, 17, '2021-05-27 09:33:40'),
(189, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 43, 17, '2021-05-27 09:34:32'),
(190, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 44, 17, '2021-05-27 09:34:54'),
(191, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 45, 17, '2021-05-27 09:37:14'),
(192, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 46, 17, '2021-05-27 09:37:49'),
(193, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 47, 17, '2021-05-27 09:38:19'),
(194, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 48, 17, '2021-05-27 09:38:35'),
(195, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 49, 17, '2021-05-27 09:39:01'),
(196, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 50, 17, '2021-05-27 09:39:24'),
(197, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 51, 17, '2021-05-27 09:40:05'),
(198, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 52, 17, '2021-05-27 09:40:32'),
(199, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 53, 17, '2021-05-27 09:41:11'),
(200, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 54, 17, '2021-05-27 09:41:29'),
(201, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 55, 17, '2021-05-27 09:41:53'),
(202, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 56, 17, '2021-05-27 09:44:24'),
(203, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 57, 17, '2021-05-27 09:44:56'),
(204, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 58, 17, '2021-05-27 09:45:21'),
(205, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 59, 17, '2021-05-27 09:45:50'),
(206, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 60, 17, '2021-05-27 09:46:30'),
(207, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 61, 17, '2021-05-27 09:48:53'),
(208, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 62, 17, '2021-05-27 11:10:13'),
(209, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 63, 17, '2021-05-27 11:17:24'),
(210, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 64, 17, '2021-05-27 11:18:05'),
(211, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 65, 17, '2021-05-27 11:21:10'),
(212, 17, 'Ürün Kategori', 'urun_kategori', 'Güncelleme', 2, 17, '2021-05-28 11:44:17'),
(213, 17, 'Ürün Kategori', 'urun_kategori', 'Güncelleme', 3, 17, '2021-05-28 11:44:24'),
(214, 17, 'Ürün Kategori', 'urun_kategori', 'Güncelleme', 4, 17, '2021-05-28 11:44:31'),
(215, 17, 'Ürün Kategori', 'urun_kategori', 'Güncelleme', 5, 17, '2021-05-28 11:44:38'),
(216, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 66, 17, '2021-05-31 11:37:38'),
(217, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 67, 17, '2021-05-31 15:19:55'),
(218, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 11, 17, '2021-06-08 08:46:28'),
(219, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 12, 17, '2021-06-08 08:48:26'),
(220, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 13, 17, '2021-06-08 11:42:15'),
(221, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 15, 17, '2021-06-08 11:43:22'),
(222, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 17, 17, '2021-06-08 11:48:03'),
(223, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 19, 17, '2021-06-08 11:49:26'),
(224, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 21, 17, '2021-06-08 11:51:04'),
(225, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 23, 17, '2021-06-09 10:21:12'),
(226, 17, 'tartisma', 'tartisma', 'Ekleme', 6, 17, '2021-06-09 10:36:49'),
(227, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2021-06-09 10:37:21'),
(228, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 25, 17, '2021-06-16 06:55:13'),
(229, 17, 'Uyeler', 'uyeler', 'Ekleme', 1, 17, '2021-06-17 11:02:44'),
(230, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 27, 17, '2021-06-18 07:12:04'),
(231, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 29, 17, '2021-06-18 07:15:21'),
(232, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 31, 17, '2021-06-18 07:16:33'),
(233, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 33, 17, '2021-06-18 07:18:13'),
(234, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 35, 17, '2021-06-18 07:19:28'),
(235, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 37, 17, '2021-06-18 07:22:15'),
(236, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 39, 17, '2021-06-18 07:23:29'),
(237, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 41, 17, '2021-06-18 07:30:40'),
(238, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 43, 17, '2021-06-18 07:36:03'),
(239, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 45, 17, '2021-06-18 07:37:39'),
(240, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 47, 17, '2021-06-18 07:56:36'),
(241, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 49, 17, '2021-06-18 07:57:37'),
(242, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 51, 17, '2021-06-18 07:58:06'),
(243, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 53, 17, '2021-06-18 08:46:45'),
(244, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 55, 17, '2021-06-18 08:48:03'),
(245, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 57, 17, '2021-06-18 08:48:51'),
(246, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 59, 17, '2021-06-18 08:49:39'),
(247, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 61, 17, '2021-06-18 08:50:23'),
(248, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 63, 17, '2021-06-18 08:52:13'),
(249, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 65, 17, '2021-06-18 08:52:59'),
(250, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 67, 17, '2021-06-18 08:53:53'),
(251, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 69, 17, '2021-06-18 08:54:49'),
(252, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 71, 17, '2021-06-18 08:55:39'),
(253, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 73, 17, '2021-06-18 08:56:21'),
(254, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 75, 17, '2021-06-18 08:57:43'),
(255, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 77, 17, '2021-06-18 09:00:33'),
(256, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 79, 17, '2021-06-18 09:01:16'),
(257, 47, 'Fatura Güncelle', 'fatura', 'Güncelleme', 32, 17, '2021-06-21 06:56:14'),
(258, 47, 'Fatura Güncelle', 'fatura', 'Güncelleme', 32, 17, '2021-06-21 07:06:36'),
(259, 47, 'Fatura Güncelle', 'fatura', 'Güncelleme', 32, 17, '2021-06-21 07:08:01'),
(260, 47, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2021-06-21 12:14:50'),
(261, 47, 'Fatura Kayıt', 'fatura', 'Ekleme', 81, 17, '2021-06-23 08:33:22'),
(262, 47, 'Fatura Güncelle', 'fatura', 'Güncelleme', 42, 17, '2021-06-23 08:38:35'),
(263, 17, 'Fatura Güncelle', 'fatura', 'Güncelleme', 42, 17, '2021-06-23 09:10:33'),
(264, 17, 'Fatura Güncelle', 'fatura', 'Güncelleme', 42, 17, '2021-06-23 09:11:17'),
(265, 17, 'Fatura Güncelle', 'fatura', 'Güncelleme', 42, 17, '2021-06-23 09:11:59'),
(266, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 13, 17, '2021-06-23 11:23:17'),
(267, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 15, 17, '2021-06-23 11:23:26'),
(268, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 14, 17, '2021-06-23 11:23:42'),
(269, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 16, 17, '2021-06-23 11:23:50'),
(270, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 17, 17, '2021-06-23 11:23:57'),
(271, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 18, 17, '2021-06-23 11:24:05'),
(272, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 12, 17, '2021-06-23 11:24:28'),
(273, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 28, 17, '2021-06-23 11:25:10'),
(274, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 29, 17, '2021-06-23 11:25:20'),
(275, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 30, 17, '2021-06-23 11:25:35'),
(276, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 42, 17, '2021-06-23 11:25:55'),
(277, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 43, 17, '2021-06-23 11:26:07'),
(278, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 44, 17, '2021-06-23 11:26:18'),
(279, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 66, 17, '2021-06-23 11:26:59'),
(280, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 67, 17, '2021-06-23 11:27:10'),
(281, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 15, 17, '2021-06-25 13:22:33'),
(282, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 61, 17, '2021-06-25 13:23:02'),
(283, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 83, 17, '2021-06-25 15:09:48'),
(284, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 85, 17, '2021-06-25 15:11:06'),
(285, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 87, 17, '2021-06-25 15:12:11'),
(286, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 89, 17, '2021-06-25 15:13:08'),
(287, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 91, 17, '2021-06-25 15:14:02'),
(288, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 93, 17, '2021-06-25 15:28:57'),
(289, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 95, 17, '2021-06-28 09:33:39'),
(290, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 97, 17, '2021-06-28 09:34:31'),
(291, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 99, 17, '2021-06-28 09:35:26'),
(292, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 101, 17, '2021-06-28 09:36:09'),
(293, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 103, 17, '2021-06-28 09:37:15'),
(294, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 105, 17, '2021-06-28 09:38:10'),
(295, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 107, 17, '2021-06-28 09:40:04'),
(296, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 109, 17, '2021-06-28 09:41:02'),
(297, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 111, 17, '2021-06-28 09:41:42'),
(298, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 113, 17, '2021-06-28 09:43:05'),
(299, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 115, 17, '2021-06-29 07:46:36'),
(300, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 117, 17, '2021-06-29 08:00:27'),
(301, 17, 'Fatura Güncelle', 'fatura', 'Güncelleme', 60, 17, '2021-06-29 08:02:30'),
(302, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 119, 17, '2021-06-29 09:23:50'),
(303, 17, 'Cari', 'cari', 'Ekleme', 37, 17, '2021-06-29 09:46:28'),
(304, 17, 'faturaNot Kaydı', 'notlar', 'Ekleme', 61, 17, '2021-06-29 14:40:43'),
(305, 17, 'fatura Not Silme', 'notlar', 'Silme', 0, 17, '2021-06-29 14:40:49'),
(306, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 121, 17, '2021-06-30 12:38:24'),
(307, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 123, 17, '2021-06-30 12:40:57'),
(308, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 14, 17, '2021-07-01 07:31:10'),
(309, 17, 'Ürün Kategori', 'urun_kategori', 'Ekleme', 15, 17, '2021-07-01 07:31:29'),
(310, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 73, 17, '2021-07-01 07:32:47'),
(311, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 74, 17, '2021-07-01 07:33:20'),
(312, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 75, 17, '2021-07-01 07:33:49'),
(313, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 76, 17, '2021-07-01 07:34:46'),
(314, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 77, 17, '2021-07-01 07:35:30'),
(315, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 78, 17, '2021-07-01 07:44:01'),
(316, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 79, 17, '2021-07-01 07:44:51'),
(317, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 80, 17, '2021-07-01 07:45:18'),
(318, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 81, 17, '2021-07-01 07:45:42'),
(319, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 82, 17, '2021-07-01 07:46:23'),
(320, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 83, 17, '2021-07-01 07:46:58'),
(321, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 84, 17, '2021-07-01 07:47:40'),
(322, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 85, 17, '2021-07-01 07:48:09'),
(323, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 86, 17, '2021-07-01 07:48:36'),
(324, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 87, 17, '2021-07-01 07:48:58'),
(325, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 88, 17, '2021-07-01 07:49:22'),
(326, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 89, 17, '2021-07-01 07:51:11'),
(327, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 90, 17, '2021-07-01 07:51:36'),
(328, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 91, 17, '2021-07-01 07:51:58'),
(329, 17, 'Hizmet Ürün', 'hizmet_urun', 'Ekleme', 92, 17, '2021-07-01 07:52:25'),
(330, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 125, 17, '2021-07-05 07:15:24'),
(331, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 73, 17, '2021-07-05 09:01:13'),
(332, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 74, 17, '2021-07-05 09:01:30'),
(333, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 75, 17, '2021-07-05 09:02:03'),
(334, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 76, 17, '2021-07-05 09:02:21'),
(335, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 77, 17, '2021-07-05 09:02:33'),
(336, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 78, 17, '2021-07-05 09:02:47'),
(337, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 79, 17, '2021-07-05 09:03:02'),
(338, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 80, 17, '2021-07-05 09:03:19'),
(339, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 81, 17, '2021-07-05 09:03:33'),
(340, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 82, 17, '2021-07-05 09:03:49'),
(341, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 73, 17, '2021-07-05 09:17:54'),
(342, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 74, 17, '2021-07-05 09:18:19'),
(343, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 75, 17, '2021-07-05 09:18:32'),
(344, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 76, 17, '2021-07-05 09:18:47'),
(345, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 77, 17, '2021-07-05 09:18:59'),
(346, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 78, 17, '2021-07-05 09:19:18'),
(347, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 79, 17, '2021-07-05 09:19:33'),
(348, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 80, 17, '2021-07-05 09:19:45'),
(349, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 81, 17, '2021-07-05 09:20:00'),
(350, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 82, 17, '2021-07-05 09:20:10'),
(351, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 127, 17, '2021-07-05 09:21:30'),
(352, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 129, 17, '2021-07-05 13:18:59'),
(353, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 131, 17, '2021-07-05 13:19:28'),
(354, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2021-07-05 14:50:07'),
(355, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2021-07-05 14:53:29'),
(356, 17, 'Tartışma Gönderim', 'tartisma', 'Gönderildi', 0, 17, '2021-07-05 14:58:27'),
(357, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 133, 17, '2021-07-07 11:08:51'),
(358, 17, 'Fatura Güncelle', 'fatura', 'Güncelleme', 68, 17, '2021-07-07 12:17:23'),
(359, 17, 'Hizmet Ürün Silme', 'hizmet_urun', 'Silme', 0, 17, '2021-08-03 07:37:56'),
(360, 17, 'Hizmet Ürün Silme', 'hizmet_urun', 'Silme', 0, 17, '2021-08-03 07:38:03'),
(361, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 135, 17, '2021-08-03 07:55:55'),
(362, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 137, 17, '2021-08-03 11:50:10'),
(363, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 139, 17, '2021-08-03 11:50:39'),
(364, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 141, 17, '2021-08-04 08:20:56'),
(365, 17, 'Fatura Güncelle', 'fatura', 'Güncelleme', 72, 17, '2021-08-05 07:04:54'),
(366, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 11, 17, '2021-08-09 07:59:06'),
(367, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 143, 17, '2021-08-10 08:29:10'),
(368, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 145, 17, '2021-08-10 08:29:52'),
(369, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 147, 17, '2021-08-10 13:38:11'),
(370, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 63, 17, '2021-08-11 11:30:10'),
(371, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 62, 17, '2021-08-11 11:30:28'),
(372, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 61, 17, '2021-08-11 11:30:46'),
(373, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 41, 17, '2021-08-11 11:31:03'),
(374, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 64, 17, '2021-08-11 11:32:10'),
(375, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 27, 17, '2021-08-11 11:32:26'),
(376, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 20, 17, '2021-08-11 11:32:47'),
(377, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 21, 17, '2021-08-11 11:32:54'),
(378, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 64, 17, '2021-08-11 12:16:03'),
(379, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 63, 17, '2021-08-11 12:16:12'),
(380, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 62, 17, '2021-08-11 12:16:17'),
(381, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 41, 17, '2021-08-11 12:16:25'),
(382, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 62, 17, '2021-08-11 12:16:31'),
(383, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 27, 17, '2021-08-11 12:16:47'),
(384, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 61, 17, '2021-08-11 12:16:54'),
(385, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 20, 17, '2021-08-11 12:18:02'),
(386, 17, 'Hizmet Ürün', 'hizmet_urun', 'Güncelleme', 21, 17, '2021-08-11 12:18:07'),
(387, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 149, 17, '2021-08-11 12:37:08'),
(388, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 151, 17, '2021-08-12 07:41:53'),
(389, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 153, 17, '2021-08-12 08:04:56'),
(390, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 155, 17, '2021-08-12 08:06:35'),
(391, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 157, 17, '2021-08-16 14:07:48'),
(392, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 159, 17, '2021-08-16 14:37:57'),
(393, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 161, 17, '2021-08-16 14:39:41'),
(394, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 163, 17, '2021-08-16 14:45:30'),
(395, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 165, 17, '2021-08-16 14:47:31'),
(396, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 167, 17, '2021-08-16 14:48:55'),
(397, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 169, 17, '2021-08-16 14:49:40'),
(398, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 171, 17, '2021-08-17 06:29:44'),
(399, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 173, 17, '2021-08-17 06:32:05'),
(400, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 175, 17, '2021-08-17 06:32:20'),
(401, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 177, 17, '2021-08-17 06:33:21'),
(402, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 179, 17, '2021-08-17 06:33:49'),
(403, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 181, 17, '2021-08-17 06:34:48'),
(404, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 183, 17, '2021-08-17 06:35:31'),
(405, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 185, 17, '2021-08-17 06:36:59'),
(406, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 187, 17, '2021-08-17 06:37:48'),
(407, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 189, 17, '2021-08-17 06:38:57'),
(408, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 191, 17, '2021-08-17 06:40:19'),
(409, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 193, 17, '2021-08-17 06:46:06'),
(410, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 195, 17, '2021-08-17 06:47:45'),
(411, 17, 'Fatura Kayıt', 'fatura', 'Ekleme', 197, 17, '2021-08-18 06:47:09');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesaj`
--

CREATE TABLE `mesaj` (
  `id` int(11) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gonderici` int(11) NOT NULL,
  `alici` int(11) NOT NULL,
  `mesaj` text NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `mesaj`
--

INSERT INTO `mesaj` (`id`, `tarih`, `gonderici`, `alici`, `mesaj`, `durum`, `kullanici_id`) VALUES
(20, '2021-06-21 09:14:25', 17, 47, '<p>hhhfyj76j76 ıı78kıı87ı78</p>', 1, 17),
(21, '2021-06-21 09:14:25', 17, 47, '<p>hhhfyj76j76 ıı78kıı87ı78</p>', 1, 17),
(22, '2021-06-21 09:14:25', 17, 47, '<p>lıulılllulıo uılı ılul</p>', 1, 17),
(23, '2021-06-21 09:14:25', 17, 47, '<p>uıkıkkuıkıkı lı ıkuı</p>', 1, 17),
(24, '2021-07-06 06:34:43', 47, 17, '<p>merhaba</p>', 1, 17),
(25, '2021-07-06 06:42:05', 55, 17, '<p>merhaba</p>', 1, 17),
(26, '2021-07-06 06:42:10', 17, 55, '<p>htrhtrhthtr</p>', 0, 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notlar`
--

CREATE TABLE `notlar` (
  `id` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `kim` int(11) NOT NULL,
  `konu` varchar(225) NOT NULL,
  `teklif` text NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ornek_dosyalar`
--

CREATE TABLE `ornek_dosyalar` (
  `id` int(11) NOT NULL,
  `dosya_adi` varchar(225) NOT NULL,
  `aciklama` text NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `potansiyel`
--

CREATE TABLE `potansiyel` (
  `id` int(11) NOT NULL,
  `adi_soyadi` varchar(225) NOT NULL,
  `unvan` varchar(225) NOT NULL,
  `tc` varchar(225) NOT NULL,
  `vergi_dairesi` varchar(225) NOT NULL,
  `vergi` varchar(225) NOT NULL,
  `eposta` varchar(225) NOT NULL,
  `eposta_durum` int(11) NOT NULL,
  `tel` varchar(225) NOT NULL,
  `fax` varchar(225) NOT NULL,
  `adres` text NOT NULL,
  `ilce/il` varchar(225) NOT NULL,
  `posta_kodu` varchar(225) NOT NULL,
  `ulke` varchar(225) NOT NULL,
  `gorev` varchar(225) NOT NULL,
  `maas` varchar(225) NOT NULL,
  `baslama_tarihi` date NOT NULL,
  `cikis_tarihi` date NOT NULL,
  `ozluk_dosyalari` varchar(225) NOT NULL,
  `aciklama` text NOT NULL,
  `kisi_turu` varchar(225) NOT NULL,
  `bas_boal_durum` int(11) NOT NULL,
  `bas_borc_alacak` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `durum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis`
--

CREATE TABLE `siparis` (
  `id` int(11) NOT NULL,
  `fatura_turu` varchar(225) NOT NULL,
  `tutar` varchar(225) NOT NULL,
  `vergi` varchar(225) CHARACTER SET ucs2 NOT NULL,
  `indirim` varchar(225) NOT NULL,
  `toplam` varchar(225) NOT NULL,
  `cari_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `vade_tarihi` date NOT NULL,
  `seri_no` varchar(225) NOT NULL,
  `fatura_no` varchar(225) NOT NULL,
  `aciklama` varchar(225) NOT NULL,
  `irsaliye_durum` int(11) NOT NULL,
  `gelir_gider_fat` int(11) NOT NULL,
  `iade_fat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis_item`
--

CREATE TABLE `siparis_item` (
  `id` int(11) NOT NULL,
  `fatura_id` int(11) NOT NULL,
  `fatura_turu` varchar(225) NOT NULL,
  `hizmet_urun_id` int(11) NOT NULL,
  `adet` int(11) NOT NULL,
  `aktarim` int(11) NOT NULL,
  `birim_fiyat` varchar(225) NOT NULL,
  `tutar` varchar(225) NOT NULL,
  `aciklama` varchar(225) NOT NULL,
  `indirim` varchar(225) NOT NULL,
  `vergi` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sss`
--

CREATE TABLE `sss` (
  `id` int(11) NOT NULL,
  `soru` varchar(225) NOT NULL,
  `cevap` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `sss`
--

INSERT INTO `sss` (`id`, `soru`, `cevap`) VALUES
(1, 'Nasıl fatura keserim ?', 'Cevap Cevap Cevap Cevap Cevap'),
(2, 'Nasıl tahsilat yaparım ?', 'Cevap Cevap Cevap Cevap Cevap'),
(3, 'Drive sistemini nasıl kullanırım ?', 'Cevap Cevap Cevap Cevap Cevap'),
(4, 'Nasıl rapor oluştururum ?', 'Cevap Cevap Cevap Cevap Cevap'),
(5, 'Nasıl E-Fatura gönderirim ?', 'Cevap Cevap Cevap Cevap Cevap'),
(6, 'Yeni kullanıcı nasıl tanımlarım ?', 'Cevap Cevap Cevap Cevap Cevap'),
(7, 'Nasıl yedek alırım ?', 'Cevap Cevap Cevap Cevap Cevap'),
(8, 'E-Fatura aboneliği nasıl başlatabilirim ?', 'Cevap Cevap Cevap Cevap Cevap'),
(9, 'Nasıl ek kullanıcı satın alırım ?', 'Cevap Cevap Cevap Cevap Cevap'),
(10, 'Siparişlerimi nasıl faturaya dönüştürürüm ?', 'Cevap Cevap Cevap Cevap Cevap'),
(11, 'Şifremi Nasıl değiştiririm ?', 'Cevap Cevap Cevap Cevap Cevap');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tartisma`
--

CREATE TABLE `tartisma` (
  `id` int(11) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kim` int(11) NOT NULL,
  `konu` text NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tartisma`
--

INSERT INTO `tartisma` (`id`, `tarih`, `kim`, `konu`, `kullanici_id`) VALUES
(5, '2020-07-22 12:09:25', 17, '<p>aaaaaaaa</p>', 17),
(6, '2021-06-09 10:36:49', 17, '<p>e defterde xxxx yyyy problemi</p>', 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tartisma_msj`
--

CREATE TABLE `tartisma_msj` (
  `id` int(11) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `tartisma_id` int(11) NOT NULL,
  `kim` int(11) NOT NULL,
  `mesaj` text NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tartisma_msj`
--

INSERT INTO `tartisma_msj` (`id`, `tarih`, `tartisma_id`, `kim`, `mesaj`, `kullanici_id`) VALUES
(13, '2020-07-22 12:17:55', 5, 17, 'gtrgtrgergerg', 17),
(14, '2020-07-22 12:18:43', 5, 17, 'sdffsdfsdffds', 17),
(15, '2021-06-09 10:37:21', 6, 17, 'e defterde o problem şu şekilde &ccedil;&ouml;z&uuml;l&uuml;r....', 17),
(16, '2021-06-21 12:14:50', 5, 47, 'k&ouml;k&ouml;jk&ouml;j&ouml;&ouml;j&ouml;jk&ouml;', 17),
(17, '2021-07-05 14:50:07', 5, 17, 'deneme yazısı', 17),
(18, '2021-07-05 14:53:29', 5, 17, 'eeerewrerewrewrewrerere', 17),
(19, '2021-07-05 14:58:27', 5, 17, '7ı67ı76ı67ı76ı76', 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `kim` int(11) NOT NULL,
  `task` text NOT NULL,
  `durum` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teklif`
--

CREATE TABLE `teklif` (
  `id` int(11) NOT NULL,
  `fatura_turu` varchar(225) NOT NULL,
  `tutar` varchar(225) NOT NULL,
  `vergi` varchar(225) CHARACTER SET ucs2 NOT NULL,
  `indirim` varchar(225) NOT NULL,
  `toplam` varchar(225) NOT NULL,
  `cari_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `vade_tarihi` date NOT NULL,
  `seri_no` varchar(225) NOT NULL,
  `fatura_no` varchar(225) NOT NULL,
  `aciklama` varchar(225) NOT NULL,
  `irsaliye_durum` int(11) NOT NULL,
  `gelir_gider_fat` int(11) NOT NULL,
  `iade_fat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teklif_item`
--

CREATE TABLE `teklif_item` (
  `id` int(11) NOT NULL,
  `fatura_id` int(11) NOT NULL,
  `fatura_turu` varchar(225) NOT NULL,
  `hizmet_urun_id` int(11) NOT NULL,
  `adet` int(11) NOT NULL,
  `aktarim` int(11) NOT NULL,
  `birim_fiyat` varchar(225) NOT NULL,
  `tutar` varchar(225) NOT NULL,
  `aciklama` varchar(225) NOT NULL,
  `indirim` varchar(225) NOT NULL,
  `vergi` varchar(225) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uruneslestir`
--

CREATE TABLE `uruneslestir` (
  `uruneslestir_id` int(11) NOT NULL,
  `urun_1` int(11) NOT NULL,
  `kategori_2` int(11) NOT NULL,
  `uruneslestir_kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `uruneslestir`
--

INSERT INTO `uruneslestir` (`uruneslestir_id`, `urun_1`, `kategori_2`, `uruneslestir_kullanici_id`) VALUES
(1, 12, 6, 17),
(2, 12, 7, 17),
(3, 12, 8, 17),
(4, 13, 9, 17),
(5, 13, 10, 17),
(6, 13, 8, 17),
(7, 13, 11, 17),
(8, 13, 12, 17),
(9, 13, 13, 17),
(10, 14, 9, 17),
(11, 14, 10, 17),
(12, 14, 8, 17),
(13, 14, 12, 17),
(14, 14, 13, 17),
(15, 15, 9, 17),
(16, 15, 10, 17),
(17, 15, 8, 17),
(18, 15, 11, 17),
(19, 15, 12, 17),
(20, 15, 13, 17),
(21, 16, 9, 17),
(22, 16, 13, 17),
(23, 16, 10, 17),
(24, 16, 8, 17),
(25, 16, 11, 17),
(26, 16, 12, 17),
(27, 17, 9, 17),
(28, 17, 12, 17),
(29, 17, 8, 17),
(30, 17, 13, 17),
(31, 18, 9, 17),
(32, 18, 10, 17),
(33, 18, 8, 17),
(34, 18, 12, 17),
(35, 18, 13, 17),
(36, 17, 15, 17),
(37, 17, 14, 17),
(38, 15, 15, 17),
(39, 15, 14, 17),
(40, 18, 15, 17),
(41, 18, 14, 17),
(42, 13, 15, 17),
(43, 13, 14, 17),
(44, 14, 15, 17),
(45, 14, 14, 17),
(46, 16, 15, 17),
(47, 16, 14, 17),
(48, 12, 15, 17),
(49, 12, 14, 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uruneslestir_iliski`
--

CREATE TABLE `uruneslestir_iliski` (
  `uruneslestir_iliski_id` int(11) NOT NULL,
  `uruneslestir_id` int(11) NOT NULL,
  `urun_1` int(11) NOT NULL,
  `kategori_2` int(11) NOT NULL,
  `urun_2` int(11) NOT NULL,
  `uruneslestir_kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `uruneslestir_iliski`
--

INSERT INTO `uruneslestir_iliski` (`uruneslestir_iliski_id`, `uruneslestir_id`, `urun_1`, `kategori_2`, `urun_2`, `uruneslestir_kullanici_id`) VALUES
(1, 1, 12, 6, 20, 17),
(2, 2, 12, 7, 21, 17),
(3, 3, 12, 8, 22, 17),
(4, 3, 12, 8, 23, 17),
(5, 3, 12, 8, 24, 17),
(6, 3, 12, 8, 25, 17),
(7, 3, 12, 8, 26, 17),
(8, 4, 13, 9, 27, 17),
(9, 5, 13, 10, 28, 17),
(10, 5, 13, 10, 29, 17),
(11, 6, 13, 8, 24, 17),
(12, 6, 13, 8, 25, 17),
(13, 6, 13, 8, 22, 17),
(14, 6, 13, 8, 23, 17),
(15, 6, 13, 8, 26, 17),
(16, 7, 13, 11, 30, 17),
(17, 8, 13, 12, 31, 17),
(18, 8, 13, 12, 32, 17),
(19, 8, 13, 12, 33, 17),
(20, 8, 13, 12, 34, 17),
(21, 8, 13, 12, 35, 17),
(22, 8, 13, 12, 36, 17),
(23, 8, 13, 12, 37, 17),
(24, 8, 13, 12, 38, 17),
(25, 9, 13, 13, 39, 17),
(26, 9, 13, 13, 40, 17),
(27, 10, 14, 9, 41, 17),
(28, 11, 14, 10, 42, 17),
(29, 11, 14, 10, 43, 17),
(30, 11, 14, 10, 44, 17),
(31, 12, 14, 8, 24, 17),
(32, 12, 14, 8, 25, 17),
(33, 12, 14, 8, 22, 17),
(34, 12, 14, 8, 23, 17),
(35, 12, 14, 8, 26, 17),
(36, 13, 14, 12, 31, 17),
(37, 13, 14, 12, 32, 17),
(38, 13, 14, 12, 33, 17),
(39, 13, 14, 12, 34, 17),
(40, 13, 14, 12, 35, 17),
(41, 13, 14, 12, 36, 17),
(42, 13, 14, 12, 37, 17),
(43, 13, 14, 12, 45, 17),
(44, 13, 14, 12, 46, 17),
(45, 13, 14, 12, 53, 17),
(46, 13, 14, 12, 47, 17),
(47, 13, 14, 12, 49, 17),
(48, 13, 14, 12, 50, 17),
(49, 13, 14, 12, 51, 17),
(50, 13, 14, 12, 52, 17),
(51, 13, 14, 12, 53, 17),
(52, 13, 14, 12, 54, 17),
(53, 13, 14, 12, 55, 17),
(54, 13, 14, 12, 56, 17),
(55, 13, 14, 12, 57, 17),
(56, 13, 14, 12, 58, 17),
(57, 13, 14, 12, 59, 17),
(58, 13, 14, 12, 57, 17),
(59, 14, 14, 13, 39, 17),
(60, 14, 14, 13, 40, 17),
(61, 15, 15, 9, 61, 17),
(62, 16, 15, 10, 28, 17),
(63, 16, 15, 10, 29, 17),
(64, 16, 15, 10, 42, 17),
(65, 16, 15, 10, 43, 17),
(66, 16, 15, 10, 44, 17),
(67, 17, 15, 8, 24, 17),
(68, 17, 15, 8, 25, 17),
(69, 17, 15, 8, 22, 17),
(70, 17, 15, 8, 23, 17),
(71, 17, 15, 8, 26, 17),
(72, 18, 15, 11, 30, 17),
(73, 19, 15, 12, 31, 17),
(74, 19, 15, 12, 32, 17),
(75, 19, 15, 12, 33, 17),
(76, 19, 15, 12, 34, 17),
(77, 19, 15, 12, 35, 17),
(78, 19, 15, 12, 36, 17),
(79, 19, 15, 12, 37, 17),
(80, 19, 15, 12, 45, 17),
(81, 19, 15, 12, 46, 17),
(82, 19, 15, 12, 48, 17),
(83, 19, 15, 12, 49, 17),
(84, 19, 15, 12, 47, 17),
(85, 19, 15, 12, 50, 17),
(86, 19, 15, 12, 51, 17),
(87, 19, 15, 12, 52, 17),
(88, 19, 15, 12, 53, 17),
(89, 19, 15, 12, 54, 17),
(90, 19, 15, 12, 55, 17),
(91, 19, 15, 12, 38, 17),
(92, 19, 15, 12, 56, 17),
(93, 19, 15, 12, 57, 17),
(94, 19, 15, 12, 58, 17),
(95, 19, 15, 12, 60, 17),
(96, 19, 15, 12, 59, 17),
(97, 20, 15, 13, 39, 17),
(98, 20, 15, 13, 40, 17),
(99, 21, 16, 9, 62, 17),
(100, 22, 16, 13, 39, 17),
(101, 22, 16, 13, 40, 17),
(102, 23, 16, 10, 28, 17),
(103, 23, 16, 10, 29, 17),
(104, 23, 16, 10, 42, 17),
(105, 23, 16, 10, 43, 17),
(106, 23, 16, 10, 44, 17),
(107, 24, 16, 8, 24, 17),
(108, 24, 16, 8, 25, 17),
(109, 24, 16, 8, 22, 17),
(110, 24, 16, 8, 23, 17),
(111, 24, 16, 8, 26, 17),
(112, 25, 16, 11, 30, 17),
(113, 26, 16, 12, 31, 17),
(114, 26, 16, 12, 32, 17),
(115, 26, 16, 12, 33, 17),
(116, 26, 16, 12, 34, 17),
(117, 26, 16, 12, 35, 17),
(118, 26, 16, 12, 36, 17),
(119, 26, 16, 12, 37, 17),
(120, 26, 16, 12, 45, 17),
(121, 26, 16, 12, 46, 17),
(122, 26, 16, 12, 48, 17),
(123, 26, 16, 12, 49, 17),
(124, 26, 16, 12, 47, 17),
(125, 26, 16, 12, 50, 17),
(126, 26, 16, 12, 51, 17),
(127, 26, 16, 12, 52, 17),
(128, 26, 16, 12, 53, 17),
(129, 26, 16, 12, 54, 17),
(130, 26, 16, 12, 55, 17),
(131, 26, 16, 12, 57, 17),
(132, 26, 16, 12, 58, 17),
(133, 26, 16, 12, 59, 17),
(134, 26, 16, 12, 60, 17),
(135, 27, 17, 9, 63, 17),
(136, 29, 17, 8, 24, 17),
(137, 29, 17, 8, 25, 17),
(138, 29, 17, 8, 22, 17),
(139, 29, 17, 8, 23, 17),
(140, 29, 17, 8, 26, 17),
(141, 30, 17, 13, 39, 17),
(142, 30, 17, 13, 40, 17),
(143, 28, 17, 12, 31, 17),
(144, 28, 17, 12, 32, 17),
(145, 28, 17, 12, 33, 17),
(146, 28, 17, 12, 34, 17),
(147, 28, 17, 12, 35, 17),
(148, 28, 17, 12, 36, 17),
(149, 28, 17, 12, 37, 17),
(150, 31, 18, 9, 64, 17),
(151, 35, 18, 13, 39, 17),
(152, 35, 18, 13, 40, 17),
(153, 33, 18, 8, 24, 17),
(154, 33, 18, 8, 25, 17),
(155, 33, 18, 8, 22, 17),
(156, 33, 18, 8, 23, 17),
(157, 33, 18, 8, 26, 17),
(158, 32, 18, 10, 29, 17),
(159, 34, 18, 12, 31, 17),
(160, 34, 18, 12, 32, 17),
(161, 34, 18, 12, 33, 17),
(162, 34, 18, 12, 34, 17),
(163, 34, 18, 12, 35, 17),
(164, 34, 18, 12, 36, 17),
(165, 34, 18, 12, 37, 17),
(166, 5, 13, 10, 70, 17),
(167, 11, 14, 10, 69, 17),
(168, 11, 14, 10, 71, 17),
(169, 11, 14, 10, 72, 17),
(170, 16, 15, 10, 70, 17),
(171, 16, 15, 10, 69, 17),
(172, 16, 15, 10, 71, 17),
(173, 16, 15, 10, 72, 17),
(174, 23, 16, 10, 70, 17),
(175, 23, 16, 10, 69, 17),
(176, 23, 16, 10, 71, 17),
(177, 23, 16, 10, 72, 17),
(178, 32, 18, 10, 70, 17),
(179, 36, 17, 15, 83, 17),
(180, 36, 17, 15, 86, 17),
(181, 36, 17, 15, 89, 17),
(182, 36, 17, 15, 92, 17),
(183, 36, 17, 15, 90, 17),
(184, 36, 17, 15, 84, 17),
(185, 36, 17, 15, 87, 17),
(186, 36, 17, 15, 85, 17),
(187, 36, 17, 15, 88, 17),
(188, 36, 17, 15, 91, 17),
(189, 38, 15, 15, 83, 17),
(190, 38, 15, 15, 86, 17),
(191, 38, 15, 15, 89, 17),
(192, 38, 15, 15, 92, 17),
(193, 38, 15, 15, 90, 17),
(194, 38, 15, 15, 84, 17),
(195, 38, 15, 15, 87, 17),
(196, 38, 15, 15, 85, 17),
(197, 38, 15, 15, 88, 17),
(198, 38, 15, 15, 91, 17),
(199, 40, 18, 15, 83, 17),
(200, 40, 18, 15, 86, 17),
(201, 40, 18, 15, 89, 17),
(202, 40, 18, 15, 92, 17),
(203, 40, 18, 15, 90, 17),
(204, 40, 18, 15, 84, 17),
(205, 40, 18, 15, 87, 17),
(206, 40, 18, 15, 85, 17),
(207, 40, 18, 15, 88, 17),
(208, 40, 18, 15, 91, 17),
(209, 42, 13, 15, 83, 17),
(210, 42, 13, 15, 86, 17),
(211, 42, 13, 15, 89, 17),
(212, 42, 13, 15, 92, 17),
(213, 42, 13, 15, 90, 17),
(214, 42, 13, 15, 84, 17),
(215, 42, 13, 15, 87, 17),
(216, 42, 13, 15, 85, 17),
(217, 42, 13, 15, 88, 17),
(218, 42, 13, 15, 91, 17),
(219, 44, 14, 15, 83, 17),
(220, 44, 14, 15, 86, 17),
(221, 44, 14, 15, 89, 17),
(222, 44, 14, 15, 92, 17),
(223, 44, 14, 15, 90, 17),
(224, 44, 14, 15, 84, 17),
(225, 44, 14, 15, 87, 17),
(226, 44, 14, 15, 88, 17),
(227, 44, 14, 15, 91, 17),
(228, 46, 16, 15, 83, 17),
(229, 46, 16, 15, 86, 17),
(230, 46, 16, 15, 89, 17),
(231, 46, 16, 15, 92, 17),
(232, 46, 16, 15, 90, 17),
(233, 46, 16, 15, 84, 17),
(234, 46, 16, 15, 87, 17),
(235, 46, 16, 15, 85, 17),
(236, 46, 16, 15, 88, 17),
(237, 46, 16, 15, 91, 17),
(238, 48, 12, 15, 83, 17),
(239, 48, 12, 15, 86, 17),
(240, 48, 12, 15, 89, 17),
(241, 48, 12, 15, 92, 17),
(242, 48, 12, 15, 90, 17),
(243, 48, 12, 15, 84, 17),
(244, 48, 12, 15, 87, 17),
(245, 48, 12, 15, 85, 17),
(246, 48, 12, 15, 88, 17),
(247, 48, 12, 15, 91, 17),
(248, 37, 17, 14, 75, 17),
(249, 37, 17, 14, 76, 17),
(250, 37, 17, 14, 82, 17),
(251, 39, 15, 14, 79, 17),
(252, 41, 18, 14, 77, 17),
(253, 43, 13, 14, 73, 17),
(254, 43, 13, 14, 80, 17),
(255, 45, 14, 14, 74, 17),
(256, 45, 14, 14, 81, 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_kategori`
--

CREATE TABLE `urun_kategori` (
  `id` int(11) NOT NULL,
  `adi` varchar(225) NOT NULL,
  `tam_adi` varchar(550) NOT NULL,
  `urun_grubu_kategori` int(11) NOT NULL,
  `durum` int(11) NOT NULL,
  `kampanya` int(11) NOT NULL,
  `is_old` int(11) NOT NULL,
  `takip_turu` int(11) NOT NULL,
  `kullanici` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `urun_kategori`
--

INSERT INTO `urun_kategori` (`id`, `adi`, `tam_adi`, `urun_grubu_kategori`, `durum`, `kampanya`, `is_old`, `takip_turu`, `kullanici`) VALUES
(2, 'KAMPANYA-KAMPANYALI PAKETLER', '', 1, 1, 1, 0, 0, 17),
(3, 'NOVA-PAKET SATIŞI', '', 1, 1, 0, 0, 2, 17),
(4, 'MASAÜSTÜ-PAKET SATIŞI', '', 1, 1, 0, 0, 2, 17),
(5, 'KOLAY e-SMM ABONELİK (SERBEST MESLEK  MENSUPLARI AVUKAT,DOKTOR,MİMAR VB.', 'KOLAY e-SMM ABONELİK (SERBEST MESLEK  MENSUPLARI AVUKAT,DOKTOR,MİMAR VB.', 1, 1, 0, 0, 2, 17),
(6, 'Nova - İlave Kullanıcı', 'Nova - İlave Kullanıcı', 2, 1, 0, 0, 1, 17),
(7, 'Nova - İlave Firma', 'Nova - İlave Firma', 2, 1, 0, 0, 1, 17),
(8, 'Zirve Drive - Zirve Drive Hizmetleri', 'Zirve Drive - Zirve Drive Hizmetleri', 2, 1, 0, 0, 2, 17),
(9, 'Masaüstü - İlave Kullanıcı', 'Masaüstü - İlave Kullanıcı', 2, 1, 0, 0, 1, 17),
(10, 'Masaüstü - e-Dönüşüm Paketleri', 'Masaüstü - e-Dönüşüm Paketleri', 2, 1, 0, 0, 2, 17),
(11, 'Masaüstü Defter Beyan Paketkeri', 'Masaüstü Defter Beyan Paketkeri', 2, 1, 0, 0, 2, 17),
(12, 'Teknik Destek - Teknik Destek', 'Teknik Destek - Teknik Destek', 2, 1, 0, 0, 1, 17),
(13, 'Ek Modüller - Ek Modüller', 'Ek Modüller - Ek Modüller', 2, 1, 0, 0, 1, 17),
(14, 'MASAÜSTÜ PAKET YÜKSELTME', 'MASAÜSTÜ PAKET YÜKSELTME', 2, 1, 0, 1, 2, 17),
(15, 'E-DÖNÜŞÜM KONTÖR', 'E-DÖNÜŞÜM KONTÖR', 2, 1, 0, 1, 2, 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyeler`
--

CREATE TABLE `uyeler` (
  `id` int(11) NOT NULL,
  `name` varchar(500) DEFAULT NULL,
  `surname` varchar(225) NOT NULL,
  `username` varchar(500) DEFAULT NULL,
  `pass` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `tel` varchar(225) NOT NULL,
  `adres` varchar(225) NOT NULL,
  `ilce` varchar(225) NOT NULL,
  `il` varchar(225) NOT NULL,
  `ulke` varchar(225) NOT NULL,
  `posta_kod` varchar(225) NOT NULL,
  `status` int(11) NOT NULL,
  `bas_tar` date NOT NULL,
  `bit_tar` date NOT NULL,
  `cari_id` int(11) NOT NULL,
  `bayi_id` int(11) NOT NULL,
  `uye_turu` int(11) NOT NULL,
  `uye_sayisi` int(10) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `yetki` int(11) NOT NULL,
  `firma` int(11) NOT NULL,
  `uyelik` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `cari` int(11) NOT NULL,
  `siparis` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `uyeler`
--

INSERT INTO `uyeler` (`id`, `name`, `surname`, `username`, `pass`, `email`, `tel`, `adres`, `ilce`, `il`, `ulke`, `posta_kod`, `status`, `bas_tar`, `bit_tar`, `cari_id`, `bayi_id`, `uye_turu`, `uye_sayisi`, `kullanici_id`, `yetki`, `firma`, `uyelik`, `stok`, `cari`, `siparis`) VALUES
(17, 'hhhh', '', 'hhhh', '20cc88d2e204ffa768509d33fa882492', 'yocalmis@gmail.com', '', 'adresadresadres', 'Kocasinan', 'Kayseri', '', '', 1, '2019-04-09', '2025-06-11', 0, 1, 1, 27, 17, 1, 1, 1, 1, 1, 1),
(47, 'Yılmaz', 'Yıldız', 'yyildiz', '20cc88d2e204ffa768509d33fa882492', 'yusuf@zirvekayseri.com', '4324243424', 'sefgsgdf bfdbdthtd', 'rgrehgreh', 'hrehre', 'fsgrgr', '34567', 1, '2021-05-20', '2025-05-27', 4, 1, 2, 0, 17, 0, 1, 0, 1, 1, 1),
(55, 'Yılmaz', 'Yıldız', 'kkkkk', '20cc88d2e204ffa768509d33fa882492', 'yuaa@zirvekayseri.com', '4324243424', 'sefgsgdf bfdbdthtd', 'rgrehgreh', 'hrehre', 'fsgrgr', '34567', 1, '2021-05-20', '2025-05-27', 4, 1, 2, 0, 17, 0, 1, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uye_cari`
--

CREATE TABLE `uye_cari` (
  `uye_cari_id` int(11) NOT NULL,
  `uye` int(11) NOT NULL,
  `cari` int(11) NOT NULL,
  `kullanici` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `uye_cari`
--

INSERT INTO `uye_cari` (`uye_cari_id`, `uye`, `cari`, `kullanici`) VALUES
(1, 47, 9, 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `virman`
--

CREATE TABLE `virman` (
  `id` int(11) NOT NULL,
  `gonderici` int(11) NOT NULL,
  `alici` int(11) NOT NULL,
  `tutar` varchar(225) NOT NULL,
  `tarih` date NOT NULL,
  `aciklama` text NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `zaman`
--

CREATE TABLE `zaman` (
  `id` int(11) NOT NULL,
  `tarih_bas` date NOT NULL,
  `tarih_bit` date NOT NULL,
  `kim` int(11) NOT NULL,
  `islem` varchar(225) NOT NULL,
  `aciklama` text NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `zaman`
--

INSERT INTO `zaman` (`id`, `tarih_bas`, `tarih_bit`, `kim`, `islem`, `aciklama`, `kullanici_id`) VALUES
(1, '2020-07-01', '2020-07-01', 17, 'Ticaride güncellemeler yaptım', '<p>Ticaride güncellemeler yaptım</p>', 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `zimmet`
--

CREATE TABLE `zimmet` (
  `id` int(11) NOT NULL,
  `demirbas` int(11) NOT NULL,
  `adet` int(11) NOT NULL,
  `teslim_tarihi` date NOT NULL,
  `iade_tarihi` date NOT NULL,
  `aciklama` text NOT NULL,
  `cari_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `arac`
--
ALTER TABLE `arac`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ayar`
--
ALTER TABLE `ayar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `bakim`
--
ALTER TABLE `bakim`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `bina`
--
ALTER TABLE `bina`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `blok`
--
ALTER TABLE `blok`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `borc_alacak`
--
ALTER TABLE `borc_alacak`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `cari`
--
ALTER TABLE `cari`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adi_soyadi_unvan` (`adi_soyadi_unvan`);

--
-- Tablo için indeksler `cari_gecmis`
--
ALTER TABLE `cari_gecmis`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `cek_senet`
--
ALTER TABLE `cek_senet`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `daire`
--
ALTER TABLE `daire`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `dosyalar`
--
ALTER TABLE `dosyalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ek_kullanici_takip`
--
ALTER TABLE `ek_kullanici_takip`
  ADD PRIMARY KEY (`ek_kullanici_id`);

--
-- Tablo için indeksler `etkinlik`
--
ALTER TABLE `etkinlik`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `fatura`
--
ALTER TABLE `fatura`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `fatura_item`
--
ALTER TABLE `fatura_item`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `fatura_not`
--
ALTER TABLE `fatura_not`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `fat_irs_iliski`
--
ALTER TABLE `fat_irs_iliski`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gider_kategori`
--
ALTER TABLE `gider_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gorusme`
--
ALTER TABLE `gorusme`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `hedefler`
--
ALTER TABLE `hedefler`
  ADD PRIMARY KEY (`hedef_id`);

--
-- Tablo için indeksler `hizmet_urun`
--
ALTER TABLE `hizmet_urun`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `irsaliye`
--
ALTER TABLE `irsaliye`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `irsaliye_item`
--
ALTER TABLE `irsaliye_item`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `islem`
--
ALTER TABLE `islem`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `izin`
--
ALTER TABLE `izin`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kampanya_urunleri`
--
ALTER TABLE `kampanya_urunleri`
  ADD PRIMARY KEY (`kampanya_urun_id`);

--
-- Tablo için indeksler `kasa`
--
ALTER TABLE `kasa`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `km`
--
ALTER TABLE `km`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `komite`
--
ALTER TABLE `komite`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `mesaj`
--
ALTER TABLE `mesaj`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `notlar`
--
ALTER TABLE `notlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ornek_dosyalar`
--
ALTER TABLE `ornek_dosyalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `potansiyel`
--
ALTER TABLE `potansiyel`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `siparis`
--
ALTER TABLE `siparis`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `siparis_item`
--
ALTER TABLE `siparis_item`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sss`
--
ALTER TABLE `sss`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tartisma`
--
ALTER TABLE `tartisma`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tartisma_msj`
--
ALTER TABLE `tartisma_msj`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `teklif`
--
ALTER TABLE `teklif`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `teklif_item`
--
ALTER TABLE `teklif_item`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `uruneslestir`
--
ALTER TABLE `uruneslestir`
  ADD PRIMARY KEY (`uruneslestir_id`);

--
-- Tablo için indeksler `uruneslestir_iliski`
--
ALTER TABLE `uruneslestir_iliski`
  ADD PRIMARY KEY (`uruneslestir_iliski_id`);

--
-- Tablo için indeksler `urun_kategori`
--
ALTER TABLE `urun_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `uyeler`
--
ALTER TABLE `uyeler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `uye_cari`
--
ALTER TABLE `uye_cari`
  ADD PRIMARY KEY (`uye_cari_id`);

--
-- Tablo için indeksler `virman`
--
ALTER TABLE `virman`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `zaman`
--
ALTER TABLE `zaman`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `zimmet`
--
ALTER TABLE `zimmet`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `arac`
--
ALTER TABLE `arac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `ayar`
--
ALTER TABLE `ayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `bakim`
--
ALTER TABLE `bakim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `bina`
--
ALTER TABLE `bina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Tablo için AUTO_INCREMENT değeri `blok`
--
ALTER TABLE `blok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `borc_alacak`
--
ALTER TABLE `borc_alacak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `cari`
--
ALTER TABLE `cari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Tablo için AUTO_INCREMENT değeri `cari_gecmis`
--
ALTER TABLE `cari_gecmis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `cek_senet`
--
ALTER TABLE `cek_senet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `daire`
--
ALTER TABLE `daire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `dosyalar`
--
ALTER TABLE `dosyalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ek_kullanici_takip`
--
ALTER TABLE `ek_kullanici_takip`
  MODIFY `ek_kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `etkinlik`
--
ALTER TABLE `etkinlik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `fatura`
--
ALTER TABLE `fatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- Tablo için AUTO_INCREMENT değeri `fatura_item`
--
ALTER TABLE `fatura_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- Tablo için AUTO_INCREMENT değeri `fatura_not`
--
ALTER TABLE `fatura_not`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `fat_irs_iliski`
--
ALTER TABLE `fat_irs_iliski`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `gider_kategori`
--
ALTER TABLE `gider_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `gorusme`
--
ALTER TABLE `gorusme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `hedefler`
--
ALTER TABLE `hedefler`
  MODIFY `hedef_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `hizmet_urun`
--
ALTER TABLE `hizmet_urun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- Tablo için AUTO_INCREMENT değeri `irsaliye`
--
ALTER TABLE `irsaliye`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `irsaliye_item`
--
ALTER TABLE `irsaliye_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `islem`
--
ALTER TABLE `islem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- Tablo için AUTO_INCREMENT değeri `izin`
--
ALTER TABLE `izin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `kampanya_urunleri`
--
ALTER TABLE `kampanya_urunleri`
  MODIFY `kampanya_urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `kasa`
--
ALTER TABLE `kasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `km`
--
ALTER TABLE `km`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `komite`
--
ALTER TABLE `komite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- Tablo için AUTO_INCREMENT değeri `mesaj`
--
ALTER TABLE `mesaj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Tablo için AUTO_INCREMENT değeri `notlar`
--
ALTER TABLE `notlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ornek_dosyalar`
--
ALTER TABLE `ornek_dosyalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `potansiyel`
--
ALTER TABLE `potansiyel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `siparis`
--
ALTER TABLE `siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `siparis_item`
--
ALTER TABLE `siparis_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `sss`
--
ALTER TABLE `sss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `tartisma`
--
ALTER TABLE `tartisma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `tartisma_msj`
--
ALTER TABLE `tartisma_msj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `teklif`
--
ALTER TABLE `teklif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `teklif_item`
--
ALTER TABLE `teklif_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `uruneslestir`
--
ALTER TABLE `uruneslestir`
  MODIFY `uruneslestir_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Tablo için AUTO_INCREMENT değeri `uruneslestir_iliski`
--
ALTER TABLE `uruneslestir_iliski`
  MODIFY `uruneslestir_iliski_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- Tablo için AUTO_INCREMENT değeri `urun_kategori`
--
ALTER TABLE `urun_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `uyeler`
--
ALTER TABLE `uyeler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Tablo için AUTO_INCREMENT değeri `uye_cari`
--
ALTER TABLE `uye_cari`
  MODIFY `uye_cari_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `virman`
--
ALTER TABLE `virman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `zaman`
--
ALTER TABLE `zaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `zimmet`
--
ALTER TABLE `zimmet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
