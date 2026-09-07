<?php
session_start();
if (isset($_POST['title']) and isset($_POST['content'])){
    save_note();
    header("Location: index.php");

}
if (isset($_POST['note_id']) && $_POST['action'] == 'delete'){
    delNote($_POST['note_id']);
    header("Location: index.php");
}
if (isset($_POST['action']) and $_POST['action'] == 'edit'){
    if (isset($_SESSION['note'])) unset($_SESSION['note']);
    $note = returnById($_POST['note_id']);
    $_SESSION['note'] = [
        'content' => $note['content'],
        'title' => $note['title'],
        'note_id' => $note['note_id']
    ];
    header("Location: index.php");
}
function decodeJson(){
    return(json_decode(file_get_contents("notes.json"), true));
}
function encodeJson($notes){
    $jsonNotes = json_encode($notes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents("notes.json", $jsonNotes);
}
function returnById($note_id){
    $notes = decodeJson();
    foreach ($notes as $note){
        if ($note['note_id'] == $note_id){
            return $note;
        }
    }
}
function save_note(){
    if (!empty($_POST)) {
        if(file_exists("notes.json")){
            $notes = decodeJson();
            if (!empty($_POST['note_id'])){ # Updates an existing note
                $noteIdColumn = array_column($notes, "note_id"); # Extracts note_id column from $notes
                $noteKey = array_search($_POST['note_id'],$noteIdColumn); # Finds the note index by note_id
                $notes[$noteKey] = [
                    'title' => $_POST['title'],
                    'content' => $_POST['content'],
                    'note_id' => $_POST['note_id']
                ];
            }
            else{ # Creates new note
                $notes[] = [
                    'title' => $_POST['title'],
                    'content' => $_POST['content'],
                    'note_id' => bin2hex(random_bytes(8))
                ];
            }
            $jsonNotes = json_encode($notes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            file_put_contents("notes.json", $jsonNotes);
        }
        else{
            $notes[] = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'note_id' => bin2hex(random_bytes(8))
            ];
            encodeJson($notes);
        }
    }
}
function show_notes(){
    if(file_exists("notes.json")){
        $notes = decodeJson();
        foreach ($notes as $elem){
            $title = htmlspecialchars($elem['title']);
            $content = htmlspecialchars($elem['content']);
            echo " name='action' value='edit'>Редактировать</button>
                </form>
                </div>";
        }
        }
    }
function delNote($id){
    $notes = decodeJson();
    foreach ($notes as $key=>$elem){
        if ($elem['note_id'] == $id){
            unset($notes[$key]);
        }
    }
    encodeJson($notes);

}
