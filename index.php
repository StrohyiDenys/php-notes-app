<?php
require_once "notes.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои заметки</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="app">
    <h1>📝 Мои заметки</h1>

    <!-- Форма добавления заметки -->
    <form action="notes.php" class="note-form" method="post">
        <input
                type="text"
                name="title"
                placeholder="Заголовок заметки"
        >

        <textarea
                name="content"
                placeholder="Текст заметки"
        ></textarea>

        <button type="submit">Сохранить</button>
    </form>

    <!-- Список заметок -->
    <div class="notes">
        <?php show_notes(); ?>
    </div>
</div>

</body>
</html>
