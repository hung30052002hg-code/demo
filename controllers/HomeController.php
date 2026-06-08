<?php
/**
 * HomeController - Trang chủ
 * Shoptrasua - Cửa hàng trà sữa online
 */

class HomeController
{
    /**
     * Trang chủ - Hiển thị sản phẩm nổi bật và danh mục
     */
    public function index()
    {
        $productModel = new Product();
        $categoryModel = new Category();

        // Lấy dữ liệu
        $featuredProducts = $productModel->getFeatured(8);
        $categories = $categoryModel->getAll();

        // Tiêu đề trang
        $pageTitle = 'Trang Chủ - ShopTraSua';

        // Render views
        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/home/index.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * API Chatbot AI phục vụ tư vấn đồ uống từ Database
     */
    public function chatbot()
    {
        // Nhận tin nhắn từ client
        $message = isset($_POST['message']) ? trim($_POST['message']) : '';
        
        $response = [
            'success' => true,
            'reply' => ''
        ];

        if (empty($message)) {
            $response['reply'] = '🤖 Xin chào! Mình là trợ lý ảo CHUS TEA. Mình có thể giúp gì cho bạn hôm nay?';
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        $apiConfig = file_exists(ROOT_PATH . 'config/api.php') ? require ROOT_PATH . 'config/api.php' : [];
        $apiKey = $apiConfig['openrouter_key'] ?? '';
        $userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
        
        // 1. Lấy dữ liệu sản phẩm trong kho để AI có thông tin thực tế tư vấn
        $productModel = new Product();
        $db = Database::getInstance();
        
        $productsList = [];
        try {
            $sql = 'SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id';
            $stmt = $db->query($sql);
            $productsList = $stmt->fetchAll();
        } catch (Exception $e) {
            // Bỏ qua lỗi DB
        }
        
        $menuContext = "Menu hiện tại của cửa hàng CHUS TEA:\n";
        foreach ($productsList as $p) {
            $menuContext .= "- {$p['name']} (ID sản phẩm: {$p['id']}, Danh mục: {$p['category_name']}, Giá size M: " . number_format($p['price']) . "đ, Giá size L: " . number_format($p['price_large']) . "đ, Mô tả: {$p['description']})\n";
        }
        
        $shopInfo = "
Thông tin cửa hàng CHUS TEA:
- Giờ mở cửa: 07:00 AM đến 10:30 PM hằng ngày (kể cả lễ tết).
- Địa chỉ: Ngõ 33 Xuân Thị Tứ, Minh Hải, Hải Phòng.
- Số điện thoại: 0904050257.
- Ưu đãi/Khuyến mãi:
  * Mã 'STARBUCKS10': Giảm 10k đơn từ 50k
  * Mã 'CHUSTEAFREE': Giảm 20k đơn từ 100k
  * Mã 'WELCOME50': Giảm 50k đơn từ 200k
- Giao hàng: MIỄN PHÍ giao hàng khu vực nội thành Quận 1 và lân cận (giao 15-30 phút).
- Khách hàng đang chat: " . ($userName ? $userName : "Khách vãng lai") . ".
- Xưng xô: Xưng là '🤖 Trợ lý ảo CHUS TEA' hoặc 'mình', gọi khách hàng là 'bạn' (hoặc gọi bằng tên là '$userName' nếu có tên). Trả lời lịch sự, thân thiện, mang tính hỗ trợ cao.
- Quy định định dạng:
  * Trả lời bằng tiếng Việt.
  * Câu trả lời ngắn gọn, tập trung, dễ đọc.
  * Định dạng bằng thẻ HTML cơ bản (sử dụng <br>, <strong>, <em>, không dùng markdown như **, #, * vì giao diện hiển thị là HTML thuần).
  * Khi giới thiệu sản phẩm có trong menu, hãy LUÔN LUÔN đính kèm đường dẫn chi tiết của sản phẩm đó dưới dạng thẻ HTML chính xác sau: <a href='index.php?controller=product&action=detail&id=ID_SẢN_PHẨM' class='text-primary hover:underline font-bold'>TÊN_SẢN_PHẨM</a>. Hãy thay thế ID_SẢN_PHẨM bằng ID sản phẩm thực tế từ danh sách.
";

        $systemPrompt = "Bạn là trợ lý ảo thông minh của cửa hàng trà sữa CHUS TEA. Hãy dùng thông tin dưới đây để trả lời khách hàng:\n" . $shopInfo . "\n" . $menuContext;
        
        $aiReply = '';
        
        // Gọi OpenRouter
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'HTTP-Referer: http://localhost/Shoptrasua',
            'X-Title: CHUS TEA Chatbot'
        ]);
        
        $postData = [
            'model' => 'google/gemini-2.5-flash',
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $message]
            ],
            'max_tokens' => 1000,
            'temperature' => 0.7
        ];
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_TIMEOUT, 8); // Giới hạn timeout 8 giây
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
        
        $apiResult = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $apiResult) {
            $resultDecoded = json_decode($apiResult, true);
            if (isset($resultDecoded['choices'][0]['message']['content'])) {
                $aiReply = trim($resultDecoded['choices'][0]['message']['content']);
            }
        }

        // 2. Fallback cục bộ nếu cURL lỗi hoặc không gọi được AI
        if (empty($aiReply)) {
            $messageLower = mb_strtolower($message);
            
            // Hỏi về sản phẩm nổi bật / ngon nhất
            if (strpos($messageLower, 'ngon nhất') !== false || strpos($messageLower, 'nổi bật') !== false || strpos($messageLower, 'bán chạy') !== false || strpos($messageLower, 'recommend') !== false || strpos($messageLower, 'gợi ý') !== false) {
                $products = $productModel->getFeatured(3);
                if (!empty($products)) {
                    $reply = '🤖 Các món ngon và nổi bật nhất tại cửa hàng được khách đặc biệt yêu thích:<br>';
                    foreach ($products as $p) {
                        $reply .= "- <a href='index.php?controller=product&action=detail&id={$p['id']}' class='text-primary hover:underline font-bold'>{$p['name']}</a> ({$p['category_name']}): <strong>" . number_format($p['price']) . "đ</strong><br>";
                    }
                    $reply .= 'Bạn hãy click vào tên món để xem chi tiết và đặt hàng nhé!';
                    $aiReply = $reply;
                } else {
                    $aiReply = '🤖 Hiện các món ngon của cửa hàng đang cháy hàng, bạn vui lòng xem danh sách menu nhé!';
                }
            }
            // Hỏi giá sản phẩm cụ thể hoặc tìm món trà sữa
            else if (strpos($messageLower, 'giá') !== false || strpos($messageLower, 'món') !== false || strpos($messageLower, 'có') !== false || strpos($messageLower, 'tìm') !== false || strpos($messageLower, 'trà') !== false || strpos($messageLower, 'sữa') !== false || strpos($messageLower, 'coffee') !== false || strpos($messageLower, 'cà phê') !== false) {
                $cleanKeyword = str_replace(['giá', 'bao nhiêu', 'có', 'không', 'món', 'bán', 'tìm', 'cho', 'mình', 'hỏi', 'sản phẩm', 'trà sữa', 'ly', 'cốc'], '', $messageLower);
                $cleanKeyword = trim($cleanKeyword);

                if (strlen($cleanKeyword) > 1) {
                    $sql = 'SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.name LIKE :keyword LIMIT 5';
                    $stmt = $db->prepare($sql);
                    $stmt->execute([':keyword' => '%' . $cleanKeyword . '%']);
                    $products = $stmt->fetchAll();

                    if (!empty($products)) {
                        $reply = '🤖 Mình tìm thấy các sản phẩm phù hợp với yêu cầu của bạn:<br>';
                        foreach ($products as $p) {
                            $reply .= "- <a href='index.php?controller=product&action=detail&id={$p['id']}' class='text-primary hover:underline font-bold'>{$p['name']}</a>: <strong>" . number_format($p['price']) . "đ</strong><br>";
                        }
                        $aiReply = $reply;
                    }
                }
            }
            
            // Nếu vẫn rỗng, trả về false để JS chạy rule-based fallback trên client
            if (empty($aiReply)) {
                $response['success'] = false;
            } else {
                $response['reply'] = $aiReply;
            }
        } else {
            $response['reply'] = $aiReply;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    /**
     * Hệ thống cửa hàng - Store Locator
     */
    public function stores()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();
        $pageTitle = 'Hệ Thống Cửa Hàng - CHUS TEA';

        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/home/stores.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }
}
