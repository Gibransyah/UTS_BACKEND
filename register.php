<?php
session_start();
include 'db.php';

// Proses registrasi mahasiswa
$notification = '';  // Variable to hold notification messages
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'mahasiswa';

    // Check if the passwords match
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $notification = "<div id='notification' class='notification bg-red-600 text-white text-center py-3 rounded-lg mb-6'>Password dan Konfirmasi Password tidak cocok.</div>";
    } else {
        $query = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $query->bind_param("sss", $username, $password, $role);

        if ($query->execute()) {
            $notification = "<div id='notification' class='notification bg-green-600 text-white text-center py-3 rounded-lg mb-6'>Registrasi berhasil!</div>";
        } else {
            $notification = "<div id='notification' class='notification bg-red-600 text-white text-center py-3 rounded-lg mb-6'>Registrasi gagal. Silakan coba lagi.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .notification.hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg flex max-w-4xl w-full">
        <div class="w-1/2 p-10">
            <h2 class="text-3xl font-semibold mb-2">Register</h2>
            <p class="text-gray-500 mb-6">Buat Akun Anda disini!</p>

            <!-- Display notification if it exists -->
            <?php if ($notification): ?>
                <div id="notification-container">
                    <?php echo $notification; ?>
                </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <form method="POST" action="register.php">
                <!-- Username Field -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="username">Username</label>
                    <input class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" 
                           id="username" name="username" placeholder="Username" type="text" required/>
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="password">Password</label>
                    <input class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" 
                           id="password" name="password" placeholder="Password" type="password" required/>
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2" for="confirm_password">Konfirmasi Password</label>
                    <input class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" 
                           id="confirm_password" name="confirm_password" placeholder="Confirm Password" type="password" required/>
                </div>

                <!-- Register Button -->
                <button class="w-full bg-purple-500 text-white py-2 rounded-lg hover:bg-purple-600 transition duration-200">
                    Register
                </button>

                <!-- Login Redirect -->
                <p class="text-center mt-6 text-gray-500">Sudah Punya Akun? 
                    <a href="login.php" class="text-purple-400 font-semibold hover:underline">Login disini</a>
                </p>
            </form>
        </div>

        <!-- Right Side Image (Optional) -->
        <div class="w-1/2 bg-gray-50 rounded-r-lg flex items-center justify-center p-10">
            <img alt="3D illustration of a person with icons" 
                 src="https://storage.googleapis.com/a1aa/image/URVV49ZE4bYxGtiPsaJCyJaMdHunzaYFIZolDO8Ky5BPxf3JA.jpg" 
                 class="h-96 w-96"/>
        </div>
    </div>

    <script>
        window.onload = function() {
            var notification = document.getElementById('notification');
            if (notification) {
                setTimeout(function() {
                    notification.classList.add('hidden'); 
                }, 3000);
            }
        };
    </script>
</body>
</html>
