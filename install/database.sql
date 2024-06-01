-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 10 Eki 2020, 15:06:16
-- Sunucu sürümü: 10.3.24-MariaDB-log-cll-lve
-- PHP Sürümü: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `deniuivl_newpanel`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `alert` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Tablo için tablo yapısı `bouqet_list`
--

CREATE TABLE `bouqet_list` (
  `id` int(11) NOT NULL,
  `bouquet_id` int(11) NOT NULL,
  `bouquet_name` varchar(255) NOT NULL,
  `create_time` int(60) NOT NULL,
  `sira` int(60) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `guides`
--

CREATE TABLE `guides` (
  `id` int(11) NOT NULL,
  `guide_name` varchar(255) NOT NULL,
  `guide_desc` longtext NOT NULL,
  `is_smart` int(1) NOT NULL DEFAULT 0,
  `sira` int(60) NOT NULL,
  `create_time` int(60) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `site_desc` longtext NOT NULL,
  `site_xtream` varchar(255) NOT NULL,
  `site_portal` varchar(255) NOT NULL,
  `site_lang` varchar(255) NOT NULL,
  `site_logo` varchar(255) NOT NULL,
  `site_fav` varchar(255) NOT NULL,
  `iptv_links` longtext NOT NULL,
  `mag_login` int(1) NOT NULL DEFAULT 1,
  `bouquet_edit` int(1) NOT NULL DEFAULT 1,
  `unlimited_login` int(1) NOT NULL DEFAULT 1,
  `password_change` int(1) NOT NULL DEFAULT 1,
  `recaptcha` int(1) NOT NULL DEFAULT 0,
  `dark_mode` int(1) NOT NULL DEFAULT 0,
  `color` varchar(255) NOT NULL,
  `recaptcha_key` varchar(255) NOT NULL,
  `recaptcha_secret` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `site_title`, `site_desc`, `site_xtream`, `site_portal`, `site_lang`, `site_logo`, `site_fav`, `iptv_links`, `mag_login`, `bouquet_edit`, `unlimited_login`, `password_change`, `dark_mode`, `color`, `recaptcha_key`, `recaptcha_secret`) VALUES
(1, 'WebPanel', 'WebPanel', '', '', 'en', '', '', '<p><strong>M3U Playlist</strong><br />\r\n<br />\r\n{api_url}get.php?username={username}&amp;password={password}&amp;type=m3u&amp;output=ts<br />\r\n<br />\r\n<strong>M3u Playlist (Kategorili)</strong><br />\r\n<br />\r\n{api_url}get.php?username={username}&amp;password={password}&amp;type=m3u_plus&amp;output=ts<br />\r\n<br />\r\n<strong>Enigma 2.0 AutoScript</strong><br />\r\n<br />\r\nwget -O {iptv.sh}&nbsp;&quot;{api_url}get.php?username={username}&amp;password={password}&amp;type=enigma22_script&amp;output=ts&quot;&nbsp;&amp;&amp; chmod 777 {iptv.sh}&nbsp;&amp;&amp; {iptv.sh}&nbsp;<br />\r\n<br />\r\n<strong>Octagon</strong></p>\r\n\r\n<p>wget -O {iptv.sh}&nbsp;&quot;{api_url}get.php?username={username}&amp;password={password}&amp;type=enigma22_script&amp;output=ts&quot;&nbsp;&amp;&amp; chmod 777 {iptv.sh}&nbsp;&amp;&amp; {iptv.sh}&nbsp;<br />\r\n&nbsp;</p>\r\n', 1, 1, 1, 1, 1, 'color-theme-cadetblue color-theme-darkorchid', '', '');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `bouqet_list`
--
ALTER TABLE `bouqet_list`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Tablo için AUTO_INCREMENT değeri `bouqet_list`
--
ALTER TABLE `bouqet_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Tablo için AUTO_INCREMENT değeri `guides`
--
ALTER TABLE `guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
