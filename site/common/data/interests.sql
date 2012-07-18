﻿
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

SET NAMES 'utf8';

USE happy_giraffe;

TRUNCATE interest__users_interests;
TRUNCATE interest__categories;
TRUNCATE interest__interests;

INSERT INTO interest__categories VALUES
(11, 'Домашние питомцы', 'pets'),
(12, 'Кино', 'cinema'),
(13, 'Музыка', 'music'),
(14, 'Спорт', 'sport'),
(15, 'Рукоделие', 'handmade'),
(16, 'Охота', 'hunting'),
(17, 'Рыбалка', 'fishing'),
(18, 'Путешествие', 'journey'),
(19, 'Танцы', 'dancing');

INSERT INTO interest__interests VALUES
(30, 'Кошки', 11),
(31, 'Собаки', 11),
(32, 'Грызуны', 11),
(33, 'Пернатые', 11),
(34, 'Террариум', 11),
(35, 'Рыбки', 11),
(36, 'Трагедия', 12),
(37, 'Комедия ', 12),
(38, 'Ужасы', 12),
(39, 'Детектив', 12),
(40, 'Приключения', 12),
(41, 'Историческое кино', 12),
(42, 'Сказка', 12),
(43, 'Военное кино', 12),
(44, 'Триллер', 12),
(45, 'Боевик', 12),
(46, 'Сериалы', 12),
(47, 'Авторское кино', 12),
(48, 'Фантастика', 12),
(49, 'Фильм-катастрофа', 12),
(50, 'Мюзиклы', 12),
(51, 'Вестерн', 12),
(52, 'Мелодрама', 12),
(53, 'Документальное кино', 12),
(54, 'Драма', 12),
(55, 'Аниме', 12),
(56, 'Романс', 13),
(57, 'Рэп', 13),
(58, 'Техно', 13),
(59, 'Хип-хоп', 13),
(60, 'Латино', 13),
(61, 'Рок', 13),
(62, 'R&B', 13),
(63, 'Караоке', 13),
(64, 'Классика', 13),
(65, 'Ска', 13),
(66, 'Авторская песня', 13),
(67, 'Джаз', 13),
(68, 'Блюз', 13),
(69, 'Кантри', 13),
(70, 'Электронная музыка', 13),
(71, 'Регги', 13),
(72, 'Народная музыка', 13),
(73, 'Шансон', 13),
(74, 'Lounge', 13),
(75, 'Drum & Bass', 13),
(76, 'Disco', 13),
(77, 'House', 13),
(78, 'Поп-музыка', 13),
(79, 'Инструментальная музыка', 13),
(80, 'Плавание', 14),
(81, 'Велоспорт', 14),
(82, 'Футбол', 14),
(83, 'Бокс', 14),
(84, 'Фигурное катание', 14),
(85, 'Баскетбол', 14),
(86, 'Волейбол', 14),
(87, 'Настольный теннис', 14),
(88, 'Конный спорт', 14),
(89, 'Боулинг', 14),
(90, 'Гребля', 14),
(91, 'Тяжелая атлетика', 14),
(92, 'Лыжный спорт', 14),
(93, 'Стрельба', 14),
(94, 'Легкая атлетика', 14),
(95, 'Гимнастика', 14),
(96, 'Теннис', 14),
(97, 'Биатлон', 14),
(98, 'Хоккей', 14),
(99, 'Сноуборд', 14),
(100, 'Бег', 14),
(101, 'Борьба', 14),
(102, 'Вязание', 15),
(103, 'Кройка и шитье', 15),
(104, 'Вышивка', 15),
(105, 'Декупаж', 15),
(106, 'Изделия из бумаги', 15),
(107, 'Бижутерия', 15),
(108, 'Валяние', 15),
(109, 'Квиллинг', 15),
(110, 'Мыловарение', 15),
(111, 'Ткачество', 15),
(112, 'Роспись', 15),
(113, 'Батик', 15),
(114, 'Солёное тесто ', 15),
(115, 'Работа с кожей', 15),
(116, 'Резьба', 15),
(117, 'Пирография', 15),
(118, 'Фриволите', 15),
(119, 'Лепка', 15),
(120, 'Хенд-мейд ', 15),
(121, 'Темари', 15),
(122, 'Искусственные цветы', 15),
(123, 'Пэчворк', 15),
(124, 'Плетение', 15),
(125, 'Выжигание по ткани', 15),
(126, 'Картины из соломы', 15),
(127, 'Бродовая охота', 16),
(128, 'Любительская охота', 16),
(129, 'Охота с ловчими птицами', 16),
(130, 'Псовая охота', 16),
(131, 'Ружейная охота', 16),
(132, 'Фотоохота', 16),
(133, 'Подводная охота', 16),
(134, 'Охота на пернатых', 16),
(135, 'Охота на пушных зверей', 16),
(136, 'Охота на диких копытных', 16),
(137, 'Охота из засады', 16),
(138, 'Групповая охота', 16),
(139, 'Ловля капканами', 16),
(140, 'Летняя рыбалка', 17),
(141, 'Зимняя рыбалка', 17),
(142, 'Речная рыбалка', 17),
(143, 'Озерная рыбалка', 17),
(144, 'Морская рыбалка', 17),
(145, 'Рыбалка с помощью остроги', 17),
(146, 'Поплавочная удочка', 17),
(147, 'Донная удочка', 17),
(148, 'Спиннинг', 17),
(149, 'Нахлыст', 17),
(150, 'Рыбалка с лодки', 17),
(151, 'Рыбалка с берега', 17),
(152, 'На автомобиле', 18),
(153, 'На мотоцикле', 18),
(154, 'На велосипеде', 18),
(155, 'Водный туризм', 18),
(156, 'Горный туризм', 18),
(157, 'Сафари', 18),
(158, 'Религиозные путешествия', 18),
(159, 'Экотуризм', 18),
(160, 'Пешеходный туризм', 18),
(161, 'Гастрономический туризм', 18),
(162, 'Сельский туризм', 18),
(163, 'Военно-археологический туризм', 18),
(164, 'Спелеотуризм', 18),
(165, 'Фототуризм', 18),
(166, 'Бальные танцы', 19),
(167, 'Клубные танцы', 19),
(168, 'Hip-hop', 19),
(169, 'Break dance', 19),
(170, 'Hustle', 19),
(171, 'Народный танец', 19),
(172, 'Танец живота', 19),
(173, 'Ирландские танцы', 19),
(174, 'Исторические', 19),
(175, 'Rock&Roll', 19),
(176, 'Контемп', 19),
(177, 'Акробатический танец', 19),
(178, 'Самба', 19),
(179, 'Румба', 19),
(180, 'Танго', 19),
(181, 'Фламенко', 19),
(182, 'Сальса', 19),
(183, 'Step', 19);

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;