<?php session_start(); ?>

<?php
include('admin/connect.php');
include('navbar.php');
?>

<?php
$STATUS_PENDING = 1;
$STATUS_ACCEPT = 2;
$STATUS_REJECT = 3;

// current user dep id
$q_current_user = $conn->prepare("SELECT * from employee where empid = ?");
$q_current_user->bind_param("s", $_SESSION["user_id"]);
$q_current_user->execute();
$result_current_user = $q_current_user->get_result();
$current_dep_id = $result_current_user->fetch_assoc()["DEPARTMENT"];

$q_requests = $conn->prepare(
  "SELECT r.rid, d.dname, j.jname, r.quantity, GROUP_CONCAT(s.skillname) as skills from request r 
    join request_skill rs on r.rid = rs.request_id
    join skill s on rs.skill_id = s.skillid
    join department d on r.deptrequest = d.did
    join jobposition j on r.jobrequest = j.jid
    where deptrequest = ? and r.status_id = $STATUS_PENDING
    group by d.dname, j.jname, r.quantity
    "
);
$q_requests->bind_param("s", $current_dep_id);
$q_requests->execute();
$result_requests = $q_requests->get_result();

// TODO: report when no request;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JOB REQUEST</title>
</head>

<body>
  <style>
    body {
      background-color: #eee;
    }

    .acceptbutton,
    .denybutton {
      width: 30%;
    }

    .jobrequestdetail {
      font-size: 16px;
    }

    .skill-list {
      text-align: left;
    }
    .accept-link{
      text-decoration: none;
      color: inherit
    }
  </style>
  <section>
    <div class="text-center container py-5">
      <h1 class="mt-4 mb-5"><strong>JOB REQUEST</strong></h1>

      <div class="row">
        <?php while ($row = $result_requests->fetch_assoc()): ?>
          <!-- วน For ตั้งแต่ตรงนี้-->
          <div class="col-md-4 mb-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title mb-3">Request</h5>
                  <hr />
                  <div class="row jobrequestdetail">
                    <div class="col-md-4">
                      <p style="text-align: left">Department :</p>
                    </div>
                    <div class="col-md-8">
                      <a href="" class="text-reset">
                        <p style="text-align: left">
                          <?= $row["dname"] ?>
                        </p>
                      </a>
                    </div>
                  </div>
                  <div class="row jobrequestdetail">
                    <div class="col-md-4">
                      <p style="text-align: left">Job :</p>
                    </div>
                    <div class="col-md-8">
                      <a href="" class="text-reset">
                        <p style="text-align: left">
                          <?= $row["jname"] ?>
                        </p>
                      </a>
                    </div>
                  </div>
                  <div class="row jobrequestdetail">
                    <div class="col-md-4">
                      <p style="text-align: left">Quantity :</p>
                    </div>
                    <div class="col-md-8">
                      <a href="" class="text-reset">
                        <p style="text-align: left">
                          <?= $row["quantity"] ?>
                        </p>
                      </a>
                    </div>
                  </div>
                  <div class="row jobrequestdetail">
                    <div class="col-md-4">
                      <p style="text-align: left">Skill :</p>
                    </div>
                    <a class="col-md-8 text-dark">
                      <span class="me-2" style="float: left">
                        <?= $row["skills"] ?>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            <div class="card-footer bg-white justify-content-center align-content-center text-center">
              <a href="update_request.php?rid=<?=$row["rid"]?>&status=<?=$STATUS_ACCEPT?>" class="accept-link">
                <button id="acceptbutton" class="btn btn-success ms-3 me-4 acceptbutton"> Accept </button>
              </a>

                <button id="denybutton" class="btn btn-outline-danger ms-4 me-3 denybutton" value="<?= $row["rid"] ?>"> Deny </button>

              <input id="rid_hidden" type="text" value="<?= $row["rid"] ?>" hidden/>
            </div>
          </div>
          <!--จุดจบของการวน for -->
        <?php endwhile; ?>
      </div>
    </div>
  </section>

  <div class="modal fade" id="denyModal" tabindex="-1" aria-labelledby="denyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <!--head-->
        <div class="modal-header">
          <h5 class="modal-title" id="denyModalLabel">Deny Request</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!--Body-->
        <div class="modal-body">
          <p>คุณแน่ใจหรือไม่ที่จะปฏิเสธคำขอนี้?</p>
          <hr />
          <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="commentdeny"
              style="height: 200px"></textarea>
            <label for="commentdeny">เพราะอะไร : </label>
          </div>
        </div>

          <!--Footer-->
        <div class="modal-footer">
          <a id="hee" style="display:hidden;">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal"> ยืนยัน </button>
          </a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        </div>
        
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function () {
      $(".denybutton").click(function () {
        $("#denyModal").modal("show"); // เรียก modal ที่คุณสร้างขึ้น
        $("#denyModal #hee").attr("href", "update_request.php?rid=" + $(this).val() + "&status=<?= $STATUS_REJECT ?>");
      });
    });
  </script>
</body>

</html>