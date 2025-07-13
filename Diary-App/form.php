<?php

require __DIR__ . '/inc/db-connect.php';
require __DIR__ . '/inc/functions.php';

if(isset($_POST) && !empty($_POST)) {

    if(!empty($_FILES) && !empty($_FILES['image'])) {
        if ($_FILES['image']['error'] === 0 && $_FILES['image']['size'] !== 0) {
            $targetDir = __DIR__ . '/uploads/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            $check = getimagesize($_FILES['image']['tmp_name']);
            if($check === false) {
                echo 'File is not an image.';
                exit;
            }

            $allowedExtentions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if(!in_array($imageFileType, $allowedExtentions)) {
                echo "Only JPG, JPEG, PNG, GIF & WEBP files are allowed.";
                exit;
            }

            // MIME check
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
            finfo_close($finfo);

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($mime, $allowedMimeTypes)) {
                echo "MIME type not allowed.";
                exit;
            }

            // Generate a unique file name
            $uniqueName = uniqid('img_', true) . '.' . $imageFileType;
            $targetFile = $targetDir . $uniqueName;

            // Resize image if needed
            [$width, $height] = getimagesize($_FILES['image']['tmp_name']);
            $maxDim = 512;

            if ($width > $maxDim || $height > $maxDim) {
                switch ($mime) {
                    case 'image/jpeg': $src = imagecreatefromjpeg($_FILES['image']['tmp_name']); break;
                    case 'image/png': $src = imagecreatefrompng($_FILES['image']['tmp_name']); break;
                    case 'image/gif': $src = imagecreatefromgif($_FILES['image']['tmp_name']); break;
                    case 'image/webp': $src = imagecreatefromwebp($_FILES['image']['tmp_name']); break;
                    default:
                        echo "Unsupported image format.";
                        exit;
                }

                $ratio = $width / $height;
                if ($ratio > 1) {
                    $newWidth = $maxDim;
                    $newHeight = $maxDim / $ratio;
                } else {
                    $newHeight = $maxDim;
                    $newWidth = $maxDim * $ratio;
                }

                $tmp = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                switch ($mime) {
                    case 'image/jpeg': imagejpeg($tmp, $targetFile); break;
                    case 'image/png': imagepng($tmp, $targetFile); break;
                    case 'image/gif': imagegif($tmp, $targetFile); break;
                    case 'image/webp': imagewebp($tmp, $targetFile); break;
                }

                imagedestroy($src);
                imagedestroy($tmp);

                echo "Image was resized and uploaded as " . htmlspecialchars($uniqueName);
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    echo "The file " . htmlspecialchars(string: $uniqueName) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }



    $title = (string) (e($_POST['title']) ?? '');
    $date = (string) (e($_POST['date']) ?? '');
    $message = (string) (e($_POST['message']) ?? '');

    $stmt = $pdo->prepare('INSERT INTO entries (`title`, `date`, `message`, `image`) VALUES (:title, :date, :message, :image)');
    $stmt->bindValue('title', $title);
    $stmt->bindValue('date', $date);
    $stmt->bindValue('message', $message);
    $stmt->bindValue('image', $uniqueName ?? null);

    $stmt->execute();

    header('Location: index.php');
}

?>

<?php require __DIR__ . '/views/header.php'; ?>

<h1 class="main-heading">Entries</h1>

<form method="POST" action="form.php" enctype="multipart/form-data">
    <div class="form-group">
        <label for="entry-title" class="form-label">Title:</label>
        <input type="text" id="entry-title" name="title" class="form-input" required>
    </div>
    <div class="form-group">
        <label for="entry-date" class="form-label">Date:</label>
        <input type="date" id="entry-date" name="date" class="form-input" required>
    </div>
    <div class="form-group">
        <label for="image" class="form-label">Image:</label>
        <input type="file" id="image" name="image" class="form-input">
    </div>
    <div class="form-group">
        <textarea id="message" name="message" class="form-textarea" rows="15" required></textarea>
    </div>

    <div class="form-submit">
        <button type="submit" class="button">
            <img src="images/send.svg" alt="Save" class="button-icon">
            Save
        </button>
    </div>
</form>

<?php require __DIR__ . '/views/footer.php'; ?>
