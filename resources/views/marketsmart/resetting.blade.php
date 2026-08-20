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

        <h2>RESETTING</h2>

        <form>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password"  name="password" placeholder="Enter New Password" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"placeholder="Confirm password" required>
            </div>

            <button type="submit" class="login-button">Submit</button>

        </form>



    </div>
