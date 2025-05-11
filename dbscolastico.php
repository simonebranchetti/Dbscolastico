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
        
        echo("errore " . $connessione -> error_list);
        
    }

    else{

        echo("inserimento avvenuto con successo");
        
    }
    
    $statement -> close();
    return $esegui;
    
}

$studenti = "INSERT INTO studenti(nome_studente , cognome_studente ,voti ,data_voto) VALUES (? ,?, ?, ?)";
$dati_studente = ["Luca" , "Rossi" , "8" , "2025-05-11"];
inserimentodati($connessione , $studenti , "ssis" , $dati_studente);



$docenti = "INSERT INTO docenti (nome_docente , cognome_docente , id_materia) VALUES (? , ? , ?)";
$materie = "INSERT INTO materie (nome_materia) VALUES (?)";
$voti = "INSERT INTO voti(id_studente , id_materia , voto) VALUES (? ,?, ?)";