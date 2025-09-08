<?php 
include 'config/db.php';
include 'includes/header.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=$_POST['name'];
  $email=$_POST['email'];
  $role=$_POST['role'];
  $college = $_POST['college_type'] ?? null;
  $branch = $_POST['branch'] ?? null;
  // Only get year if role is Student
  $year = ($role === 'Student') ? ($_POST['year'] ?? 'All') : NULL;
  $password=password_hash($_POST['password'],PASSWORD_DEFAULT);

  $stmt=$conn->prepare("INSERT INTO users(name,email,role,college_type,branch,year,password) VALUES(?,?,?,?,?,?,?)");
  $stmt->bind_param("sssssss",$name,$email,$role,$college,$branch,$year,$password);

  if($stmt->execute()) echo "<div class='alert alert-success'>Registered. <a href='login.php'>Login</a></div>";
  else echo "<div class='alert alert-danger'>".$conn->error."</div>";
}
?>

<div class="card p-4 col-md-8">
  <h3>Registration</h3>
  <form method="post" id="regForm">
    <div class="mb-3"><label>Name</label><input name="name" class="form-control" required></div>
    <div class="mb-3"><label>Email</label><input name="email" type="email" class="form-control" required></div>
    <div class="mb-3"><label>Role</label>
      <select name="role" id="role" class="form-control" required>
        <option value="">-- Select role --</option>
        <option>Vice Chancellor</option><option>Rector</option><option>Registrar</option>
        <option>Principal</option><option>HOD</option><option>Teacher</option><option>Student</option>
      </select>
    </div>
    <div id="extraFields"></div>
    <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
    <button class="btn btn-success">Register</button>
  </form>
</div>

<script>
const extra = document.getElementById('extraFields');

document.getElementById('role').addEventListener('change', (e)=>{
  const r = e.target.value;
  extra.innerHTML = '';

  if(r === 'Principal'){
    extra.innerHTML = `
      <div class="mb-3"><label>College Type</label>
        <select name="college_type" class="form-control" required>
          <option value="">Select</option>
          <option value="Engineering">Engineering</option>
          <option value="BPharmacy">BPharmacy</option>
          <option value="ArtsScience">Arts & Science</option>
        </select>
      </div>`;
  } 
  else if(r === 'HOD' || r === 'Teacher'){
    extra.innerHTML = `
      <div class="mb-3"><label>College Type</label>
        <select name="college_type" id="collegeType" class="form-control" required>
          <option value="">Select</option>
          <option value="Engineering">Engineering</option>
          <option value="BPharmacy">BPharmacy</option>
          <option value="ArtsScience">Arts & Science</option>
        </select>
      </div>
      <div class="mb-3"><label>Branch / Course</label>
        <select name="branch" id="branchSel" class="form-control" required>
          <option value="">Select college first</option>
        </select>
      </div>`;
  }
  else if(r === 'Student'){
    extra.innerHTML = `
      <div class="mb-3"><label>College Type</label>
        <select name="college_type" id="collegeType" class="form-control" required>
          <option value="">Select</option>
          <option value="Engineering">Engineering</option>
          <option value="BPharmacy">BPharmacy</option>
          <option value="ArtsScience">Arts & Science</option>
        </select>
      </div>
      <div class="mb-3"><label>Branch / Course</label>
        <select name="branch" id="branchSel" class="form-control" required>
          <option value="">Select college first</option>
        </select>
      </div>
      <div class="mb-3"><label>Year</label>
        <select name="year" class="form-control" required>
          <option value="1st">1st</option>
          <option value="2nd">2nd</option>
          <option value="3rd">3rd</option>
          <option value="4th">4th</option>
        </select>
      </div>`;
  }
});

document.addEventListener('change', function(e){
  if(e.target && e.target.id === 'collegeType'){
    const v = e.target.value;
    const branch = document.getElementById('branchSel');
    let opts = '<option value="All">All</option>';
    if(v === 'Engineering') opts += '<option>ECE</option><option>CSE</option><option>AI&ML</option><option>MECH</option><option>CIVIL</option><option>EEE</option>';
    else if(v === 'BPharmacy') opts += '<option>All</option>';
    else if(v === 'ArtsScience') opts += '<option>LLB</option><option>MBA</option><option>MCA</option><option>BioMaths</option><option>BioScience</option>';
    branch.innerHTML = opts;
  }
});
</script>

<?php include 'includes/footer.php'; ?>
