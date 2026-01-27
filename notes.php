<?php
if (isset($_POST['title']) and isset($_POST['content'])){
    save_note();
    header("Location: index.php");

}
if (isset($_POST['note_id']) && $_POST['action'] == 'delete'){
    delNote($_POST['note_id']);
    header("Location: index.php");
}
if (isset($_POST['action']) and $_POST['action'] == 'edit'){
    $editableNote = [
        'content' => $_POST['content'],
        'title' => $_POST['title'],
        'note_id' => $_POST['note_id']
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
function showById($notes, $note_id){
    echo $notes[array_search($note_id, array_column($notes, 'note_id',))]['note_id'];
}
function save_note(){
    if (isset($_POST)) {
        if(file_exists("notes.json")){
            $notes = decodeJson();
            $notes[] = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'note_id' => $_POST['note_id'] ?? bin2hex(random_bytes(8))
            ];
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
            echo "<div class=\"note\">
                <h2>{$elem['title']}</h2>
                <p>{$elem['content']}</p>
                <form action=\"notes.php\" method=\"post\">
                <input type=\"hidden\" name=\"note_id\" value=\"{$elem['note_id']}\">
                <button type=\"submit\" name='action' value='delete'>Удалить</button>
                <button type=\"submit\" name='action' value='edit'>Редактировать</button>
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
