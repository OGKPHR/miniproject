<!DOCTYPE html>
<html lang="en">
  <head>
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
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
      integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
      integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
      crossorigin="anonymous"
    ></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
      .profileimagerate {
        height: 25vh;
        object-fit: cover;
        object-position: center;
      }
      .profileimagerate {
        border-radius: 10px;
      }
      body {
        background-image: url(https://images.pexels.com/photos/1166644/pexels-photo-1166644.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1);
        background-repeat: no-repeat;
        background-size: cover;
        position: relative; /* เพื่อให้ ::before มีตำแหน่งเริ่มต้นใน body */
      }

      body::before {
        content: "";
        background-color: rgba(0, 0, 0, 0.262); /* สี overlay */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1; /* ทำให้ overlay อยู่ด้านหลังของ background */
      }
      .head {
        background-color: rgb(255, 255, 255);
        justify-content: center;
      }
      .contenteiei {
        background-color: rgba(0, 0, 0, 0.478);
      }
      .inputrate {
        width: 20%;
      }
      .input-group-text {
        width: 40%;
      }
    </style>
  </head>
  <body>
    <section>
      <div class="container py-5">
        <div class="row justify-content-center mb-3 contenteiei">
          <h1 class="text-center head">Rate interview</h1>
          <!--เริ่มวน for -->
          <div class="col-md-12 col-xl-10 mb-2">
            <div class="card shadow-0 border rounded-3 boxemp">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                    <div
                      class="bg-image hover-zoom ripple rounded ripple-surface"
                    >
                      <img
                        src="https://m.media-amazon.com/images/I/71JpPdKSEAL._AC_UY1100_.jpg"
                        class="w-100 profileimagerate"
                        alt=""
                      />
                      <a href="#!">
                        <div class="hover-overlay">
                          <div
                            class="mask"
                            style="background-color: rgba(253, 253, 253, 0.15)"
                          ></div>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xl-6">
                    <h5>Name : Tony Stark</h5>
                    <hr />

                    <p class="text-truncate mb-4 mb-md-0">
                      Skill : มหาเศรษฐี อัจฉริยะ เพลย์บอย แถมยังใจบุญ
                    </p>
                    <p class="text-truncate mb-4 mb-md-0">
                      ยังคิดไม่ออกว่าต้องแสดงอะไร :
                    </p>
                    <p class="text-truncate mb-4 mb-md-0">
                      ยังคิดไม่ออกว่าต้องแสดงอะไร :
                    </p>
                  </div>
                  <div
                    class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start"
                  >
                    <div
                      class="d-flex flex-column mt-4 align-content-center justify-content-center"
                    >
                      <button
                        class="btn btn-primary btn-lg"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#rateModal"
                      >
                        ให้คะแนน
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--จบการ for -->
        </div>
      </div>
    </section>
    <!--modal-->
    <div
      class="modal fade"
      id="rateModal"
      tabindex="-1"
      aria-labelledby="rateModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rateModalLabel">ให้คะแนน</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <h4>ชื่อ : ชื่อ นามสกุล</h4>
            <hr />
            <div class="input-group mb-3">
              <!--คะแนนด้านเทคนิค-->
              <span class="input-group-text" id="technic">คะแนนเทคนิค</span>
              <input
                type="text"
                class="form-control inputrate"
                aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default"
              />
            </div>
            <!--คะแนนด้านความคิดสร้างสรรค์-->
            <div class="input-group mb-3">
              <span class="input-group-text" id="creativity"
                >คะแนนความคิดสร้างสรรค์</span
              >
              <input
                type="text"
                class="form-control inputrate"
                aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default"
              />
            </div>
            <!--มนุษยสัมพันธ์-->
            <div class="input-group mb-3">
              <span class="input-group-text" id="human_relations"
                >คะแนนมนุษยสัมพันธ์</span
              >
              <input
                type="text"
                class="form-control inputrate"
                aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default"
              />
            </div>
            <!--การเรียนรู้-->
            <div class="input-group mb-3">
              <span class="input-group-text" id="learning"
                >คะแนนการเรียนรู้</span
              >
              <input
                type="text"
                class="form-control inputrate"
                aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default"
              />
            </div>
            <hr />
            <!--ข้อเสนอแนะ-->
            <div class="form-floating">
              <textarea
                class="form-control"
                placeholder="Leave a comment here"
                id="floatingTextarea2"
                style="height: 100px"
              ></textarea>
              <label for="floatingTextarea2">ข้อเสนอแนะ</label>
            </div>
            <hr />
            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="checkbox"
                id="inlineCheckbox1"
                value="option1"
              />
              <label class="form-check-label" for="inlineCheckbox1"
                >ผ่านการสัมภาษณ์</label
              >
            </div>
            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="checkbox"
                id="inlineCheckbox2"
                value="option2"
              />
              <label class="form-check-label" for="inlineCheckbox2"
                >ไม่ผ่านการสัมภาษณ์</label
              >
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="submitRating">
              ยืนยัน
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              ปิด
            </button>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script>
    document
      .getElementById("submitRating")
      .addEventListener("click", function () {
        // ดึงคะแนนที่กรอกจาก input
        var rating = document.getElementById("ratingInput").value;

        // ดำเนินการเกี่ยวกับคะแนนที่ได้รับ (เช่น ส่งไปยังเซิร์ฟเวอร์)

        // ซ่อน Modal
        var rateModal = new bootstrap.Modal(
          document.getElementById("rateModal")
        );
        rateModal.hide();
      });
    var checkboxes = document.querySelectorAll(".form-check-input");

    checkboxes.forEach(function (checkbox) {
      checkbox.addEventListener("change", function () {
        checkboxes.forEach(function (checkbox) {
          checkbox.checked = false; // ยกเลิกการเลือกทุกช่อง
        });
        this.checked = true; // เลือกเฉพาะช่องนี้
      });
    });
  </script>
</html>
