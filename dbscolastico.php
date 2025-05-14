<?php

$host = "127.0.0.1";
$user = "root";
$password = "";
$database = "dbscolastico";

$connessione = new mysqli($host , $user , $password , $database);

if($connessione == true){

    echo("connessione riuscita " . $connessione -> host_info);

}

else{

    echo("connessione non riuscita " . $connessione -> error_list);

}

/*funzione per automizzare l'inserimento dati,
si crea una funzione che richiede dei parametri ovvero:
una connessione al database, una query, il tipo dei dati e i parametri.
*/
function inserimentodati($connessione , $query , $tipo , $parametri){

    $statement = $connessione -> prepare($query);
    
    if($statement == false ){
        
        die("errore " . $connessione -> error_list);
        
    }
    
    $statement -> bind_param($tipo , ... $parametri); //... serve a spillatare l'array
    
    $esegui = $statement -> execute();
    
    if($esegui == false){
        
        echo("errore " . $connessione -> error_list . "\n");
        
    }

    else{

        echo("inserimento avvenuto con successo \n");
        
    }
    
    $statement -> close();
    return $esegui;
    
}

$studenti = "INSERT INTO studenti(nome_studente , cognome_studente ,voti ,data_voto , classe) VALUES (? ,?, ?, ? , ?)";
// $dati_studente = ["Luca" , "Rossi" , "8" , "2025-05-11"];
// $dati_studente2 = ["Mario" , "Bianchi" , "7" , "2025-05-11"];

// inserimentodati($connessione , $studenti , "ssis" , $dati_studente);
// inserimentodati($connessione , $studenti , "ssis" , $dati_studente2);

$materie = "INSERT INTO materie (nome_materia) VALUES (?)";
// $materia1 = ["Italiano"];
// inserimentodati($connessione , $materie , "s" , $materia1);

$docenti = "INSERT INTO docenti (nome_docente , cognome_docente , id_materia) VALUES (? , ? , ?)";
// $dati_prof = ["Luigi" , "Verdi" , "1"];
// inserimentodati($connessione , $docenti , "ssi" , $dati_prof);

$voti = "INSERT INTO voti(id_studente , id_materia , voto) VALUES (? ,?, ?)";
// $voto1 = ["1","1","8"];
// inserimentodati($connessione , $voti , "iii" , $voto1);


$query1 = "SELECT nome_studente , cognome_studente , classe FROM studenti WHERE classe LIKE '5%'  ";


if($result = $connessione -> query($query1)){

    if($result -> num_rows > 0){

        echo '<table>
        <thead>
        <tr>
        <th>nome</th>
        <th>cognome</th>
        <th>classe</th>
        </tr></thead><tbody>';

    }

    while ($row = $result -> fetch_array()){

            echo '<tr>
            <td>'. $row['nome_studente'] .'</td>
            <td>'. $row['cognome_studente']. '</td>
            <td>'. $row['classe'] . '</td>
            </tr>';
            
        }

        echo '</tbody> </table>';

}

else{

    echo("errore " . $connessione -> error_list);

}

$id_studente = 1;

$query2 = "SELECT voti FROM studenti WHERE id_studente = $id_studente ";

if($result = $connessione -> query($query2)){

    if($result -> num_rows > 0){

        echo '<table>
        <thead>
        <tr>
        <th>voti</th>
        </tr></thead><tbody>';

    }

    while ($row = $result -> fetch_array()){

            echo '<tr>
            <td>'. $row['voti'] .'</td>
            </tr>';
            
        }

        echo '</tbody> </table>';

}

else{

    echo("errore " . $connessione -> error_list);

}

$id_docente = 2;

$query3 = "SELECT id_docente , nome_docente , cognome_docente FROM docenti WHERE id_docente = $id_docente";

if($result = $connessione -> query($query3)){

    if($result -> num_rows > 0){

        echo '<table>
        <thead>
        <tr>
        <th>id_docente</th>
        <th>nome_docente</th>
        <th>cognome_docente</th>
        </tr></thead><tbody>';

    }

    while ($row = $result -> fetch_array()){

            echo '<tr>
            <td>'. $row['id_docente'] .'</td>
            <td>'. $row['nome_docente'] .'</td>
            <td>'. $row['cognome_docente'] .'</td>
            </tr>';
            
        }

        echo '</tbody> </table>';

}

else{

    echo("errore " . $connessione -> error_list);

}

$id_materia = 1;

$query4 = "SELECT id_docente , nome_docente , cognome_docente , nome_materia , docenti.id_materia FROM docenti INNER JOIN materie
ON materie.id_materia = docenti.id_materia
WHERE docenti.id_materia = $id_materia";

if($result = $connessione -> query($query4)){

    if($result -> num_rows > 0){

        echo '<table>
        <thead>
        <tr>
        <th>id_docente</th>
        <th>nome_docente</th>
        <th>cognome_docente</th>
        <th>nome_materia</th>
        <th>id_materia</th>
        </tr></thead><tbody>';

    }

    while ($row = $result -> fetch_array()){

            echo '<tr>
            <td>'. $row['id_docente'] .'</td>
            <td>'. $row['nome_docente'] .'</td>
            <td>'. $row['cognome_docente'] .'</td>
            <td>'. $row['nome_materia'] .'</td>
            <td>'. $row['id_materia'] .'</td>
            </tr>';
            
        }

        echo '</tbody> </table>';

}

else{

    echo("errore " . $connessione -> error_list);

}

$query5 = "SELECT studenti.id_studente , studenti.nome_studente , studenti.cognome_studente , studenti.classe , materie.nome_materia , studenti.voti
FROM studenti
INNER JOIN voti ON studenti.id_studente = voti.id_studente
INNER JOIN materie ON materie.id_materia = voti.id_materia
WHERE studenti.voti < 5";

if($result = $connessione -> query($query5)){

    if($result -> num_rows > 0){

        echo '<table>
        <thead>
        <tr>
        <th>id_studente</th>
        <th>nome_studente</th>
        <th>cognome_studente</th>
        <th>classe</th>
        <th>nome_materia</th>
        <th>voti</th>
        </tr></thead><tbody>';

    }

    while ($row = $result -> fetch_array()){

            echo '<tr>
            <td>'. $row['id_studente'] .'</td>
            <td>'. $row['nome_studente'] .'</td>
            <td>'. $row['cognome_studente'] .'</td>
            <td>'. $row['classe'] .'</td>
            <td>'. $row['nome_materia'] .'</td>
            <td>'. $row['voti'] .'</td>
            </tr>';
            
        }

        echo '</tbody> </table>';

}

else{

    echo("errore " . $connessione -> error_list);

}

$query6 = "ALTER TABLE studenti DROP COLUMN voti";

if($connessione -> query($query6)){

    echo("ok");

}

else{

    echo("non ok");
}
