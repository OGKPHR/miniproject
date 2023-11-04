<?php 
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <title>Document</title>
    <style>
      .backgroundimage {
        background-image: url("https://images.pexels.com/photos/667838/pexels-photo-667838.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1");
        background-repeat: no-repeat;
        background-size: cover;
        position: relative; 
        width: 100%; 
        height: 100%; 
      }
      .overlay {
        position: absolute; /* ตั้งค่าตำแหน่งเป็น absolute สำหรับ .overlay */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.456); /* สี overlay ที่คุณต้องการ (rgba โดยมีค่า alpha 0.5 สำหรับความโปร่งแสง) */
      }
      body{
        overflow: scroll;
        overflow-x: hidden;
        background-color: black;

      }
      ::-webkit-scrollbar {
          width: 0;
          background: transparent;
      }
      
      ::-webkit-scrollbar-thumb {
          background: #FF0000;
      }
    </style>
  </head>
  <body>
    <!-- Section: Design Block -->
    <section >
      <div class="backgroundimage">
      <div class="overlay"></div>
      <!-- Jumbotron -->
      <div
        class="px-4 py-5 px-md-5 text-center text-lg-start "
        >
        <div class="container d-flex justify-content-center align-items-center" >
          <div class="row gx-lg-5 ">
            
            <form method="post" action="register.php" enctype="multipart/form-data">
              <div class="card" style="border-radius: 15px;">
                <div class="card-body py-5 px-md-5">
                  <form>
                    <h1 class="justify-content-center align-content-center text-center fw-bold ls-tight" ><span class="text-primary">REGISTER HERE</span></h1>
                    <hr>
                    <!-- Username input -->
                    <div class="form-floating mb-3 mt-3">
                      <input
                        type="text"
                        class="form-control"
                        id="username"
                        name="username"
                        placeholder="Username"
                      />
                      <label for="username">Username</label>
                    </div>
                    <!-- Password input -->
                    <div class="form-floating mb-3">
                      <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Password"
                      />
                      <label for="password">Password</label>
                    </div>
                    <!-- Password input -->
                    <div class="form-floating mb-3">
                        <input
                          type="Password"
                          class="form-control"
                          id="ConfirmPassword"
                          name="password"
                          placeholder="ConfirmPassword"
                        />
                        <label for="ConfirmPassword">Confirm Password</label>
                      </div>
                    <div class="row">
                      <!--First name input-->
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input
                            type="text"
                            id="firstname"
                            name="first_name"
                            class="form-control"
                            placeholder="First name"
                          />
                          <label for="firstname">First name</label>
                        </div>
                      </div>
                      <!--Last name input-->
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input
                            type="text"
                            class="form-control"
                            id="lastname"
                            name="last_name"
                            placeholder="Last name"
                          />
                          <label for="lastname">Last name</label>
                        </div>
                      </div>
                    </div>

                    <!-- Telephone input -->
                    <div class="form-floating mb-3">
                      <input
                        type="text"
                        class="form-control"
                        id="Telephone"
                        name="telephone"
                        placeholder="Telephone Number"
                      />
                      <label for="Telephone">Telephone</label>
                    </div>

                    
                    <!--Bdate input-->
                    <div class="form-floating mb-3">
                      <input
                        type="text"
                        class="form-control"
                        id="Dateofbirth"
                        name="date_of_birth"
                        placeholder="Date of birth"
                      />
                      <label for="Dateofbirth">Date of birth</label>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-6">
                        <!--House number input-->
                        <div class="form-floating mb-3">
                          <input
                            type="text"
                            class="form-control"
                            id="Housenumber"
                            name="house_number"
                            placeholder="House number"
                          />
                          <label for="Housenumber">House number</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <!--Village number input-->
                        <div class="form-floating mb-3">
                          <input
                            type="text"
                            class="form-control"
                            id="Village"
                            name="village_number"
                            placeholder="Village number"
                          />
                          <label for="Village">Village number</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <!--Subdistrict input-->
                            <div class="form-floating mb-3">
                            <input
                                type="text"
                                class="form-control"
                                id="Subdistrict"
                                name="subdistrict"
                                placeholder="Subdistrict"
                            />
                            <label for="Subdistrict">Subdistrict</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                          <!--District input-->
                          <div class="form-floating mb-3">
                            <input
                              type="text"
                              class="form-control"
                              id="floatingDistrict"
                              name="district"
                              placeholder="District"
                            />
                            <label for="District">District</label>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <!--Province input-->
                          <div class="form-floating mb-3">
                            <input
                              type="text"
                              class="form-control"
                              id="Province"
                              name="province"
                              placeholder="Province"
                            />
                            <label for="Province">Province</label>
                          </div>
                        </div>
                    </div>
                    <!--Gender input-->
                    <div class="row mb-3 mt-3 justify-content-center align-content-center text-center">
                        <div class="col-md-3">
                          <p style="font-size: 18px">Gender</p>
                        </div>
                        <div class="col-md-4">
                          <div class="form-check form-check-inline">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="inlineRadioOptions"
                              id="genderMale"
                              name="inlineRadioOptions"
                              value="option1"
                            />
                            <label class="form-check-label" for="genderMale"
                              >Male</label
                            >
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-check form-check-inline">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="inlineRadioOptions"
                              id="genderFemale"
                              name="inlineRadioOptions"
                              value="option2"
                            />
                            <label class="form-check-label" for="genderFemale"
                              >Female</label
                            >
                          </div>
                        </div>
                      </div>
                      <hr>
                </div>
                <div class="justify-content-center align-content-center text-center">
                    <!-- Submit button -->
                    <button
                      type="submit"
                      class="btn btn-primary btn-block mb-4"
                      style="width: 80%;">
                      Sign up
                    </button>
                </div>
                <hr>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->
    <script>
      flatpickr('#Dateofbirth', {
        enableTime: false,
        dateFormat: "Y-m-d",
        maxDate: "today", // จำกัดการเลือกวันเป็นวันปัจจุบันและวันที่อาจารย์
        minDate: "1900-01-01", // กำหนดวันขั้นต่ำในอดีต
      });
    </script>
    
  </body>
</html>
