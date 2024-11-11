<?php
session_start();
include 'db.php'; // Memasukkan koneksi database

// Cek apakah pengguna adalah dosen
if ($_SESSION['role'] !== 'dosen') {
    header("Location: login.php");
    exit();
}

// Ambil data nilai mahasiswa
$grades = $conn->query("SELECT grades.id, grades.course_name, grades.grade, users.username AS mahasiswa_name
                        FROM grades
                        JOIN users ON grades.mahasiswa_id = users.id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h2 class="text-4xl font-bold mb-6 text-center text-purple-600">Dosen Dashboard</h2>
        
        <!-- Tautan Logout -->
        <div class="text-right mb-4">
            <a href="logout.php" class="text-red-500 hover:text-red-700 font-semibold">Logout</a>
        </div>

        <!-- Daftar Nilai Mahasiswa dengan Formulir untuk Edit -->
        <h3 class="text-2xl font-semibold mb-4 text-purple-600">Daftar Nilai Mahasiswa</h3>
        <form method="POST" action="update_grade.php">
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="min-w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-3 px-4 border">ID</th>
                            <th class="py-3 px-4 border">Mahasiswa</th>
                            <th class="py-3 px-4 border">Mata Kuliah</th>
                            <th class="py-3 px-4 border">Nilai</th>
                            <th class="py-3 px-4 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $grades->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-100 transition duration-200">
                                <td class="py-2 px-4 border"><?php echo $row['id']; ?></td>
                                <td class="py-2 px-4 border"><?php echo $row['mahasiswa_name']; ?></td>
                                <td class="py-2 px-4 border"><?php echo $row['course_name']; ?></td>
                                <td class="py-2 px-4 border">
                                    <input type="number" step="0.01" name="grades[<?php echo $row['id']; ?>]"
                                           value="<?php echo $row['grade']; ?>"
                                           class="w-full p-2 border border-gray-300 rounded text-center">
                                </td>
                                <td class="py-2 px-4 border text-center">
                                    <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600 transition duration-200">
                                        Simpan
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</body>
</html>
