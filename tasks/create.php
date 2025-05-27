<?php
include("../includes/dbcon.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'):
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $status = isset($_POST['status']) && $_POST['status'] ? 1 : 0;

    $sql = "INSERT INTO tasks (title, description, status) VALUES ('$title', '$description', $status)";

    if ($conn->query($sql)):
        $success_message = "Inserted successfully.";
    else:
        $error_message = "Error: " . $conn->error;
    endif;

    $conn->close();
    // exit;

endif;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>To-Do List Application</title>
</head>

<body>

    <div class="container m-5">
        <h1 class="text-center">To-Do List Application</h1>
        <p class="text-center text-decoration-underline">Create Page</p>
        <a href="./../index.php" class="btn btn-primary">All Tasks</a>

        <!-- Success Message -->
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($success_message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

        <form method="POST" id="createForm">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"
                    placeholder="Enter description"></textarea>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="status" name="status">
                <label class="form-check-label" for="status">Completion Status</label>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $("createForm").submit(function (event) {
                
                event.preventDefault();
                var formData = JSON.stringify({
                    title: $("#title").val(),
                    description: $("#description").val(),
                    status: $("#status").val(),
                });

                $.ajax({
                    type: "POST",
                    url: "create.php",
                    contentType: "application/json",
                    data: formData,
                    // encode: true,
                    success: function(data){
                        console.log(data);
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });
        });
    </script>
</body>

</html>