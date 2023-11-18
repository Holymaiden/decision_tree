<footer class="main-footer">
    <div class="footer-left">
        {{ str_replace('_', ' ', 'Fihaa') }}
        <div class="bullet"></div> Copyright &copy; 2023
    </div>
    <div class="footer-right">
        {{ str_replace('_', ' ',   config('app.version', 'Version 1.0.0')) }}
    </div>
</footer>