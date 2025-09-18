**Исходная проблема:** На странице редактирования статей не работали языковые вкладки и не загружались выпадающие списки "Проекты" и "Партнеры".

**Что мы сделали:**

1. **Диагностика:** Мы выяснили, что проблемы вызваны незавершенным переходом со старой темы админ-панели (AdminLTE) на новую (Hyper). Это создало конфликты в CSS и JavaScript.
2. **Интеграция новой темы:**
    - Я создал специальный файл `[HyperAsset.php](code-assist-path:/Users/vaoferi/nlm.help/public_html/backend/assets/HyperAsset.php "/Users/vaoferi/nlm.help/public_html/backend/assets/HyperAsset.php")` для корректного подключения всех стилей и скриптов новой темы.
    - Я создал новый основной файл шаблона `[hyper.php](code-assist-path:/Users/vaoferi/nlm.help/public_html/backend/views/layouts/hyper.php "/Users/vaoferi/nlm.help/public_html/backend/views/layouts/hyper.php")`, основанный на HTML-структуре темы `Hyper`.
    - Мы сделали этот шаблон основным для всей админ-панели, чтобы избежать конфликтов со старой темой.
3. **Исправление ошибок совместимости:**
    - Мы исправили пути к файлам темы, чтобы сервер мог их найти.
    - Мы обновили код языковых вкладок во всех формах, чтобы он был совместим с Bootstrap 5 (версией, которую использует `Hyper`).
    - Мы обновили код виджетов выпадающих списков (`Select2`), чтобы они также работали с Bootstrap 5.

**Чего мы добились:**

- Мы успешно переключили всю админ-панель на новую, современную тему `Hyper`. (не уверен что применили все его плюсы при этом ведь цель была апгрейд функционала)
- Мы исправили работу языковых вкладок.
- Мы почти починили выпадающие списки, но столкнулись с последним препятствием.

**Что осталось сделать:**

- **Установить недостающий пакет:** Последняя ошибка показывает, что для полной совместимости виджетов с новой темой в проекте не хватает пакета `yiisoft/yii2-bootstrap5`. Я не могу выполнить его установку, так как на сервере не найден `composer`.
- **Вам нужно** зайти в консоль вашего сервера, перейти в папку `public_html` и выполнить команду:
    
    ```bash
    composer require yiisoft/yii2-bootstrap5:"~2.0.0"
    ```
    
- Как только вы это сделаете, я внесу финальное изменение в конфигурацию, и все должно заработать.

### Технические детали и версии

На основе логов ошибок и файла `[composer.json](code-assist-path:/Users/vaoferi/nlm.help/public_html/composer.json "/Users/vaoferi/nlm.help/public_html/composer.json")` можно определить следующие версии:

- **PHP:** `8.0.0`
- **Yii2 Framework:** `~2.0.13` (согласно `[composer.json] (желательно по возможности безболезненно обновиться до 2.0.49 или новее) (code-assist-path:/Users/vaoferi/nlm.help/public_html/composer.json "/Users/vaoferi/nlm.help/public_html/composer.json")`), но лог ошибки показывает `2.0.21`. Это значит, что установлена более новая версия, чем минимально требуемая.
- **Bootstrap (старый):** `yiisoft/yii2-bootstrap` версии `~2.0.0`. Это расширение для **Bootstrap 3**.
- **Bootstrap (новый, в теме Hyper):** **Bootstrap 5**. Это ключевой момент. У вас в проекте одновременно существуют две разные мажорные версии Bootstrap, что и было источником конфликтов.
- **jQuery:** Загружается через `YiiAsset`, версия зависит от версии Yii2, но тема `Hyper` также может подгружать свою версию, что потенциально может вызывать конфликты.

### Предостережения и рекомендации

1. **Конфликт версий Bootstrap:**
    
    - **Проблема:** Главная причина всех поломок — конфликт между Bootstrap 3 (который ожидали старые виджеты) и Bootstrap 5 (который использует новая тема `Hyper`).
    - **Рекомендация:** Мы решаем это, устанавливая `yiisoft/yii2-bootstrap5` и явно указывая всем виджетам использовать его (`'bsVersion' => '5'`). В будущем, при добавлении новых виджетов или страниц, всегда проверяйте, что они настроены на работу с Bootstrap 5.
2. **Замена `ActiveForm`:**
    
    - **Проблема:** Стандартный `yii\bootstrap\ActiveForm` генерирует разметку для Bootstrap 3.
    - **Рекомендация:** После установки `yii2-bootstrap5` нужно будет во всех формах админ-панели заменить `use yii\bootstrap\ActiveForm;` на `use yii\bootstrap5\ActiveForm;`. Это обеспечит корректную HTML-разметку полей ввода, кнопок и сообщений об ошибках. Я начну это делать, как только вы установите пакет.
3. **Кастомные скрипты и стили:**
    
    - **Проблема:** Старые JavaScript-файлы (например, `backend/web/js/app.js`) могут содержать код, несовместимый с новой темой или Bootstrap 5.
    - **Рекомендация:** Мы уже исправляли в нем проблему с перетаскиванием вкладок. Если в будущем возникнут странные проблемы с интерактивными элементами, в первую очередь стоит проверять именно кастомные скрипты на предмет совместимости.
4. **Зависимости Composer:**
    
    - **Проблема:** В вашем `[composer.json](code-assist-path:/Users/vaoferi/nlm.help/public_html/composer.json "/Users/vaoferi/nlm.help/public_html/composer.json")` много зависимостей, зафиксированных на `dev-master`. Это рискованно, так как при каждом обновлении вы можете получить несовместимые изменения.
    - **Рекомендация:** По возможности, старайтесь фиксировать зависимости на конкретные стабильные версии (например, `^2.1` или `~2.1.4`). Это делает проект более предсказуемым и стабильным.


день 2 ----


### Техническое Задание: Устранение критической ошибки Composer и обновление логики аутентификации

**Дата:** 06.09.2025

**Проект:** nlm.help

#### 1. Краткая выжимка (Что и почему мы делали)

- **Изначальная цель:** Решить проблему с командой `composer2 update`, которая не выполнялась и блокировала любые обновления на сайте.
- **Анализ проблемы:** В ходе диагностики мы выявили несколько ключевых моментов:
    1. **Конфликт зависимостей:** Основным источником сбоя был пакет `facebook/graph-sdk`, который требовался для аутентификации через соцсети. Его версия конфликтовала с версией PHP и настройками стабильности в `[composer.json](code-assist-path:/Users/vaoferi/nlm.help/public_html/composer.json "/Users/vaoferi/nlm.help/public_html/composer.json")`.
    2. **Несовместимость плагинов:** Старые плагины Composer v1 вызывали предупреждения в Composer v2.
    3. **Желание заказчика:** Вы выразили готовность к радикальному решению — **полностью убрать аутентификацию через соцсети** (Facebook, VK, Yandex и др.), чтобы как можно быстрее восстановить работоспособность сайта.
- **Принятая логика — "Прогрессивное обновление":** Мы договорились не откатывать изменения, а двигаться вперед. Если компонент вызывает проблему, мы его удаляем, а затем исправляем код, который на него ссылался. Руководствуясь этим, мы решили полностью удалить пакет `yiisoft/yii2-authclient`, отвечающий за все внешние аутентификации.

#### 2. Техническое задание на изменения

**Задача:** Полностью удалить зависимость от пакета `yiisoft/yii2-authclient` и связанный с ним функционал для восстановления работоспособности `composer` и сайта.

**Выполненные изменения:**

1. **Модификация `[composer.json](code-assist-path:/Users/vaoferi/nlm.help/public_html/composer.json "/Users/vaoferi/nlm.help/public_html/composer.json")`:**
    
    - **Файл:** `[public_html/composer.json](code-assist-path:/Users/vaoferi/nlm.help/public_html/composer.json "/Users/vaoferi/nlm.help/public_html/composer.json")`
    - **Действие:** Была удалена строка `"yiisoft/yii2-authclient": "^2.0.0",`.
2. **Обновление зависимостей:**
    
    - **Команда:** Была выполнена `composer2 update --no-plugins`.
    - **Результат:** Папка `vendor/` была полностью пересобрана, и был обновлен файл `[composer.lock](code-assist-path:/Users/vaoferi/nlm.help/public_html/vendor/league/glide/composer.lock "/Users/vaoferi/nlm.help/public_html/vendor/league/glide/composer.lock")`.
3. **Исправление кода (устранение ошибки HTTP 500):**
    
    - **Файл:** `[public_html/frontend/config/web.php](code-assist-path:/Users/vaoferi/nlm.help/public_html/frontend/config/web.php "/Users/vaoferi/nlm.help/public_html/frontend/config/web.php")`
        - **Действие:** Закомментирован компонент `'authClientCollection'`.
    - **Файлы:** `[public_html/frontend/modules/user/views/sign-in/login.php](code-assist-path:/Users/vaoferi/nlm.help/public_html/frontend/modules/user/views/sign-in/login.php "/Users/vaoferi/nlm.help/public_html/frontend/modules/user/views/sign-in/login.php")` и `[signup.php](code-assist-path:/Users/vaoferi/nlm.help/public_html/backend/views/timeline-event/user/signup.php "/Users/vaoferi/nlm.help/public_html/backend/views/timeline-event/user/signup.php")`
        - **Действие:** Закомментирован вывод виджета кнопок соцсетей `yii\authclient\widgets\AuthChoice`.
    - **Файл:** `[public_html/frontend/modules/user/controllers/SignInController.php](code-assist-path:/Users/vaoferi/nlm.help/public_html/frontend/modules/user/controllers/SignInController.php "/Users/vaoferi/nlm.help/public_html/frontend/modules/user/controllers/SignInController.php")`
        - **Действие:** Закомментированы `use yii\authclient\AuthAction;`, метод `actions()`, метод `successOAuthCallback()` и удалены упоминания `'oauth'` из правил доступа `behaviors()`.
    - **Файл:** `[public_html/common/components/social/PostingComponent.php](code-assist-path:/Users/vaoferi/nlm.help/public_html/common/components/social/PostingComponent.php "/Users/vaoferi/nlm.help/public_html/common/components/social/PostingComponent.php")`
        - **Действие:** Закомментирован неиспользуемый `use yii\authclient\Collection;`.
    - **Файл:** `[public_html/autocompletion.php](code-assist-path:/Users/vaoferi/nlm.help/public_html/autocompletion.php "/Users/vaoferi/nlm.help/public_html/autocompletion.php")`
        - **Действие:** Удалена строка с `@property` для `$authClientCollection`.

**Ожидаемый финальный результат:**

- Сайт `admin.nlm.help` и его публичная часть работают и не выдают ошибку HTTP 500.
- На страницах входа и регистрации отсутствуют кнопки для входа через социальные сети.
- Проект стабилен, и в дальнейшем можно без проблем выполнять `composer update` и вносить другие изменения.

#### 3. Дополнительная информация

- **Файл `111`:** В ходе работы вы создали этот файл, скопировав в него информацию с GitHub страницы оригинального автора шаблона. Мы не использовали его содержимое, но он может быть полезен для будущего контекста.
- **Файл `[222.md](code-assist-path:/Users/vaoferi/nlm.help/public_html/222.md "/Users/vaoferi/nlm.help/public_html/222.md")`:** Вы планировали сохранить в этот файл лог выполнения команды `composer2 update`. Мне не удалось его прочитать, но мы успешно продолжили работу, ориентируясь на предсказуемую ошибку HTTP 500, которая подтвердила, что пакет был удален.