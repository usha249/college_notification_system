<?php
include 'config/db.php';
include 'includes/header.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email=$_POST['email'];$password=$_POST['password'];
  $stmt=$conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
  $stmt->bind_param("s",$email);
  $stmt->execute();
  $user=$stmt->get_result()->fetch_assoc();
  if($user && password_verify($password,$user['password'])){
    $_SESSION['user']=$user; header("Location: index.php"); exit;
  } else echo "<div class='alert alert-danger'>Invalid credentials</div>";
}
?>
<div class="card p-4 col-md-6">
  <h3>Login</h3>
  <form method="post">
    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
    <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
    <button class="btn btn-primary">Login</button>
  </form>
</div>
<?php include 'includes/footer.php'; ?>