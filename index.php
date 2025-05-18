<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depunere cerere nouă</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="timer">
        <span id="timer">Selectati programul Rabla pentru Tractoare a incepe!</span>
    </div>
    <div class="container">
        <nav class="navbar">
            <div class="navbar-left">
                <div class="navbar-links">
                    <a href="leaderboard.php"><span>🏅</span>Leadertboard</a>
                    <a href="DosarDemo.rar"><span>📁</span>Dosar demo</a>
                </div>
            </div>
            <div class="navbar-user">
                <div class="navbar-user-icon">👤</div>
                <div class="navbar-user-info">
                    <span>Bună dimineața,<br><strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></span>

                    <a href='#'><small>TIMPI DUMNEAVOASTRĂ</small></a>
                </div>
                <a href="?logout=1" class="btn btn-outline-danger">Deconectare</a>
            </div>
        </nav>
        <h1>Depunere cerere nouă</h1>
        <section class="form-section">
            <label for="program-select">Selectați programul de finanțare pentru care doriți depunerea cererii</label>
            <select id="program-select">
                <option> -- Selectați o sesiune aferentă programului de finanțare -- </option>
                <option value="startTimer">Sesiune depunere dosare de finanțare tractoare și mașini agricole autopropulsate</option>
            </select>
            <div class="cards">
                <div class="card corect">
                    <strong>2.000.000€</strong>
                    <span class="card-label corect">Disponibil rămas</span>
                </div>
                <div class="card">
                    <strong>Start time!</strong>
                    <span class="card-label">Dupa ce s-a selectat programul</span>
                </div>
                <div class="card">
                    <strong>Stop time!</strong>
                    <span class="card-label">Dupa ce dosarul este depus</span>
                </div>
                <div class="card">
                    <strong>0</strong>
                    <span class="card-label">Total incarcari simulate pe platforma</span>
                </div>
            </div>
            <div class="container transparent d-flex justify-content-between">
                <a id="dowload-link" href="CF_AFM_Tractoare_v1 .pdf" download="CF_AFM_Tractoare" class ="disabled-link"><button id="dowload-button" type="button" class="btn download-btn" disabled>⬇️ Descarcă model cerere</button></a>
                <button id="uploadCerere" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn download-btn" disabled>⬆️ Incarcă model cerere</button>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog-centered modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Incarca modelul de cerere</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form id="uploadForm" enctype="multipart/form-data" method="post">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Alegeți fișierul</label>
                                    <input class="form-control" type="file" id="formFile" name="file" accept=".pdf" required>
                                </div>
                                <div class="mb-3">
                                    <label for="captchaText" class="form-label">Introduceți codul din imagine</label>
                                    <div style="margin-bottom:8px;">
                                        <img src="captcha.php?rand=" id="captchaImage" style="border-radius:6px;vertical-align:middle;cursor:pointer;" title="Reîncarcă codul">
                                        <button type="button" id="refreshCaptcha" class="btn btn-sm btn-outline-secondary" style="margin-left:6px;vertical-align:middle;">↻</button>
                                    </div>
                                    <input class="form-control" type="text" id="captchaText" placeholder="Codul din imagine">
                                    <div id="captchaError" style="color:red;display:none;font-size:0.95em;margin-top:4px;margin-bottom:-5%;padding-bottom:-6%;"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveChangesBtn" type="button" class="btn btn-primary" tabindex="-1">Save changes</a>
                    </div>
                    </div>
                </div>
                </div>
            <div class="alert">
                Modelul de cerere trebuie completata!! Orice timp scos fara a fi completat modelul de cererea va fi considerat ca fiind un timp scos in mod eronat si ulterior sters.
            </div>
        </section>
    </div>
    <div class="footer-warning">
        <span><strong>Trebuie utilizată ultima versiune a cererii de finanțare disponibilă în pagina curentă.</strong> Aceasta trebuie completată utilizând <span class="highlight">Adobe Acrobat Reader DC</span> sau <span class="highlight">Adobe Acrobat Pro 2020</span> sau versiuni mai noi ale acestora, actualizate la zi. Completarea trebuie realizată manual, de către utilizator, fără a se apela la roboți informatici sau alte soluții de completare automată a formularului. În aplicație se va încărca cererea de finanțare completată electronic. În situația în care, în funcție de specificul fiecărei sesiuni/fiecărui program, cererea de finanțare este semnată electronic, aceasta NU trebuie imprimată și scanată!</span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
    var fileUploaded = false;
    var captchaValid = false;
    var randomNumber;
    $('#saveChangesBtn').on('click', function() {
        if (!fileUploaded) {
            $('#captchaError').text('Trebuie să încărcați un fișier înainte de a salva modificările.').show();
            return;
        }
        if (!captchaValid) {
            $('#captchaError').text('Captcha nu este valid. Vă rugăm să reintroduceți codul.').show();
            return;
        }
        var fileInput = $('#formFile')[0];
        if ('CF_AFM_Tractoare' + randomNumber + '.pdf' !== fileInput.files[0].name) {
            $('#captchaError').text('Vă rugăm să reîncărcați ultima cerere descarcata.').show();
            return;
        }
        var formData = new FormData();
        formData.append('file', fileInput.files[0]);   
        localStorage.setItem('fileName', fileInput.files[0].name); 

        $.ajax({
            url: 'upload_handler.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log('Upload successful:', response); // No JSON.parse!
                if (response.status === 'success') {
                    window.location.href = 'loadDocumetns.php';
                } else {
                    alert('Eroare: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Upload error:', error);
                alert('A apărut o eroare la trimiterea fișierului.');
            }
        });
    })
    
    $('#formFile').change(function() {
        fileUploaded = true;
    })

    const timer = document.getElementById('timer');
    
    function startTime(){
        sTime = Date.now();
        localStorage.setItem('timer-start', sTime);
    }

    function updateTimer() {
        if (sTime !== null) {
            const elapsedTime = Math.floor((Date.now() - sTime) / 1000);
            const minutes = Math.floor(elapsedTime / 60);
            const seconds = elapsedTime % 60;
            if(minutes < 1){
                if(seconds < 10){
                    timer.textContent = `00:0${seconds}`;
                } else {
                    timer.textContent = `00:${seconds}`;
                }
            }
            else if(minutes < 10){
                if(seconds < 10){
                    timer.textContent = `0${minutes}:0${seconds}`;
                } else {
                    timer.textContent = `0${minutes}:${seconds}`;
                }
            } else {
                if(seconds < 10){
                    timer.textContent = `${minutes}:0${seconds}`;
                } else {
                    timer.textContent = `${minutes}:${seconds}`
                }
            }
        }
    }

    $('#program-select').change(function() {
        if ($(this).val() === 'startTimer') {
            enableDowloadButton();
            startTime();
            updateTimer();
            setInterval(updateTimer, 1000);
        } else {
            disableButtons();
            timer.textContent = 'Selectati programul Rabla pentru Tractoare a incepe!';
            localStorage.removeItem('timer-start');
            sTime = null;
        }
    });

    $('#dowload-button').click(function() {
        if (sTime !== null) {
            enableModalButton();
        } else {
            disableButtons();
        }
    });

    // setInterval(updateTimer, 1000);

    function enableDowloadButton() {
        $('#dowload-link').removeClass('disabled-link');
        $('#dowload-button').removeAttr('disabled');
        randomNumber = Math.floor(Math.random() * 10000);
         $('#dowload-link').attr('download', 'CF_AFM_Tractoare' + randomNumber);
    }

    function enableModalButton() {
        $('#uploadCerere').removeAttr('disabled');
    }

    function disableButtons() {
        $('#dowload-link').addClass('disabled-link');
        $('#dowload-button').attr('disabled', 'disabled');
        $('#uploadCerere').attr('disabled', 'disabled');
    }

    // Refresh captcha image
    function refreshCaptcha() {
        var img = document.getElementById('captchaImage');
        img.src = 'captcha.php?rand=' + Math.random();
        document.getElementById('captchaText').value = '';
        document.getElementById('captchaError').style.display = 'none';
    }
    document.getElementById('refreshCaptcha').onclick = refreshCaptcha;
    document.getElementById('captchaImage').onclick = refreshCaptcha;
    // Validate captcha input via AJAX
    function checkCaptchaInput() {
        var val = document.getElementById('captchaText').value.trim();
        if (val.length === 0) {
            document.getElementById('captchaError').style.display = 'none';
            return;
        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'captcha_check.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200 && xhr.responseText === 'OK') {
                captchaValid = true;
                document.getElementById('captchaError').style.display = 'none';
            } else {
                document.getElementById('captchaError').style.display = 'block';
            }
        };
        xhr.send('captcha=' + encodeURIComponent(val));
    }
    document.getElementById('captchaText').addEventListener('input', checkCaptchaInput);
    // When modal opens, refresh captcha and disable button
    var exampleModal = document.getElementById('exampleModal');
    exampleModal.addEventListener('show.bs.modal', function () {
        refreshCaptcha();
    });
    </script>
</body>
</html>