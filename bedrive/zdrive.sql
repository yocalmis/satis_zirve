-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 04 Haz 2020, 15:05:36
-- Sunucu sürümü: 10.1.34-MariaDB
-- PHP Sürümü: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `zdrive`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `billing_plans`
--

CREATE TABLE `billing_plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$',
  `interval` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'month',
  `interval_count` int(11) NOT NULL DEFAULT '1',
  `parent_id` int(11) DEFAULT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paypal_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recommended` tinyint(1) NOT NULL DEFAULT '0',
  `free` tinyint(1) NOT NULL DEFAULT '0',
  `show_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `features` text COLLATE utf8mb4_unicode_ci,
  `position` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `available_space` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `file_entries`
--

CREATE TABLE `file_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `path` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `public_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `preview_token` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `file_entries`
--

INSERT INTO `file_entries` (`id`, `name`, `description`, `file_name`, `mime`, `file_size`, `user_id`, `parent_id`, `password`, `created_at`, `updated_at`, `deleted_at`, `path`, `public_path`, `type`, `extension`, `public`, `preview_token`, `thumbnail`) VALUES
(1, 'aa.jpg', NULL, 'kOxxECH2CTSbFrEXwkFRfhCnwe16rSn0jS71m5kQ', 'image/jpeg', 600593, NULL, NULL, NULL, '2019-11-11 08:44:01', '2019-11-11 09:51:10', '2019-11-11 09:51:10', '1', NULL, 'image', 'jpg', 0, NULL, 1),
(2, 'aa.jpg', NULL, 'OznjckLkaKCmTwVJTR0mn06xfBhwyfdjoC57M17l', 'image/jpeg', 600593, NULL, NULL, NULL, '2019-11-13 10:42:50', '2019-11-13 10:55:03', '2019-11-13 10:55:03', '2', NULL, 'image', 'jpg', 0, NULL, 1),
(3, 'a0898ff2-0ffd-4cc7-858c-77d81d76c982.jpg', NULL, 'yrmSo1qm3CQO6IFVV92XyGFHRCD52cka65ZnvR07', 'image/jpeg', 283041, NULL, NULL, NULL, '2019-11-13 10:43:53', '2019-11-13 10:54:59', '2019-11-13 10:54:59', '3', NULL, 'image', 'jpg', 0, NULL, 0),
(4, 'aa.jpg', NULL, 'nN8NQ9lu3lsHK7VMO9smMN5uFm8uk5q7GBHlnKzr', 'image/jpeg', 600593, NULL, NULL, NULL, '2019-11-13 10:47:20', '2019-11-26 04:35:41', '2019-11-26 04:35:41', '4', NULL, 'image', 'jpg', 0, NULL, 1),
(5, 'aa.jpg', NULL, 'WYH9RM21dzstfYWvQFGNsnhRgpzPVrVq9WUTbWo0', 'image/jpeg', 600593, NULL, NULL, NULL, '2019-11-13 10:51:40', '2019-11-13 10:53:30', '2019-11-13 10:53:30', '5', NULL, 'image', 'jpg', 0, NULL, 1),
(6, 'aa.jpg', NULL, '0Cjcos68rhctK7VZUoU84zBsK6ZdCGy5MRg4I6mP', 'image/jpeg', 600593, NULL, NULL, NULL, '2019-11-13 10:57:41', '2019-11-13 11:03:03', '2019-11-13 11:03:03', '6', NULL, 'image', 'jpg', 0, NULL, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `file_entry_models`
--

CREATE TABLE `file_entry_models` (
  `id` int(10) UNSIGNED NOT NULL,
  `file_entry_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `folders`
--

CREATE TABLE `folders` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `folder_id` int(11) DEFAULT NULL,
  `share_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `labelables`
--

CREATE TABLE `labelables` (
  `id` int(10) UNSIGNED NOT NULL,
  `label_id` int(11) NOT NULL,
  `labelable_id` int(11) NOT NULL,
  `labelable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `labels`
--

CREATE TABLE `labels` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `localizations`
--

CREATE TABLE `localizations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `localizations`
--

INSERT INTO `localizations` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'english', '2019-11-08 10:26:07', '2019-11-08 10:26:07'),
(2, 'turkish', '2019-11-26 05:21:36', '2019-11-26 05:21:36');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mail_templates`
--

CREATE TABLE `mail_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `markdown` tinyint(1) NOT NULL DEFAULT '0',
  `action` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `display_name`, `file_name`, `subject`, `markdown`, `action`, `created_at`, `updated_at`) VALUES
(1, 'Email Confirmation', 'email-confirmation.blade.php', 'Confirm your {{SITE_NAME}} account', 0, 'email_confirmation', '2019-11-08 10:26:08', '2019-11-08 10:26:08'),
(2, 'Generic', 'generic.blade.php', '{{EMAIL_SUBJECT}}', 0, 'generic', '2019-11-08 10:26:08', '2019-11-08 10:26:08'),
(3, 'Share', 'share.blade.php', '{{DISPLAY_NAME}} shared \'{{ITEM_NAME}}\' with you', 0, 'share', '2019-11-08 10:26:08', '2019-11-08 10:26:08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2015_04_127_156842_create_social_profiles_table', 1),
(4, '2015_04_127_156842_create_users_oauth_table', 1),
(5, '2015_04_13_140047_create_files_models_table', 1),
(6, '2015_04_18_134312_create_folders_table', 1),
(7, '2015_05_05_131439_create_labels_table', 1),
(8, '2015_05_29_131549_create_settings_table', 1),
(9, '2015_08_08_131451_create_labelables_table', 1),
(10, '2016_03_18_142141_add_email_confirmation_to_users_table', 1),
(11, '2016_04_06_140017_add_folder_id_index_to_files_table', 1),
(12, '2016_05_12_190852_create_tags_table', 1),
(13, '2016_05_12_190958_create_taggables_table', 1),
(14, '2016_05_26_170044_create_uploads_table', 1),
(15, '2016_05_27_143158_create_uploadables_table', 1),
(16, '2016_07_14_153703_create_groups_table', 1),
(17, '2016_07_14_153921_create_user_group_table', 1),
(18, '2016_10_17_152159_add_space_available_column_to_users_table', 1),
(19, '2017_07_02_120142_create_pages_table', 1),
(20, '2017_07_11_122825_create_localizations_table', 1),
(21, '2017_07_17_135837_create_mail_templates_table', 1),
(22, '2017_08_26_131330_add_private_field_to_settings_table', 1),
(23, '2017_09_17_144728_add_columns_to_users_table', 1),
(24, '2017_09_17_152854_make_password_column_nullable', 1),
(25, '2017_09_30_152855_make_settings_value_column_nullable', 1),
(26, '2017_10_01_152897_add_public_column_to_uploads_table', 1),
(27, '2017_12_04_132911_add_avatar_column_to_users_table', 1),
(28, '2018_01_10_140732_create_subscriptions_table', 1),
(29, '2018_01_10_140746_add_billing_to_users_table', 1),
(30, '2018_01_10_161706_create_billing_plans_table', 1),
(31, '2018_06_02_143319_create_user_file_entry_table', 1),
(32, '2018_06_05_142932_rename_files_table_to_file_entries', 1),
(33, '2018_06_06_141629_rename_file_entries_table_columns', 1),
(34, '2018_06_07_141630_merge_files_and_folders_tables', 1),
(35, '2018_07_03_114346_create_shareable_links_table', 1),
(36, '2018_07_24_113757_add_available_space_to_billing_plans_table', 1),
(37, '2018_07_24_124254_add_available_space_to_users_table', 1),
(38, '2018_07_26_142339_rename_groups_to_roles', 1),
(39, '2018_07_26_142842_rename_user_role_table_columns_to_roles', 1),
(40, '2018_08_07_124200_rename_uploads_to_file_entries', 1),
(41, '2018_08_07_124327_refactor_file_entries_columns', 1),
(42, '2018_08_07_130653_add_folder_path_column_to_file_entries_table', 1),
(43, '2018_08_07_140328_delete_legacy_root_folders', 1),
(44, '2018_08_07_140330_move_folders_into_file_entries_table', 1),
(45, '2018_08_07_140440_migrate_file_entry_users_to_many_to_many', 1),
(46, '2018_08_10_142251_update_users_table_to_v2', 1),
(47, '2018_08_15_125115_update_uploads_structure_to_v2', 1),
(48, '2018_08_15_132225_move_uploads_into_subfolders', 1),
(49, '2018_08_16_111525_transform_file_entries_records_to_v2', 1),
(50, '2018_08_31_104145_rename_uploadables_table', 1),
(51, '2018_08_31_104325_rename_file_entry_models_table_columns', 1),
(52, '2018_11_26_171703_add_type_and_title_columns_to_pages_table', 1),
(53, '2018_12_01_144233_change_unique_index_on_tags_table', 1),
(54, '2019_02_16_150049_delete_old_seo_settings', 1),
(55, '2019_02_24_141457_create_jobs_table', 1),
(56, '2019_03_11_162627_add_preview_token_to_file_entries_table', 1),
(57, '2019_03_12_160803_add_thumbnail_column_to_file_entries_table', 1),
(58, '2019_03_16_161836_add_paypal_id_column_to_billing_plans_table', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `default` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `guests` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions`, `default`, `guests`, `created_at`, `updated_at`) VALUES
(1, 'guests', '{\"users.view\":1,\"pages.view\":1,\"links.view\":1}', 0, 1, '2019-11-08 10:26:08', '2019-11-08 10:26:08'),
(2, 'users', '{\"users.view\":1,\"localizations.view\":1,\"pages.view\":1,\"files.create\":1,\"plans.view\":1,\"links.view\":1,\"links.create\":1,\"0\":1}', 1, 0, '2019-11-08 10:26:08', '2019-11-08 10:26:08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`, `private`) VALUES
(1, 'dates.format', 'yyyy-MM-dd', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(2, 'dates.locale', 'en_US', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(3, 'social.google.enable', '1', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(4, 'social.twitter.enable', '1', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(5, 'social.facebook.enable', '1', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(6, 'realtime.enable', '0', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(7, 'registration.disable', '0', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(8, 'branding.use_custom_theme', '1', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(9, 'branding.favicon', '', '2019-11-08 10:26:08', '2020-06-04 06:50:34', 0),
(10, 'branding.logo_dark', '', '2019-11-08 10:26:08', '2020-06-04 06:50:34', 0),
(11, 'branding.logo_light', '', '2019-11-08 10:26:08', '2020-06-04 06:50:34', 0),
(12, 'i18n.default_localization', 'english', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(13, 'i18n.enable', '1', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(14, 'logging.sentry_public', NULL, '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(15, 'realtime.pusher_key', NULL, '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(16, 'homepage.type', 'default', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(17, 'billing.enable', '0', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(18, 'billing.paypal_test_mode', '1', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(19, 'billing.stripe_test_mode', '1', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(20, 'billing.stripe.enable', '0', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(21, 'billing.paypal.enable', '0', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(22, 'billing.accepted_cards', '[\"visa\",\"mastercard\",\"american-express\",\"discover\"]', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(23, 'branding.site_name', 'BeDrive', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(24, 'cache.report_minutes', '60', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(25, 'site.force_https', '0', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(26, 'menus', '[{\"name\":\"Drive Sidebar\",\"position\":\"drive-sidebar\",\"items\":[{\"type\":\"route\",\"order\":1,\"label\":\"Shared with me\",\"action\":\"drive\\/shares\",\"icon\":\"people\"},{\"type\":\"route\",\"order\":2,\"label\":\"Recent\",\"action\":\"drive\\/recent\",\"icon\":\"access-time\"},{\"type\":\"route\",\"order\":3,\"label\":\"Starred\",\"action\":\"drive\\/starred\",\"icon\":\"star\"},{\"type\":\"route\",\"order\":4,\"label\":\"Trash\",\"action\":\"drive\\/trash\",\"icon\":\"delete\"}]}]', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(27, 'uploads.max_size', '52428800', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(28, 'uploads.available_space', '104857600', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(29, 'uploads.blocked_extensions', '[\"exe\",\"application\\/x-msdownload\",\"x-dosexec\"]', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(30, 'landingPage.background', '', '2019-11-08 10:26:08', '2020-06-04 06:49:33', 0),
(31, 'landingPage.title', 'BeDrive. A new home for your files.', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(32, 'landingPage.subtitle', 'Register or Login now to upload, backup, manage and access your files on any device, from anywhere, free.', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(33, 'landingPage.ctaButton', 'Register Now', '2019-11-08 10:26:08', '2019-11-08 10:26:08', 0),
(34, 'branding.site_description', 'Dosyalarınızı saklayabilir , paylaşabilirsiniz.', '2020-06-04 06:50:34', '2020-06-04 06:50:34', 0),
(35, 'seo.home.show.keywords', 'Dosya, Güvenlik, Bulut, Saklama,Yedekleme', '2020-06-04 06:52:18', '2020-06-04 06:52:18', 0),
(36, 'seo.home.show.og:description', 'Bulut size güvenli dosya saklama hizmeti sağlar.', '2020-06-04 06:52:18', '2020-06-04 06:52:18', 0),
(37, 'seo.home.show.og:title', 'Bulut , dosya saklama', '2020-06-04 06:52:18', '2020-06-04 06:52:18', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `shareable_links`
--

CREATE TABLE `shareable_links` (
  `id` int(10) UNSIGNED NOT NULL,
  `hash` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `entry_id` int(10) UNSIGNED NOT NULL,
  `allow_edit` tinyint(1) NOT NULL DEFAULT '0',
  `allow_download` tinyint(1) NOT NULL DEFAULT '1',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `social_profiles`
--

CREATE TABLE `social_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_service_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `gateway_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `quantity` int(11) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `renews_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `taggables`
--

CREATE TABLE `taggables` (
  `tag_id` int(10) UNSIGNED NOT NULL,
  `taggable_id` int(10) UNSIGNED NOT NULL,
  `taggable_type` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'custom',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `tags`
--

INSERT INTO `tags` (`id`, `name`, `display_name`, `type`, `created_at`, `updated_at`) VALUES
(1, 'starred', 'Starred', 'label', '2019-11-08 10:26:07', '2019-11-08 10:26:07');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uploads`
--

CREATE TABLE `uploads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `path` varchar(191) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '1',
  `confirmation_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `space_available` bigint(20) UNSIGNED DEFAULT NULL,
  `language` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available_space` bigint(20) UNSIGNED DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `card_brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `confirmed`, `confirmation_code`, `space_available`, `language`, `country`, `timezone`, `avatar`, `stripe_id`, `available_space`, `first_name`, `last_name`, `permissions`, `card_brand`, `card_last_four`) VALUES
(1, 'yocalmis', 'yocalmis@gmail.com', '$2y$10$xsMUi7OA7qNTsMHQTKo8luVMCunwfco1K7JrlWU6Gy.BjcFBsBE36', 'CDlcBBCNyGIIdNzsusBf6n5AnhyOWv3dNzXP8jVESEdFC8tnTSBRb2HMzZ4V', '2019-11-08 10:26:06', '2019-11-26 06:03:13', 1, NULL, NULL, 'turkish', 'tr', NULL, 'https://www.gravatar.com/avatar/0e331a65b04d7db5866a804eac6adb1a?s=65', NULL, 8073741824, NULL, NULL, '{\"admin\":1,\"superAdmin\":1}', NULL, NULL),
(2, '', 'yusuf@zirvekayseri.com', '$2y$10$xsMUi7OA7qNTsMHQTKo8luVMCunwfco1K7JrlWU6Gy.BjcFBsBE36', 'ZTbllJ6GpexIFlaClfzRJKg4g6yF2ztuQx0gN2TfF4xH20qtpfKvkG5AcoXh', '2019-11-08 10:40:47', '2019-11-13 11:02:38', 1, NULL, NULL, 'english', NULL, NULL, 'https://www.gravatar.com/avatar/16884c1050f5ba448d894eda0bccf5e6?s=65', NULL, 0, 'Yusuf', 'Zirve', '{\"files.delete\":1}', NULL, NULL),
(3, '', 'yusuf2@zirvekayseri.com', '$2y$10$u9mqvD8Xa.kYm1T8kVY0We9X/yVPQdLdy4IEWkb7mMtMjNMAUdTrm', 'Y7erRKARo2xPaJpKs7ZcfrRE6hyjbtMbF88zEJe6WYVsif3eUyQJnAVuEn2e', '2019-11-08 10:40:47', '2019-11-26 05:59:00', 1, NULL, NULL, 'english', NULL, NULL, 'https://www.gravatar.com/avatar/a842dee0c4036892efb65b0fcc8765fb?s=65', NULL, 1073741824, 'Yusufss', 'Zirvess', '[]', NULL, NULL),
(4, 'mr.mix0000', 'mr.mix0000@gmail.com', '$2y$10$xsMUi7OA7qNTsMHQTKo8luVMCunwfco1K7JrlWU6Gy.BjcFBsBE36', 'wHHJmogZHGmn0n4WkM7A7kYCGhxhAzyyamgzUMgeu3J940WsL7A0OIHBC46T', NULL, NULL, 1, NULL, NULL, 'english', NULL, NULL, 'https://www.gravatar.com/avatar/16884c1050f5ba448d894eda0bccf5e6?s=65', NULL, 1073741824, NULL, NULL, '[]', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users_oauth`
--

CREATE TABLE `users_oauth` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `service` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_file_entry`
--

CREATE TABLE `user_file_entry` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `file_entry_id` int(10) UNSIGNED NOT NULL,
  `owner` tinyint(1) NOT NULL DEFAULT '0',
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `user_file_entry`
--

INSERT INTO `user_file_entry` (`id`, `user_id`, `file_entry_id`, `owner`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL),
(2, 1, 2, 1, NULL, NULL, NULL),
(3, 1, 3, 1, NULL, NULL, NULL),
(4, 4, 4, 1, NULL, NULL, NULL),
(5, 6, 5, 1, NULL, NULL, NULL),
(6, 2, 5, 0, '{\"view\":true,\"edit\":true,\"download\":true}', '2019-11-13 10:52:29', '2019-11-13 10:52:29'),
(7, 1, 6, 1, NULL, NULL, NULL),
(8, 2, 6, 0, '{\"view\":true,\"edit\":true,\"download\":true}', '2019-11-13 10:58:53', '2019-11-13 10:58:53');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_role`
--

CREATE TABLE `user_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`, `created_at`) VALUES
(1, 1, 2, '2019-11-08 10:26:08'),
(2, 2, 2, '2019-11-08 10:26:08'),
(3, 3, 2, '2019-11-08 10:26:08'),
(4, 4, 2, NULL);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `billing_plans`
--
ALTER TABLE `billing_plans`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `file_entries`
--
ALTER TABLE `file_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_user_id_index` (`user_id`),
  ADD KEY `files_folder_id_index` (`parent_id`),
  ADD KEY `file_entries_name_index` (`name`),
  ADD KEY `file_entries_path_index` (`path`),
  ADD KEY `file_entries_type_index` (`type`),
  ADD KEY `file_entries_public_index` (`public`);

--
-- Tablo için indeksler `file_entry_models`
--
ALTER TABLE `file_entry_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uploadables_upload_id_uploadable_id_uploadable_type_unique` (`file_entry_id`,`model_id`,`model_type`);

--
-- Tablo için indeksler `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `folders_user_id_index` (`user_id`),
  ADD KEY `folders_share_id_index` (`share_id`),
  ADD KEY `folders_folder_id_index` (`folder_id`);

--
-- Tablo için indeksler `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`);

--
-- Tablo için indeksler `labelables`
--
ALTER TABLE `labelables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `labelables_label_id_labelable_id_labelable_type_unique` (`label_id`,`labelable_id`,`labelable_type`),
  ADD KEY `labelables_labelable_id_index` (`labelable_id`),
  ADD KEY `labelables_label_id_index` (`label_id`);

--
-- Tablo için indeksler `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `labels_name_unique` (`name`);

--
-- Tablo için indeksler `localizations`
--
ALTER TABLE `localizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `localizations_name_index` (`name`);

--
-- Tablo için indeksler `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail_templates_file_name_unique` (`file_name`),
  ADD UNIQUE KEY `mail_templates_action_unique` (`action`);

--
-- Tablo için indeksler `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`),
  ADD KEY `pages_type_index` (`type`);

--
-- Tablo için indeksler `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Tablo için indeksler `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_name_unique` (`name`),
  ADD KEY `groups_default_index` (`default`),
  ADD KEY `groups_guests_index` (`guests`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_name_unique` (`name`),
  ADD KEY `settings_private_index` (`private`);

--
-- Tablo için indeksler `shareable_links`
--
ALTER TABLE `shareable_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shareable_links_hash_unique` (`hash`),
  ADD KEY `shareable_links_user_id_index` (`user_id`),
  ADD KEY `shareable_links_entry_id_index` (`entry_id`);

--
-- Tablo için indeksler `social_profiles`
--
ALTER TABLE `social_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `social_profiles_user_id_service_name_unique` (`user_id`,`service_name`),
  ADD UNIQUE KEY `social_profiles_service_name_user_service_id_unique` (`service_name`,`user_service_id`),
  ADD KEY `social_profiles_user_id_index` (`user_id`);

--
-- Tablo için indeksler `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_gateway_index` (`gateway`);

--
-- Tablo için indeksler `taggables`
--
ALTER TABLE `taggables`
  ADD UNIQUE KEY `taggables_tag_id_taggable_id_user_id_taggable_type_unique` (`tag_id`,`taggable_id`,`user_id`,`taggable_type`),
  ADD KEY `taggables_tag_id_index` (`tag_id`),
  ADD KEY `taggables_taggable_id_index` (`taggable_id`),
  ADD KEY `taggables_taggable_type_index` (`taggable_type`),
  ADD KEY `taggables_user_id_index` (`user_id`);

--
-- Tablo için indeksler `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_name_type_unique` (`name`,`type`),
  ADD KEY `tags_type_index` (`type`);

--
-- Tablo için indeksler `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uploads_file_name_unique` (`file_name`),
  ADD KEY `uploads_name_index` (`name`),
  ADD KEY `uploads_user_id_index` (`user_id`),
  ADD KEY `uploads_public_index` (`public`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Tablo için indeksler `users_oauth`
--
ALTER TABLE `users_oauth`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_oauth_user_id_service_unique` (`user_id`,`service`),
  ADD UNIQUE KEY `users_oauth_token_unique` (`token`),
  ADD KEY `users_oauth_user_id_index` (`user_id`);

--
-- Tablo için indeksler `user_file_entry`
--
ALTER TABLE `user_file_entry`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_file_entry_file_entry_id_user_id_unique` (`file_entry_id`,`user_id`),
  ADD KEY `user_file_entry_user_id_index` (`user_id`),
  ADD KEY `user_file_entry_file_entry_id_index` (`file_entry_id`),
  ADD KEY `user_file_entry_owner_index` (`owner`);

--
-- Tablo için indeksler `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_group_user_id_group_id_unique` (`user_id`,`role_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `billing_plans`
--
ALTER TABLE `billing_plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `file_entries`
--
ALTER TABLE `file_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `file_entry_models`
--
ALTER TABLE `file_entry_models`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `labelables`
--
ALTER TABLE `labelables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `labels`
--
ALTER TABLE `labels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `localizations`
--
ALTER TABLE `localizations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Tablo için AUTO_INCREMENT değeri `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Tablo için AUTO_INCREMENT değeri `shareable_links`
--
ALTER TABLE `shareable_links`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `social_profiles`
--
ALTER TABLE `social_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `users_oauth`
--
ALTER TABLE `users_oauth`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `user_file_entry`
--
ALTER TABLE `user_file_entry`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
