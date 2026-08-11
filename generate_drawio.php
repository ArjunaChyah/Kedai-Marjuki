<?php

$diagramsDir = __DIR__ . '/../diagrams';
if (!file_exists($diagramsDir)) {
    mkdir($diagramsDir, 0777, true);
}

function createDrawioFile($filename, $title, $mermaidCode) {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<mxfile host="app.diagrams.net" type="device">' . "\n";
    $xml .= '  <diagram id="' . md5($title) . '" name="' . htmlspecialchars($title) . '">' . "\n";
    $xml .= '    <mxGraphModel dx="1200" dy="800" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="1169" pageHeight="827" math="0" shadow="0">' . "\n";
    $xml .= '      <root>' . "\n";
    $xml .= '        <mxCell id="0" />' . "\n";
    $xml .= '        <mxCell id="1" parent="0" />' . "\n";
    $xml .= '        <mxCell id="2" value="' . htmlspecialchars($mermaidCode) . '" style="shape=mxgraph.mermaid.diagram;whiteSpace=wrap;html=1;" vertex="1" parent="1">' . "\n";
    $xml .= '          <mxGeometry x="40" y="40" width="1000" height="700" as="geometry" />' . "\n";
    $xml .= '        </mxCell>' . "\n";
    $xml .= '      </root>' . "\n";
    $xml .= '    </mxGraphModel>' . "\n";
    $xml .= '  </diagram>' . "\n";
    $xml .= '</mxfile>';

    file_put_contents($filename, $xml);
}

$useCaseMermaid = <<<EOT
graph LR
    Buyer[Pembeli]
    Admin[Admin Kedai]

    UC1[Registrasi dan Login Akun]
    UC2[Melihat Katalog dan Detail Produk]
    UC3[Mencari dan Filter Kategori Produk]
    UC4[Kelola Keranjang Belanja]
    UC5[Checkout dan Buat Pesanan]
    UC6[Pilih Pembayaran QRIS atau Tunai]
    UC7[Konfirmasi Pembayaran QRIS]
    UC8[Melihat Riwayat dan Detail Pesanan]
    UC9[Pengaturan Profil Pembeli]

    UC10[Kelola Data Produk CRUD]
    UC11[Kelola Data Kategori CRUD]
    UC12[Verifikasi Pembayaran QRIS dan Cash]
    UC13[Update Status Pesanan Kedai]
    UC14[Kelola dan Upload Gambar QRIS]
    UC15[Melihat Daftar Pelanggan]
    UC16[Melihat Laporan Penjualan]

    Buyer --> UC1
    Buyer --> UC2
    Buyer --> UC3
    Buyer --> UC4
    Buyer --> UC5
    Buyer --> UC6
    Buyer --> UC7
    Buyer --> UC8
    Buyer --> UC9

    Admin --> UC1
    Admin --> UC10
    Admin --> UC11
    Admin --> UC12
    Admin --> UC13
    Admin --> UC14
    Admin --> UC15
    Admin --> UC16
EOT;

$sitemapMermaid = <<<EOT
graph TD
    Home[Halaman Utama Beranda]
    Catalog[Katalog Produk]
    Detail[Detail Produk]
    Login[Halaman Login]
    Register[Halaman Register]

    BuyerDash[Dashboard Pembeli]
    Cart[Keranjang Belanja]
    Checkout[Halaman Checkout]
    Payment[Halaman Pembayaran]
    Orders[Riwayat Pesanan Saya]
    OrderDetail[Detail Pesanan]
    Profile[Pengaturan Profil]

    AdminDash[Dashboard Admin]
    AdminProd[Kelola Produk]
    AdminCat[Kelola Kategori]
    AdminOrd[Kelola Pesanan]
    AdminPay[Verifikasi Pembayaran]
    AdminQris[Pengaturan QRIS]
    AdminUsers[Daftar Pelanggan]
    AdminRep[Laporan Penjualan]

    Home --> Catalog
    Home --> Detail
    Home --> Login
    Home --> Register

    Login --> BuyerDash
    Login --> AdminDash

    BuyerDash --> Cart
    BuyerDash --> Orders
    BuyerDash --> Profile

    Cart --> Checkout
    Checkout --> Payment
    Payment --> OrderDetail
    Orders --> OrderDetail

    AdminDash --> AdminProd
    AdminDash --> AdminCat
    AdminDash --> AdminOrd
    AdminDash --> AdminPay
    AdminDash --> AdminQris
    AdminDash --> AdminUsers
    AdminDash --> AdminRep
EOT;

$erdMermaid = <<<EOT
erDiagram
    USERS ||--o{ ORDERS : membuat
    USERS ||--o| CARTS : memiliki
    CARTS ||--o{ CART_ITEMS : berisi
    PRODUCTS ||--o{ CART_ITEMS : dimasukkan
    CATEGORIES ||--o{ PRODUCTS : mengkategorikan
    ORDERS ||--o{ ORDER_ITEMS : memiliki
    PRODUCTS ||--o{ ORDER_ITEMS : dipesan

    USERS {
        int id
        string name
        string email
        string password
        string role
        string phone
        text address
        timestamp created_at
    }

    CATEGORIES {
        int id
        string name
        string slug
        timestamp created_at
    }

    PRODUCTS {
        int id
        int category_id
        string name
        string slug
        text description
        int price
        int stock
        string image
        string status
        timestamp created_at
    }

    CARTS {
        int id
        int user_id
        timestamp created_at
    }

    CART_ITEMS {
        int id
        int cart_id
        int product_id
        int quantity
        timestamp created_at
    }

    ORDERS {
        int id
        int user_id
        string order_number
        string customer_name
        string customer_phone
        text customer_address
        text notes
        int total_price
        string payment_method
        string payment_status
        string order_status
        timestamp created_at
    }

    ORDER_ITEMS {
        int id
        int order_id
        int product_id
        string product_name
        int price
        int quantity
        int subtotal
        timestamp created_at
    }

    QRIS_SETTINGS {
        int id
        string qris_image
        text description
        boolean is_active
        timestamp created_at
    }
EOT;

$cdmMermaid = <<<EOT
classDiagram
    class User {
        +int id
        +string nama
        +string email
        +string role
        +string phone
        +string address
    }

    class Category {
        +int id
        +string nama_kategori
        +string slug
    }

    class Product {
        +int id
        +string nama_produk
        +int harga
        +int stok
        +string status
    }

    class Cart {
        +int id
        +int total_harga
    }

    class CartItem {
        +int jumlah
        +int subtotal
    }

    class Order {
        +int id
        +string nomor_pesanan
        +int total_bayar
        +string metode_pembayaran
        +string status_pembayaran
        +string status_pesanan
    }

    class OrderItem {
        +string nama_produk
        +int harga
        +int jumlah
        +int subtotal
    }

    class QrisSetting {
        +string gambar_qris
        +boolean status_aktif
    }

    User "1" -- "0..1" Cart : Memiliki
    Cart "1" -- "1..*" CartItem : Berisi
    Product "1" -- "0..*" CartItem : Diisi
    Category "1" -- "0..*" Product : Mengelompokkan
    User "1" -- "0..*" Order : Melakukan
    Order "1" -- "1..*" OrderItem : TerdiriDari
    Product "1" -- "0..*" OrderItem : DicatatDalam
EOT;

$pdmMermaid = <<<EOT
classDiagram
    class users {
        +INT id
        +VARCHAR name
        +VARCHAR email
        +VARCHAR password
        +VARCHAR role
        +VARCHAR phone
        +TEXT address
        +TIMESTAMP created_at
    }

    class categories {
        +INT id
        +VARCHAR name
        +VARCHAR slug
        +TIMESTAMP created_at
    }

    class products {
        +INT id
        +INT category_id
        +VARCHAR name
        +VARCHAR slug
        +TEXT description
        +INT price
        +INT stock
        +VARCHAR status
        +VARCHAR image
        +TIMESTAMP created_at
    }

    class carts {
        +INT id
        +INT user_id
        +TIMESTAMP created_at
    }

    class cart_items {
        +INT id
        +INT cart_id
        +INT product_id
        +INT quantity
        +TIMESTAMP created_at
    }

    class orders {
        +INT id
        +INT user_id
        +VARCHAR order_number
        +VARCHAR customer_name
        +VARCHAR customer_phone
        +TEXT customer_address
        +TEXT notes
        +INT total_price
        +VARCHAR payment_method
        +VARCHAR payment_status
        +VARCHAR order_status
        +TIMESTAMP created_at
    }

    class order_items {
        +INT id
        +INT order_id
        +INT product_id
        +VARCHAR product_name
        +INT price
        +INT quantity
        +INT subtotal
        +TIMESTAMP created_at
    }

    class qris_settings {
        +INT id
        +VARCHAR qris_image
        +TEXT description
        +BOOLEAN is_active
        +TIMESTAMP created_at
    }

    users "1" --> "0..1" carts
    carts "1" --> "0..*" cart_items
    products "1" --> "0..*" cart_items
    categories "1" --> "0..*" products
    users "1" --> "0..*" orders
    orders "1" --> "1..*" order_items
    products "1" --> "0..*" order_items
EOT;

$activityMermaid = <<<EOT
graph TD
    Start[Mulai Aktivitas] --> Step1[Pembeli Buka Website]
    Step1 --> Step2[Pilih Produk dan Tambah Keranjang]
    Step2 --> Step3[Buka Keranjang dan Klik Checkout]
    Step3 --> Step4[Isi Form Pelanggan dan Pilih Metode Bayar]
    
    Step4 --> CheckMethod{Pilih Metode Bayar?}
    CheckMethod -->|Pilih QRIS| QRISPage[Tampil QR Code QRIS]
    QRISPage --> ScanPay[Pembeli Scan dan Bayar via Wallet]
    ScanPay --> ClickPaid[Klik Tombol Saya Sudah Membayar]
    ClickPaid --> WaitAdmin[Status Pembayaran Menunggu Verifikasi]
    
    CheckMethod -->|Pilih Tunai| CashInfo[Tampil Petunjuk Bayar Tunai]
    CashInfo --> WaitAdmin
    
    WaitAdmin --> AdminCheck{Admin Cek Verifikasi Pembayaran}
    AdminCheck -->|Admin Setujui| Paid[Status Pembayaran LUNAS]
    AdminCheck -->|Admin Tolak| Rejected[Status Pembayaran DITOLAK]
    
    Paid --> Process[Kedai Memasak dan Menyiapkan Makanan]
    Process --> Ready[Pesanan Siap Diserahkan]
    Ready --> Finish[Pesanan Selesai]
EOT;

$flowchartMermaid = <<<EOT
graph TD
    Start[Mulai] --> CheckAuth{Apakah Sudah Login?}
    CheckAuth -->|Belum| FormLogin[Halaman Login dan Register]
    FormLogin --> CheckAuth
    
    CheckAuth -->|Sudah| Browse[Pilih Menu Makanan]
    Browse --> Cart[Masuk Keranjang Belanja]
    Cart --> Checkout[Buka Halaman Checkout]
    Checkout --> FormOrder[Isi Alamat dan Catatan]
    
    FormOrder --> PaymentChoice{Metode Pembayaran}
    PaymentChoice -->|Pilih QRIS| QRISPage[Scan Gambar QRIS]
    QRISPage --> ConfirmBuyer[Klik Saya Sudah Membayar]
    ConfirmBuyer --> AdminVerify[Status Menunggu Verifikasi]
    
    PaymentChoice -->|Pilih Tunai| CashPage[Petunjuk Pembayaran Tunai]
    CashPage --> AdminVerify
    
    AdminVerify --> AdminDecision{Keputusan Admin}
    AdminDecision -->|Setuju| StatusPaid[Status Pembayaran LUNAS]
    AdminDecision -->|Tolak| StatusReject[Status Pembayaran DITOLAK]
    
    StatusPaid --> Cook[Kedai Menyiapkan Makanan]
    Cook --> Deliver[Pesanan Diserahkan ke Pembeli]
    Deliver --> Done[Selesai]
EOT;

createDrawioFile($diagramsDir . '/use_case.drawio', 'Use Case Diagram', $useCaseMermaid);
createDrawioFile($diagramsDir . '/sitemap.drawio', 'Sitemap Diagram', $sitemapMermaid);
createDrawioFile($diagramsDir . '/erd.drawio', 'ERD Diagram', $erdMermaid);
createDrawioFile($diagramsDir . '/cdm.drawio', 'CDM Diagram', $cdmMermaid);
createDrawioFile($diagramsDir . '/pdm.drawio', 'PDM Diagram', $pdmMermaid);
createDrawioFile($diagramsDir . '/activity_diagram.drawio', 'Activity Diagram', $activityMermaid);
createDrawioFile($diagramsDir . '/flowchart.drawio', 'Flowchart Sistem', $flowchartMermaid);

echo "DRAWIO_FILES_CREATED_SUCCESS";
