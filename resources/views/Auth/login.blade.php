
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Inventory Management</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 20px;
            background: #f1f5f3;
            font-family: Arial, sans-serif;
            color: #19372b;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, .07);
        }

        h1 { margin-top: 0; }
        .muted { color: #718078; margin-bottom: 25px; }

        label {
            display: block;
            margin: 16px 0 7px;
            font-weight: 700;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d6e1db;
            border-radius: 8px;
            font-size: 15px;
        }

        button {
            width: 100%;
            margin-top: 22px;
            padding: 13px;
            border: 0;
            border-radius: 8px;
            background: #137746;
            color: white;
            font-weight: 700;
            cursor: pointer;
        }

        .error {
            padding: 12px;
            background: #fff0ef;
            color: #a32d27;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .status {
            padding: 12px;
            background: #eaf7ee;
            color: #17633c;
            border-radius: 8px;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <main class="card">
        <h1>Welcome back</h1>
        <p class="muted">Sign in to Inventory Management</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <label for="email">Email address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                autocomplete="username"
                required
                autofocus
            >

            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                autocomplete="current-password"
                required
            >

            <button type="submit">Sign In</button>
        </form>
    </main>
</body>
</html>
