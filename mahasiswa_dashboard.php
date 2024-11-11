<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'mahasiswa') {
    header("Location: login.php");
    exit();
}

$grades = $conn->query("SELECT course_name, grade FROM grades WHERE mahasiswa_id = " . $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h2 class="text-4xl font-bold mb-6 text-center text-purple-600">Mahasiswa Dashboard</h2>

        <!-- Tautan Logout -->
        <div class="text-right mb-4">
            <a href="logout.php" class="text-red-500 hover:text-red-700">Logout</a>
        </div>

        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-4 border">Mata Kuliah</th>
                    <th class="py-3 px-4 border">Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $grades->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="py-2 px-4 border"><?php echo $row['course_name']; ?></td>
                        <td class="py-2 px-4 border"><?php echo $row['grade']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>