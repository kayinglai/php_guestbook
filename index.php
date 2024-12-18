<?php

$name = '';
$email = '';
$message = '';
$readyToStore = false;

function connectToDB() {
    // Create connection
    $conn = new mysqli("localhost", "root", "", "guestbook");

    // Check connection
    if($conn->connect_error) {
        return false;
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

$conn = connectToDB();


/*
    STORING A GUESTBOOK ENTRY

    Get input via POST
    and prepare for Database
*/

if( $_SERVER['REQUEST_METHOD'] === "POST" &&
    isset($_POST['submit']) &&
    isset($_POST['name']) &&
    isset($_POST['email']) &&
    isset($_POST['message']) ) {
        
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $readyToStore = true;
}


/*
    Once the input (name, message, email) is ready
    we connect and store the data
*/

if($readyToStore && $conn) {
    
    // Connected successfully, insert data
    // TODO: show a nice message, in case a post with a non-unique email was submititted
    
    $sql = "INSERT INTO posts (name, email, message) VALUES ('$name', '$email', '$message')";
    
    if($conn->query($sql) === TRUE) {
        echo "Thank you! Your message was stored in the database :)";
    } else{
        echo "Error: " . $sql. "<br>" . $conn->error;
    }   

}


/*
    READING THE DATA

    Get the the guestbook entries from the database
    and prepare them as HTML
*/
    
    if($conn) {
        // get the data
        $sql = "SELECT * FROM posts ORDER BY created_at DESC";
        $result = $conn->query($sql);
        $posts = "";

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $posts .= '<div class="entry">
                    <div class="entry-header">
                        <span class="entry-name">'.$row['name'].'</span>
                        <span class="entry-date">'.date('d M Y', strtotime($row['created_at'])).'</span>
                    </div>
                    <p class="entry-message">'.$row['message'].'</p>
                </div>';
            }
        } else{
            echo "0 results";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Awesome Guestbook</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(to bottom, #000066, #000033);
            color: white;
            font-family: "Comic Sans MS", "Comic Sans", cursive;
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
            background: #000080;
            border: 4px solid white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }

        .title {
            font-size: 2.5rem;
            color: #ffff00;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin-bottom: 1rem;
        }

        .marquee {
            color: #00ffff;
            margin: 1rem 0;
        }

        .content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            padding: 1.5rem 1rem;
            backdrop-filter: blur(10px);
            height: fit-content;
        }

        .form-title {
            color: #00ffff;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1rem;
            padding: 0 0.5rem;
        }

        label {
            display: block;
            color: #00ffff;
            margin-bottom: 0.5rem;
        }

        input, textarea {
            width: 100%;
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            color: white;
            font-family: inherit;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .emoji-picker {
            display: flex;
            gap: 0.5rem;
            margin: 1rem 0.5rem;
            flex-wrap: wrap;
        }

        .emoji {
            font-size: 1.2rem;
            cursor: pointer;
            background: none;
            border: none;
            color: white;
            padding: 0.25rem;
        }

        .submit-btn {
            width: calc(100% - 1rem);
            margin: 0 0.5rem;
            padding: 0.5rem;
            background: linear-gradient(to right, #00ffff, #0066ff);
            border: 2px solid white;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-family: inherit;
        }

        .entries-container {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .entries-title {
            color: #00ffff;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .entry {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .entry-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .entry-name {
            color: #ffff00;
            font-weight: bold;
        }

        .entry-date {
            color: #00ffff;
            font-size: 0.8rem;
        }

        .entry-message {
            color: rgba(255, 255, 255, 0.9);
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            color: #00ffff;
            font-size: 0.9rem;
        }

        /* Add some retro decorations */
        .star {
            color: #ffff00;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1 class="title"><span class="star">⭐</span> My Awesome Guestbook <span class="star">⭐</span></h1>
            <marquee class="marquee">Welcome to my guestbook! • Please sign below! • Thanks for visiting! • Made with GeoCities • Best viewed in IE6 •</marquee>
        </header>

        <div class="content">
            <div class="form-container">
                <h2 class="form-title">✍️ Sign My Guestbook!</h2>
                <form method="post">
                    <div class="form-group">
                        <label>Your Name:</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Your Email:</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Your Message:</label>
                        <textarea name="message" required></textarea>
                    </div>
                    <div class="emoji-picker">
                        <button type="button" class="emoji">😊</button>
                        <button type="button" class="emoji">😂</button>
                        <button type="button" class="emoji">❤️</button>
                        <button type="button" class="emoji">👍</button>
                        <button type="button" class="emoji">🌟</button>
                        <button type="button" class="emoji">🎉</button>
                        <button type="button" class="emoji">💖</button>
                        <button type="button" class="emoji">✨</button>
                    </div>
                    <button name="submit" type="submit" class="submit-btn">Sign Guestbook!</button>
                </form>
            </div>

            <div class="entries-container">
                <h2 class="entries-title">📝 Recent Visitors</h2>
                <?= $posts ?>
            </div>
        </div>

        <footer class="footer">
            <p>© 2024 My Awesome Guestbook • Made with 💖 • Best viewed in IE6 • Last updated: 03/15/2024</p>
        </footer>
    </div>
</body>
</html>