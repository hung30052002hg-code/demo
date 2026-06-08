<?php
/**
 * Mailer Helper - Gửi email tự động xác nhận đơn hàng
 * Shoptrasua - Cửa hàng trà sữa online
 */

class Mailer
{
    /**
     * Gửi email xác nhận đơn hàng
     * @param string $toEmail Email nhận thư
     * @param int $orderId ID đơn hàng
     * @return bool
     */
    public static function sendOrderEmail($toEmail, $orderId)
    {
        $orderModel = new Order();
        $order = $orderModel->getById($orderId);
        if (!$order) return false;

        $items = $orderModel->getItems($orderId);

        // Tiêu đề email
        $subject = "Xác nhận đơn hàng #" . $orderId . " từ CHUS TEA";

        // Bố cục nội dung email HTML thiết kế sang trọng
        $htmlContent = "
        <html>
        <head>
            <title>Xác nhận đơn hàng</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f6f6f6; color: #333333; margin: 0; padding: 20px; }
                .container { max-width: 600px; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin: 0 auto; }
                .header { text-align: center; border-bottom: 2px solid #dc2626; padding-bottom: 20px; }
                .logo { font-size: 24px; font-weight: bold; color: #dc2626; text-decoration: none; }
                .content { padding: 20px 0; }
                .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
                .table th, .table td { padding: 10px; border-bottom: 1px solid #eeeeee; text-align: left; }
                .table th { background-color: #f9f9f9; font-weight: bold; }
                .total { text-align: right; font-size: 16px; font-weight: bold; color: #dc2626; padding-top: 15px; }
                .footer { text-align: center; font-size: 11px; color: #999999; margin-top: 30px; border-t: 1px solid #eeeeee; padding-top: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <span class='logo'>CHUS TEA</span>
                    <h2>Cảm ơn bạn đã đặt hàng!</h2>
                    <p>Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>
                </div>
                <div class='content'>
                    <p><strong>Xin chào " . htmlspecialchars($order['user_name']) . ",</strong></p>
                    <p>Dưới đây là thông tin chi tiết về đơn hàng <strong>#" . $orderId . "</strong> đặt ngày " . date('d/m/Y H:i', strtotime($order['created_at'])) . ":</p>
                    
                    <p>📍 <strong>Địa chỉ giao nhận:</strong> " . htmlspecialchars($order['shipping_address']) . "</p>
                    <p>📞 <strong>Số điện thoại:</strong> " . htmlspecialchars($order['phone']) . "</p>
                    <p>💳 <strong>Phương thức thanh toán:</strong> " . ($order['payment_method'] === 'ONLINE' ? 'Trực tuyến (QR Code)' : 'Khi nhận hàng (COD)') . "</p>
                    
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Kích cỡ</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                            </tr>
                        </thead>
                        <tbody>";

        foreach ($items as $item) {
            $htmlContent .= "
                            <tr>
                                <td>" . htmlspecialchars($item['product_name']) . "</td>
                                <td>" . $item['size'] . "</td>
                                <td>" . $item['quantity'] . "</td>
                                <td>" . number_format($item['price']) . "đ</td>
                            </tr>";
        }

        $htmlContent .= "
                        </tbody>
                    </table>
                    
                    <div class='total'>
                        Tổng số tiền thanh toán: " . number_format($order['total_money']) . "đ
                    </div>
                </div>
                
                <div class='footer'>
                    Đây là email tự động từ hệ thống cửa hàng CHUS TEA.<br>
                    Địa chỉ: Ngõ 33 Xuân Thị Tứ, Minh Hải, Hải Phòng | SĐT: 0904 050 257<br>
                    © 2024 CHUS TEA. All rights reserved.
                </div>
            </div>
        </body>
        </html>
        ";

        // Thiết lập header gửi mail HTML
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: CHUS TEA <no-reply@chustea.vn>' . "\r\n";

        // Gọi hàm gửi mail mặc định của PHP (cần cấu hình SMTP ở php.ini trên localhost)
        // Trong trường hợp localhost chưa cấu hình SMTP, hàm mail() sẽ trả về false nhưng không gây sập ứng dụng.
        try {
            return mail($toEmail, $subject, $htmlContent, $headers);
        } catch (Exception $e) {
            return false;
        }
    }

    /*
     * HƯỚNG DẪN TÍCH HỢP PHPMAILER GỬI SMTP THẬT (GMAIL/SENDGRID)
     * 
     * Hướng dẫn cài đặt:
     * Chạy lệnh CLI: composer require phpmailer/phpmailer
     * 
     * Code mẫu triển khai:
     * 
    public static function sendSMTPReal($toEmail, $subject, $htmlContent) {
        require 'vendor/autoload.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            // Cấu hình máy chủ SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';             // Máy chủ SMTP của Gmail
            $mail->SMTPAuth   = true;
            $mail->Username   = 'your-email@gmail.com';       // Tài khoản Gmail của bạn
            $mail->Password   = 'your-app-password';          // Mật khẩu ứng dụng Gmail (App Password)
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            // Người nhận và gửi
            $mail->setFrom('your-email@gmail.com', 'CHUS TEA');
            $mail->addAddress($toEmail);

            // Nội dung email HTML
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $htmlContent;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    */
}
