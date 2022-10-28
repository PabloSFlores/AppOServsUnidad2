<?php
//Flores Santana Pablo Samuel 4° "A" DSM
header('Content-Type:application/json');
$metodo = $_SERVER["REQUEST_METHOD"];
switch ($metodo) {
    case 'GET':
        if ($_GET['accion'] == 'personaje') {
            try {
                $conn = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            if (isset($_GET['id'])) {
                $pstm = $conn->prepare("SELECT p.*,m.*,t.* FROM personaje p LEFT JOIN magia m ON p.magia_id = m.m_id 
                LEFT JOIN tipo_lucha t ON p.tipo_lucha_id = t.t_id WHERE p.p_id = :id");
                $pstm->bindParam(':id', $_GET['id']);
                $pstm->execute();
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
                if ($rs != null) {
                    echo json_encode($rs[0], JSON_PRETTY_PRINT);
                } else {
                    echo "No se encontraron coincidencias.";
                }
            } else {
                $pstm = $conn->prepare("SELECT p.*,m.*,t.* FROM personaje p LEFT JOIN magia m ON p.magia_id = m.m_id 
                LEFT JOIN tipo_lucha t ON p.tipo_lucha_id = t.t_id");
                $pstm->execute();
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
                if ($rs != null) {
                    echo json_encode($rs, JSON_PRETTY_PRINT);
                } else {
                    echo "No hay registros.";
                }
            }
        }

        if ($_GET['accion'] == 'magia') {
            try {
                $conn = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            if (isset($_GET['id'])) {
                $pstm = $conn->prepare("SELECT * FROM magia WHERE m_id = :id");
                $pstm->bindParam(':id', $_GET['id']);
                $pstm->execute();
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
                if ($rs != null) {
                    echo json_encode($rs[0], JSON_PRETTY_PRINT);
                } else {
                    echo "No se encontraron coincidencias.";
                }
            } else {
                $pstm = $conn->prepare("SELECT * FROM magia");
                $pstm->execute();
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
                if ($rs != null) {
                    echo json_encode($rs, JSON_PRETTY_PRINT);
                } else {
                    echo "No hay registros.";
                }
            }
        }

        if ($_GET['accion'] == 'lucha') {
            try {
                $conn = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            if (isset($_GET['id'])) {
                $pstm = $conn->prepare("SELECT * FROM tipo_lucha WHERE t_id = :id");
                $pstm->bindParam(':id', $_GET['id']);
                $pstm->execute();
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
                if ($rs != null) {
                    echo json_encode($rs[0], JSON_PRETTY_PRINT);
                } else {
                    echo "No se encontraron coincidencias.";
                }
            } else {
                $pstm = $conn->prepare("SELECT * FROM tipo_lucha");
                $pstm->execute();
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
                if ($rs != null) {
                    echo json_encode($rs, JSON_PRETTY_PRINT);
                } else {
                    echo "No hay registros.";
                }
            }
        }
        break;
    case 'POST':
        if ($_GET['accion'] == 'personaje') {
            $json_data = json_decode(file_get_contents('php://input'));
            try {
                $conn = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $pstm = $conn->prepare("INSERT INTO personaje (p_name,lastname,birthday,utiliza_magia,
            estatura,peso,equipo,magia_id,tipo_lucha_id) VALUES (:p_name,:lastname,:birthday,:utiliza_magia,
            :estatura,:peso,:equipo,:magia_id,:tipo_lucha_id)");
            $pstm->bindParam(':p_name', $json_data->p_name);
            $pstm->bindParam(':lastname', $json_data->lastname);
            $pstm->bindParam(':birthday', $json_data->birthday);
            $pstm->bindParam(':utiliza_magia', $json_data->utiliza_magia);
            $pstm->bindParam(':estatura', $json_data->estatura);
            $pstm->bindParam(':peso', $json_data->peso);
            $pstm->bindParam(':equipo', $json_data->equipo);
            $pstm->bindParam(':magia_id', $json_data->magia_id);
            $pstm->bindParam(':tipo_lucha_id', $json_data->tipo_lucha_id);
            $rs = $pstm->execute();
            if ($rs) {
                $_POST['error'] = false;
                $_POST['message'] = "Personaje registrado correctamente";
                $_POST['status'] = 200;
            } else {
                $_POST['error'] = true;
                $_POST['message'] = "Error al registrar Personaje";
                $_POST['status'] = 400;
            }

            echo json_encode($_POST);
        }
        break;
    case 'PUT':
        if ($_GET['accion'] == 'personaje') {
            $json_data = json_decode(file_get_contents('php://input'));
            try {
                $conn = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $pstm = $conn->prepare("UPDATE personaje SET p_name=:p_name,lastname=:lastname,birthday=:birthday,
                utiliza_magia=:utiliza_magia,estatura=:estatura,peso=:peso,equipo=:equipo,
                magia_id=:magia_id,tipo_lucha_id=:tipo_lucha_id where p_id = :id");
            $pstm->bindParam(':p_name', $json_data->p_name);
            $pstm->bindParam(':lastname', $json_data->lastname);
            $pstm->bindParam(':birthday', $json_data->birthday);
            $pstm->bindParam(':utiliza_magia', $json_data->utiliza_magia);
            $pstm->bindParam(':estatura', $json_data->estatura);
            $pstm->bindParam(':peso', $json_data->peso);
            $pstm->bindParam(':equipo', $json_data->equipo);
            $pstm->bindParam(':magia_id', $json_data->magia_id);
            $pstm->bindParam(':tipo_lucha_id', $json_data->tipo_lucha_id);
            $pstm->bindParam(':id', $json_data->p_id);
            $rs = $pstm->execute();
            if ($rs) {
                echo "Exito al actualizar. Code: ", $rs;
            } else {
                echo "Error al actualizar. Code: ", $rs;
            }
        }
        break;
    case 'DELETE':
        if ($_GET['accion'] == 'personaje') {
            $id = $_GET['id'];
            try {
                $conn = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $pstm = $conn->prepare("DELETE FROM personaje WHERE p_id = :id");
            $pstm->bindParam(':id', $id);
            $rs = $pstm->execute();;
            if ($rs) {
                echo "Eliminado con exito";
            } else {
                echo "No se encontraron coincidencias.";
            }
        }
        break;
    default:
        echo "Metodo no soportado";
        break;
}
