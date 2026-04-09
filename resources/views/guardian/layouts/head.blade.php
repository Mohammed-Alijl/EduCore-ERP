<meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<title>@yield('title', setting('school_name'))</title>
<link rel="icon" href="{{ setting()->logo_url }}" type="image/png" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=Manrope:wght@400;500;600;700;800&amp;display=swap"
    rel="stylesheet" />

<script>
    (() => {
        try {
            const storedTheme = localStorage.getItem('guardian-theme');
            const theme = storedTheme === 'dark' ? 'dark' : 'light';

            document.documentElement.classList.remove('light', 'dark');
            document.documentElement.classList.add(theme);
        } catch (error) {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        }
    })();
</script>

@vite(['resources/css/guardian.css', 'resources/js/app.js'])
@yield('css')
