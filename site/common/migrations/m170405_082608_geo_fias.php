<?php

class m170405_082608_geo_fias extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE `FIAS__ACTSTAT` (
  `ACTSTATID` int(10) unsigned NOT NULL COMMENT 'Идентификатор статуса (ключ)',
  `NAME` varchar(100) NOT NULL COMMENT 'Наименование\n0 – Не актуальный\n1 – Актуальный (последняя запись по адресному объекту)\n',
  PRIMARY KEY (`ACTSTATID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по статусу актуальности в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__ADDROBJ` (
  `AOGUID` varchar(36) NOT NULL COMMENT 'Глобальный уникальный идентификатор адресного объекта ',
  `FORMALNAME` varchar(120) NOT NULL COMMENT 'Формализованное наименование',
  `REGIONCODE` varchar(2) NOT NULL COMMENT 'Код региона',
  `AUTOCODE` varchar(1) NOT NULL COMMENT 'Код автономии',
  `AREACODE` varchar(3) NOT NULL COMMENT 'Код района',
  `CITYCODE` varchar(3) NOT NULL COMMENT 'Код города',
  `CTARCODE` varchar(3) NOT NULL COMMENT 'Код внутригородского района',
  `PLACECODE` varchar(3) NOT NULL COMMENT 'Код населенного пункта',
  `STREETCODE` varchar(4) DEFAULT NULL COMMENT 'Код улицы',
  `EXTRCODE` varchar(4) NOT NULL COMMENT 'Код дополнительного адресообразующего элемента',
  `SEXTCODE` varchar(3) NOT NULL COMMENT 'Код подчиненного дополнительного адресообразующего элемента',
  `OFFNAME` varchar(120) DEFAULT NULL COMMENT 'Официальное наименование',
  `POSTALCODE` varchar(6) DEFAULT NULL COMMENT 'Почтовый индекс',
  `IFNSFL` varchar(4) DEFAULT NULL COMMENT 'Код ИФНС ФЛ',
  `TERRIFNSFL` varchar(4) DEFAULT NULL COMMENT 'Код территориального участка ИФНС ФЛ',
  `IFNSUL` varchar(4) DEFAULT NULL COMMENT 'Код ИФНС ЮЛ',
  `TERRIFNSUL` varchar(4) DEFAULT NULL COMMENT 'Код территориального участка ИФНС ЮЛ',
  `OKATO` varchar(11) DEFAULT NULL COMMENT 'OKATO',
  `OKTMO` varchar(11) DEFAULT NULL COMMENT 'OKTMO',
  `UPDATEDATE` date NOT NULL COMMENT 'Дата  внесения записи',
  `SHORTNAME` varchar(10) NOT NULL COMMENT 'Краткое наименование типа объекта',
  `AOLEVEL` int(10) unsigned NOT NULL COMMENT 'Уровень адресного объекта ',
  `PARENTGUID` varchar(36) DEFAULT NULL COMMENT 'Идентификатор объекта родительского объекта',
  `AOID` varchar(36) NOT NULL COMMENT 'Уникальный идентификатор записи. Ключевое поле.',
  `PREVID` varchar(36) DEFAULT NULL COMMENT 'Идентификатор записи связывания с предыдушей исторической записью',
  `NEXTID` varchar(36) DEFAULT NULL COMMENT 'Идентификатор записи  связывания с последующей исторической записью',
  `CODE` varchar(17) DEFAULT NULL COMMENT 'Код адресного объекта одной строкой с признаком актуальности из КЛАДР 4.0. ',
  `PLAINCODE` varchar(15) DEFAULT NULL COMMENT 'Код адресного объекта из КЛАДР 4.0 одной строкой без признака актуальности (последних двух цифр)',
  `ACTSTATUS` int(10) unsigned NOT NULL COMMENT 'Статус исторической записи в жизненном цикле адресного объекта:\n0 – не последняя\n1 - последняя',
  `CENTSTATUS` int(10) unsigned NOT NULL COMMENT 'Статус центра',
  `OPERSTATUS` int(10) unsigned NOT NULL COMMENT 'Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus):\n01 – Инициация;\n10 – Добавление;\n20 – Изменение;\n21 – Групповое изменение;\n30 – Удаление;\n31 - Удаление вследствие удаления вышестоящего объекта;\n40 – Присоединение адресного объекта (слияние);\n41 – Переподчинение вследствие слияния вышестоящего объекта;\n42 - Прекращение существования вследствие присоединения к другому адресному объекту;\n43 - Создание нового адресного объекта в результате слияния адресных объектов;\n50 – Переподчинение;\n51 – Переподчинение вследствие переподчинения вышестоящего объекта;\n60 – Прекращение существования вследствие дробления;\n61 – Создание нового адресного объекта в результате дробления\n',
  `CURRSTATUS` int(10) unsigned NOT NULL COMMENT 'Статус актуальности КЛАДР 4 (последние две цифры в коде)',
  `STARTDATE` date NOT NULL COMMENT 'Начало действия записи',
  `ENDDATE` date NOT NULL COMMENT 'Окончание действия записи',
  `NORMDOC` varchar(36) DEFAULT NULL COMMENT 'Внешний ключ на нормативный документ',
  `LIVESTATUS` int(1) unsigned NOT NULL COMMENT 'Признак действующего адресного объекта',
  `CADNUM` varchar(100) DEFAULT NULL COMMENT 'Кадастровый номер',
  `DIVTYPE` int(1) unsigned NOT NULL COMMENT 'Тип адресации:\n0 - не определено\n1 - муниципальный;\n2 - административно-территориальный',
  PRIMARY KEY (`AOID`),
  KEY `AOLEVEL` (`AOLEVEL`),
  KEY `FORMALNAME` (`FORMALNAME`),
  KEY `LIVESTATUS` (`LIVESTATUS`),
  KEY `PARENTGUID` (`PARENTGUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией классификатора адресообразующих элементов БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__CENTERST` (
  `CENTERSTID` int(10) unsigned NOT NULL COMMENT 'Идентификатор статуса',
  `NAME` varchar(100) NOT NULL COMMENT 'Наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по статусу центра в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__CURENTST` (
  `CURENTSTID` int(10) unsigned NOT NULL COMMENT 'Идентификатор статуса (ключ)',
  `NAME` varchar(100) NOT NULL COMMENT 'Наименование (0 - актуальный, 1-50, 2-98 – исторический (кроме 51), 51 - переподчиненный, 99 - несуществующий)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по статусу актуальности КЛАДР 4.0 в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__ESTSTAT` (
  `ESTSTATID` int(10) unsigned NOT NULL COMMENT 'Признак владения',
  `NAME` varchar(20) NOT NULL COMMENT 'Наименование',
  `SHORTNAME` varchar(20) DEFAULT NULL COMMENT 'Краткое наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по признакам владения в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__HOUSE` (
  `POSTALCODE` varchar(6) DEFAULT NULL COMMENT 'Почтовый индекс',
  `REGIONCODE` varchar(2) DEFAULT NULL COMMENT 'Код региона',
  `IFNSFL` varchar(4) DEFAULT NULL COMMENT 'Код ИФНС ФЛ',
  `TERRIFNSFL` varchar(4) DEFAULT NULL COMMENT 'Код территориального участка ИФНС ФЛ',
  `IFNSUL` varchar(4) DEFAULT NULL COMMENT 'Код ИФНС ЮЛ',
  `TERRIFNSUL` varchar(4) DEFAULT NULL COMMENT 'Код территориального участка ИФНС ЮЛ',
  `OKATO` varchar(11) DEFAULT NULL COMMENT 'OKATO',
  `OKTMO` varchar(11) DEFAULT NULL COMMENT 'OKTMO',
  `UPDATEDATE` date NOT NULL COMMENT 'Дата время внесения записи',
  `HOUSENUM` varchar(20) DEFAULT NULL COMMENT 'Номер дома',
  `ESTSTATUS` int(1) unsigned NOT NULL COMMENT 'Признак владения',
  `BUILDNUM` varchar(10) DEFAULT NULL COMMENT 'Номер корпуса',
  `STRUCNUM` varchar(10) DEFAULT NULL COMMENT 'Номер строения',
  `STRSTATUS` int(10) unsigned DEFAULT NULL COMMENT 'Признак строения',
  `HOUSEID` varchar(36) NOT NULL COMMENT 'Уникальный идентификатор записи дома',
  `HOUSEGUID` varchar(36) NOT NULL COMMENT 'Глобальный уникальный идентификатор дома',
  `AOGUID` varchar(36) NOT NULL COMMENT 'Guid записи родительского объекта (улицы, города, населенного пункта и т.п.)',
  `STARTDATE` date NOT NULL COMMENT 'Начало действия записи',
  `ENDDATE` date NOT NULL COMMENT 'Окончание действия записи',
  `STATSTATUS` int(10) unsigned NOT NULL COMMENT 'Состояние дома',
  `NORMDOC` varchar(36) DEFAULT NULL COMMENT 'Внешний ключ на нормативный документ',
  `COUNTER` int(10) unsigned NOT NULL COMMENT 'Счетчик записей домов для КЛАДР 4',
  `CADNUM` varchar(100) DEFAULT NULL COMMENT 'Кадастровый номер',
  `DIVTYPE` int(1) unsigned NOT NULL COMMENT 'Тип адресации:\n0 - не определено\n1 - муниципальный;\n2 - административно-территориальный'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по номерам домов улиц городов и населенных пунктов в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__HOUSEINT` (
  `POSTALCODE` varchar(6) DEFAULT NULL COMMENT 'Почтовый индекс',
  `IFNSFL` varchar(4) DEFAULT NULL COMMENT 'Код ИФНС ФЛ',
  `TERRIFNSFL` varchar(4) DEFAULT NULL COMMENT 'Код территориального участка ИФНС ФЛ',
  `IFNSUL` varchar(4) DEFAULT NULL COMMENT 'Код ИФНС ЮЛ',
  `TERRIFNSUL` varchar(4) DEFAULT NULL COMMENT 'Код территориального участка ИФНС ЮЛ',
  `OKATO` varchar(11) DEFAULT NULL COMMENT 'OKATO',
  `OKTMO` varchar(11) DEFAULT NULL COMMENT 'OKTMO',
  `UPDATEDATE` date NOT NULL COMMENT 'Дата  внесения записи',
  `INTSTART` int(10) unsigned NOT NULL COMMENT 'Значение начала интервала',
  `INTEND` int(10) unsigned NOT NULL COMMENT 'Значение окончания интервала',
  `HOUSEINTID` varchar(36) NOT NULL COMMENT 'Идентификатор записи интервала домов',
  `INTGUID` varchar(36) NOT NULL COMMENT 'Глобальный уникальный идентификатор интервала домов',
  `AOGUID` varchar(36) NOT NULL COMMENT 'Идентификатор объекта родительского объекта (улицы, города, населенного пункта и т.п.)',
  `STARTDATE` date NOT NULL COMMENT 'Начало действия записи',
  `ENDDATE` date NOT NULL COMMENT 'Окончание действия записи',
  `INTSTATUS` int(10) unsigned NOT NULL COMMENT 'Статус интервала (обычный, четный, нечетный)',
  `NORMDOC` varchar(36) DEFAULT NULL COMMENT 'Внешний ключ на нормативный документ',
  `COUNTER` int(10) unsigned NOT NULL COMMENT 'Счетчик записей домов для КЛАДР 4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по интервалам домов в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__HSTSTAT` (
  `HOUSESTID` int(10) unsigned NOT NULL COMMENT 'Идентификатор статуса',
  `NAME` varchar(60) NOT NULL COMMENT 'Наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по статусу состояния домов  в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__INTVSTAT` (
  `INTVSTATID` int(10) unsigned NOT NULL COMMENT 'Идентификатор статуса (обычный, четный, нечетный)',
  `NAME` varchar(60) NOT NULL COMMENT 'Наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по статусу интервалов домов в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__LANDMARK` (
  `LOCATION` varchar(500) NOT NULL COMMENT 'Месторасположение ориентира',
  `REGIONCODE` varchar(2) NOT NULL COMMENT 'Код региона',
  `POSTALCODE` varchar(6) DEFAULT NULL COMMENT 'Почтовый индекс',
  `IFNSFL` varchar(4) DEFAULT NULL COMMENT 'Код ИФНС ФЛ',
  `TERRIFNSFL` varchar(4) DEFAULT NULL COMMENT 'Код территориального участка ИФНС ФЛ',
  `IFNSUL` varchar(4) DEFAULT NULL COMMENT 'Код ИФНС ЮЛ',
  `TERRIFNSUL` varchar(4) DEFAULT NULL COMMENT 'Код территориального участка ИФНС ЮЛ',
  `OKATO` varchar(11) DEFAULT NULL COMMENT 'OKATO',
  `OKTMO` varchar(11) DEFAULT NULL COMMENT 'OKTMO',
  `UPDATEDATE` date NOT NULL COMMENT 'Дата  внесения записи',
  `LANDID` varchar(36) NOT NULL COMMENT 'Уникальный идентификатор записи ориентира',
  `LANDGUID` varchar(36) NOT NULL COMMENT 'Глобальный уникальный идентификатор ориентира',
  `AOGUID` varchar(36) NOT NULL COMMENT 'Уникальный идентификатор родительского объекта (улицы, города, населенного пункта и т.п.)',
  `STARTDATE` date NOT NULL COMMENT 'Начало действия записи',
  `ENDDATE` date NOT NULL COMMENT 'Окончание действия записи',
  `NORMDOC` varchar(36) DEFAULT NULL COMMENT 'Внешний ключ на нормативный документ',
  `CADNUM` varchar(100) DEFAULT NULL COMMENT 'Кадастровый номер'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по описанию мест расположения  имущественных объектов в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__NDOCTYPE` (
  `NDTYPEID` int(10) unsigned NOT NULL COMMENT 'Идентификатор записи (ключ)',
  `NAME` varchar(250) NOT NULL COMMENT 'Наименование типа нормативного документа'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по типу нормативного документа в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__NORMDOC` (
  `NORMDOCID` varchar(36) NOT NULL COMMENT 'Идентификатор нормативного документа',
  `DOCNAME` varchar(100) DEFAULT NULL COMMENT 'Наименование документа',
  `DOCDATE` date DEFAULT NULL COMMENT 'Дата документа',
  `DOCNUM` varchar(20) DEFAULT NULL COMMENT 'Номер документа',
  `DOCTYPE` int(10) unsigned NOT NULL COMMENT 'Тип документа',
  `DOCIMGID` int(10) unsigned DEFAULT NULL COMMENT 'Идентификатор образа (внешний ключ)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по сведениям по нормативным документам, являющимся основанием присвоения адресному элементу наименования в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__OPERSTAT` (
  `OPERSTATID` int(10) unsigned NOT NULL COMMENT 'Идентификатор статуса (ключ)',
  `NAME` varchar(100) NOT NULL COMMENT 'Наименование\n01 – Инициация;\n10 – Добавление;\n20 – Изменение;\n21 – Групповое изменение;\n30 – Удаление;\n31 - Удаление вследствие удаления вышестоящего объекта;\n40 – Присоединение адресного объекта (слияние);\n41 – Переподчинение вследствие слияния вышестоящего объекта;\n42 - Прекращение существования вследствие присоединения к другому адресному объекту;\n43 - Создание нового адресного объекта в результате слияния адресных объектов;\n50 – Переподчинение;\n51 – Переподчинение вследствие переподчинения вышестоящего объекта;\n60 – Прекращение существования вследствие дробления;\n61 – Создание нового адресного объекта в результате дробления;\n70 – Восстановление объекта прекратившего существование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по статусу действия в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__ROOM` (
  `ROOMGUID` varchar(36) NOT NULL COMMENT 'Глобальный уникальный идентификатор адресного объекта (помещения)',
  `FLATNUMBER` varchar(50) NOT NULL COMMENT 'Номер помещения или офиса',
  `FLATTYPE` int(1) unsigned NOT NULL COMMENT 'Тип помещения',
  `ROOMNUMBER` varchar(50) DEFAULT NULL COMMENT 'Номер комнаты',
  `ROOMTYPE` int(1) unsigned DEFAULT NULL COMMENT 'Тип комнаты',
  `REGIONCODE` varchar(2) NOT NULL COMMENT 'Код региона',
  `POSTALCODE` varchar(6) DEFAULT NULL COMMENT 'Почтовый индекс',
  `UPDATEDATE` date NOT NULL COMMENT 'Дата  внесения записи',
  `HOUSEGUID` varchar(36) NOT NULL COMMENT 'Идентификатор родительского объекта (дома)',
  `ROOMID` varchar(36) NOT NULL COMMENT 'Уникальный идентификатор записи. Ключевое поле.',
  `PREVID` varchar(36) DEFAULT NULL COMMENT 'Идентификатор записи связывания с предыдушей исторической записью',
  `NEXTID` varchar(36) DEFAULT NULL COMMENT 'Идентификатор записи  связывания с последующей исторической записью',
  `STARTDATE` date NOT NULL COMMENT 'Начало действия записи',
  `ENDDATE` date NOT NULL COMMENT 'Окончание действия записи',
  `LIVESTATUS` int(1) unsigned NOT NULL COMMENT 'Признак действующего адресного объекта',
  `NORMDOC` varchar(36) DEFAULT NULL COMMENT 'Внешний ключ на нормативный документ',
  `OPERSTATUS` int(10) unsigned NOT NULL COMMENT 'Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus):\n01 – Инициация;\n10 – Добавление;\n20 – Изменение;\n21 – Групповое изменение;\n30 – Удаление;\n31 - Удаление вследствие удаления вышестоящего объекта;\n40 – Присоединение адресного объекта (слияние);\n41 – Переподчинение вследствие слияния вышестоящего объекта;\n42 - Прекращение существования вследствие присоединения к другому адресному объекту;\n43 - Создание нового адресного объекта в результате слияния адресных объектов;\n50 – Переподчинение;\n51 – Переподчинение вследствие переподчинения вышестоящего объекта;\n60 – Прекращение существования вследствие дробления;\n61 – Создание нового адресного объекта в результате дробления\n',
  `CADNUM` varchar(100) DEFAULT NULL COMMENT 'Кадастровый номер помещения',
  `ROOMCADNUM` varchar(100) DEFAULT NULL COMMENT 'Кадастровый номер комнаты в помещении'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла со сведениями о помещениях';");

		$this->execute("CREATE TABLE `FIAS__SOCRBASE` (
  `LEVEL` int(10) unsigned NOT NULL COMMENT 'Уровень адресного объекта',
  `SCNAME` varchar(10) DEFAULT NULL COMMENT 'Краткое наименование типа объекта',
  `SOCRNAME` varchar(50) NOT NULL COMMENT 'Полное наименование типа объекта',
  `KOD_T_ST` varchar(4) NOT NULL COMMENT 'Ключевое поле'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по типам адресных объектов в БД ФИАС';");

		$this->execute("CREATE TABLE `FIAS__STEAD` (
  `STEADGUID` varchar(36) NOT NULL COMMENT 'Глобальный уникальный идентификатор адресного объекта (земельного участка)',
  `NUMBER` varchar(120) DEFAULT NULL COMMENT 'Номер земельного участка',
  `REGIONCODE` varchar(2) NOT NULL COMMENT 'Код региона',
  `POSTALCODE` varchar(6) DEFAULT NULL COMMENT 'Почтовый индекс',
  `IFNSFL` varchar(4) DEFAULT NULL COMMENT 'Код ИФНС ФЛ',
  `TERRIFNSFL` varchar(4) DEFAULT NULL COMMENT 'Код территориального участка ИФНС ФЛ',
  `IFNSUL` varchar(4) DEFAULT NULL COMMENT 'Код ИФНС ЮЛ',
  `TERRIFNSUL` varchar(4) DEFAULT NULL COMMENT 'Код территориального участка ИФНС ЮЛ',
  `OKATO` varchar(11) DEFAULT NULL COMMENT 'OKATO',
  `OKTMO` varchar(11) DEFAULT NULL COMMENT 'OKTMO',
  `UPDATEDATE` date NOT NULL COMMENT 'Дата  внесения записи',
  `PARENTGUID` varchar(36) DEFAULT NULL COMMENT 'Идентификатор объекта родительского объекта',
  `STEADID` varchar(36) NOT NULL COMMENT 'Уникальный идентификатор записи. Ключевое поле.',
  `PREVID` varchar(36) DEFAULT NULL COMMENT 'Идентификатор записи связывания с предыдушей исторической записью',
  `NEXTID` varchar(36) DEFAULT NULL COMMENT 'Идентификатор записи  связывания с последующей исторической записью',
  `OPERSTATUS` int(10) unsigned NOT NULL COMMENT 'Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus):\n01 – Инициация;\n10 – Добавление;\n20 – Изменение;\n21 – Групповое изменение;\n30 – Удаление;\n31 - Удаление вследствие удаления вышестоящего объекта;\n40 – Присоединение адресного объекта (слияние);\n41 – Переподчинение вследствие слияния вышестоящего объекта;\n42 - Прекращение существования вследствие присоединения к другому адресному объекту;\n43 - Создание нового адресного объекта в результате слияния адресных объектов;\n50 – Переподчинение;\n51 – Переподчинение вследствие переподчинения вышестоящего объекта;\n60 – Прекращение существования вследствие дробления;\n61 – Создание нового адресного объекта в результате дробления\n',
  `STARTDATE` date NOT NULL COMMENT 'Начало действия записи',
  `ENDDATE` date NOT NULL COMMENT 'Окончание действия записи',
  `NORMDOC` varchar(36) DEFAULT NULL COMMENT 'Внешний ключ на нормативный документ',
  `LIVESTATUS` int(1) unsigned NOT NULL COMMENT 'Признак действующего адресного объекта',
  `CADNUM` varchar(100) DEFAULT NULL COMMENT 'Кадастровый номер',
  `DIVTYPE` int(1) unsigned NOT NULL COMMENT 'Тип адресации:\n0 - не определено\n1 - муниципальный;\n2 - административно-территориальный'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла со сведениями о земельных участках';");

		$this->execute("CREATE TABLE `FIAS__STRSTAT` (
  `STRSTATID` int(10) unsigned NOT NULL COMMENT 'Признак строения',
  `NAME` varchar(20) NOT NULL COMMENT 'Наименование',
  `SHORTNAME` varchar(20) DEFAULT NULL COMMENT 'Краткое наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Состав и структура файла с информацией по признакам строения в БД ФИАС';");
	}

	public function down()
	{
		echo "m170405_082608_geo_fias does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}