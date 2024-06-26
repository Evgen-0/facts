# Схема бази даних

### Users

| Поле     | Тип          | null | Опис               |
|----------|--------------|------|--------------------|
| id       | uuid         |      | Ідентифікатор      |
| name     | varchar(20)  |      | Унікальне ім'я     |
| email    | varchar(255) |      | Електрона скринька |
| password | varchar(255) |      | Пароль             |
| photo    | varchar(128) | +    | Аватарка           |

### User_links

| Поле         | Тип          | null | Опис          |
|--------------|--------------|------|---------------|
| user_id      | uuid         |      | Ідентифікатор |
| telegram_id  | varchar(255) | +    | Telegram id   |
| facebook_id  | varchar(255) | +    | Facebook id   |
| twitter_id   | varchar(255) | +    | Twitter id    |
| github_id    | varchar(255) | +    | Github id     |
| gitlab_id    | varchar(255) | +    | Gitlab id     |
| instagram_id | varchar(255) | +    | Instagram id  |
| tiktok_id    | varchar(255) | +    | Tiktok id     |
| youtube_id   | varchar(255) | +    | Youtube id    |
| twitch_id    | varchar(255) | +    | Twitch id     |
| discord_id   | varchar(255) | +    | Discord id    |

### Categories

| Поле      | Тип          | null | Опис                                 |
|-----------|--------------|------|--------------------------------------|
| id        | uuid         |      | Ідентифікатор                        |
| name      | varchar(255) |      | Назва                                |
| alias     | json         |      | Альтернативні назви                  |
| photo     | varchar(128) | +    | Аватарка                             |
| parent_id | uuid         | +    | Ідентифікатор батьківської категорії |

### Posts

| Поле        | Тип          | null | Опис                      |
|-------------|--------------|------|---------------------------|
| id          | uuid         |      | Ідентифікатор             |
| title       | varchar(255) |      | Заголовок                 |
| body        | varchar(255) | +    | Текст повідомлення        |
| user_id     | uuid         |      | Ідентифікатор користувача |
| category_id | uuid         |      | Ідентифікатор категорії   |

### Comments (Поліморфічний)

| Поле      | Тип          | null | Опис                                  |
|-----------|--------------|------|---------------------------------------|
| id        | uuid         |      | Ідентифікатор                         |
| user_id   | uuid         |      | Ідентифікатор користувача             |
| post_id   | uuid         |      | Ідентифікатор посту                   |
| body      | varchar(255) |      | Текст повідомлення                    |
| parent_id | uuid         | +    | Ідентифікатор батьківського коментаря |

### Likes (Поліморфічний)

| Поле    | Тип  | null | Опис                      |
|---------|------|------|---------------------------|
| id      | uuid |      | Ідентифікатор             |
| user_id | uuid |      | Ідентифікатор користувача |
| post_id | uuid |      | Ідентифікатор посту       |
| is_like | bool |      | Лайк/дизлайк              |

### Media_Files

| Поле      | Тип          | null | Опис                                     |
|-----------|--------------|------|------------------------------------------|
| id        | uuid         |      | Ідентифікатор                            |
| type      | varchar(255) |      | Тип файлу (image, gif, video, text_video |
| file_path | varchar(255) |      | Шлях до файлу                            |
| post_id   | uuid         |      | Ідентифікатор посту                      |

### Tags

| Поле | Тип          | null | Опис          |
|------|--------------|------|---------------|
| id   | uuid         |      | Ідентифікатор |
| name | varchar(255) |      | Назва         |

### Post_Tags

| Поле    | Тип  | null | Опис                |
|---------|------|------|---------------------|
| tag_id  | uuid |      | Ідентифікатор тегу  |
| post_id | uuid |      | Ідентифікатор посту |

### Collections

| Поле    | Тип          | null | Опис                                            |
|---------|--------------|------|-------------------------------------------------|
| id      | uuid         |      | Ідентифікатор                                   |
| name    | varchar(255) |      | Назва                                           |
| user_id | uuid         |      | Ідентифікатор користувача, що створив категорію |

### Collection_Posts

| Поле          | Тип  | null | Опис                   |
|---------------|------|------|------------------------|
| collection_id | uuid |      | Ідентифікатор колекції |
| post_id       | uuid |      | Ідентифікатор посту    |

### User_Stats

| Поле           | Тип  | null | Опис                       |
|----------------|------|------|----------------------------|
| id             | uuid |      | Ідентифікатор              |
| user_id        | uuid |      | Ідентифікатор користувача  |
| post_count     | int  |      | Кількість доданих записів  |
| like_count     | int  |      | Кількість лайків           |
| likes_received | int  |      | Кількість отриманих лайків |
| comment_count  | int  |      | Кількість коментарів       |

### Post_Stats

| Поле          | Тип  | null | Опис                       |
|---------------|------|------|----------------------------|
| id            | uuid |      | Ідентифікатор              |
| post_id       | uuid |      | Ідентифікатор повідомлення |
| views_count   | int  |      | Кількість переглядів       |
| like_count    | int  |      | Кількість лайків           |
| comment_count | int  |      | Кількість коментарів       |

### Collection_Stats

| Поле           | Тип  | null | Опис                       |
|----------------|------|------|----------------------------|
| id             | uuid |      | Ідентифікатор              |
| collection_id  | uuid |      | Ідентифікатор колекції     |
| post_count     | int  |      | Кількість доданих записів  |
| like_count     | int  |      | Кількість лайків           |
| likes_received | int  |      | Кількість отриманих лайків |
| comment_count  | int  |      | Кількість коментарів       |
| views_count    | int  |      | Кількість переглядів       |

### User_Favorites (Поліморфічний)
| Поле              | Тип          | null | Опис                           |
|-------------------|--------------|------|--------------------------------|
| id                | uuid         |      | Ідентифікатор                  |
| user_id           | uuid         |      | Ідентифікатор користувача      |
| favoriteable_type | varchar(255) |      | Тип об'єкта (post, collection) |
| favoriteable_id   | uuid         |      | Ідентифікатор об'єкта          |
