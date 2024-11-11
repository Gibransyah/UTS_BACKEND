<?php
include 'auth.php'; 
checkLogin(); 

// Pastikan role adalah admin
if ($_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit();
}

// Koneksi ke database
$dsn = 'mysql:host=localhost;dbname=uts_backend';
$username = 'root';
$password = 'Gibran2507_';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Cek apakah ada pesan dari query string
$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses untuk menambah data
    if (isset($_POST['add_user'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        // Menyimpan data pengguna ke database
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $role]);

        // Redirect dengan pesan
        header("Location: admin_dashboard.php?message=User  berhasil ditambahkan!");
        exit();
    }

    // Proses untuk menghapus data berdasarkan username
    if (isset($_POST['delete_user'])) {
        $username_to_delete = $_POST['username'];
    
        // Validasi bahwa username tidak kosong
        if (empty($username_to_delete)) {
            header("Location: admin_dashboard.php?message=Username tidak boleh kosong!");
            exit();
        }
    
        // Ambil ID pengguna berdasarkan username
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username_to_delete]);
        $user = $stmt->fetch();
    
        if ($user) {
            // Hapus data terkait di tabel grades
            $stmt = $pdo->prepare("DELETE FROM grades WHERE mahasiswa_id = ?");
            $stmt->execute([$user['id']]);
    
            // Hapus pengguna dari tabel users
            $stmt = $pdo->prepare("DELETE FROM users WHERE username = ?");
            $stmt->execute([$username_to_delete]);
    
            // Reset auto increment ID di tabel users
            $stmt = $pdo->prepare("SET @count = 0; UPDATE users SET id = @count := (@count + 1); ALTER TABLE users AUTO_INCREMENT = 1;");
            $stmt->execute();
    
            // Redirect dengan pesan
            header("Location: admin_dashboard.php?message=User   berhasil dihapus dan ID direset!");
            exit();
        } else {
            header("Location: admin_dashboard.php?message=User   tidak ditemukan!");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6; /* Latar belakang abu-abu muda */
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.5); 
        }
        .modal-content {
            background-color: #ffffff;
            margin: 10% auto; 
            padding: 20px;
            border-radius: 10px; 
            width: 90%; 
            max-width: 400px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #333;
            text-decoration: none;
            cursor: pointer;
        }
        .button {
            transition: background-color 0.3s, transform 0.3s;
        }
        .button:hover {
            transform: scale(1.05);
        }
        .bg-purple {
            background-color: #6b46c1; /* Warna ungu */
        }
        .bg-purple-light {
            background-color: #b794f4; /* Warna ungu muda */
        }
    </style>
</head>
<body>
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-center mb-6 text-purple-700">Admin Dashboard</h1>

        <div class="text-right mb-4">
            <a href="logout.php" class="text-red-500 hover:text-red-700">Logout</a>
            </div>

<div id="messageModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <p id="modalMessage"><?php echo htmlspecialchars($message); ?></p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-lg p-8 mb-6 transition-transform transform hover:scale-105">
        <h3 class="text-xl font-semibold mb-4 text-purple-600">Add User</h3>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" class="w-full p-3 border border-gray-300 rounded mb-3 focus:outline-none focus:ring-2 focus:ring-purple-400" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-3 border border-gray-300 rounded mb-3 focus:outline-none focus:ring-2 focus:ring-purple-400" required>
            <select name="role" class="w-full p-3 border border-gray-300 rounded mb-4 focus:outline-none focus:ring-2 focus:ring-purple-400" required>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="add_user" class="bg-purple text-white w-full p-3 rounded button hover:bg-purple-light">Add User</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8 mb-6 transition-transform transform hover:scale-105">
        <h3 class="text-xl font-semibold mb-4 text-purple-600">Delete User</h3>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" class="w-full p-3 border border-gray-300 rounded mb-3 focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <button type="submit" name="delete_user" class="bg-red-600 text-white w-full p-3 rounded button hover:bg-red-700">Delete User</button>
        </form>
    </div>
</div>

<script>
    // Show modal if there's a message
    const modal = document.getElementById("messageModal");
    const closeModal = document.getElementById("closeModal");

    <?php if ($message): ?>
        modal.style.display = "block";
        // Automatically close modal after 3 seconds
        setTimeout(() => {
            modal.style.display = "none";
        }, 3000);
    <?php endif; ?>

    // Close modal
    closeModal.onclick = function() {
        modal.style.display = "none";
    }

    // Close modal if clicked outside of it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</div>
</body>
</html>