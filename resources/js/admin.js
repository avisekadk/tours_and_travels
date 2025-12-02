// Admin Panel JavaScript

// Sidebar Toggle (for mobile)
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
}
window.toggleSidebar = toggleSidebar;

// Confirm actions
function confirmAction(message) {
    return confirm(message);
}
window.confirmAction = confirmAction;

// DataTable initialization (if using DataTables)
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any DataTables if jQuery is loaded
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined') {
        $('.data-table').DataTable({
            responsive: true,
            pageLength: 15,
            order: [[0, 'desc']]
        });
    }
});

// Chart initialization (if using Chart.js)
function initCharts() {
    // Booking stats chart
    const bookingCtx = document.getElementById('bookingChart');
    if (bookingCtx) {
        new Chart(bookingCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Bookings',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: 'rgb(59, 130, 246)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', initCharts);