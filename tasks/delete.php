<?php
include "./../includes/dbcon.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'):
    if(isset($_POST['id'])){
        $id = filter_input(INPUT_POST, $_POST['id'], FILTER_VALIDATE_INT);
    }else {
        echo json_encode(['success' => false, 'message' => 'No ID supplied']);
        // exit;
    }

    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" for integer
    $stmt->execute();
    

    if ($stmt->execute()):
        echo json_encode(['success' => true, 'message'=> 'Deleted successfully']);
    else:
        $error_message = "Error: " . $conn->error;
        echo json_encode(["success"=> false,"error"=> $error_message]);
    endif;

    $conn->close();
    // exit;

endif;
?>