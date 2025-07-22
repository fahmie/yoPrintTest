import './bootstrap';
const uploadId = window.uploadId; // you will set this in Blade

if (uploadId) {
    window.Echo.channel(`uploads.${uploadId}`)
        .listen('CsvProcessingCompleted', (e) => {
             console.log('Event received:', e);
            toastr.success(e.message, 'Upload Complete', {
                closeButton: true,
                progressBar: true,
                timeOut: 5000
            });
             $('#uploadHistoryTable').load(location.href + ' #uploadHistoryTable > *');
        });
}
