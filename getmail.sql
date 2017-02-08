-- phpMyAdmin SQL Dump
-- version 4.0.10.11
-- http://www.phpmyadmin.net
--
-- Хост: phpmyadmin
-- Время создания: Фев 08 2017 г., 15:02
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `getmail`
--

-- --------------------------------------------------------

--
-- Структура таблицы `checkmail`
--

CREATE TABLE IF NOT EXISTS `checkmail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` char(255) NOT NULL,
  `date` int(11) NOT NULL,
  `checkmail` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `checkmail`
--

INSERT INTO `checkmail` (`id`, `cod`, `date`, `checkmail`) VALUES
(10, 'ul3444542342353425', 345345, 1),
(11, 'ul3444542342353425', 345345, 1),
(12, 'ul3444542342353425', 345345, 1),
(13, 'ul3444542342353425', 345345, 1),
(14, 'ul3444542342353425', 1486551719, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
