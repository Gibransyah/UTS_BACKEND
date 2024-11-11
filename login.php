<?php
session_start();
include 'db.php'; // Memasukkan koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek username dan password di database
    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set sesi
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            // Arahkan ke dashboard berdasarkan role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] === 'dosen') {
                header("Location: dosen_dashboard.php");
            } elseif ($user['role'] === 'mahasiswa') {
                header("Location: mahasiswa_dashboard.php");
            }
            exit();
        } else {
            echo "Login gagal. Cek username dan password.";
        }
    } else {
        echo "Login gagal. Cek username dan password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg flex max-w-4xl w-full">
        <div class="w-1/2 p-10">
            <h2 class="text-3xl font-semibold mb-2">Login</h2>
            <p class="text-gray-500 mb-6">Masukan Akun Anda disini</p>

            <!-- Login Form -->
            <form method="POST" action="">
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

                <!-- Login Button -->
                <button class="w-full bg-purple-500 text-white py-2 rounded-lg hover:bg-purple-600 transition duration-200">
                    Login
                </button>
            </form>

            <!-- Register Redirect Link -->
            <p class="text-center mt-6 text-gray-500">Tidak Punya Akun? 
                <a href="register.php" class="text-purple-400 font-semibold hover:underline">Register disini</a>
            </p>
        </div>

        <!-- Right Side Image (Optional) -->
        <div class="w-1/2 bg-gray-50 rounded-r-lg flex items-center justify-center p-10">
            <img alt="3D illustration of a person with icons" 
                 src="https://storage.googleapis.com/a1aa/image/URVV49ZE4bYxGtiPsaJCyJaMdHunzaYFIZolDO8Ky5BPxf3JA.jpg" 
                 class="h-96 w-96"/>
        </div>
    </div>
</body>
</html>
