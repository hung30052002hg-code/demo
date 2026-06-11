<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10 gap-4 animate-fade-in-up">
        <div class="space-y-2">
            <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Thanh toán trực tuyến</h1>
            <p class="text-3xl font-playfair font-bold text-white">Chuyển Khoản & Quét Mã QR</p>
            <div class="w-16 h-1 bg-primary rounded-full"></div>
        </div>
        <a href="<?php echo BASE_URL; ?>index.php?controller=order&action=detail&id=<?php echo $order['id']; ?>" 
           class="px-5 py-2.5 border border-white/20 hover:border-white/50 text-white text-xs font-bold rounded-xl hover:bg-white/5 transition-all duration-300">
            ← Quay Lại Đơn Hàng
        </a>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start animate-fade-in-up" style="animation-delay: 100ms">
        
        <!-- Left: Instruction & Details (2 columns) -->
        <div class="lg:col-span-2 bg-card border border-white/5 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
            <h2 class="text-sm font-bold uppercase tracking-wider text-white pb-4 border-b border-white/5">Thông Tin Giao Dịch</h2>
            
            <!-- Account Info Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <!-- Account Name -->
                <div class="bg-[#1A1A1A] border border-white/5 rounded-2xl p-4 space-y-1">
                    <span class="text-[11px] text-text-gray uppercase tracking-wider font-semibold">Chủ tài khoản nhận</span>
                    <div class="flex items-center justify-between">
                        <strong class="text-white text-base font-bold">VU LE PHI HUNG</strong>
                        <span class="text-xs text-primary font-bold px-2 py-0.5 bg-primary/10 rounded-lg">Momo & Ngân hàng</span>
                    </div>
                </div>

                <!-- Account Number / Service -->
                <div class="bg-[#1A1A1A] border border-white/5 rounded-2xl p-4 space-y-1">
                    <span class="text-[11px] text-text-gray uppercase tracking-wider font-semibold">Phương thức quét mã</span>
                    <strong class="text-white text-base block font-bold">Quét đa năng (VietQR / MoMo)</strong>
                </div>
            </div>

            <!-- Transaction Details with Copy Buttons -->
            <div class="space-y-4">
                <div class="bg-[#1A1A1A] border border-white/5 rounded-2xl p-5 space-y-4">
                    <!-- Amount -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <span class="text-[11px] text-text-gray uppercase tracking-wider font-semibold block">Số tiền cần chuyển</span>
                            <span class="text-white text-xl font-bold font-mono" id="amountVal"><?php echo number_format($order['total_money']); ?></span>
                            <span class="text-white text-sm font-bold font-mono">VND</span>
                        </div>
                        <button type="button" id="copyAmountBtn" onclick="copyText('<?php echo $order['total_money']; ?>', 'copyAmountBtn')"
                                class="self-start sm:self-center px-4 py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-semibold rounded-xl transition-all duration-300 border border-white/10 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                            </svg>
                            <span>Sao chép số tiền</span>
                        </button>
                    </div>

                    <div class="h-px bg-white/5"></div>

                    <!-- Memo Code -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <span class="text-[11px] text-text-gray uppercase tracking-wider font-semibold block">Nội dung chuyển khoản (Memo)</span>
                            <span class="text-primary-light text-xl font-bold font-mono" id="memoVal">DH<?php echo $order['id']; ?></span>
                        </div>
                        <button type="button" id="copyMemoBtn" onclick="copyText('DH<?php echo $order['id']; ?>', 'copyMemoBtn')"
                                class="self-start sm:self-center px-4 py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-semibold rounded-xl transition-all duration-300 border border-white/10 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                            </svg>
                            <span>Sao chép nội dung</span>
                        </button>
                    </div>
                </div>

                <!-- Guidance alert -->
                <div class="bg-primary/10 border border-primary/20 text-primary-light text-xs rounded-2xl p-4 flex items-start space-x-2.5">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="space-y-1">
                        <strong class="font-bold block text-sm">Lưu ý quan trọng:</strong>
                        <p class="leading-normal">
                            Vui lòng nhập <strong class="underline">chính xác tuyệt đối</strong> số tiền và nội dung chuyển khoản để hệ thống ghi nhận tự động nhanh nhất. Đơn hàng sẽ bắt đầu được pha chế ngay sau khi hệ thống nhận được khoản chuyển khoản của bạn.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Steps Progress list -->
            <div class="space-y-4 pt-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-white">Các bước thực hiện</h3>
                <div class="space-y-3 text-xs text-text-gray">
                    <div class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-white/5 border border-white/10 text-white flex items-center justify-center flex-shrink-0 font-bold">1</span>
                        <p class="mt-0.5">Mở ứng dụng Ngân hàng của bạn hoặc ví điện tử MoMo.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-white/5 border border-white/10 text-white flex items-center justify-center flex-shrink-0 font-bold">2</span>
                        <p class="mt-0.5">Chọn chức năng **Quét mã QR** và đưa camera quét hình ảnh mã QR bên cạnh.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-white/5 border border-white/10 text-white flex items-center justify-center flex-shrink-0 font-bold">3</span>
                        <p class="mt-0.5">Xác nhận chuyển đúng số tiền <strong class="text-white font-mono"><?php echo number_format($order['total_money']); ?>đ</strong> và nhập nội dung chuyển khoản <strong class="text-primary-light font-mono">DH<?php echo $order['id']; ?></strong>.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-white/5 border border-white/10 text-white flex items-center justify-center flex-shrink-0 font-bold">4</span>
                        <p class="mt-0.5">Sau khi giao dịch thành công trên app, ấn nút **Xác Nhận Đã Chuyển Khoản** để hoàn tất đơn hàng.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: QR Code Visualizer (1 column) -->
        <div class="bg-card border border-white/5 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl text-center">
            <h2 class="text-sm font-bold uppercase tracking-wider text-white pb-4 border-b border-white/5">Mã QR Thanh Toán</h2>
            
            <!-- QR code image container with premium layout -->
            <div class="relative group bg-white rounded-3xl p-4 shadow-xl border border-white/10 inline-block max-w-full">
                <!-- Outer styling glow -->
                <div class="absolute -inset-0.5 bg-gradient-to-br from-primary to-primary-light rounded-3xl blur opacity-10 group-hover:opacity-25 transition-opacity duration-300 -z-10"></div>
                <img src="<?php echo BASE_URL; ?>public/images/payment_qr.png?v=<?php echo time(); ?>" 
                     alt="Mã QR nhận tiền VU LE PHI HUNG" 
                     class="w-64 h-auto mx-auto rounded-2xl block object-contain">
            </div>

            <!-- CTA Confirm Button -->
            <div class="space-y-4 pt-2">
                <a href="<?php echo BASE_URL; ?>index.php?controller=payment&action=confirm&order_id=<?php echo $order['id']; ?>"
                   class="w-full bg-primary hover:bg-primary-hover text-white font-bold rounded-xl py-4 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>XÁC NHẬN ĐÃ CHUYỂN KHOẢN</span>
                </a>
                
                <a href="<?php echo BASE_URL; ?>index.php?controller=order&action=detail&id=<?php echo $order['id']; ?>" 
                   class="block text-xs text-text-gray hover:text-white transition-colors duration-300 font-medium pt-2">
                    Thanh toán sau / Xem chi tiết đơn hàng
                </a>
            </div>
        </div>

    </div>
</div>

<!-- Copy Clipboard Script -->
<script>
function copyText(text, btnId) {
    navigator.clipboard.writeText(text).then(function() {
        const btn = document.getElementById(btnId);
        const originalHTML = btn.innerHTML;
        btn.innerHTML = `
            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="text-emerald-400">Đã sao chép!</span>
        `;
        btn.classList.add('bg-emerald-500/10', 'border-emerald-500/20');
        setTimeout(function() {
            btn.innerHTML = originalHTML;
            btn.classList.remove('bg-emerald-500/10', 'border-emerald-500/20');
        }, 2000);
    }, function(err) {
        console.error('Không thể sao chép: ', err);
    });
}
</script>
