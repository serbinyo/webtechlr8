<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Редактор публикации. Сайт Сербина Александра</title>

        <?php
        $id = (int) $_GET['id'];
        echo "$id<br>";

        if (!empty($_POST)) {

            $updateBlog = BlogModel::find($id);

            $title = htmlspecialchars(trim($_POST['0']));
            $image = htmlspecialchars(trim($_POST['1']));
            $body = htmlspecialchars(trim($_POST['2']));

            $updateBlog->title = $title;
            $updateBlog->image = $image;
            $updateBlog->body = $body;
            $updateBlog->save();
            
        } else {
            ?>
            <script>
                var title = parent.document.getElementById('title<?php echo $id ?>').value,
                        image = parent.document.getElementById('image<?php echo $id ?>').value,
                        body = parent.document.getElementById('body<?php echo $id ?>').value,
                        data = [];
                data.push(title);
                data.push(image);
                data.push(body);
                postToIframe('blogupdatenow?id=<?php echo $id ?>', data);

                function postToIframe(url, data) {
                    var phonyForm = document.getElementById('phonyForm');
                    if (!phonyForm) {
                        // временную форму создаем, если нет
                        phonyForm = document.createElement("form");
                        phonyForm.id = 'phonyForm';
                        phonyForm.style.display = "none";
                        phonyForm.method = "POST";
                        phonyForm.enctype = "multipart/form-data";
                        document.body.appendChild(phonyForm);
                    }

                    phonyForm.action = url;

                    // заполнить форму данными из объекта
                    var html = [];
                    for (var key in data) {
                        var value = String(data[key]).replace(/"/g, "&quot;");
                        html.push("<input type='hidden' name=\"" + key + "\" value=\"" + value + "\">");
                    }
                    phonyForm.innerHTML = html.join('');

                    phonyForm.submit();
                }
            </script>
<?php } ?>
    </head>
    <body>
        <div id="wrapper">
            <main>
                <h3>Тут</h3>
            </main>
        </div>
    </body>
</html>