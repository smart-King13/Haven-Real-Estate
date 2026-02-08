<!DOCTYPE html>
<html>
<head>
    <title>Logout - Haven</title>
</head>
<body>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
    <script>
        document.getElementById('logout-form').submit();
    </script>
</body>
</html>
