
<?php
include('config.php');

if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($conx, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conx, $_POST['lastname']);
    $amount = mysqli_real_escape_string($conx, $_POST['amount']);


    echo  $firstname;
    echo  $lastname ,$amount;

}

?>

<form method="post" action='' class="needs-validation" novalidate>
                <div class="row g-3">
                  <div class="col-sm-6">
                    <label for="firstName" class="form-label">First name</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="" value="<?php if (isset($_POST['firstname'])) { echo $firstname;} ?>" required>

                    <div class="invalid-feedback">
                      Valid first name is required.
                    </div>
                  </div>
      
                  <div class="col-sm-6">
                    <label for="lastName" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="lastname" placeholder="" name="lastname" value="<?php if (isset($_POST['lastname'])) { echo $lastname;} ?>" required>
                    <div class="invalid-feedback">
                      Valid last name is required.
                    </div>
                  </div>

                  <div class="row">
                      <div class="col-sm-3 mb-2">
                          <div class="card p-3">
                              <div class="d-flex align-items-center justify-content-between">
                                  <div class="d-flex align-items-center">
                                      <p class="pe-3">1 Month</p>
                                      <div class="form-check form-switch">
                                        <?php $amount=1000;?>
                                          <input class="form-check-input" type="checkbox"   id="amount" name="amount" value="<?php   echo $amount*2;?>" onchange="handleCheckboxChange(this)">
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                     
      
                  <input type="submit" class="w-100 btn btn-primary btn-lg" id="submit" name="submit" value='submit'>


                
                  </form>