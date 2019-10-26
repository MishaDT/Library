-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 26 2019 г., 16:15
-- Версия сервера: 5.6.38
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `library`
--

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `img`, `title`, `author`, `description`) VALUES
(1, 'Deadline.jpg', 'Deadline. Роман об управлении проектами', 'Том ДеМарко', 'Все принципы хорошего менеджмента описаны здесь в интересной и ненавязчивой форме бизнес-романа. Автор — Том Демарко — написал уже 13 книг, но Deadline считает своей самой сильной книгой. Он уверен — ее чтение добавит вам целых два года великолепного управленческого опыта, а захватывающий сюжет и наглядные примеры будут полезнее любого учебника.'),
(2, 'Взлом креатива.jpg', 'Взлом креатива', 'Майкл Микалко', 'Книга раскроет секреты нестандартного мышления известных людей и расскажет, как их применять на практике.  В этой книге ведущий эксперт по креативности Майкл Микалко показывает, как мыслят творческие люди — и как вы можете использовать их секреты, чтобы мыслить нестандартно и создавать новые идеи.'),
(3, 'Триггеры.jpg', 'Триггеры', 'Маршалл Голдсмит', 'Триггер — это любой стимул, который влияет на наше поведение. Маршалл Голдсмит, автор бестселлеров и ведущий бизнес-мыслитель, в своей новой книге рассказывает о триггерах, которые мешают нам достигать своих целей.'),
(4, 'Личная власть.jpg', 'Личная власть', 'Николай Мрочковский', 'Как сделать так, чтобы подчиненные хорошо выполняли свою работу, а шеф признавал заслуги? Как управлять конфликтами и выходить победителем из любой ситуации? Ответ прост – развить личную власть.'),
(5, 'Начинай с малого.jpg', 'Начинай с малого', 'Оуэйн Сервис', 'Простой и доступный путь к высоким результатам, основанный на научно обоснованных и проверенных шагах.'),
(6, 'Илон Маск. История успеха.jpg', 'Илон Маск. Правила успеха', 'Илон Маск', 'Биография и правила успеха самого известного предпринимателя и инноватора нашего времени, создателя Tesla и SpaceX, прототипа Железного Человека Илона Маска!'),
(7, 'Психология счастья.jpg', 'Психология счастья', 'Энтони Бэйкер', 'В этой книге мы рассмотрим понятие счастья и пути достижения этого таинственного состояния.'),
(8, 'Развитие памяти.jpg', 'Развитие памяти', 'Элен Харрис', 'Научит Вас: правильно концентрировать внимание; выделять главное при запоминании; создавать полезные ассоциации; эффективно тренировать память и многому другому!'),
(9, 'Практика менеджмента.jpg', 'Практика менеджмента', 'Питер Друкер', 'Эта книга создала то, что в наши дни принято называть дисциплиной менеджмента. И это не было ни случайностью, ни удачей — такую цель поставил перед собой автор при написании книги.');

-- --------------------------------------------------------

--
-- Структура таблицы `i_will_read`
--

CREATE TABLE `i_will_read` (
  `id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `user_uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `i_will_read`
--

INSERT INTO `i_will_read` (`id`, `img`, `title`, `author`, `users_id`, `user_uid`) VALUES
(5, 'Начинай с малого.jpg', 'Начинай с малого', 'Оуэйн Сервис', 5, 20),
(11, 'Взлом креатива.jpg', 'Взлом креатива', 'Майкл Микалко', 2, 20),
(12, 'Развитие памяти.jpg', 'Развитие памяти', 'Элен Харрис', 8, 20),
(14, 'Взлом креатива.jpg', 'Взлом креатива', 'Майкл Микалко', 2, 27);

-- --------------------------------------------------------

--
-- Структура таблицы `read_the_book`
--

CREATE TABLE `read_the_book` (
  `id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `user_uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `read_the_book`
--

INSERT INTO `read_the_book` (`id`, `img`, `title`, `author`, `users_id`, `user_uid`) VALUES
(10, 'Психология счастья.jpg', 'Психология счастья', 'Энтони Бэйкер', 7, 20),
(11, 'Практика менеджмента.jpg', 'Практика менеджмента', 'Питер Друкер', 9, 22),
(12, 'Практика менеджмента.jpg', 'Практика менеджмента', 'Питер Друкер', 9, 20),
(13, 'Триггеры.jpg', 'Триггеры', 'Маршалл Голдсмит', 3, 20),
(14, 'Взлом креатива.jpg', 'Взлом креатива', 'Майкл Микалко', 2, 20),
(16, 'Deadline.jpg', 'Deadline. Роман об управлении проектами', 'Том ДеМарко', 1, 20),
(17, 'Илон Маск. История успеха.jpg', 'Илон Маск. Правила успеха', 'Илон Маск', 6, 20),
(18, 'Личная власть.jpg', 'Личная власть', 'Николай Мрочковский', 4, 20),
(19, 'Начинай с малого.jpg', 'Начинай с малого', 'Оуэйн Сервис', 5, 20),
(20, 'Развитие памяти.jpg', 'Развитие памяти', 'Элен Харрис', 8, 20),
(23, 'Взлом креатива.jpg', 'Взлом креатива', 'Майкл Микалко', 2, 27),
(24, 'Развитие памяти.jpg', 'Развитие памяти', 'Элен Харрис', 8, 27);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `uemail` varchar(100) NOT NULL,
  `upass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`uid`, `uname`, `uemail`, `upass`) VALUES
(20, 'Миша', 'misha@gmail.com', '202cb962ac59075b964b07152d234b70'),
(22, 'Лёха', 'alexa@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
(23, 'Андрей', 'andrey@gmail.com', '202cb962ac59075b964b07152d234b70'),
(24, 'Александр', 'sasha@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
(26, 'Вася', 'vasya@gmail.com', '202cb962ac59075b964b07152d234b70'),
(27, 'Дима', 'dima@gmail.com', '202cb962ac59075b964b07152d234b70');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `i_will_read`
--
ALTER TABLE `i_will_read`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `read_the_book`
--
ALTER TABLE `read_the_book`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `i_will_read`
--
ALTER TABLE `i_will_read`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `read_the_book`
--
ALTER TABLE `read_the_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
