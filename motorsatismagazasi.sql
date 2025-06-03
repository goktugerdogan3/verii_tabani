-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 04 Haz 2025, 01:19:07
-- Sunucu sürümü: 8.0.41
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `motorsatismagazasi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `motor`
--

CREATE TABLE `motor` (
  `Motor_ID` int NOT NULL,
  `Marka` varchar(50) DEFAULT NULL,
  `Model` varchar(50) DEFAULT NULL,
  `Fiyat` decimal(10,2) DEFAULT NULL,
  `Stok_Miktarı` int DEFAULT NULL,
  `Yıl` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `motor`
--

INSERT INTO `motor` (`Motor_ID`, `Marka`, `Model`, `Fiyat`, `Stok_Miktarı`, `Yıl`) VALUES
(1, 'Honda', 'CBR600RR', 12999.99, 10, 2022),
(2, 'Yamaha', 'YZF-R1', 19999.99, 5, 2023),
(3, 'Kawasaki', 'Ninja ZX-6R', 15999.99, 8, 2022),
(4, 'Suzuki', 'GSX-R1000', 17999.99, 15, 2023),
(5, 'Ducati', 'Panigale V4', 24999.99, 2, 2023),
(6, 'KTM', '390 Duke', 9999.99, 12, 2023),
(7, 'BMW', 'S1000 RR', 22999.99, 0, 2023),
(8, 'Harley-Davidson', 'Sportster S', 13999.99, 6, 2022),
(9, 'Triumph', 'Street Triple 765', 12999.99, 10, 2023),
(10, 'Indian', 'Scout Bobber', 11999.99, 8, 2022),
(11, 'Honda', 'CB500F', 6999.99, 20, 2021),
(12, 'Yamaha', 'MT-09', 11999.99, 5, 2023),
(13, 'Kawasaki', 'Z900', 10999.99, 4, 2023),
(14, 'Ducati', 'Scrambler Icon', 10999.99, 10, 2022),
(15, 'Suzuki', 'SV650', 7799.99, 15, 2021),
(16, 'Honda', 'CBR600RR', 12999.99, 10, 2022),
(17, 'Yamaha', 'YZF-R1', 19999.99, 5, 2023),
(18, 'Kawasaki', 'Ninja ZX-6R', 15999.99, 8, 2022),
(19, 'Suzuki', 'GSX-R1000', 17999.99, 15, 2023),
(20, 'Ducati', 'Panigale V4', 24999.99, 2, 2023),
(21, 'KTM', '390 Duke', 9999.99, 12, 2023),
(22, 'BMW', 'S1000 RR', 22999.99, 4, 2023),
(23, 'Harley-Davidson', 'Sportster S', 13999.99, 6, 2022),
(24, 'Triumph', 'Street Triple 765', 12999.99, 10, 2023),
(25, 'Indian', 'Scout Bobber', 11999.99, 8, 2022),
(26, 'Honda', 'CB500F', 6999.99, 20, 2021),
(27, 'Yamaha', 'MT-09', 11999.99, 5, 2023),
(28, 'Kawasaki', 'Z900', 10999.99, 4, 2023),
(29, 'Ducati', 'Scrambler Icon', 10999.99, 10, 2022),
(30, 'Suzuki', 'SV650', 7799.99, 15, 2021),
(31, 'Honda', 'CBR600RR', 12999.99, 10, 2022),
(32, 'Yamaha', 'YZF-R1', 19999.99, 5, 2023),
(33, 'Kawasaki', 'Ninja ZX-6R', 15999.99, 8, 2022),
(34, 'Suzuki', 'GSX-R1000', 17999.99, 15, 2023),
(35, 'Ducati', 'Panigale V4', 24999.99, 2, 2023),
(36, 'KTM', '390 Duke', 9999.99, 12, 2023),
(37, 'BMW', 'S1000 RR', 22999.99, 3, 2023),
(38, 'Harley-Davidson', 'Sportster S', 13999.99, 6, 2022),
(39, 'Triumph', 'Street Triple 765', 12999.99, 10, 2023),
(40, 'Indian', 'Scout Bobber', 11999.99, 8, 2022),
(41, 'Honda', 'CB500F', 6999.99, 20, 2021),
(42, 'Yamaha', 'MT-09', 11999.99, 5, 2023),
(43, 'Kawasaki', 'Z900', 10999.99, 2, 2023),
(44, 'Ducati', 'Scrambler Icon', 10999.99, 10, 2022),
(45, 'Suzuki', 'SV650', 7799.99, 15, 2021),
(46, 'Honda', 'CBR600RR', 12999.99, 10, 2022),
(47, 'Yamaha', 'YZF-R1', 19999.99, 5, 2023),
(48, 'Kawasaki', 'Ninja ZX-6R', 15999.99, 8, 2022),
(49, 'Suzuki', 'GSX-R1000', 17999.99, 15, 2023),
(50, 'Ducati', 'Panigale V4', 24999.99, 2, 2023),
(51, 'KTM', '390 Duke', 9999.99, 12, 2023),
(52, 'BMW', 'S1000 RR', 22999.99, 4, 2023),
(53, 'Harley-Davidson', 'Sportster S', 13999.99, 6, 2022),
(54, 'Triumph', 'Street Triple 765', 12999.99, 10, 2023),
(55, 'Indian', 'Scout Bobber', 11999.99, 8, 2022),
(56, 'Honda', 'CB500F', 6999.99, 20, 2021),
(57, 'Yamaha', 'MT-09', 11999.99, 5, 2023),
(58, 'Kawasaki', 'Z900', 10999.99, 4, 2023),
(59, 'Ducati', 'Scrambler Icon', 10999.99, 10, 2022),
(60, 'Suzuki', 'SV650', 7799.99, 15, 2021),
(61, 'Honda', 'CBR600RR', 12999.99, 10, 2022),
(62, 'Yamaha', 'YZF-R1', 19999.99, 5, 2023),
(63, 'Kawasaki', 'Ninja ZX-6R', 15999.99, 8, 2022),
(64, 'Suzuki', 'GSX-R1000', 17999.99, 15, 2023),
(65, 'Ducati', 'Panigale V4', 24999.99, 2, 2023),
(66, 'KTM', '390 Duke', 9999.99, 12, 2023),
(67, 'BMW', 'S1000 RR', 22999.99, 4, 2023),
(68, 'Harley-Davidson', 'Sportster S', 13999.99, 6, 2022),
(69, 'Triumph', 'Street Triple 765', 12999.99, 10, 2023),
(70, 'Indian', 'Scout Bobber', 11999.99, 8, 2022),
(71, 'Honda', 'CB500F', 6999.99, 20, 2021),
(72, 'Yamaha', 'MT-09', 11999.99, 5, 2023),
(73, 'Kawasaki', 'Z900', 10999.99, 4, 2023),
(74, 'Ducati', 'Scrambler Icon', 10999.99, 10, 2022),
(75, 'Suzuki', 'SV650', 7799.99, 15, 2021),
(76, 'Erdocar', 'Göktur8', 3800.00, 35, 2003),
(77, 'Bersinho', 'Kekonsi', 54600.00, 4, 2002),
(78, 'Tunator', 'Canazaki', 60000.00, 21, 2018),
(79, 'nruco', 'havaki', 60000.00, 12, 1938),
(80, 'veri', 'taban', 3000.00, 30, 2025),
(81, 'Honda', 'CBR600RR', 12999.99, 10, 2022),
(82, 'Yamaha', 'YZF-R1', 19999.99, 5, 2023),
(83, 'Kawasaki', 'Ninja ZX-6R', 15999.99, 8, 2022),
(84, 'Suzuki', 'GSX-R1000', 17999.99, 15, 2023),
(85, 'Ducati', 'Panigale V4', 24999.99, 2, 2023),
(86, 'KTM', '390 Duke', 9999.99, 12, 2023),
(87, 'BMW', 'S1000 RR', 22999.99, 4, 2023),
(88, 'Harley-Davidson', 'Sportster S', 13999.99, 6, 2022),
(89, 'Triumph', 'Street Triple 765', 12999.99, 10, 2023),
(90, 'Indian', 'Scout Bobber', 11999.99, 8, 2022),
(91, 'Honda', 'CB500F', 6999.99, 20, 2021),
(92, 'Yamaha', 'MT-09', 11999.99, 5, 2023),
(93, 'Kawasaki', 'Z900', 10999.99, 4, 2023),
(94, 'Ducati', 'Scrambler Icon', 10999.99, 10, 2022),
(95, 'Suzuki', 'SV650', 7799.99, 15, 2021),
(96, 'SAA', 'ASDA', 222.00, 122, 2222);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musteri`
--

CREATE TABLE `musteri` (
  `Musteri_ID` int NOT NULL,
  `Ad` varchar(50) DEFAULT NULL,
  `Soyad` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Telefon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `musteri`
--

INSERT INTO `musteri` (`Musteri_ID`, `Ad`, `Soyad`, `Email`, `Telefon`) VALUES
(1, 'Ahmet', 'Yılmaz', 'ahmet.yilmaz@email.com', '555-1234-5678'),
(2, 'Emine', 'Kara', 'emine.kara@email.com', '555-9876-5432'),
(3, 'Ali', 'Can', 'ali.can@email.com', '555-5555-5555'),
(4, 'Fatma', 'Demir', 'fatma.demir@email.com', '555-1111-1111'),
(5, 'Mehmet', 'Çelik', 'mehmet.celik@email.com', '555-2222-2222'),
(6, 'Zeynep', 'Aydın', 'zeynep.aydin@email.com', '555-3333-3333'),
(7, 'Canan', 'Yılmaz', 'canan.yilmaz@email.com', '555-4444-4444'),
(8, 'Murat', 'Keskin', 'murat.keskin@email.com', '555-5555-1234'),
(9, 'Selin', 'Öztürk', 'selin.ozturk@email.com', '555-6789-6789'),
(10, 'Emre', 'Akman', 'emre.akman@email.com', '555-7777-7777'),
(51, 'Şükrü Göktuğ', 'Erdoğan', 'sukruerdo38@gmail.com', '05050044064'),
(52, 'Atacan', 'Tuna', 'atacantuna2@gmail.com', '5054662771'),
(53, 'Bediye Nur', 'Söğüt', 'bediye_eylul_bediye@hotmail.com', '05321717481'),
(54, 'selami', 'selaminyo', 'selami@gmail.com', '5050044444'),
(55, 'bayram', 'hoca', 'bayram@gmail.com', '5555555555'),
(56, 'Ahmet', 'Yılmaz', 'ahmet.yilmaz@email.com', '555-1234-5678'),
(57, 'Emine', 'Kara', 'emine.kara@email.com', '555-9876-5432'),
(58, 'Ali', 'Can', 'ali.can@email.com', '555-5555-5555'),
(59, 'Fatma', 'Demir', 'fatma.demir@email.com', '555-1111-1111'),
(60, 'Mehmet', 'Çelik', 'mehmet.celik@email.com', '555-2222-2222'),
(61, 'Zeynep', 'Aydın', 'zeynep.aydin@email.com', '555-3333-3333'),
(62, 'Canan', 'Yılmaz', 'canan.yilmaz@email.com', '555-4444-4444'),
(63, 'Murat', 'Keskin', 'murat.keskin@email.com', '555-5555-1234'),
(64, 'Selin', 'Öztürk', 'selin.ozturk@email.com', '555-6789-6789'),
(65, 'Emre', 'Akman', 'emre.akman@email.com', '555-7777-7777'),
(66, 'ADIN ', 'NE ', 'ADINNE@xn--gmail-bgd.com', '111111111111');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis`
--

CREATE TABLE `siparis` (
  `Siparis_ID` int NOT NULL,
  `Musteri_ID` int DEFAULT NULL,
  `Tarih` date DEFAULT NULL,
  `Toplam_Tutar` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `siparis`
--

INSERT INTO `siparis` (`Siparis_ID`, `Musteri_ID`, `Tarih`, `Toplam_Tutar`) VALUES
(1, 1, '2023-01-15', 12999.99),
(2, 2, '2023-02-20', 15999.99),
(3, 3, '2023-03-05', 12999.99),
(4, 4, '2023-04-25', 17999.99),
(5, 5, '2023-05-30', 24999.99),
(6, 6, '2023-06-10', 9999.99),
(7, 7, '2023-06-15', 11999.99),
(8, 8, '2023-07-20', 10999.99),
(9, 9, '2023-08-05', 12999.99),
(11, 6, '2023-06-10', 9999.99),
(12, 7, '2023-06-15', 11999.99),
(13, 8, '2023-07-20', 10999.99),
(14, 9, '2023-08-05', 12999.99),
(15, 10, '2023-09-28', 8999.99),
(16, 1, '2023-01-15', 12999.99),
(17, 2, '2023-02-20', 15999.99),
(18, 3, '2023-03-05', 12999.99),
(19, 4, '2023-04-25', 17999.99),
(20, 5, '2023-05-30', 24999.99),
(21, 6, '2023-06-10', 9999.99),
(22, 7, '2023-06-15', 11999.99),
(23, 8, '2023-07-20', 10999.99),
(24, 9, '2023-08-05', 12999.99),
(25, 10, '2023-09-28', 8999.99),
(26, 1, '2023-01-15', 12999.99),
(27, 2, '2023-02-20', 15999.99),
(28, 3, '2023-03-05', 12999.99),
(29, 4, '2023-04-25', 17999.99),
(30, 5, '2023-05-30', 24999.99),
(31, 6, '2023-06-10', 9999.99),
(32, 7, '2023-06-15', 11999.99),
(33, 8, '2023-07-20', 10999.99),
(34, 9, '2023-08-05', 12999.99),
(35, 10, '2023-09-28', 8999.99),
(36, 1, '2023-01-15', 12999.99),
(37, 2, '2023-02-20', 15999.99),
(38, 3, '2023-03-05', 12999.99),
(39, 4, '2023-04-25', 17999.99),
(40, 5, '2023-05-30', 24999.99),
(41, 6, '2023-06-10', 9999.99),
(42, 7, '2023-06-15', 11999.99),
(43, 8, '2023-07-20', 10999.99),
(44, 9, '2023-08-05', 12999.99),
(45, 10, '2023-09-28', 8999.99),
(46, 1, '2023-01-15', 12999.99),
(47, 2, '2023-02-20', 15999.99),
(48, 3, '2023-03-05', 12999.99),
(49, 4, '2023-04-25', 17999.99),
(50, 5, '2023-05-30', 24999.99),
(51, 6, '2023-06-10', 9999.99),
(52, 7, '2023-06-15', 11999.99),
(53, 8, '2023-07-20', 10999.99),
(54, 9, '2023-08-05', 12999.99),
(55, 10, '2023-09-28', 8999.99),
(66, 1, '2023-01-15', 12999.99),
(67, 2, '2023-02-20', 15999.99),
(68, 3, '2023-03-05', 12999.99),
(69, 4, '2023-04-25', 17999.99),
(70, 5, '2023-05-30', 24999.99),
(71, 6, '2023-06-10', 9999.99),
(72, 7, '2023-06-15', 11999.99),
(73, 8, '2023-07-20', 10999.99),
(74, 9, '2023-08-05', 12999.99),
(75, 10, '2023-09-28', 8999.99),
(76, 66, '2025-06-04', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis_detaylari`
--

CREATE TABLE `siparis_detaylari` (
  `Siparis_Detay_ID` int NOT NULL,
  `Siparis_ID` int DEFAULT NULL,
  `Motor_ID` int DEFAULT NULL,
  `Miktar` int DEFAULT NULL,
  `Tutar` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `siparis_detaylari`
--

INSERT INTO `siparis_detaylari` (`Siparis_Detay_ID`, `Siparis_ID`, `Motor_ID`, `Miktar`, `Tutar`) VALUES
(1, 1, 1, 1, 12999.99),
(2, 2, 3, 1, 15999.99),
(3, 3, 2, 1, 19999.99),
(4, 4, 4, 2, 34999.98),
(5, 5, 5, 1, 24999.99),
(6, 6, 6, 1, 9999.99),
(7, 7, 7, 11, 6999.99),
(8, 8, 8, 13, 10999.99),
(9, 9, 9, 12, 11999.99),
(11, 1, 1, 1, 12999.99),
(12, 2, 3, 1, 15999.99),
(13, 3, 2, 1, 19999.99),
(14, 4, 4, 2, 34999.98),
(15, 5, 5, 1, 24999.99),
(16, 6, 6, 1, 9999.99),
(17, 7, 7, 11, 6999.99),
(18, 8, 8, 13, 10999.99),
(19, 9, 9, 12, 11999.99),
(21, 1, 1, 1, 12999.99),
(22, 2, 3, 1, 15999.99),
(23, 3, 2, 1, 19999.99),
(24, 4, 4, 2, 34999.98),
(25, 5, 5, 1, 24999.99),
(26, 6, 6, 1, 9999.99),
(27, 7, 7, 11, 6999.99),
(28, 8, 8, 13, 10999.99),
(29, 9, 9, 12, 11999.99),
(31, 1, 1, 1, 12999.99),
(32, 2, 3, 1, 15999.99),
(61, 1, 1, 1, 12999.99),
(62, 2, 3, 1, 15999.99),
(63, 3, 2, 1, 19999.99),
(64, 4, 4, 2, 34999.98),
(65, 5, 5, 1, 24999.99),
(66, 6, 6, 1, 9999.99),
(67, 7, 7, 11, 6999.99),
(68, 8, 8, 13, 10999.99),
(69, 9, 9, 12, 11999.99),
(71, 76, 7, 2, 45999.98);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `motor`
--
ALTER TABLE `motor`
  ADD PRIMARY KEY (`Motor_ID`);

--
-- Tablo için indeksler `musteri`
--
ALTER TABLE `musteri`
  ADD PRIMARY KEY (`Musteri_ID`);

--
-- Tablo için indeksler `siparis`
--
ALTER TABLE `siparis`
  ADD PRIMARY KEY (`Siparis_ID`),
  ADD KEY `Musteri_ID` (`Musteri_ID`);

--
-- Tablo için indeksler `siparis_detaylari`
--
ALTER TABLE `siparis_detaylari`
  ADD PRIMARY KEY (`Siparis_Detay_ID`),
  ADD KEY `Siparis_ID` (`Siparis_ID`),
  ADD KEY `Motor_ID` (`Motor_ID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `motor`
--
ALTER TABLE `motor`
  MODIFY `Motor_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- Tablo için AUTO_INCREMENT değeri `musteri`
--
ALTER TABLE `musteri`
  MODIFY `Musteri_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Tablo için AUTO_INCREMENT değeri `siparis`
--
ALTER TABLE `siparis`
  MODIFY `Siparis_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Tablo için AUTO_INCREMENT değeri `siparis_detaylari`
--
ALTER TABLE `siparis_detaylari`
  MODIFY `Siparis_Detay_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `siparis`
--
ALTER TABLE `siparis`
  ADD CONSTRAINT `siparis_ibfk_1` FOREIGN KEY (`Musteri_ID`) REFERENCES `musteri` (`Musteri_ID`);

--
-- Tablo kısıtlamaları `siparis_detaylari`
--
ALTER TABLE `siparis_detaylari`
  ADD CONSTRAINT `siparis_detaylari_ibfk_1` FOREIGN KEY (`Siparis_ID`) REFERENCES `siparis` (`Siparis_ID`),
  ADD CONSTRAINT `siparis_detaylari_ibfk_2` FOREIGN KEY (`Motor_ID`) REFERENCES `motor` (`Motor_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
