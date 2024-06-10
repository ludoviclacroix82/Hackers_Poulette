<?php
session_start();

$arrayGender = array(
    '' => 'Select your gender',
    'Mister' => 'Male',
    'Miss' => 'Female',
    'Mx' => 'Non-binary',
    'noreply' => 'Prefer not to say'
);

$arraySubject = array(
    '' => 'Select a subject',
    'order_issue' => 'Order Issue',
    'technical_support' => 'Technical Support',
    'general_inquiry' => 'General Inquiry'
);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackers Poulette</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <header></header>
    <main>
        <section class="form-control from">
            <?php 
                $delai = 5; 
                $url = './';
                if(!empty($_SESSION['sendMail'])){
                    if($_SESSION['sendMail'] == true){    
                        echo '<div class="alert alert-success" role="alert">Your email has been successfully sent, and a copy has been sent to you at the address <b>'.$_SESSION['email'].'</b></div>';
                        session_destroy();
                    }else{
                        echo '<div class="alert alert-danger" role="alert">Message could not be sent.</div>';

                    }
                    
                    header("Refresh: $delai;url=$url");
                }
            ?>
            
            <form method="post" action="process_form.php">
                <div class="form-group">
                    <label for="object">Select a subject:</label>
                    <select class="form-control" name="gender" id="gender" aria-label="Select your gender">
                        <?php
                        foreach ($arrayGender as $key => $value) {
                            $disabled = ($key == '') ? 'disabled' : '';
                            $selected = (!empty($_SESSION['gender']) && $_SESSION['gender'] == $key) ? 'selected' : (($key == '') ? 'selected' : '');
                            echo '<option value="' . $key . '" ' . $selected . ' ' . $disabled . '>' . $value . '</option>';
                        }
                        ?>
                    </select>
                    <div class="error">
                        <?php echo (!empty($_SESSION['errorGender'])) ? $_SESSION['errorGender'] : ''; ?>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="userName">
                        <input type="text" class="form-control" name="name" id="name" aria-label="Your name" placeholder="Name" value="<?php echo (!empty($_SESSION['name'])) ? $_SESSION['name'] : ''; ?>">
                        <input type="text" class="form-control" name="lastName" id="lastName" aria-label="Your last name" placeholder="Last name" value="<?php echo (!empty($_SESSION['lastName'])) ? $_SESSION['lastName'] : ''; ?>">
                    </div>
                    <div class="error">
                        <?php echo (!empty($_SESSION['errorName']) || !empty($_SESSION['errorLastName'])) ? $_SESSION['errorName'] . '<br>' . $_SESSION['errorLastName'] : ''; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" aria-label="Your Email" placeholder="Email" value="<?php echo (!empty($_SESSION['email'])) ? $_SESSION['email'] : ''; ?>">
                    <div class="error"><?php echo (!empty($_SESSION['errorEmail'])) ? $_SESSION['errorEmail'] : ''; ?></div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="country" id="country" aria-label="Your country" placeholder="Country" value="<?php echo (!empty($_SESSION['country'])) ? $_SESSION['country'] : ''; ?>">
                    <div class="error">
                        <?php echo (!empty($_SESSION['errorCountry'])) ? $_SESSION['errorCountry'] : ''; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject">Select a subject:</label>
                    <select class="form-control" name="subject" id="subject" aria-label=">Select a subject">
                        <?php
                        foreach ($arraySubject as $key => $value) {
                            $disabled = ($key == '') ? 'disabled' : '';
                            $selected = ($_SESSION['subject'] == $key) ? 'selected' : '';
                            echo '<option value="' . $key . '" ' . $selected . ' ' . $disabled . '>' . $value . '</option>';
                        }
                        ?>
                    </select>
                    <div class="error">
                        <?php echo (!empty($_SESSION['errorSubject'])) ? $_SESSION['errorSubject'] : ''; ?>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="message" name="message" rows="6" aria-label="Your message" placeholder="Your message"><?php echo (!empty($_SESSION['message'])) ? $_SESSION['message'] : ''; ?></textarea>
                    <div class="error">
                        <?php echo (!empty($_SESSION['errorMessage'])) ? $_SESSION['errorMessage'] : ''; ?>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </section>
    </main>
    <footer></footer>
</body>

</html>