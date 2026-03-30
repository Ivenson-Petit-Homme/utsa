<?php
// Aktive rapò erè pou nou ka wè sa k ap pase
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nou verifye si tout done yo voye
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $study_level = isset($_POST['study_level']) ? $_POST['study_level'] : '';
    $faculty = isset($_POST['faculty']) ? $_POST['faculty'] : '';
    $motivation = isset($_POST['motivation']) ? $_POST['motivation'] : '';

    // Jesyon dosye "uploads" la
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            die("Erreur : Impossible de créer le dossier 'uploads'. Vérifiez les permissions.");
        }
    }

    // Jesyon Pièce d'Identité
    $id_card_path = "";
    if (isset($_FILES['id_card']) && $_FILES['id_card']['error'] == 0) {
        $id_card_path = $upload_dir . time() . "_id_" . basename($_FILES['id_card']['name']);
        if (!move_uploaded_file($_FILES['id_card']['tmp_name'], $id_card_path)) {
            $id_card_path = ""; // Si sa pa mache
        }
    }

    // Jesyon Relevé de Notes
    $transcript_path = "";
    if (isset($_FILES['transcript']) && $_FILES['transcript']['error'] == 0) {
        $transcript_path = $upload_dir . time() . "_transcript_" . basename($_FILES['transcript']['name']);
        if (!move_uploaded_file($_FILES['transcript']['tmp_name'], $transcript_path)) {
            $transcript_path = ""; // Si sa pa mache
        }
    }

    // Insertion nan baz done a
    try {
        $sql = "INSERT INTO admissions (last_name, first_name, email, phone, study_level, faculty, id_card_path, transcript_path, motivation) 
                VALUES (:last_name, :first_name, :email, :phone, :study_level, :faculty, :id_card_path, :transcript_path, :motivation)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':last_name' => $last_name,
            ':first_name' => $first_name,
            ':email' => $email,
            ':phone' => $phone,
            ':study_level' => $study_level,
            ':faculty' => $faculty,
            ':id_card_path' => $id_card_path,
            ':transcript_path' => $transcript_path,
            ':motivation' => $motivation
        ]);

        // Mesaj siksè
        echo "<script>
                alert('Félicitations ! Votre candidature a été soumise avec succès.');
                window.location.href = 'index.html';
              </script>";
    } catch (\PDOException $e) {
        // Si gen yon erè, n ap afiche l pi byen
        die("Erreur MySQL : " . $e->getMessage() . "<br>Asire w ke ou te kreye baz done a ak tablo 'admissions' an.");
    }
} else {
    // Si yon moun vle aksede dosye a dirèkteman
    header("Location: admission.html");
    exit();
}
?>