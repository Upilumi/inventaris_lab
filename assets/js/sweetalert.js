document.addEventListener("DOMContentLoaded", function () {

    const status = document.body.dataset.status;
    const message = document.body.dataset.message;

    if (!status) return;

    Swal.fire({
        icon: status,
        title: message,
        timer: 2500,
        showConfirmButton: false,
        toast: true,
        position: "top-end"
    });

});

// ==============================
// KONFIRMASI HAPUS
// ==============================
function confirmDelete(url) {

    Swal.fire({

        title: 'Hapus Barang?',

        text: 'Data yang dihapus tidak dapat dikembalikan.',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc3545',

        cancelButtonColor: '#6c757d',

        confirmButtonText: '🗑️ Ya, Hapus',

        cancelButtonText: 'Batal',

        reverseButtons: true

    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href = url;

        }

    });

}

// ===============================
// CONFIRM LOGOUT
// ===============================
function confirmLogout(url) {

    Swal.fire({
        title: 'Logout?',
        text: 'Apakah Anda yakin ingin keluar dari aplikasi?',
        icon: 'question',

        showCancelButton: true,

        confirmButtonColor: '#198754',
        cancelButtonColor: '#dc3545',

        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'

    }).then((result) => {

        if(result.isConfirmed){

            window.location.href = url;

        }

    });

}