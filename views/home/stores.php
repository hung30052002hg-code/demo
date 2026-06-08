<!-- Leaflet Map CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<style>
    /* Custom Leaflet Map styling for Dark mode integration */
    .dark #map {
        border-color: #2D2D2D !important;
    }
    .dark .leaflet-tile-container {
        filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%);
    }
    .dark .leaflet-bar a, .dark .leaflet-control-zoom {
        background-color: #1E1E1E !important;
        color: #FBF9F6 !important;
        border-bottom-color: #2D2D2D !important;
    }
    .dark .leaflet-popup-content-wrapper, .dark .leaflet-popup-tip {
        background: #1E1E1E !important;
        color: #FBF9F6 !important;
        border: 1px solid #2D2D2D;
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="text-center space-y-4 mb-12 animate-fade-in-up">
        <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Tìm kiếm chi nhánh</h1>
        <p class="text-3xl sm:text-4xl font-playfair font-bold text-text-light">Hệ Thống Cửa Hàng</p>
        <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
    </div>

    <!-- Main Content Grid: Split Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch animate-fade-in-up" style="animation-delay: 100ms">
        
        <!-- Left Panel: Stores list (5 cols) -->
        <div class="lg:col-span-5 flex flex-col gap-4 max-h-[600px] overflow-y-auto pr-2 scrollbar-thin">
            
            <!-- Store HP -->
            <div onclick="focusStore(0)" 
                 class="store-card cursor-pointer bg-card border border-border/10 rounded-3xl p-6 hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 group"
                 id="store-card-0">
                <div class="flex justify-between items-start gap-4">
                     <span class="text-2xl">⚓</span>
                    <div class="flex-grow space-y-2">
                        <span class="bg-primary/10 border border-primary/20 text-primary text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full">Trụ sở chính</span>
                        <h3 class="font-playfair font-bold text-text-light text-lg group-hover:text-primary transition-colors">CHUS TEA Lạch Tray</h3>
                        <p class="text-xs text-text-gray dark:text-gray-400">Số 15 Lạch Tray, Quận Ngô Quyền, Hải Phòng</p>
                        
                        <div class="grid grid-cols-2 gap-2 text-[11px] text-text-gray dark:text-gray-500 pt-2 border-t border-border/10">
                            <span class="flex items-center gap-1">
                                📞 0904 050 257
                            </span>
                            <span class="flex items-center gap-1">
                                ⏰ 07:00 - 22:30
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store HN -->
            <div onclick="focusStore(1)" 
                 class="store-card cursor-pointer bg-card border border-border/10 rounded-3xl p-6 hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 group"
                 id="store-card-1">
                <div class="flex justify-between items-start gap-4">
                    <span class="text-2xl">🗼</span>
                    <div class="flex-grow space-y-2">
                        <span class="bg-primary/10 border border-primary/20 text-primary text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full">Chi nhánh Hà Nội</span>
                        <h3 class="font-playfair font-bold text-text-light text-lg group-hover:text-primary transition-colors">CHUS TEA Hoàn Kiếm</h3>
                        <p class="text-xs text-text-gray dark:text-gray-400">Số 45 Tràng Tiền, Quận Hoàn Kiếm, Hà Nội</p>
                        
                        <div class="grid grid-cols-2 gap-2 text-[11px] text-text-gray dark:text-gray-500 pt-2 border-t border-border/10">
                            <span class="flex items-center gap-1">
                                📞 0904 050 258
                            </span>
                            <span class="flex items-center gap-1">
                                ⏰ 07:00 - 23:00
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store HCM -->
            <div onclick="focusStore(2)" 
                 class="store-card cursor-pointer bg-card border border-border/10 rounded-3xl p-6 hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 group"
                 id="store-card-2">
                <div class="flex justify-between items-start gap-4">
                    <span class="text-2xl">🌴</span>
                    <div class="flex-grow space-y-2">
                        <span class="bg-primary/10 border border-primary/20 text-primary text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full">Chi nhánh Sài Gòn</span>
                        <h3 class="font-playfair font-bold text-text-light text-lg group-hover:text-primary transition-colors">CHUS TEA Đồng Khởi</h3>
                        <p class="text-xs text-text-gray dark:text-gray-400">Số 120 Đồng Khởi, Quận 1, TP. Hồ Chí Minh</p>
                        
                        <div class="grid grid-cols-2 gap-2 text-[11px] text-text-gray dark:text-gray-500 pt-2 border-t border-border/10">
                            <span class="flex items-center gap-1">
                                📞 0904 050 259
                            </span>
                            <span class="flex items-center gap-1">
                                ⏰ 07:00 - 23:00
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Panel: Leaflet Map (7 cols) -->
        <div class="lg:col-span-7 bg-card border border-border/10 rounded-3xl overflow-hidden shadow-2xl relative min-h-[400px] lg:min-h-0">
            <!-- Map Container -->
            <div id="map" class="w-full h-full min-h-[450px] lg:h-full z-10 border border-border/20 rounded-3xl"></div>
        </div>

    </div>
</div>

<!-- Leaflet Map Script -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // List of stores coordinates and details
    const stores = [
        {
            name: "CHUS TEA Lạch Tray",
            lat: 20.8530,
            lng: 106.6915,
            address: "Số 15 Lạch Tray, Quận Ngô Quyền, Hải Phòng",
            phone: "0904 050 257"
        },
        {
            name: "CHUS TEA Hoàn Kiếm",
            lat: 21.0252,
            lng: 105.8524,
            address: "Số 45 Tràng Tiền, Quận Hoàn Kiếm, Hà Nội",
            phone: "0904 050 258"
        },
        {
            name: "CHUS TEA Đồng Khởi",
            lat: 10.7765,
            lng: 106.7009,
            address: "Số 120 Đồng Khởi, Quận 1, TP. Hồ Chí Minh",
            phone: "0904 050 259"
        }
    ];

    let map;
    let markers = [];

    document.addEventListener("DOMContentLoaded", () => {
        // Init map focusing on Vietnam center view
        map = L.map('map').setView([16.0471, 108.2062], 6);

        // Load openstreetmap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Custom green theme pin
        const pinIcon = L.divIcon({
            html: `<div class="w-8 h-8 rounded-full bg-primary border-2 border-white flex items-center justify-center shadow-lg text-white">🧋</div>`,
            className: 'custom-pin-icon',
            iconSize: [32, 32],
            iconAnchor: [16, 32]
        });

        // Add markers
        stores.forEach((store, index) => {
            const marker = L.marker([store.lat, store.lng], { icon: pinIcon })
                .addTo(map)
                .bindPopup(`
                    <div class="space-y-1 p-1">
                        <h4 class="font-bold text-sm text-primary">${store.name}</h4>
                        <p class="text-xs text-gray-500">${store.address}</p>
                        <p class="text-[11px] text-gray-400 font-semibold">📞 ${store.phone}</p>
                    </div>
                `);
            markers.push(marker);
        });

        // Set default focus to the main HQ branch in Haiphong
        setTimeout(() => {
            focusStore(0);
        }, 800);
    });

    function focusStore(index) {
        if (!map) return;
        const store = stores[index];
        
        // Fly to store location with zoom level 15
        map.flyTo([store.lat, store.lng], 15, {
            animate: true,
            duration: 1.5
        });

        // Open marker popup
        setTimeout(() => {
            markers[index].openPopup();
        }, 1500);

        // Highlight selected store card in left list
        document.querySelectorAll('.store-card').forEach(card => {
            card.classList.remove('border-primary/40', 'bg-primary/5');
            card.classList.add('border-border/10');
        });
        const activeCard = document.getElementById(`store-card-${index}`);
        if (activeCard) {
            activeCard.classList.remove('border-border/10');
            activeCard.classList.add('border-primary/40', 'bg-primary/5');
        }
    }
</script>
