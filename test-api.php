<?PHP
	
	require 'vendor/autoload.php';

	use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    function dbCon(){
        $servername = "localhost";
        $username = "phpmyadmin";
        $password = "TestAutomation01";
        $dbname = "pw_tables";

        return new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    }

	
	$app = new \Slim\App();
	
	   /* Home */
    $app->get('/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Home Page ");
        return $response;
    });

    /* Afisarea etichetelor disponibile */
    $app->get('/etichete', function (Request $request, Response $response, array $args) {
        $array = array(
            "lista" => array(),
        );

        $stmt = dbCon()->query("SELECT * FROM etichete;");
        while ($row = $stmt->fetch()) {
            array_push($array["lista"], array($row['id'], $row['sName']));
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });
    
	/* Afisarea imaginile disponibile */
    $app->get('/imagini', function (Request $request, Response $response, array $args) {
        $array = array(
            "lista" => array(),
        );

        $stmt = dbCon()->query("SELECT * FROM imagini;");
        while ($row = $stmt->fetch()) {
            array_push($array["lista"], array($row['id'], $row['sName'], $row['sUrl'], $row['sEticheta']));
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });
    
	/* Obtine lista de imagini dintr-o colectie */
    $app->get('/imagini/colectie/{id}', function (Request $request, Response $response, array $args) {
		$colectia = $args['id'];
        $array = array(
            "colectie" => array($colectia),
            "lista" => array(),
        );

        $stmt = dbCon()->query("SELECT * FROM colectii WHERE id = '".$colectia."';");
        while ($row = $stmt->fetch()) {
            array_push($array["lista"], array($row['id'], $row['sName'], $row['img1'], $row['img2'], $row['img3'], $row['img4'], $row['img5']));
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });
	
	/* Obtine lista de etichete pentru o colectie */
    $app->get('/etichete/colectie/{id}', function (Request $request, Response $response, array $args) {
		$colectia = $args['id'];
        $array = array(
            "lista" => array(),
        );

        $stmt = dbCon()->query("SELECT * FROM etichete;");
        while ($row = $stmt->fetch()) {
            array_push($array["lista"], array($row['id'], $row['sName']));
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });
	
	/* Obtine lista de etichete pentru o imagine */
    $app->get('/etichete/imagine/{id}', function (Request $request, Response $response, array $args) {
		$imagine = $args['id'];
		$array = array(
            "imagine" => array($imagine),
            "lista" => array(),
        );

        $stmt = dbCon()->query("SELECT * FROM imagini WHERE id = '".$imagine."';");
        while ($row = $stmt->fetch()) {
            array_push($array["lista"], $row['sEticheta']);
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });
	
	/* Afiseaza informatii despre imagine */
    $app->get('/imagine/{id}', function (Request $request, Response $response, array $args) {
		$imagine = $args['id'];
		$array = array(
            "imagine" => array($imagine),
            "name" => array(),
            "url" => array(),
            "etichete" => array(),
        );

        $stmt = dbCon()->query("SELECT * FROM imagini WHERE id = '".$imagine."';");
        while ($row = $stmt->fetch()) {
            array_push($array["url"], $row['sUrl']);
            array_push($array["name"], $row['sName']);
            array_push($array["etichete"], $row['sEticheta']);
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });
    
    // Afiseaza toup imaginilor  /top/{id}
    $app->get('/top/{id}', function (Request $request, Response $response, array $args) {
		$id = $args['id'];
		$array = array(
            "id" => array($id),
            "lista" => array(),
        );

        $stmt = dbCon()->query("SELECT * FROM topimg ORDER BY iVoturi DESC LIMIT ".$id.";");
        while ($row = $stmt->fetch()) {
            array_push($array["lista"], array($row['id'], $row['sUrl'], $row['iVoturi']));
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });

    // PUT 

    /* Adauga un utilizator nou */
    $app->put('/adauga/utilizator', function (Request $request, Response $response, array $args) {
        $allPostPutVars = $request->getParsedBody();
        $username = $allPostPutVars['username'];
        $email = $allPostPutVars['email'];
        $password = $allPostPutVars['password'];

        $array = array(
            "status" => "OK",
            "msg" => "",
        );
        
        try {
            $conn = dbCon();
            $sql = "INSERT INTO users SET sName = '".$username."', sEmail = '".$email."', sPass = '".$password."'; ";
            $conn->exec($sql);
            
            $array["msg"] = "Contul a fost inregistrat.";

        }catch(PDOException $e){
            $array["status"] = "ERROR";
            $array["msg"] = $e->getMessage();
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });

    /* Adauga o eticheta noua */
    $app->put('/adauga/eticheta', function (Request $request, Response $response, array $args) {
        $allPostPutVars = $request->getParsedBody();
        $name = $allPostPutVars['name'];

        $array = array(
            "status" => "OK",
            "msg" => "",
        );

        try {
            $conn = dbCon();
            $sql = "INSERT INTO etichete SET sName = '".$name."'; ";
            $conn->exec($sql);
            
            $array["msg"] = "Eticheta a fost adaugata cu succes.";

        }catch(PDOException $e){
            $array["status"] = "ERROR";
            $array["msg"] = $e->getMessage();
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });

	/* Adauga o colectie */
    $app->put('/adauga/colectie', function (Request $request, Response $response, array $args) {
        $allPostPutVars = $request->getParsedBody();
        $name = $allPostPutVars['name'];
        $img1 = $allPostPutVars['img1'];
        $img2 = $allPostPutVars['img2'];
        $img3 = $allPostPutVars['img3'];
        $img4 = $allPostPutVars['img4'];
        $img5 = $allPostPutVars['img5'];

        $array = array(
            "status" => "OK",
            "msg" => "",
        );
        
        try {
            $conn = dbCon();
            $sql = "INSERT INTO colectii SET sName = '".$name."', img1 = '".$img1."', img2 = '".$img2."', img3 = '".$img3."', img4 = '".$img4."', img5 = '".$img5."'; ";
            $conn->exec($sql);
            
            $array["msg"] = "Colectia a fost adaugata cu succes.";

        }catch(PDOException $e){
            $array["status"] = "ERROR";
            $array["msg"] = $e->getMessage();
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });
    
	/* Adauga imagine */
    $app->put('/adauga/imagine', function (Request $request, Response $response, array $args) {
        $allPostPutVars = $request->getParsedBody();
        $name = $allPostPutVars['name'];
        $url = $allPostPutVars['url'];
        $etichete = $allPostPutVars['etichete'];
        
        $array = array(
            "status" => "OK",
            "msg" => "",
        );

        try {
            $conn = dbCon();
            $sql = "INSERT INTO imagini SET sName = '".$name."', sUrl = '".$url."', sEticheta = '".$etichete."'; ";
            $conn->exec($sql);
            
            $array["msg"] = "Imaginea a fost adaugata cu succes.";

        }catch(PDOException $e){
            $array["status"] = "ERROR";
            $array["msg"] = $e->getMessage();
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });
	
    /* Adauga o imagine in top */
    $app->put('/top/add', function (Request $request, Response $response, array $args) {
        $allPostPutVars = $request->getParsedBody();
        $id = $allPostPutVars['id'];
        
        $array = array(
            "status" => "OK",
            "msg" => "",
        );

        try {
            $conn = dbCon();
            $sql = "INSERT INTO topimg SET sUrl = '".$id."'; ";
            $conn->exec($sql);
            
            $array["msg"] = "Imaginea a fost adaugata in top.";

        }catch(PDOException $e){
            $array["status"] = "ERROR";
            $array["msg"] = $e->getMessage();
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });

    // POST
    
    /* Adauga eticheta la imagine */
    $app->post('/modifica/imagine/{id_imagine}', function (Request $request, Response $response, array $args) {
        $id_imagine = $args['id_imagine'];
        $allPostPutVars = $request->getParsedBody();
        $name = $allPostPutVars['name'];
        $url = $allPostPutVars['url'];
        $eticheta = $allPostPutVars['eticheta'];

        $array = array(
            "status" => "OK",
            "msg" => "",
        );
        
        try {
            $conn = dbCon();
            $sql = "UPDATE imagini SET sName = '".$name."', sUrl = '".$url."', sEticheta = '".$eticheta."' WHERE id = '".$id_imagine."'; ";
            $conn->exec($sql);
            
            $array["msg"] = "Imaginea a fost actualizata.";

        }catch(PDOException $e){
            $array["status"] = "ERROR";
            $array["msg"] = $e->getMessage();
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });
	
    /* Modica o colectie */
    $app->post('/modifica/colectie/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];
        $allPostPutVars = $request->getParsedBody();
        $name = $allPostPutVars['name'];
        $img1 = $allPostPutVars['img1'];
        $img2 = $allPostPutVars['img2'];
        $img3 = $allPostPutVars['img3'];
        $img4 = $allPostPutVars['img4'];
        $img5 = $allPostPutVars['img5'];

        $array = array(
            "status" => "OK",
            "msg" => "",
        );
        
        try {
            $conn = dbCon();
            $sql = "UPDATE colectii SET sName = '".$name."', img1 = '".$img1."', img2 = '".$img2."', img3 = '".$img3."', img4 = '".$img4."', img5 = '".$img5."' WHERE id = '".$id."'; ";
            $conn->exec($sql);
            
            $array["msg"] = "Colectia a fost actualizata.";

        }catch(PDOException $e){
            $array["status"] = "ERROR";
            $array["msg"] = $e->getMessage();
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });

	/* Sterge un utilizator */
    $app->post('/delete/utilizator/{id}', function (Request $request, Response $response, array $args) {
		$id = $args['id'];

        $array = array(
            "status" => "OK",
            "msg" => "",
        );
        
        try {
            $conn = dbCon();
            $sql = "DELETE FROM users WHERE id = '".$id."'; ";
            $conn->exec($sql);
            
            $array["msg"] = "Utilizatorul a fost sters.";

        }catch(PDOException $e){
            $array["status"] = "ERROR";
            $array["msg"] = $e->getMessage();
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });

	/* Modifica un utilizator */
    $app->post('/modifica/utilizator/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];
        $allPostPutVars = $request->getParsedBody();
        $username = $allPostPutVars['username'];
        $email = $allPostPutVars['email'];
        $password = $allPostPutVars['password'];

        $array = array(
            "status" => "OK",
            "msg" => "",
        );
        
        try {
            $conn = dbCon();
            $sql = "UPDATE users SET sName = '".$username."', sEmail = '".$email."', sPass = '".$password."' WHERE id = '".$id."'; ";
            $conn->exec($sql);
            
            $array["msg"] = "Contul a fost actualizata.";

        }catch(PDOException $e){
            $array["status"] = "ERROR";
            $array["msg"] = $e->getMessage();
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });

    /* Voteaza o imagine */
    $app->post('/top/vote/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];

        $array = array(
            "status" => "OK",
            "msg" => "",
        );
        
        try {
            $conn = dbCon();
            $sql = "UPDATE topimg SET iVoturi = iVoturi + 1 WHERE id = '".$id."'; ";
            $conn->exec($sql);
            
            $array["msg"] = "Ai adaugat un vot la imagine.";

        }catch(PDOException $e){
            $array["status"] = "ERROR";
            $array["msg"] = $e->getMessage();
        }

        $response->getBody()->write(json_encode($array));
        return $response;
    });
	$app->run();
?>
