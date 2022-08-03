<div class="container">
    <center class="mt-3">
        <h1>Register</h1>
    </center>

    <form method="POST" action="/register/auth" class="form-check mt-3">
        <div class="mb-3">
            <label for="login" class="form-label">Username</label>
            <input type="text" class="form-control" id="login" placeholder="Vasya" name="login">
        </div>
        <div class="mb-3">
            <label for="pwd" class="form-label">Password</label>
            <input type="password" class="form-control" id="pwd" name="password"/>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Register</button>
    </form>
</div>