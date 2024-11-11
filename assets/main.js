// Function untuk menampilkan pop-up konfirmasi sebelum menghapus data
function confirmDelete(event) {
    if (!confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        event.preventDefault(); // Jika user memilih 'Batal', proses hapus dibatalkan
    }
}

// Event listener otomatis untuk semua tombol hapus
document.addEventListener('DOMContentLoaded', () => {
    const deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(link => {
        link.addEventListener('click', confirmDelete);
    });
});
