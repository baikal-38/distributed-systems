
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `api_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tt_users`
--

CREATE TABLE IF NOT EXISTS `tt_users` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(256) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `pass` varchar(150) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tt_users`
--

INSERT INTO `tt_users` (`id`, `name`, `login`, `pass`, `created`, `modified`) VALUES
(19, 'user 1', 'login 1', 'hash 1', '2023-03-27 00:00:00', '2023-03-27 05:34:45'),
(20, 'user 2', 'login 2', 'hash 2', '2023-03-27 00:00:00', '2023-03-27 05:34:45'),
(21, 'FIO', 'looogin', 'parolka', '2023-03-27 10:09:22', '2023-03-27 07:09:22'),
(22, 'new_user', NULL, NULL, '2023-03-27 10:09:23', '2023-03-27 07:09:23'),
(23, 'new_user', NULL, NULL, '2023-03-27 10:09:24', '2023-03-27 07:09:24'),
(24, 'new_user', NULL, NULL, '2023-03-27 10:13:09', '2023-03-27 07:13:09'),
(50, 'new_user', NULL, NULL, '2023-03-27 10:58:15', '2023-03-27 07:58:15'),
(51, 'new_user', NULL, NULL, '2023-03-27 10:59:22', '2023-03-27 07:59:22'),
(52, 'new_user', NULL, NULL, '2023-03-27 11:15:08', '2023-03-27 08:15:08'),
(53, 'new_user', NULL, NULL, '2023-03-27 11:15:09', '2023-03-27 08:15:09'),
(54, 'new_user', NULL, NULL, '2023-03-27 11:29:42', '2023-03-27 08:29:42'),
(55, 'new_user', NULL, NULL, '2023-03-27 11:31:38', '2023-03-27 08:31:38'),
(56, 'new_user', NULL, NULL, '2023-03-27 11:31:41', '2023-03-27 08:31:41');

-- --------------------------------------------------------

--
-- Структура таблицы `tt_user_rights`
--

CREATE TABLE IF NOT EXISTS `tt_user_rights` (
  `id` int(11) NOT NULL,
  `message` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tt_user_rights`
--

INSERT INTO `tt_user_rights` (`id`, `message`, `description`, `user_id`, `created`, `modified`) VALUES
(65, '3456', 'c:\\path\\1\\2\\3', 19, '2023-03-27 00:00:00', '2023-03-27 05:42:00'),
(66, '3457', 'c:\\path\\1\\2\\4', 19, '2023-03-27 00:00:00', '2023-03-27 05:42:00');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tt_users`
--
ALTER TABLE `tt_users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tt_user_rights`
--
ALTER TABLE `tt_user_rights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tt_users`
--
ALTER TABLE `tt_users`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT для таблицы `tt_user_rights`
--
ALTER TABLE `tt_user_rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tt_user_rights`
--
ALTER TABLE `tt_user_rights`
  ADD CONSTRAINT `tt_user_rights_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tt_users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
