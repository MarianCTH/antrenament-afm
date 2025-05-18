<?php
session_start();
require_once 'config/database.php';

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

// Handle submission time save
if (isset($_POST['submission_time']) && isset($_POST['fileName'])) {
    $fileName = $_POST['fileName'];
    $submission_time = (int)$_POST['submission_time'];
    $stmt = $pdo->prepare("INSERT INTO leaderboard (user_id, submission_time, idCerere) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $submission_time, $fileName]);
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
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
        <span id="timer">--</span>
    </div>
    <div class="container">
        <nav class="navbar">
            <div class="navbar-left">
                <div class="navbar-links">
                    <a href="leaderboard.php"><span>🏅</span>Leadertboard</a>
                    <a href="#"><span>📁</span>Dosar demo</a>
                    <a href="index.php"><span>🔄</span>Reincercare</a>
                </div>
            </div>
            <div class="navbar-user">
                <div class="navbar-user-icon">👤</div>
                <div class="navbar-user-info">
                    <span>Bună dimineața,<br><strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></span>
                    <a href='#'><small>TIMPI DUMNEAVOASTRĂ</small></a>
                </div>
                <button>Deconectare</button>
            </div>
        </nav>
        <h1>Vizualizare dosar</h1>
        <section class="form-section">
            <div class="grey">
                <span>📁</span>Fisiere incarcate pe acesta pagina nu sunt salvate!</a>
            </div>
            <div style="color: #4f971f;" class="d-flex justify-content-center my-3">
                <strong>Simulare a programului</strong>
            </div>
            <div class="d-flex transparent my-3">
                <div>
                    <strong>Simulare a programul de stimularea a innoirii Parcului national de tractoare si masini agricole autoproopulsate</strong><br>
                    <strong>Solicitanti: </strong><span>User</span><br>
                    <strong>Valoare achizitie: </strong>55.000EUR
                </div>
                <div>
                    <strong>Simulare a sesiunea de cerere de finantare tractoare si masini agricole autopropulsate</strong><br>
                    <strong>Cod: </strong> 123456789<br>
                    <strong>Autoscore:</strong> -
                </div>
            </div>
            <div class="my-3">
                <div class="grey">
                    <span>⌛</span>Istoric dosar
                </div>
                <div>
                    ⏱ <span>2025-01-01 12:00:00</span>   <span>Dosarul a fost creat</span><br>
                </div>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td colspan="11" class="py-3">a) cererea de finanțare, completată integral prin tehnoredactare, semnată cu semnătură electronică calificată bazată pe un certificat calificat emis de un prestator de servicii de încredere conform Regulamentului (UE) 910/2014</td>
                        <td class="col-1">
                            <input type="file" id="fileUpload" class="file-upload" name="fileUpload" disabled>
                            <label for="" class="btn btn-green">
                                ✅
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="11" class="py-3">b) actul de identitate al solicitantului, valabil la momentul înscrierii în aplicație;</td>
                        <td class="col-1">
                            <input type="file" id="fileUpload0" class="file-upload" name="fileUpload0">
                            <label for="fileUpload0" class="btn btn-primary">
                                ⬆️
                            </label>
                        </td>
                    </tr>
                     <tr>
                        <td colspan="11" class="py-3">c) certificatul de atestare fiscală privind obligațiile de plată către bugetul de stat, emis pe numele solicitantului de către organul teritorial de specialitate al Ministerului Finanțelor, în termen de valabilitate la momentul înscrierii în aplicație;</td>
                        <td class="col-1">
                            <input type="file" id="fileUpload1" class="file-upload" name="fileUpload1">
                            <label for="fileUpload1" class="btn btn-primary">
                                ⬆️
                            </label>
                        </td>
                    </tr>
                     <tr>
                        <td colspan="11" class="py-3">d) certificatul de atestare fiscală privind impozitele și taxele locale și alte venituri ale bugetului local, emis pe numele solicitantului de către autoritatea publică locală în a cărei rază teritorială își are domiciliul, în termen de valabilitate la momentul înscrierii în aplicație;</td>
                        <td class="col-1">
                            <input type="file" id="fileUpload2" class="file-upload" name="fileUpload2">
                            <label for="fileUpload2" class="btn btn-primary">
                                ⬆️
                            </label>
                        </td>
                    </tr>
                     <tr>
                        <td colspan="11" class="py-3">e) atestatul de producător, emis pe numele solicitantului, în termen de valabilitate la momentul înscrierii în aplicație</td>
                        <td class="col-1">
                            <input type="file" id="fileUpload3" class="file-upload" name="fileUpload3">
                            <label for="fileUpload3" class="btn btn-primary">
                                ⬆️
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="checkbox" id="checkbox" class="form-check-input"> Am citit si sunt de acord cu termenii și condițiile
            <div class="d-flex justify-content-between my-3">
                <a href="loadDocumetns.php" type="button" class="btn btn-danger">Reset</a>
                <button type="button" class="btn btn-primary" id="submitBtn" disabled>Depune dosar</button>
        </section>
    </div>
    <script>
        var fileToUpload = 4;
        var filesWereUpload = false;
        var checkboxValue = false;
        const timer = document.getElementById("timer");
        let sTime = localStorage.getItem("timer-start");
        sTime = parseInt(sTime, 10);

        $(document).ready(function() {
            $(".file-upload").change(function() {
                $(this).prop("disabled", true);
                 const $label = $(this).next();
                $label.html("✅");
                $label.removeClass("btn-primary").addClass("btn-green");
                fileToUpload--;
                checkIfAllFilesWereUploaded();
            });
            $("#checkbox").change(function() {
                checkboxValue = $(this).is(":checked");
                enableSubmitButton()
            });
            $("#submitBtn").click(function() {
                if (filesWereUpload && checkboxValue) {
                    const endTime = Date.now();
                    const submissionTime = Math.floor((endTime - sTime) / 1000);
                    const fileName = localStorage.getItem("fileName");
                    
                    // Save submission time to database
                    $.ajax({
                        url: 'loadDocumetns.php',
                        type: 'POST',
                        data: { submission_time: submissionTime, fileName: fileName },
                        success: function(response) {
                            if (response.success) {
                                localStorage.setItem("timer-end", endTime);
                                window.location.href = "results.php";
                            } else {
                                alert('Eroare la salvarea timpului. Vă rugăm să încercați din nou.');
                            }
                        },
                        error: function() {
                            alert('Eroare la salvarea timpului. Vă rugăm să încercați din nou.');
                        }
                    });
                } else {
                    console.log("Va rugam sa completati toate campurile necesare!");
                }
            });
            updateTimer();
            setInterval(updateTimer, 1000);
        });

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

        function checkIfAllFilesWereUploaded() {
            if (fileToUpload <= 0){
                filesWereUpload = true;
                enableSubmitButton()
            }
            else{
                filesWereUpload = false;
            }
        }

        function enableSubmitButton() {
            if (checkboxValue && filesWereUpload) {
                $("#submitBtn").prop("disabled", false);
            } else {
                $("#submitBtn").prop("disabled", true);
            }
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
