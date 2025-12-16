<?php
session_start();
$hash = '';
$verification_result = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        
        // Hashing process
        if (isset($_POST['hash'])) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $_SESSION['stored_hash'] = $hash;
        }
        
        // Verification process
        if (isset($_POST['verify']) && isset($_SESSION['stored_hash'])) {
            if (password_verify($password, $_SESSION['stored_hash'])) {
                $verification_result = 'Match';
            } else {
                $verification_result = 'No match';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تجزئة كلمة المرور - الواجب 2</title>
    <style>
        * {
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #34495e;
        }
        input[type="password"], input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        button, input[type="submit"] {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .hash-btn {
            background-color: #3498db;
            color: white;
        }
        .verify-btn {
            background-color: #2ecc71;
            color: white;
        }
        .result {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-right: 4px solid #3498db;
            text-align: right;
        }
        .result h3 {
            color: #2c3e50;
            margin-top: 0;
        }
        .hash-result, .verification-result {
            word-break: break-all;
            padding: 10px;
            background-color: #ecf0f1;
            border-radius: 3px;
            margin: 10px 0;
        }
        .match {
            color: #27ae60;
            font-weight: bold;
        }
        .no-match {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 تجزئة كلمة المرور والتحقق منها</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="password">كلمة المرور:</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
            </div>
            
            <div class="buttons">
                <input type="submit" name="hash" value="تجزئة (Hashing)" class="hash-btn">
                <input type="submit" name="verify" value="التحقق (Verification)" class="verify-btn">
            </div>
        </form>
        
        <?php if ($hash): ?>
        <div class="result">
            <h3>📊 نتيجة التجزئة:</h3>
            <p><strong>كلمة المرور المدخلة:</strong> <?php echo htmlspecialchars($password); ?></p>
            <div class="hash-result">
                <strong>التجزئة (Hash):</strong><br>
                <?php echo $hash; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($verification_result): ?>
        <div class="result">
            <h3>✅ نتيجة التحقق:</h3>
            <p><strong>كلمة المرور المدخلة:</strong> <?php echo htmlspecialchars($password); ?></p>
            <div class="verification-result">
                <strong>حالة التطابق:</strong>
                <span class="<?php echo strtolower(str_replace(' ', '-', $verification_result)); ?>">
                    <?php echo $verification_result; ?>
                </span>
            </div>
        </div>
        <?php endif; ?>
        
        <div style="margin-top: 30px; color: #7f8c8d; font-size: 14px;">
            <p>الجامعة الإسلامية بغزة - قسم الوسائط المتعددة وتطوير الويب</p>
            <p>مدرس المساق: صهيب إبراهيم أبو شعر</p>
        </div>
    </div>
</body>
</html>