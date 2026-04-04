{{-- Font Awesome JS (optional, only for some features) --}}
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>

{{-- Lucide Icons --}}
<script defer src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

{{-- Main dashboard JS --}}
<script src="{{ asset('dashboard/assets/js/main.js') }}"></script>

@vite(['resources/js/app.js'])
@stack('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    if(typeof lucide !== 'undefined') lucide.createIcons();

    // Live date in header
    const el = document.getElementById('live-date');
    if(el) el.textContent = new Date().toLocaleDateString('en-PH', {
        weekday: 'short', month: 'short', day: 'numeric'
    });
});
</script>