<!DOCTYPE html>
<html>
<head>
    <title>CSRF Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>CSRF Test</h1>
    
    <p><strong>CSRF Token:</strong> {{ csrf_token() }}</p>
    <p><strong>Session ID:</strong> {{ session()->getId() }}</p>
    <p><strong>Session Driver:</strong> {{ config('session.driver') }}</p>
    <p><strong>App Key Set:</strong> {{ config('app.key') ? 'Yes' : 'No' }}</p>
    
    <form method="POST" action="/test-csrf-post">
        @csrf
        <input type="text" name="test" value="test data">
        <button type="submit">Test CSRF</button>
    </form>
    
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    
    @if($errors->any())
        <div style="color: red;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
</body>
</html>
