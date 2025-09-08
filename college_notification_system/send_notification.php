<?php  
session_start();
include 'config/db.php';
include 'includes/header.php';

// Logged-in user role from session (set during login)
$current_role = $_SESSION['role'] ?? '';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $receiver_role = $_POST['receiver_role'];
  $college = $_POST['college'] ?? null;
  $branch = $_POST['branch'] ?? null;
  $year = $_POST['year'] ?? null;
  $category = $_POST['category'] ?? 'General';
  $message = $_POST['message'];

  // Handle attachment
  $attachment = null;
  if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0){
    $targetDir = "uploads/";
    if(!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $filename = time()."_".basename($_FILES['attachment']['name']);
    $targetFile = $targetDir.$filename;
    if(move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)){
      $attachment = $filename;
    }
  }

  // Insert into DB
  $stmt = $conn->prepare("INSERT INTO notifications(sender_role,receiver_role,college,branch,year,category,message,attachment) VALUES(?,?,?,?,?,?,?,?)");
  $stmt->bind_param("ssssssss",$current_role,$receiver_role,$college,$branch,$year,$category,$message,$attachment);

  if($stmt->execute()){
    echo "<div class='alert alert-success'>Notification sent successfully.</div>";
  } else {
    echo "<div class='alert alert-danger'>".$conn->error."</div>";
  }
}
?>

<div class="card p-4 col-md-10">
  <h3>Send Notification</h3>
  <form method="post" enctype="multipart/form-data">

    <!-- Receiver Role -->
    <div class="mb-3">
      <label>Receiver Role</label>
      <select name="receiver_role" id="receiver_role" class="form-control" required>
        <option value="">-- Select Role --</option>
        <?php
        // All roles
        $roles = ["Vice Chancellor","Rector","Registrar","Principal","HOD","Teacher","Student"];

        // Hide logged-in role
        foreach($roles as $role){
          if(strtolower($role) !== strtolower($current_role)){
            echo "<option value='$role'>$role</option>";
          }
        }
        ?>
        <option value="All">All</option>
      </select>
    </div>

    <!-- Extra Fields -->
    <div id="extraFields"></div>

    <!-- Category -->
    <div class="mb-3">
      <label>Category</label>
      <select name="category" class="form-control" required>
        <option value="General">General</option>
        <option value="Exam">Exam</option>
        <option value="Holiday">Holiday</option>
        <option value="Event">Event</option>
        <option value="Emergency">Emergency</option>
      </select>
    </div>

    <!-- Attachment -->
    <div class="mb-3">
      <label>Attachment (PDF/Image)</label>
      <input type="file" name="attachment" class="form-control">
    </div>

    <!-- Message -->
    <div class="mb-3">
      <label>Message</label>
      <textarea name="message" class="form-control" required></textarea>
    </div>

    <button class="btn btn-success">Send</button>
  </form>
</div>

<script>
const extra = document.getElementById('extraFields');
document.getElementById('receiver_role').addEventListener('change', (e)=>{
  const role = e.target.value;
  extra.innerHTML = '';

  if(role === 'Principal'){
    extra.innerHTML = `
      <div class="mb-3"><label>College</label>
        <select name="college" class="form-control" required>
          <option value="">Select</option>
          <option value="All">All</option>
          <option value="Engineering">Engineering</option>
          <option value="BPharmacy">BPharmacy</option>
          <option value="ArtsScience">Arts & Science</option>
        </select>
      </div>`;
  }
  else if(role === 'HOD'){
    extra.innerHTML = `
      <div class="mb-3"><label>College</label>
        <select name="college" id="collegeType" class="form-control" required>
          <option value="">Select</option>
          <option value="All">All</option>
          <option value="Engineering">Engineering</option>
          <option value="BPharmacy">BPharmacy</option>
          <option value="ArtsScience">Arts & Science</option>
        </select>
      </div>
      <div class="mb-3"><label>Branch</label>
        <select name="branch" id="branchSel" class="form-control" required>
          <option value="">Select college first</option>
        </select>
      </div>`;
  }
  else if(role === 'Teacher'){
    extra.innerHTML = `
      <div class="mb-3"><label>College</label>
        <select name="college" id="collegeType" class="form-control" required>
          <option value="">Select</option>
          <option value="All">All</option>
          <option value="Engineering">Engineering</option>
          <option value="BPharmacy">BPharmacy</option>
          <option value="ArtsScience">Arts & Science</option>
        </select>
      </div>
      <div class="mb-3"><label>Branch</label>
        <select name="branch" id="branchSel" class="form-control" required>
          <option value="">Select college first</option>
        </select>
      </div>`;
  }
  else if(role === 'Student'){
    extra.innerHTML = `
      <div class="mb-3"><label>College</label>
        <select name="college" id="collegeType" class="form-control" required>
          <option value="">Select</option>
          <option value="All">All</option>
          <option value="Engineering">Engineering</option>
          <option value="BPharmacy">BPharmacy</option>
          <option value="ArtsScience">Arts & Science</option>
        </select>
      </div>
      <div class="mb-3"><label>Branch</label>
        <select name="branch" id="branchSel" class="form-control" required>
          <option value="">Select college first</option>
        </select>
      </div>
      <div class="mb-3"><label>Year</label>
        <select name="year" class="form-control" required>
          <option value="All">All</option>
          <option value="1st">1st</option>
          <option value="2nd">2nd</option>
          <option value="3rd">3rd</option>
          <option value="4th">4th</option>
        </select>
      </div>`;
  }
});

// Dynamic branch options
document.addEventListener('change', function(e){
  if(e.target && e.target.id === 'collegeType'){
    const v = e.target.value;
    const branch = document.getElementById('branchSel');
    let opts = '<option value="All">All</option>';
    if(v === 'Engineering') opts += '<option>CSE</option><option>ECE</option><option>AI&ML</option>';
    else if(v === 'BPharmacy') opts += '<option>Pharmacy</option>';
    else if(v === 'ArtsScience') opts += '<option>LLB</option><option>MBA</option><option>MCA</option><option>BioMaths</option><option>BioScience</option>';
    branch.innerHTML = opts;
  }
});
</script>

<?php include 'includes/footer.php'; ?>
