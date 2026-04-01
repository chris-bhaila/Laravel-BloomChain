<!DOCTYPE html>
<html>
<body>
<script>
    const token = "{{ request()->query('token') }}";

    // Signal Android WebView via JS bridge
    if (window.Android) {
        window.Android.onTokenReceived(token);
    }

    // Store in localStorage as fallback
    localStorage.setItem('auth_token', token);

    window.location.replace('/dashboard');
</script>
</body>
</html>