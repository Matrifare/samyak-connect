<?php
/**
 * Secure Chat API Handler
 * Uses prepared statements for all database queries
 */
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
include_once '../lib/Security.php';

$DatabaseCo = new DatabaseConnection();
$connection = $DatabaseCo->dbLink;

// Validate action parameter
$action = isset($_GET['action']) ? Security::sanitizeAlphanumeric($_GET['action']) : '';

// Require authentication for all chat operations
if (!Security::isAuthenticated()) {
    header('Content-type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

switch ($action) {
    case 'chatheartbeat':
        chatHeartbeat($connection);
        break;
    case 'sendchat':
        sendChat($connection);
        break;
    case 'closechat':
        closeChat($connection);
        break;
    case 'startchatsession':
        startChatSession($connection);
        break;
    case 'chatname':
        chatName($connection);
        break;
    default:
        header('Content-type: application/json');
        echo json_encode(['error' => 'Invalid action']);
        exit;
}

if (!isset($_SESSION['chatHistory'])) {
    $_SESSION['chatHistory'] = array();
}

if (!isset($_SESSION['openChatBoxes'])) {
    $_SESSION['openChatBoxes'] = array();
}

function chatHeartbeat($connection) {
    $chatUser = Security::sanitizeInt($_SESSION['chatuser'] ?? 0);
    
    // Use prepared statement
    $stmt = $connection->prepare(
        "SELECT register.username, register.gender, register.photo1, 
                chat.`from`, chat.message, chat.`to`, chat.id, chat.sent, chat.recd 
         FROM chat, register 
         WHERE chat.`to` = ? AND recd = 0 AND chat.`from` = register.index_id 
         ORDER BY id ASC"
    );
    $stmt->bind_param("i", $chatUser);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = array();

    while ($chat = $result->fetch_assoc()) {
        if (!isset($_SESSION['openChatBoxes'][$chat['from']]) && isset($_SESSION['chatHistory'][$chat['from']])) {
            // Get existing history items
            if (is_array($_SESSION['chatHistory'][$chat['from']])) {
                $items = array_merge($items, $_SESSION['chatHistory'][$chat['from']]);
            }
        }

        // Sanitize message for output
        $message = sanitize($chat['message']);
        $username = Security::escape($chat['username']);
        
        // Default photo based on gender
        $photo = $chat['photo1'];
        if (empty($photo)) {
            $photo = ($chat['gender'] == 'Groom') ? 'male_small.png' : 'female_small.png';
        }
        $photo = Security::sanitizeAlphanumeric(pathinfo($photo, PATHINFO_FILENAME)) . '.' . 
                 Security::sanitizeAlphanumeric(pathinfo($photo, PATHINFO_EXTENSION));

        $item = [
            's' => '0',
            'u' => $username,
            'ph' => $photo,
            'f' => (string)$chat['from'],
            'm' => $message
        ];
        
        $items[] = $item;

        if (!isset($_SESSION['chatHistory'][$chat['from']])) {
            $_SESSION['chatHistory'][$chat['from']] = array();
        }

        $_SESSION['chatHistory'][$chat['from']][] = $item;

        unset($_SESSION['tsChatBoxes'][$chat['from']]);
        $_SESSION['openChatBoxes'][$chat['from']] = $chat['sent'];
    }
    $stmt->close();

    // Add timestamp messages for old open chat boxes
    if (!empty($_SESSION['openChatBoxes'])) {
        foreach ($_SESSION['openChatBoxes'] as $chatbox => $time) {
            if (!isset($_SESSION['tsChatBoxes'][$chatbox])) {
                $now = time() - strtotime($time);
                $timeFormatted = date('g:iA M dS', strtotime($time));

                if ($now > 180) {
                    $message = "Sent at " . Security::escape($timeFormatted);
                    $item = [
                        's' => '2',
                        'f' => (string)$chatbox,
                        'm' => $message
                    ];
                    
                    $items[] = $item;

                    if (!isset($_SESSION['chatHistory'][$chatbox])) {
                        $_SESSION['chatHistory'][$chatbox] = array();
                    }
                    $_SESSION['chatHistory'][$chatbox][] = $item;
                    $_SESSION['tsChatBoxes'][$chatbox] = 1;
                }
            }
        }
    }

    // Mark messages as received using prepared statement
    $updateStmt = $connection->prepare("UPDATE chat SET recd = 1 WHERE `to` = ? AND recd = 0");
    $updateStmt->bind_param("i", $chatUser);
    $updateStmt->execute();
    $updateStmt->close();

    header('Content-type: application/json');
    echo json_encode(['items' => $items]);
    exit(0);
}

function chatBoxSession($chatbox) {
    $items = array();
    
    if (isset($_SESSION['chatHistory'][$chatbox]) && is_array($_SESSION['chatHistory'][$chatbox])) {
        $items = $_SESSION['chatHistory'][$chatbox];
    }

    return $items;
}

function startChatSession($connection) {
    $items = array();
    
    if (!empty($_SESSION['openChatBoxes'])) {
        foreach ($_SESSION['openChatBoxes'] as $chatbox => $void) {
            $boxItems = chatBoxSession($chatbox);
            if (!empty($boxItems)) {
                $items = array_merge($items, $boxItems);
            }
        }
    }

    header('Content-type: application/json');
    echo json_encode([
        'username' => Security::escape($_SESSION['chatuser'] ?? ''),
        'items' => $items
    ]);
    exit(0);
}

function chatName($connection) {
    // Sanitize and validate input
    $userId = Security::sanitizeInt($_GET['usw'] ?? 0);
    
    if ($userId <= 0) {
        header('Content-type: application/json');
        echo json_encode(['unm' => ['']]);
        exit(0);
    }
    
    // Use prepared statement
    $stmt = $connection->prepare("SELECT username FROM register WHERE index_id = ? LIMIT 1");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $username = '';
    if ($row = $result->fetch_assoc()) {
        $username = Security::escape($row['username']);
    }
    $stmt->close();

    header('Content-type: application/json');
    echo json_encode(['unm' => [$username]]);
    exit(0);
}

function sendChat($connection) {
    date_default_timezone_set("Asia/Kolkata");
    $date = date('Y-m-d H:i:s');

    $from = Security::sanitizeInt($_SESSION['chatuser'] ?? 0);
    $to = Security::sanitizeInt($_POST['to'] ?? 0);
    $message = trim($_POST['message'] ?? '');
    
    // Validate inputs
    if ($from <= 0 || $to <= 0 || empty($message)) {
        echo "0";
        exit(0);
    }
    
    // Limit message length
    if (strlen($message) > 2000) {
        $message = substr($message, 0, 2000);
    }
    
    // Get sender username using prepared statement
    $stmt = $connection->prepare("SELECT username FROM register WHERE index_id = ? LIMIT 1");
    $stmt->bind_param("i", $from);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $from_user = '';
    if ($row = $result->fetch_assoc()) {
        $from_user = $row['username'];
    }
    $stmt->close();

    $_SESSION['openChatBoxes'][$to] = date('Y-m-d H:i:s', time());

    $messagesan = sanitize($message);

    if (!isset($_SESSION['chatHistory'][$to])) {
        $_SESSION['chatHistory'][$to] = array();
    }

    $_SESSION['chatHistory'][$to][] = [
        's' => '1',
        'u' => Security::escape($from_user),
        'f' => (string)$to,
        'm' => $messagesan
    ];

    unset($_SESSION['tsChatBoxes'][$to]);

    // Update online status using prepared statement
    $updateStmt = $connection->prepare("UPDATE online_users SET dt = NOW() WHERE matri_id = ?");
    $updateStmt->bind_param("i", $from);
    $updateStmt->execute();
    $updateStmt->close();

    // Insert chat message using prepared statement
    $insertStmt = $connection->prepare("INSERT INTO chat (`from`, `to`, message, sent) VALUES (?, ?, ?, ?)");
    $insertStmt->bind_param("iiss", $from, $to, $message, $date);
    $insertStmt->execute();
    $insertStmt->close();

    echo "1";
    exit(0);
}

function closeChat($connection) {
    $chatbox = Security::sanitizeInt($_POST['chatbox'] ?? 0);
    
    if ($chatbox > 0) {
        unset($_SESSION['openChatBoxes'][$chatbox]);
    }

    echo "1";
    exit(0);
}

function sanitize($text) {
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $text = str_replace("\n\r", "\n", $text);
    $text = str_replace("\r\n", "\n", $text);
    $text = str_replace("\n", "<br>", $text);
    return $text;
}
