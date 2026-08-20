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

        <h2>RESET PASSWORD</h2>

        <form>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email"  name="email" placeholder="Enter email" required>
            </div>


            <button type="submit" class="login-button">Reset</button>

        </form>

        <div class="Login">
            <a href="#">Login</a>
        </div>

    </div>
