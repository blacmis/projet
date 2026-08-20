<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
</head>
<body> 
<div class="login-container">
        <div class="logo">
             <img src="{{ asset("image/marketlogo.png")}}">
            
        </div>

        <h2>SIGN IN</h2>

        <form>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email"  name="email" placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"placeholder="Enter password" required>
            </div>

            <button type="submit" class="login-button">Login</button>

        </form>

        <div class="forgot-password">
            <a href="#">Forgot Password?</a>
        </div>

    </div>
