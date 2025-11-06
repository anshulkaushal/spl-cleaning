// Admin Panel JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            if (bsAlert) {
                bsAlert.close();
            }
        }, 5000);
    });

    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('[name="delete_employee"]');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this employee? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Date range filter helper
    const dateFromInput = document.getElementById('date_from');
    const dateToInput = document.getElementById('date_to');
    
    if (dateFromInput && dateToInput) {
        dateFromInput.addEventListener('change', function() {
            if (dateToInput.value && dateFromInput.value > dateToInput.value) {
                dateToInput.value = dateFromInput.value;
            }
        });
        
        dateToInput.addEventListener('change', function() {
            if (dateFromInput.value && dateToInput.value < dateFromInput.value) {
                dateFromInput.value = dateToInput.value;
            }
        });
    }
});

