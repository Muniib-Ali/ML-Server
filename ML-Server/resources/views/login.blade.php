<!DOCTYPE html>
<html>
<header>

</header>

<body>
    <div class = "login">
        <form method = "POST" action = "/login">
            @csrf

            <label for = "slack"> Slack ID: </label>
            <input type = "text" placeholder = "slack" name = "slack"> 

            <label for = "password"> Password: </label>
            <input type = "password" placeholder = "password" name  = "password">

            <button type = "submit"> Login </button>

        </form>
    </div>
</body>
</html>