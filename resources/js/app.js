import Swal from 'sweetalert2';

function showSuccessDeleteNotification() {
    Swal.fire({
        icon: 'success',
        title: 'Delete Successful',
        text: 'The item has been deleted successfully.',
    });
}

export { showSuccessDeleteNotification };

