<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Загрузка сообщений блога. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../admin/assets/css/admin_style.css">
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>		
    </head>
    <body>
        <div id="wrapper">

            <main>

                <div id="current-date"></div>

                <h2> Форма для загрузки публикаций в блог </h2>

                <form action="blogloadfile" class="form-fileload" method="post" enctype="multipart/form-data">
                    <input type="file" name="messages"/> <br>
                    <input type="submit" value="3arpyзить" name="loadfile"/>
                </form>

                <?php
                if (isset($_POST['loadfile'])) {
                    $source = $_FILES["messages"]["tmp_name"];
                    $file_type = $_FILES["messages"]["type"];
                    if ($file_type === 'application/vnd.ms-excel') {
                        foreach (file($source) as $v) {
                            $rows[] = explode(',', $v);
                        }
                        if (isset($rows)) {
                            foreach ($rows as $row) {
//                                insertFromFile($row);
                                insertFromFile_AR($row);
                            }
                            echo 'Да, добавленно!';
                        } else {
                            echo 'Файл пустой';
                        }
                    } else {
                        echo 'Поддерживаемый формат: CSV. Проверьте и повторите';
                    }
                }

                function insertFromFile($row) {
                    $title = trim($row['0'], '"');
                    $image = trim($row['2'], '"');
                    $body = trim($row['1'], '"');
                    $date = trim($row['3'], '"');
                    
                    $query = "INSERT INTO blog VALUES (null, :title, :image, :body, :date)";
                    $stmt = BaseActiveRecord::$pdo->prepare($query);                    
                    $stmt->bindParam(':title', $title);                    
                    $stmt->bindParam(':image', $image);                   
                    $stmt->bindParam(':body', $body);                    
                    $stmt->bindParam(':date', $date);
                    $stmt->execute();
                }

                function insertFromFile_AR($row) {
                    $title = trim($row['0'], '"');
                    $image = trim($row['2'], '"');
                    $body = trim($row['1'], '"');
                    $date = trim($row['3'], '"');
                    
                    $newRecord = new BlogModel();
                    $newRecord->title = $title;
                    $newRecord->image = $image;
                    $newRecord->body = $body;                    
                    $newRecord->date = $date;
                    $newRecord->save();
                }
                ?>

            </main>
        </div>
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>

    </body>
</html>