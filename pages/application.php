<?php

if (isset($_POST['btn_pharmacist']) || isset($_POST['btn_sales_rep'])) {
    if (isset($_POST['btn_pharmacist'])) {
        $subject = 'New Regulatory Pharmacist Application';
        $postFile = $_FILES['resume'];
    }

    if (isset($_POST['btn_sales_rep'])) {
        $subject = 'New Med Rep Application';
        $postFile = $_FILES['sales_rep_resume'];
    }

    if (isset($postFile) && $postFile['error'] == 0) {

        if (empty($postFile) || $postFile['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            exit('No file uploaded or an error occurred.');
        }

        // (Optional) Validate file type & size
        $allowed = ['pdf', 'doc', 'docx'];
        $maxBytes = 2 * 1024 * 1024; // 2MB

        $tmpPath = $postFile['tmp_name'];
        $fileName = basename($postFile['name']);
        $fileSize = (int) $postFile['size'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed, true)) {
            http_response_code(400);
            exit('Invalid file type. Allowed: PDF, DOC, DOCX.');
        }
        if ($fileSize > $maxBytes) {
            http_response_code(400);
            exit('File too large. Max is 2MB.');
        }

        require 'MailService.php';
        require 'MailerConfig.php';

        $body = file_get_contents('../pages/template.html');

        $result = MailService::sendMail(
            'cherose.figuerra@gmail.com',
            $subject,
            $body,
            'no-reply@bluemantacorp.com',
            'Blue Manta',
            $tmpPath,
            $fileName
        );

        header('location: /bluemanta/#thankyou');
    } else {
        header('location: /bluemanta/#error');
    }

}
?>