<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-page {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            max-width: 500px;
            margin: 0 auto;
        }

        .glass-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .form-left {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 2.5rem;
            border-radius: 20px;
        }

        .glass-title {
            color: white;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            font-weight: 600;
        }

        .glass-input-group {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .glass-input-group:focus-within {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        .glass-input-group .input-group-text {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: rgba(0, 0, 0, 0.7);
        }

        .form-control {
            background: transparent;
            border: none;
            color: #333;
            font-weight: 500;
        }

        .form-control:focus {
            background: transparent;
            border: none;
            box-shadow: none;
            color: #333;
        }

        .form-control::placeholder {
            color: rgba(0, 0, 0, 0.5);
        }

        .form-label {
            color: rgba(0, 0, 0, 0.8);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .btn-glass {
            background: rgba(13, 110, 253, 0.8);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.7rem 2rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .btn-glass:hover {
            background: rgba(13, 110, 253, 1);
            transform: translateY(-1px);
            box-shadow: 0 5px 20px rgba(13, 110, 253, 0.4);
            color: white;
        }

        .alert-glass {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #dc3545;
        }

        .form-check-input:checked {
            background-color: rgba(13, 110, 253, 0.8);
            border-color: rgba(13, 110, 253, 0.8);
        }

        .form-check-label {
            color: rgba(0, 0, 0, 0.7);
            font-weight: 500;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-left {
                padding: 2rem;
            }
            
            .glass-container {
                margin: 0 10px;
            }
        }
    </style>
</head>

<body>
    <div class="login-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <!-- <h3 class="mb-4 text-center glass-title">Login Now</h3> -->
                    <div class="glass-container">
                        <div class="form-left h-100">
                            @if ($errors->has('email'))
                                <div class="alert alert-glass mb-4">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <form action="{{ route('admin.login') }}" method="post" class="row g-4">
                                @csrf
                                <div class="col-12">
                                    <label class="form-label">Email<span class="text-danger">*</span></label>
                                    <div class="input-group glass-input-group">
                                        <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                        <input type="text" name="email" class="form-control"
                                            placeholder="Enter Email" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Password<span class="text-danger">*</span></label>
                                    <div class="input-group glass-input-group">
                                        <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Enter Password">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inlineFormCheck" name="remember">
                                        <label class="form-check-label" for="inlineFormCheck">Remember me</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-glass float-end mt-3">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
