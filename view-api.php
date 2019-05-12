<html>
    <head>
        <title> PW - View </title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script>

var URL = "http://andrive.go.ro/faculta/pw/test-ind.php/"


$(document).ready(function(){

    // GET

    // Afiseaza lista de etichete
    $("#b_1").click(function(){
        $.get(URL + "etichete", function(data, status){
            $( "#p_1" ).html("");
            $( "#p_1" ).html("Data:<br> -> " + data + " <br> Status: <br> ->" + status);
        });
    });

    // Afiseaza lista de imagini
    $("#b_2").click(function(){
        $.get(URL + "imagini", function(data, status){
            $( "#p_2" ).html("");
            $( "#p_2" ).html("Data:<br> -> " + data + " <br> Status: <br> ->" + status);
        });
    });

    // Lista de imagini din colectia data
    $("#b_3").click(function(){
        ID = $( "#i_3" ).val();
        if (!ID){
            alert("3. ID Colectie este obligatoriu.");
            return 0;
        }
        $.get(URL + "imagini/colectie/" + ID, function(data, status){
            $( "#p_3" ).html("");
            $( "#p_3" ).html("Data:<br> -> " + data + " <br> Status: <br> ->" + status);
        });
    });

    // Afiseaza informatii despre imagine
    $("#b_4").click(function(){
        ID = $( "#i_4" ).val();
        if (!ID){
            alert("4. ID Imagine este obligatoriu.");
            return 0;
        }
        $.get(URL + "imagine/" + ID, function(data, status){
            $( "#p_4" ).html("");
            $( "#p_4" ).html("Data:<br> -> " + data + " <br> Status: <br> ->" + status);
        });
    });

    // Afiseaza Top imagini
    $("#b_5").click(function(){
        ID = $( "#i_5" ).val();
        if (!ID){
            alert("5. Introduceti Valoarea pentru TOP");
            return 0;
        }
        $.get(URL + "top/" + ID, function(data, status){
            $( "#p_5" ).html("");
            $( "#p_5" ).html("Data:<br> -> " + data + " <br> Status: <br> ->" + status);
        });
    });



    // PUT

    // Adauga un utilizator
    $("#b_6").click(function(){
        user = $( "#i_6a" ).val();
        email = $( "#i_6b" ).val();
        pass = $( "#i_6c" ).val();
        if (!user || !email || !pass){
            alert("6. Nu ati completat toate datele");
            return 0;
        }

        $.ajax({
            url: URL + '/adauga/utilizator',
            type: 'PUT',
            data: "username=" + user + "&email=" + email + "&password=" + pass,
            success: function(data) {
                $( "#i_6a" ).val("");
                $( "#i_6b" ).val("");
                $( "#i_6c" ).val("");
                $( "#p_6" ).html("Contul a fost inregistrat. <br> Data: <br> -> " + data);
            }
        });
    });

    // Adauga o eticheta
    $("#b_7").click(function(){
        eticheta = $( "#i_7a" ).val();
        if (!eticheta){
            alert("7. Nu ati completat toate datele");
            return 0;
        }

        $.ajax({
            url: URL + '/adauga/eticheta',
            type: 'PUT',
            data: "name=" + eticheta,
            success: function(data) {
                $( "#i_7a" ).val("");
                $( "#p_7" ).html("Eticheta a fost adaugata. <br> Data: <br> -> " + data);
            }
        });

    });

    // Adauga o colectie
    $("#b_8").click(function(){
        name = $( "#i_8a" ).val();
        img1 = $( "#i_8b" ).val();
        img2 = $( "#i_8c" ).val();
        img3 = $( "#i_8d" ).val();
        img4 = $( "#i_8e" ).val();
        img5 = $( "#i_8f" ).val();
        if (!name || !img1 || !img2 || !img3 || !img4 || !img5){
            alert("8. Nu ati completat toate datele");
            return 0;
        }

        $.ajax({
            url: URL + '/adauga/colectie',
            type: 'PUT',
            data: "name=" + name + "&img1=" + img1 + "&img2=" + img2 + "&img3=" + img3 + "&img4=" + img4 + "&img5=" + img5,
            success: function(data) {
                $( "#i_8a" ).val("");
                $( "#i_8b" ).val("");
                $( "#i_8c" ).val("");
                $( "#i_8d" ).val("");
                $( "#i_8e" ).val("");
                $( "#i_8f" ).val("");
                $( "#p_8" ).html("Colectia a fost adaugata. <br> Data: <br> -> " + data);
            }
        });

    });

    // Adauga o imagine
    $("#b_9").click(function(){
        name = $( "#i_9a" ).val();
        img = $( "#i_9b" ).val();
        eticheta = $( "#i_9c" ).val();
        if (!name || !img || !eticheta){
            alert("9. Nu ati completat toate datele");
            return 0;
        }

        $.ajax({
            url: URL + '/adauga/imagine',
            type: 'PUT',
            data: "name=" + name + "&url=" + img + "&etichete=" + eticheta ,
            success: function(data) {
                $( "#i_9a" ).val("");
                $( "#i_9b" ).val("");
                $( "#i_9c" ).val("");
                $( "#p_9" ).html("Imaginea a fost adaugata. <br> Data: <br> -> " + data);
            }
        });
        
    });

    // [TOP] Adauga o imagine in top
    $("#b_10").click(function(){
        id = $( "#i_10a" ).val();
        if (!id){
            alert("10. Nu ati completat toate datele");
            return 0;
        }

        $.ajax({
            url: URL + '/top/add',
            type: 'PUT',
            data: "id=" + id ,
            success: function(data) {
                $( "#i_10a" ).val("");
                $( "#p_10" ).html("Imaginea a fost adaugata in TOP. <br> Data: <br> -> " + data);
            }
        });

    });


    // POST

    // [TOP] Voteaza o imagine
    $("#b_11").click(function(){
        id = $( "#i_11a" ).val();
        if (!id){
            alert("15. Nu ati completat toate datele");
            return 0;
        }

        $.ajax({
            url: URL + '/top/vote/' + id,
            type: 'POST',
            data: "",
            success: function(data) {
                $( "#i_11a" ).val("");
                $( "#p_11" ).html("Ai votat o imagine. <br> Data: <br> -> " + data);
            }
        });
    });

    // Modifica o imagine
    $("#b_12").click(function(){
        id = $( "#i_12a" ).val();
        name = $( "#i_12b" ).val();
        img = $( "#i_12c" ).val();
        eticheta = $( "#i_12d" ).val();
        if (!id || !name || !img || !eticheta){
            alert("11. Nu ati completat toate datele");
            return 0;
        }
        
        $.ajax({
            url: URL + '/modifica/imagine/' + id,
            type: 'POST',
            data: "name=" + name + "&url=" + img + "&etichete=" + eticheta,
            success: function(data) {
                $( "#i_12a" ).val("");
                $( "#i_12b" ).val("");
                $( "#i_12c" ).val("");
                $( "#i_12d" ).val("");
                $( "#p_12" ).html("Imaginea a fost actualizata. <br> Data: <br> -> " + data);
            }
        });

    });

    // Modifica o colectie
    $("#b_13").click(function(){
        id = $( "#i_13a" ).val();
        name = $( "#i_13b" ).val();
        img1 = $( "#i_13c" ).val();
        img2 = $( "#i_13d" ).val();
        img3 = $( "#i_13e" ).val();
        img4 = $( "#i_13f" ).val();
        img5 = $( "#i_13g" ).val();
        if (!id || !name || !img1 || !img2 || !img3 || !img4 || !img5 ){
            alert("12. Nu ati completat toate datele");
            return 0;
        }

        $.ajax({
            url: URL + '/modifica/colectie/' + id,
            type: 'POST',
            data: "name=" + name + "&img1=" + img1 + "&img2=" + img2 + "&img3=" + img3 + "&img4=" + img4 + "&img5=" + img5,
            success: function(data) {
                $( "#i_13a" ).val("");
                $( "#i_13b" ).val("");
                $( "#i_13c" ).val("");
                $( "#i_13d" ).val("");
                $( "#i_13e" ).val("");
                $( "#i_13f" ).val("");
                $( "#i_13g" ).val("");
                $( "#p_13" ).html("Colectia a fost actualizata. <br> Data: <br> -> " + data);
            }
        });
        
    });

    // Sterge un utilizator
    $("#b_14").click(function(){
        id = $( "#i_14a" ).val();
        if (!id){
            alert("13. Nu ati completat toate datele");
            return 0;
        }

        $.ajax({
            url: URL + '/delete/utilizator/' + id,
            type: 'POST',
            data: "",
            success: function(data) {
                $( "#i_14a" ).val("");
                $( "#p_14" ).html("Utilizatorul a fost sters. <br> Data: <br> -> " + data);
            }
        });

    });

    // Modifica un utilizator
    $("#b_15").click(function(){
        id = $( "#i_15a" ).val();
        user = $( "#i_15b" ).val();
        email = $( "#i_15c" ).val();
        pass = $( "#i_15d" ).val();
        if (!id || !user || !email || !pass){
            alert("14. Nu ati completat toate datele");
            return 0;
        }

        $.ajax({
            url: URL + '/modifica/utilizator/' + id,
            type: 'POST',
            data: "username=" + user + "&email=" + email + "&password=" + pass,
            success: function(data) {
                $( "#i_15a" ).val("");
                $( "#i_15b" ).val("");
                $( "#i_15c" ).val("");
                $( "#i_15d" ).val("");
                $( "#p_15" ).html("Contul a fost actualizat. <br> Data: <br> -> " + data);
            }
        });
    });


});


        </script>
    </head>
    <body>
        <h1> PW - View </h1>
        <ol>

            <!-- GET -->
            <li>
                <b> <font color="#61affe"> [GET] </font> Afiseaza lista de etichete </b><br>
                <div>
                    <p id="p_1"></p>
                    <button id="b_1">GET</button>
                    <button id="c_1" onclick='javascript:$( "#p_1" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#61affe"> [GET] </font> Afiseaza lista de imagini </b><br>
                <div>
                    <p id="p_2"></p>
                    <button id="b_2">GET</button>
                    <button id="c_2" onclick='javascript:$( "#p_2" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#61affe"> [GET] </font> Lista de imagini din colectia data </b><br>
                <div>
                    <p id="p_3"></p>
                    <input id="i_3" type="text" placeholder="ID Colectie"><br>
                    <button id="b_3">GET</button>
                    <button id="c_3" onclick='javascript:$( "#p_3" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#61affe"> [GET] </font> Afiseaza informatii despre imagine </b><br>
                <div>
                    <p id="p_4"></p>
                    <input id="i_4" type="text" placeholder="ID Imagine"><br>
                    <button id="b_4">GET</button>
                    <button id="c_4" onclick='javascript:$( "#p_4" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#61affe"> [GET] </font> [TOP] Afiseaza Top imagini </b><br>
                <div>
                    <p id="p_5"></p>
                    <input id="i_5" type="text" placeholder="TOP"><br>
                    <button id="b_5">GET</button>
                    <button id="c_5" onclick='javascript:$( "#p_5" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>

            <!-- PUT -->
            <li>
                <b> <font color="#fca130"> [PUT] </font> Adauga un utilizator </b><br>
                <div>
                    <p id="p_6"></p>
                    <input id="i_6a" type="text" placeholder="Username"><br>
                    <input id="i_6b" type="text" placeholder="Email"><br>
                    <input id="i_6c" type="text" placeholder="Password"><br>
                    <button id="b_6">PUT</button>
                    <button id="c_6" onclick='javascript:$( "#p_6" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#fca130"> [PUT] </font> Adauga o eticheta </b><br>
                <div>
                    <p id="p_7"></p>
                    <input id="i_7a" type="text" placeholder="Eticheta"><br>
                    <button id="b_7">PUT</button>
                    <button id="c_7" onclick='javascript:$( "#p_7" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#fca130"> [PUT] </font> Adauga o colectie </b><br>
                <div>
                    <p id="p_8"></p>
                    <input id="i_8a" type="text" placeholder="Denumire"><br>
                    <input id="i_8b" type="text" placeholder="Imagine 1"><br>
                    <input id="i_8c" type="text" placeholder="Imagine 2"><br>
                    <input id="i_8d" type="text" placeholder="Imagine 3"><br>
                    <input id="i_8e" type="text" placeholder="Imagine 4"><br>
                    <input id="i_8f" type="text" placeholder="Imagine 5"><br>
                    <button id="b_8">PUT</button>
                    <button id="c_8" onclick='javascript:$( "#p_8" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#fca130"> [PUT] </font> Adauga o imagine </b><br>
                <div>
                    <p id="p_9"></p>
                    <input id="i_9a" type="text" placeholder="Denumire"><br>
                    <input id="i_9b" type="text" placeholder="Imagine"><br>
                    <input id="i_9c" type="text" placeholder="Eticheta"><br>
                    <button id="b_9">PUT</button>
                    <button id="c_9" onclick='javascript:$( "#p_9" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#fca130"> [PUT] </font> [TOP] Adauga o imagine in top</b><br>
                <div>
                    <p id="p_10"></p>
                    <input id="i_10a" type="text" placeholder="ID Imagine"><br>
                    <button id="b_10">PUT</button>
                    <button id="c_10" onclick='javascript:$( "#p_10" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>

            <!-- POST -->
            <li>
                <b> <font color="#49cc90"> [POST] </font> Modifica o imagine </b><br>
                <div>
                    <p id="p_12"></p>
                    <input id="i_12a" type="text" placeholder="ID Imagine"><br>
                    <input id="i_12b" type="text" placeholder="Denumire"><br>
                    <input id="i_12c" type="text" placeholder="Imagine"><br>
                    <input id="i_12d" type="text" placeholder="Eticheta"><br>
                    <button id="b_12">POST</button>
                    <button id="c_12" onclick='javascript:$( "#p_12" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#49cc90"> [POST] </font> Modifica o colectie </b><br>
                <div>
                    <p id="p_13"></p>
                    <input id="i_13a" type="text" placeholder="ID Imagine"><br>
                    <input id="i_13b" type="text" placeholder="Denumire"><br>
                    <input id="i_13c" type="text" placeholder="Imagine 1"><br>
                    <input id="i_13d" type="text" placeholder="Imagine 2"><br>
                    <input id="i_13e" type="text" placeholder="Imagine 3"><br>
                    <input id="i_13f" type="text" placeholder="Imagine 4"><br>
                    <input id="i_13g" type="text" placeholder="Imagine 5"><br>
                    <button id="b_13">POST</button>
                    <button id="c_13" onclick='javascript:$( "#p_13" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#49cc90"> [POST] </font> Sterge un utilizator</b><br>
                <div>
                    <p id="p_14"></p>
                    <input id="i_14a" type="text" placeholder="ID Utilizator"><br>
                    <button id="b_14">POST</button>
                    <button id="c_14" onclick='javascript:$( "#p_14" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#49cc90"> [POST] </font> Modifica un utilizator </b><br>
                <div>
                    <p id="p_15"></p>
                    <input id="i_15a" type="text" placeholder="ID Utilizator"><br>
                    <input id="i_15b" type="text" placeholder="Username"><br>
                    <input id="i_15c" type="text" placeholder="Email"><br>
                    <input id="i_15d" type="text" placeholder="Password"><br>
                    <button id="b_15">POST</button>
                    <button id="c_15" onclick='javascript:$( "#p_15" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>
            <li>
                <b> <font color="#49cc90"> [POST] </font> [TOP] Voteaza o imagine</b><br>
                <div>
                    <p id="p_11"></p>
                    <input id="i_11a" type="text" placeholder="ID Imagine"><br>
                    <button id="b_11">POST</button>
                    <button id="c_11" onclick='javascript:$( "#p_11" ).html("");'>Clear</button>
                </div>
                <hr><br>
            </li>

        </ol>
    </body>
</html>
