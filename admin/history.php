<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Главная страница. Сайт Сербина Александра</title>
        <link rel="stylesheet" type="text/css" href="../admin/assets/css/admin_style.css">
        <script type="text/javascript" src="../../public/assets/js/main.js"></script>
    </head>
    <body>
        <div id="wrapper">

            <main>

                <div id="current-date"></div>

                <section>
                    <h1>История просмотра</h1>
                    <h3>История текущего сеанса</h3>
                    <table class="table-history" >
                        <thead>
                            <tr>
                                <th>Страница</th>
                                <th>Просмотров</th>
                            </tr>
                        </thead>
                        <tbody  id="tbody-session">
                        </tbody>
                    </table><br/>
                    <button id="mybutton">Очистить историю сеанса</button>				

                    <h3>История за всё время</h3>
                    <table class="table-history">
                        <thead>
                            <tr>
                                <th>Страница</th>
                                <th>Просмотров</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-all">
                        </tbody>
                    </table>


                </section>	
            </main>
        </div>
        <footer>
            <p>Copyright &copy; 2017 Serbin Alexandr</p>
        </footer>

        <script type="text/javascript">
            function showHistory(elementId, pages) {
                var elem = document.getElementById(elementId);
                if (!elem)
                    return false;

                for (var i = 0; i < pages.length; i++) {
                    var tr = document.createElement('TR');
                    var td1 = document.createElement('TD');
                    td1.innerHTML = pages[i].url;
                    tr.appendChild(td1);
                    var td2 = document.createElement('TD');
                    td2.innerHTML = pages[i].views;
                    tr.appendChild(td2);
                    elem.appendChild(tr);
                }
            }

            document.getElementById('mybutton').onclick = function () {
                localStorage.clear();
                location.reload();
            }


            document.addEventListener("DOMContentLoaded", function (event) {
                var allPages = JSON.parse(getCookie('history') || '[]');
                var sessionPages = JSON.parse(localStorage.getItem('history') || '[]');

                showHistory('tbody-session', sessionPages);
                showHistory('tbody-all', allPages);
            });
        </script>

    </body>
</html>