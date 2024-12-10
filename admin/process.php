<?php
session_start();
include "../connection.php";
if (!isset($_SESSION['AdminId']) || !isset($_SESSION['Email'])) {
    header('Location: index.php');
    exit;
}

// Fetch admin data
if (isset($_SESSION['AdminId'])) {
    $AdminId = $_SESSION['AdminId'];
    $query = "SELECT * FROM admin WHERE AdminId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $AdminId);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $Profilepic = $admin['Profilepic'] ? $admin['Profilepic'] : 'img/default-user.jpg';
}

$query = "SELECT * FROM process WHERE Processid = 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$processData = $result->fetch_assoc();

// If no data exists, set default values
if (!$processData) {
    $processData = [
        'Homeimg' => '',
        'weltext1' => '',
        'weltext2' => '',
        'subtext1' => '',
        'subtext2' => '',
        'subtext3' => '',
        'subtext4' => '',
        'subtext5' => '',
        'subtext6' => '',
        'popdes1' => '',
        'popdes2' => '',
        'popdes3' => '',
        'popdes4' => '',
        'Choose' => '',
        'Pay' => '',
        'Fly' => ''
    ];
}

function uploadImage($file) {
    $uploadDir = __DIR__ . '/process/';
    
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            throw new Exception('Failed to create upload directory.');
        }
    }

    if (!is_writable($uploadDir)) {
        throw new Exception('Upload directory is not writable.');
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('Invalid file type. Only JPG, PNG and GIF allowed.');
    }
    
    $maxSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        throw new Exception('File too large. Maximum size is 5MB.');
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_homeimg.' . $extension;
    $targetPath = $uploadDir . $filename;
    
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception('Failed to upload file.');
    }
    
    return 'process/' . $filename;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn->begin_transaction();

        // Fetch current data
        $stmt = $conn->prepare("SELECT * FROM process WHERE Processid = 1");
        $stmt->execute();
        $currentData = $stmt->get_result()->fetch_assoc();

        // Image update checks
        $imageUpdates = [
            'Homeimg' => isset($_FILES['Homeimg']) && $_FILES['Homeimg']['error'] === UPLOAD_ERR_OK,
            'popdes1' => isset($_FILES['popdes1']) && $_FILES['popdes1']['error'] === UPLOAD_ERR_OK,
            'popdes2' => isset($_FILES['popdes2']) && $_FILES['popdes2']['error'] === UPLOAD_ERR_OK,
            'popdes3' => isset($_FILES['popdes3']) && $_FILES['popdes3']['error'] === UPLOAD_ERR_OK,
            'popdes4' => isset($_FILES['popdes4']) && $_FILES['popdes4']['error'] === UPLOAD_ERR_OK
        ];

        // Process image updates
        $newImages = [];
        foreach ($imageUpdates as $field => $isUpdated) {
            if ($isUpdated) {
                $newImages[$field] = uploadImage($_FILES[$field]);
                
                // Delete old image if exists
                if (!empty($currentData[$field])) {
                    $oldImagePath = __DIR__ . '/' . $currentData[$field];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            } else {
                $newImages[$field] = $currentData[$field];
            }
        }

        // Update image fields
        $update_sql = "UPDATE process SET 
            Homeimg = ?, 
            popdes1 = ?, 
            popdes2 = ?, 
            popdes3 = ?, 
            popdes4 = ? 
            WHERE Processid = 1";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssss", 
            $newImages['Homeimg'], 
            $newImages['popdes1'], 
            $newImages['popdes2'], 
            $newImages['popdes3'], 
            $newImages['popdes4']
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Error updating images: " . $conn->error);
        }

        // Text update checks
        $textUpdates = [
            'weltext1', 'weltext2', 
            'subtext1', 'subtext2', 'subtext3', 'subtext4', 'subtext5', 'subtext6',
            'Choose', 'Pay', 'Fly'
        ];

        $updateValues = [];
        $updateNeeded = false;
        foreach ($textUpdates as $field) {
            $value = isset($_POST[$field]) ? trim($_POST[$field]) : $currentData[$field];
            $updateValues[$field] = $value;
            
            if ($value !== $currentData[$field]) {
                $updateNeeded = true;
            }
        }

        // Update text fields if needed
        if ($updateNeeded) {
            $update_sql = "UPDATE process SET 
                weltext1 = ?, weltext2 = ?, 
                subtext1 = ?, subtext2 = ?, subtext3 = ?, 
                subtext4 = ?, subtext5 = ?, subtext6 = ?,
                Choose = ?, Pay = ?, Fly = ? 
                WHERE Processid = 1";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("sssssssssss", 
                $updateValues['weltext1'], $updateValues['weltext2'],
                $updateValues['subtext1'], $updateValues['subtext2'], $updateValues['subtext3'],
                $updateValues['subtext4'], $updateValues['subtext5'], $updateValues['subtext6'],
                $updateValues['Choose'], $updateValues['Pay'], $updateValues['Fly']
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Error updating text fields: " . $conn->error);
            }
        }

        $conn->commit();
        echo "<script>
                alert('Content updated successfully!');
                window.location.href = 'settings.php';
              </script>";
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        error_log("Error in update: " . $e->getMessage());
        echo "<script>
                alert('Error: " . addslashes($e->getMessage()) . "');
                window.location.href = 'settings.php';
              </script>";
        exit;
    }
}
?>

<!-- (... rest of the HTML code remains the same ...) -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../admin/css/administrators.css" />
    <link rel="stylesheet" href="../admin/css/prof1.css" />
    <title>ADMIN PORTAL</title>
    <link rel="icon" href="../img/logo.png">
  </head>
  <body>
    <div class="container">
      <div class="navigation">
        <ul>
        <li style="display: flex; justify-content: center; align-items: center; text-align: center; padding: 10px; list-style-type: none;">
                <a href="#" style="display: flex; align-items: center; text-decoration: none; color: #333;">
                <img src="../img/logo.png" alt="Admin Logo" style="margin-left: -15px; display: block; width: 75px; height: 75px; border-radius: 50%; filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 5));">
                    <span style="font-size: 18px; font-weight: bold; color: #fff; text-transform: uppercase;">ItsSamarTime</span>
                </a>
            </li>

            <li><a href="home.php"><span class="icon"><ion-icon name="home-outline"></ion-icon></span><span class="title">Dashboard</span></a></li>

            <li><a href="package.php"><span class="icon"><ion-icon name="briefcase-outline"></ion-icon></span><span class="title">Package Spots</span></a></li>

            <li><a href="customers.php"><span class="icon"><ion-icon name="people-outline"></ion-icon></span><span class="title">Customers</span></a></li>

            <li><a href="message.php"><span class="icon"><ion-icon name="mail-outline"></ion-icon></span><span class="title">Messages</span></a></li>

            <li><a href="booking.php"><span class="icon"><ion-icon name="calendar-outline"></ion-icon></span><span class="title">Bookings</span></a></li>

            <li><a href="settings.php"><span class="icon"><ion-icon name="settings-outline"></ion-icon></span><span class="title">Settings</span></a></li>

            <li><a href="administrators.php" class="nav-link" aria-label="Go to Profile"><span class="icon"><ion-icon name="people-outline"></ion-icon></span><span class="title">Administrators</span></a></li>

            <li><a href="profile.php" class="nav-link" aria-label="Go to Profile">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="user-icon">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </span><span class="title">Profile</span>
                </a>
            </li>

            <li><a href="signout.php"><span class="icon"><ion-icon name="log-out-outline"></ion-icon></span><span class="title">Sign Out</span></a> </li>
            </ul>
            </div>


      <!-- Main -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
        <!-- Search -->
        <div class="cardHeader">
            <h2>SETTINGS</h2>
        </div>
        <!-- UserImg -->
        <div class="user">
          <img src="<?php echo htmlspecialchars($Profilepic); ?>" alt="User Image">
        </div>
    </div>

    <!-- Cards -->
    <!-- Orders details List -->
    <div class="recentOrders">
    <div class="recentOrders">
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Home Image</h2>
                </div>
                <div class="form-container">
                <form method="POST" action="process.php" enctype="multipart/form-data">
                    <div>
                    <div class="name-row">
                        <label for="Homeimg">Insert Image:</label>
                            <input style="width: 60%;" type="file" id="Homeimg" name="Homeimg" accept="image/*">
                            <img id="profilepicPreview" src="<?php echo htmlspecialchars($processData['Homeimg'] ?: 'img/default-image.jpg'); ?>" alt="Profile Picture" style="max-width: 200px; max-height: 200px;">
                    </div>
                  </div>
                  <hr><div class="cardHeader">
                      <h2><i>Top 4 Popular Destination</i></h2>
                    </div>
                    <div class="name-row">
                      <label for="popdes1">Top 1 :</label>
                        <input style="width: 60%;" type="file" id="popdes1" name="popdes1" accept="image/*">
                        <img id="profilepicPreview" src="<?php echo htmlspecialchars($processData['popdes1'] ?: 'img/default-image.jpg'); ?>" alt="Profile Picture" style="max-width: 200px; max-height: 200px;">
                    </div>
                    <div class="name-row">
                      <label for="popdes2">Top 2:</label>
                        <input style="width: 60%;" type="file" id="popdes2" name="popdes2" accept="image/*">
                        <img id="profilepicPreview" src="<?php echo htmlspecialchars($processData['popdes2'] ?: 'img/default-image.jpg'); ?>" alt="Profile Picture" style="max-width: 200px; max-height: 200px;">
                    </div>
                    <div class="name-row">
                      <label for="popdes3">Top 3:</label>
                        <input style="width: 60%;" type="file" id="popdes3" name="popdes3" accept="image/*">
                        <img id="profilepicPreview" src="<?php echo htmlspecialchars($processData['popdes3'] ?: 'img/default-image.jpg'); ?>" alt="Profile Picture" style="max-width: 200px; max-height: 200px;">
                    </div>
                    <div class="name-row">
                      <label for="popdes4">Top 4:</label>
                        <input style="width: 60%;" type="file" id="popdes4" name="popdes4" accept="image/*">
                        <img id="profilepicPreview" src="<?php echo htmlspecialchars($processData['popdes4'] ?: 'img/default-image.jpg'); ?>" alt="Profile Picture" style="max-width: 200px; max-height: 200px;">
                    </div>
                    
                   
                    <div class="add-button">
                    <button type="submit">Update Admin</button>
                    </div>
                    
                    </form>
                </div>
            </div>
          </div>
        </div>
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Home Text</h2>
                </div>
                <div class="form-container">
                  
                    <form method="POST" action="process.php" enctype="multipart/form-data">
                    <div class="cardHeader">
                    <h2><i>Home Text</i></h2>
                </div>
                    <div class="name-row">
                        <div>
                            <label for="weltext1">Paragraph 1</label>
                            <input type="text" id="weltext1" name="weltext1" value="<?php echo htmlspecialchars($processData['weltext1']); ?>" required>
                        </div>
                        <div>
                            <label for="weltext2">Paragraph 2</label>
                            <input type="text" id="weltext2" name="weltext2" value="<?php echo htmlspecialchars($processData['weltext2']); ?>" required>
                        </div>
                    </div>
                    <div class="name-row">
                        <div>
                            <label for="subtext1">Sub Text 1</label>
                            <input type="text" id="subtext1" name="subtext1" value="<?php echo htmlspecialchars($processData['subtext1']); ?>" required>
                        </div>
                        <div>
                            <label for="subtext2">Sub Text 2</label>
                            <input type="text" id="subtext2" name="subtext2" value="<?php echo htmlspecialchars($processData['subtext2']); ?>" required>
                        </div>
                        <div>
                            <label for="subtext3">Sub Text 3</label>
                            <input type="text" id="subtext3" name="subtext3" value="<?php echo htmlspecialchars($processData['subtext3']); ?>" required>
                        </div>
                        <div>
                            <label for="subtext4">Sub Text 4</label>
                            <input type="text" id="subtext4" name="subtext4" value="<?php echo htmlspecialchars($processData['subtext4']); ?>" required>
                        </div>
                        <div>
                            <label for="subtext5">Sub Text 5</label>
                            <input type="text" id="subtext5" name="subtext5" value="<?php echo htmlspecialchars($processData['subtext5']); ?>" required>
                        </div>
                        <div>
                            <label for="subtext6">Sub Text 6</label>
                            <input type="text" id="subtext6" name="subtext6" value="<?php echo htmlspecialchars($processData['subtext6']); ?>" required>
                        </div>
                    </div>
                    














                    <hr><div class="cardHeader">
                      <h2><i>Our Services</i></h2>
                    </div>
                    <div class="name-row">
                        <div>
                            <label for="ourser1">Samar Tours</label>
                            <input type="text" id="ourser1" name="ourser1" value="<?php echo htmlspecialchars($processData['ourser1']); ?>" required>
                        </div>
                        <div>
                            <label for="ourser2">Hotel Reservation</label>
                            <input type="text" id="ourser2" name="ourser2" value="<?php echo htmlspecialchars($processData['ourser2']); ?>" required>
                        </div>
                        <div>
                            <label for="ourser3">Travel Guides</label>
                            <input type="text" id="ourser3" name="ourser3" value="<?php echo htmlspecialchars($processData['ourser3']); ?>" required>
                        </div>
                        <div>
                            <label for="ourser4">Event Management</label>
                            <input type="text" id="ourser4" name="ourser4" value="<?php echo htmlspecialchars($processData['ourser4']); ?>" required>
                        </div>
                    </div>
                    
                    <hr><div class="cardHeader">
                      <h2><i>3 Easy Steps</i></h2>
                    </div>






                    
                    <div class="name-row">
                        <div>
                            <label for="Choose">Choose A Destination</label>
                            <input type="text" id="Choose" name="Choose" value="<?php echo htmlspecialchars($processData['Choose']); ?>" required>
                        </div>
                    </div>
                    <div class="name-row">
                        <div>
                            <label for="Pay">Pay Online</label>
                            <input type="text" id="Pay" name="Pay" value="<?php echo htmlspecialchars($processData['Pay']); ?>" required>
                        </div>
                    </div>
                    <div class="name-row">
                        <div>
                            <label for="Fly">Fly Today</label>
                            <input type="text" id="Fly" name="Fly" value="<?php echo htmlspecialchars($processData['Fly']); ?>" required>
                        </div>
                    </div>
                    <div class="add-button">
                    <button type="submit">Update Details</button>
                    </div>
                    
                    </form>
                </div>
            </div>
          </div>
        </div>

<script>
  function previewImage(event) {
        const preview = document.getElementById('profilepicPreview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
        preview.src = e.target.result; // Set the preview image
        }

        if (file) {
        reader.readAsDataURL(file); // Read the file as a Data URL
        }
    }
</script>



<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="main.js"></script>
</body>
</html>
