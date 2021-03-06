<?php

use yii\db\Migration;

/**
 * Class m200905_023510_schema
 */
class m200905_023510_schema extends Migration
{
    public function up()
    {
        // creates `categories` table
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(11)->comment('Parent category id'),
            'title' => $this->char(255)->notNull()->comment('Category heading'),
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp(),
        ]);

        // creates index for `categories` table
        $this->createIndex(
            'idx-category-parent_id',
            '{{%categories}}',
            'parent_id'
        );

        // add foreign key for `categories` table
        $this->addForeignKey(
            'fk-category-parent_id',
            '{{%categories}}',
            'parent_id',
            '{{%categories}}',
            'id',
            'SET NULL'
        );

        // creates `articles` table
        $this->createTable('{{%articles}}', [
            'id' => $this->primaryKey(),
            'title' => $this->char(255)->notNull()->comment('Article heading'),
            'content' => $this->text()->notNull()->comment('Article content'),
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp(),
        ]);

        // creates `article_categories` table
        $this->createTable('{{%article_categories}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(11)->notNull()->comment('Article id'),
            'category_id' => $this->integer(11)->notNull()->comment('Category id'),
        ]);

        // creates indexes for `article_categories` table
        $this->createIndex(
            'idx-article_categories-article_id',
            '{{%article_categories}}',
            'article_id'
        );
        $this->createIndex(
            'idx-article_categories-category_id',
            '{{%article_categories}}',
            'category_id'
        );

        // add foreign keys for `article_categories` table
        $this->addForeignKey(
            'fk-article_categories-article_id',
            '{{%article_categories}}',
            'article_id',
            '{{%articles}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-article_categories-category_id',
            '{{%article_categories}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );

        // seeds data
        $this->execute("
            INSERT INTO `categories` (`id`, `parent_id`, `title`) VALUES
                (1, NULL, 'Общество'),
                (2, NULL , 'Культура'),
                (3, NULL , 'Наука'),
                (4, NULL, 'Спорт'),
                (5, 1, 'Городская жизнь'),
                (6, 1, 'День города'),
                (7, 1, 'Выборы'),
                (8, 1, 'Детская площадка'),
                (9, 8, '0-3 года'),
                (10, 8, '3-7 лет'),
                (11, 2, 'Театр'),
                (12, 2, 'Кино'),
                (13, 2, 'Концерты');
                
            INSERT INTO `articles` (`id`, `title`, `content`) VALUES
                (1, 'Одни закрылись, другие переехали: какие заведения Перми не найти на привычных местах из-за пандемии',
                    'Кафе, бары и рестораны Перми вернулись к работе в обычном режиме только в середине августа. До этого они прошли путь от полного карантина, объявленного в конце марта, до возможности открыться в формате летника в начале июля. Восстановиться смогли не все: часть любимых пермяками мест закрылась, а некоторым пришлось поменять адрес. Рассказываем о таких заведениях.'),
                (2, 'ГИБДД Перми в выходные будет массово проверять водителей',
                    'Сотрудники Госавтоинспекции Перми в эти выходные проведут профилактическое мероприятие «Опасный водитель». Автоинспекторы будут выявлять на дороге водителей, которые садятся за руль в состоянии опьянения. — Сообщить о водителях, которые управляют автомобилем в нетрезвом состоянии или ведут себя на дороге неадекватно, можно по телефону дежурной части полка ДПС ГИБДД Управления МВД России по городу Перми по телефону 246–79–00 или 102, — говорят в Госавтоинспекции.'),
                (3, 'Три выдвиженца на выборы губернатора Пермского края не дошли до регистрации',
                    'На момент завершения приема подписи и другие необходимые бумаги сдали пять кандидатов: действующий врио губернатора Дмитрий Махонин (самовыдвижение), экс-директор ОАО «Пемос-Хенкель» Евгений Козлов (партия «Патриоты России»), депутат краевого парламента Олег Постников (ЛДПР), секретарь крайкома КПРФ Ксения Айтакова (КПРФ) и руководитель холдинга «Сатурн-Р» Александр Репин («Справедливая Россия»).'),
                (4, 'На вокзале Пермь II появится бесплатная детская площадка',
                    'Бесплатная детская площадка в скором времени появится на железнодорожном вокзале Пермь II. Ее откроют на первом этаже здания. Точная дата начала работы пока неизвестна, но в РЖД сообщили, что уже заканчивают обустройство игровой зоны.'),
                (5, 'В Перми откроется первая игровая площадка для слепых детей',
                    'Благотворительный фонд «Колыбель надежды» и 22 пермяка, среди которых преподаватели, бухгалтеры, строители, инженеры, парикмахеры, риелторы и одна пенсионерка, объединились, чтобы создать для незрячих детей «Сад ощущений». Сенсорная площадка откроется 20 августа во дворе коррекционной школы-интерната для слепых и слабовидящих детей на Самаркандской, 32.'),
                (6, 'Пермь примет фестиваль «Театральная Россия»',
                    '11 сентября в Перми на эспланаде состоится openair-фестиваль «Театральная Россия» с участием ведущих российских театров. Проведение мероприятия согласовано Роспотребнадзором по Пермскому краю и будет проведено с соблюдением санитарно-эпидемиологических норм.'),
                (7, 'Киноэкран на арене: в пермском цирке начали показывать фильмы',
                    'Сегодня, 22 мая, состоялся пробный кинопоказ в пермском цирке. В 12:00 маленькие зрители увидели мультфильм «Урфин Джюс и его деревянные солдаты» (0+). В 19:00 для взрослых покажут художественный фильм «Большой» (12+). Цены в цирковом кинозале демократичные – на дневной сеанс можно купить билет за 50 рублей, на вечерний – за 100.'),
                (8, 'Пермяки смогут увидеть концерты онлайн',
                    'Из-за коронавируса театры, музеи и концертные залы были закрыты, но некоторые учреждения нашли решение этой проблемы.  Так, 18 марта Пермская филармония будет транслировать выступление скрипача Павла Милюкова и пианиста Эмина Мартиросяна. Концерт пройдет без зрителей. Все желающие смогут его увидеть на сайте краевой филармонии. Начало в 18:30.'),
                (9, 'Исполняется 115 лет со дня рождения пермского микробиолога Алексея Пшеничнова',
                    '<p class=\"text-center\">Спутник войн и народных бедствий. <br />Так специалисты называют сыпной тиф. Эпидемии этого заболевания косили население тысячами.</p> В годы Великой Отечественной избежать мора удалось благодаря пермскому микробиологу Алексею Пшеничнову. Он создал вакцину от тифа, разработав уникальный метод. В этом году со дня рождения ученого исполнится 115 лет.'),
                (10, 'В Прикамье начнут готовить профессиональных регбистов',
                    'Правительство Прикамья подписало соглашение с высшим советом Федерации регби России о развитии этого вида спорта в регионе. Предполагается, что секцию регби смогут посещать 190 ребят в четырех территориях края.'),
                (11, 'Гнома привязали к дереву: в Соликамске Поляна сказок превратилась в декорации к фильму ужасов',
                    '<p>В Соликамске неизвестный умелец украсил место отдыха горожан — Поляну сказок. Здесь появились мягкие игрушки, снеговики и деревянные фигуры. Но получилось это очень крипово, смешно и одновременно страшновато. Поляна находится в лесу в северной части Соликамска. Здесь часто отдыхают родители с детьми, гуляют местные жители с домашними питомцами. Одна из жительниц и сделала этот фоторепортаж.</p><p>— Летом здесь оборудовали городок для белок, — рассказала 59.RU местная жительница. — Говорят, что этот городок с кормушками, скамейками между деревьев, а также деревянным настилом над болотистой частью тропинки сделал местный житель в возрасте 90 с лишним лет. Кто произвел «зимний апгрейд» полянки, не знаю. Но теперь вечером здесь довольно много людей. Кто-то фотографируется, а кто-то на ватрушках катается.</p><p>— Правда, в темноте, как в фильме ужасов, — пишут жители в соцсетях. — особенно игрушки, привязанные к деревьям.</p><p>— Днём это выглядит по-другому, — вступается одна из жительниц. — Очень там любим гулять с детьми.</p><p>— Снеговики с вытекшими глазами и вздёрнутые игрушки. Ещё красных пятен на снегу не хватает для полноты, — такие сравнения видят некоторые соликамцы.</p>'),
                (12, 'В Перми могут запустить трамвай до аэропорта',
                    'В Перми обсуждают вопрос о запуске трамваев до аэропорта Большое Савино и микрорайона Ива. О возможном сотрудничестве по этим проектам говорили во время рабочей встречи врио губернатора Дмитрия Махонина и компании «Синара — транспортные машины» («СТМ»).'),
                (13, 'Первые партии российской вакцины от COVID-19 отгрузили во все регионы',
                    'Первые небольшие партии российской вакцины от COVID-19 отгружены во все регионы. По словам главы Минздрава Михаила Мурашко, доставка ожидается до понедельника. Об этом сообщает РИА «Новости».'),
                (14, 'Роспотребнадзор проведет горячую линию по организации питания в школах Прикамья',
                    'В понедельник, 14 сентября, Управление Роспотребнадзора по Пермскому краю открывает телефонную горячую линию «Организация питания в школах». Задавать вопросы специалистам можно в рабочие дни с 14 сентября по 5 октября с 10:00 до 18:00.'),
                (15, 'Пермяки собрали 370 тысяч на перелет жителю Кунгура, сломавшему позвоночник в Адлере',
                    'Несколько дней назад мы написали о сложной ситуации, в которой оказался житель Кунгура. Месяц назад Андрей Габеркорн сломал позвоночник, нырнув в горную реку в Адлере. Семья не могла перевезти его на родину, так как на это потребовалась большая сумма, а собрать удалось лишь половину. Сегодня стало известно, что спустя сутки после публикации жители Прикамья помогли собрать недостающие деньги.'),
                (16, 'Серебристые люди, мимы и бабочки на ходулях: фото с открытия фестиваля уличных театров «Флюгер»',
                    'На эспланаде начался Международный фестиваль уличных театров «Флюгер» (0+). Несмотря на дождик, зрители пришли с зонтиками и в плащах. Ну и наш фотограф вооружился камерой и сделал целую серию снимков. Смотрим, что же там происходит.'),
                (17, 'Жителя Октябрьского района арестовали из-за неоплаченного штрафа за нарушение самоизоляции',
                    'Молодого человека арестовали за неуплату штрафа, назначенного ему за прогулку в общественном месте во время режима самоизоляции. Об административном наказании сообщило Управление Федеральной службы судебных приставов по Пермскому краю.'),
                (18, '«Много асфальта и грязный свет»: экологи не согласились с концепцией развития Балатовского парка',
                    'Согласно проекту, который в июле предложило пермским властям управление по экологии и природопользованию, в Черняевском лесу планируют скорректировать зонирование, а парк «Балатово» — реконструировать. В нем обустроят места для мероприятий, павильоны для торговых рядов, кафе и «скрытых мест тихого отдыха». Но экологи, биологи и даже архитекторы увидели в этой концепции угрозу для существования леса и написали письмо мэру и главе Прикамья.'),
                (19, 'Пермский институт ж/д транспорта прокомментировал выселение старшекурсников из своего общежития',
                    'Администрация Пермского института железнодорожного транспорта прокомментировала выселение студентов-старшекурсников из общежития на бульваре Гагарина, 47. По их словам, никого не выселяли, а студенты обязаны освобождать свои комнаты на время каникул, поэтому оставленные вещи администрация упаковала и вынесла из комнат.'),
                (20, '«9 часов с принятия вызова до передачи бригаде»: пермские медики скорой помощи пожаловались на нехватку рук',
                    'Сотрудники пермской скорой пожаловались на то, что в последнее время значительно увеличилось время между приемом и передачей вызова — оно может достигать нескольких часов. При этом медики не винят в этом диспетчеров и говорят, что проблема в соотношении количества вызовов и количества бригад — первых много, а вот вторых мало.'),
                (21, '«Буду принимать меры»: депутат Заксобрания Прикамья пожаловалась на кондуктора, который высадил ее сына из автобуса',
                    'Депутат Законодательного собрания Пермского края от «Единой России» Татьяна Шестакова опубликовала в Facebook пост о том, что ее сына кондуктор высадила из автобуса.'),
                (22, 'Не верь косметологу: 5 процедур красоты, которые давно устарели, но их всё равно предлагают',
                    'В погоне за красотой женщины готовы пойти на любые жертвы. В страстном порыве омолодиться они не глядя выбирают процедуру, ожидая мгновенный вау-эффект без последствий. Затуманенный мозг не в состоянии подсказать им, что некоторые процедуры устарели и имеют неприятный побочный эффект. Мы поговорили с врачом-косметологом Юлией Меняевой и выяснили, какие некогда модные косметологические процедуры нам следует забыть и что пришло им на замену.'),
                (23, 'В Прикамье еще на две недели продлили режим самоизоляции для людей старше 65 лет',
                    'Руководитель управления Роспотребнадзора по Пермскому краю Виталий Костарев подчеркнул, что эпидемическая обстановка в регионе остается напряженной, поэтому члены штаба сочли невозможным снять самоизоляцию для людей старше 65 лет. Это связано с риском для здоровья пожилых людей.'),
                (24, 'Почему быть матерью-одиночкой в России до сих пор стыдно? Мы спросили самих мам и эксперта по отношениям',
                    '«Ох, бедненькая, как же ты так, без мужа, одна... Ребенку отец нужен! Семья должна быть — одной не положено», — сетуют соседки на детской площадке, глядя на маму с ребенком, которая на самом-то деле неплохо справляется одна. Где-то в другом месте такую женщину без мужа, но с ребенком злые языки могут обсуждать или осуждать, вешая ярлык «мать-одиночка». В России многие женщины стыдятся этого статуса и боятся его. Журналист Алёна Золотухина поговорила с психологом и выяснила, в чем кроется причина страха и как с ним бороться. А мамы, которые воспитывают своих детей без мужа, честно ответили, стыдились ли они когда-нибудь своего положения.'),
                (25, 'Пермяк выбросил из окна квартиры колеса. Полиция не считает это преступлением',
                    'Утром 16 августа жители дома на Комсомольском проспекте, 47 обнаружили, что их автомобили сильно пострадали от выброшенных из окна колес, которые валялись по всему двору. Собирать их спустился мужчина с оружием, которое было вложено в кобуру. По словам жителей дома, владелец колес плохо ориентировался в пространстве и просил не провоцировать его вызовом полиции. Виновными в произошедшем он назвал самих пострадавших.'),
                (26, 'Оперштаб Прикамья разрешил открыть детские игровые комнаты и фуд-корты в обычном режиме',
                    'Сотрудники и посетители открывшихся детских комнат и фуд-кортов должны будут соблюдать все меры противоэпидемической безопасности: температурный и масочный режим, следить за дистанцией между посетителями. Столы на фуд-кортах должны быть размещены на расстоянии не менее 1,5 метра друг от друга.'),
                (27, '«Готов дать городу в бесплатное пользование максимум на пять лет». Репин рассказал о планах на школу в «Красных казармах»',
                    'Через три дня состоится приемка школы, построенной в ЖК «Арсенал». Владелец холдинга «Сатурн-Р» Александр Репин вновь сообщил, что не будет передавать школу городу. Ранее бизнесмен сообщал, что соглашение, которое обязывает передать школу, директор СМУ № 3 Николай Кирюхин вынужден был подписать, так как иначе компании не дали бы возвести вторую очередь ЖК «Арсенал».'),
                (28, 'В Прикамье осудили женщину, сбившую на машине свою дочь, а потом сбежавшую с места ДТП',
                    'Как сообщает краевая полиция, в июне 28-летняя жительница Кунгура приобрела автомобиль ВАЗ-21102. При этом женщина не проходила обучение в автошколе, водительского удостоверения у нее не было. Навыкам вождения ее обучал сожитель, который также никогда не имел водительских прав.'),
                (29, 'Число заболевших коронавирусом в Прикамье превысило 8,5 тысячи человек',
                    'За минувшие сутки в Прикамье выявлено 57 новых случаев заражения COVID-19. Об этом сообщает информационный центр по мониторингу ситуации с коронавирусом. Таким образом с начала пандемии коронавирусная инфекция диагностирована у 8511 жителей края.'),
                (30, 'Александр Репин хочет продать строительную компанию «Сатурн-Р» за 500 миллионов рублей',
                    'Владелец холдинга «Сатурн-Р» Александр Репин планирует продать одну из крупнейших в Прикамье строительных компаний — ООО «Сатурн-Р». Как говорит бизнесмен, это решение он принял из-за убытков, потому что власти уже 5 месяцев откладывают рассмотрение проекта 4-й очереди жилого комплекса «Арсенал». По словам Александра Репина, из-за бездействия властей компания «не может работать в полном объеме».');
                    
            INSERT INTO `article_categories` (`id`, `article_id`, `category_id`) VALUES
                (1, 1, 5),
                (2, 2, 6),
                (3, 3, 7),
                (4, 4, 9),
                (5, 5, 10),
                (6, 6, 11),
                (7, 7, 12),
                (8, 8, 13),
                (9, 9, 3),
                (10, 10, 4),
                (11, 11, 9),
                (12, 12, 10),
                (13, 13, 5),
                (14, 14, 5),
                (15, 15, 5),
                (16, 16, 5),
                (17, 17, 5),
                (18, 18, 5),
                (19, 19, 5),
                (20, 20, 5),
                (21, 21, 5),
                (22, 22, 5),
                (23, 23, 5),
                (24, 24, 5),
                (25, 25, 5),
                (26, 26, 5),
                (27, 27, 5),
                (28, 28, 5),
                (29, 29, 5),
                (30, 30, 5),
                (31, 1, 11),
                (32, 1, 12),
                (33, 1, 13);
        ");
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-category-parent_id',
            '{{%categories}}'
        );
        $this->dropForeignKey(
            'fk-article_categories-article_id',
            '{{%article_categories}}'
        );
        $this->dropForeignKey(
            'fk-article_categories-category_id',
            '{{%article_categories}}'
        );
        $this->dropTable('{{%article_categories}}');

        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%articles}}');

        return true;
    }
}
