<?php
// Menentukan lokasi folder utama proyek di server
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');

// Menghubungkan file konfigurasi database
include ROOTPATH . "/config/config.php";

// Menyertakan file header (bagian atas halaman web)
include ROOTPATH . "/includes/header.php";
?>

<style>
body {
    background: #001BB7 !important;
}

.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.dashboard-title {
    font-size: 5rem;
    color: #fff;
    margin-bottom: 30px;
    letter-spacing: 1px;
    font-weight: 800;
    text-align: center;
}

.dashboard-title .judul-welcome {
    color: #ffffff;
    font-weight: 800;
    letter-spacing: 1px;
}

.dashboard-title .judul-mart {
    color: #B6F500;
    font-weight: 800;
    letter-spacing: 1px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 16px 0 rgba(0,0,0,0.08);
    padding: 25px;
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
    border: 2px solid transparent;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px 0 rgba(0,0,0,0.12);
    border-color: #B6F500;
}

.stat-number {
    font-size: 2.5em;
    font-weight: 800;
    color: #001BB7;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 1rem;
    color: #666;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.revenue {
    color: #28a745;
}

.warning {
    color: #dc3545;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 30px;
}

@media (max-width: 768px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }
}

.quick-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.action-btn {
    background: #B6F500;
    color: black;
    border: 1px solid #B6F500;
    border-radius: 8px;
    font-weight: 600;
    box-shadow: 0 1px 4px 0 rgba(74,222,128,0.12);
    padding: 12px 25px;
    text-decoration: none;
    display: inline-block;
    transition: background 0.2s, color 0.2s;
    font-size: 1rem;
}

.action-btn:hover {
    background: #B6F500;
    color: #065f46;
    text-decoration: none;
}

.table-container {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 16px 0 rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 20px;
}

.table-title {
    background: #B6F500;
    color: #001BB7;
    padding: 15px 20px;
    font-weight: 700;
    letter-spacing: 0.5px;
    font-size: 1.1em;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 1rem;
}

th, td {
    padding: 14px 18px;
    text-align: left;
    border-bottom: 1px solid #eef2f4;
}

th {
    background: #f8f9fa;
    color: #001BB7;
    font-weight: 700;
    letter-spacing: 0.5px;
}

td {
    color: #222;
}

tr:last-child td {
    border-bottom: none;
}

tr:hover {
    background: #f5fbe7;
    transition: background 0.2s;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85em;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.completed {
    background: #d4edda;
    color: #155724;
}

.status-badge.pending {
    background: #fff3cd;
    color: #856404;
}

.low-stock {
    color: #dc3545;
    font-weight: 700;
}

.empty-state {
    text-align: center;
    color: #666;
    padding: 40px 20px;
    font-style: italic;
}

.welcome-section {
    background: #f8f9fa;
    padding: 40px 20px;
    margin-bottom: 30px;
    border-radius: 16px;
    box-shadow: 0 4px 16px 0 rgba(0,0,0,0.08);
}

.welcome-content {
    text-align: center;
}

.welcome-title {
    font-size: 1.5em;
    font-weight: 700;
    margin-bottom: 10px;
}

.welcome-message {
    font-size: 1rem;
    color: #666;
    margin-bottom: 20px;
}

.welcome-features {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.feature-item {
    margin: 10px;
    padding: 10px;
    border: 1px solid #eef2f4;
    border-radius: 8px;
    width: calc(25% - 20px);
}

</style>

<div class="dashboard-container">
    <h2 class="dashboard-title">
        <span class="judul-welcome">Welcome to</span> <span class="judul-mart">Niki Mart</span>
    </h2>
    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="/niki mart/page/transactions/add.php" class="action-btn">➕ New Transaction</a>
        <a href="/niki mart/page/products/add.php" class="action-btn">📦 Add Product</a>
        <a href="/niki mart/page/cashiers/add.php" class="action-btn">👤 Add Cashier</a>
    </div>
    
    <?php
    // Query untuk mendapatkan statistik dashboard
    $total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM product"))['count'];
    $total_cashiers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM cashier"))['count'];
    $total_transactions = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM transactions"))['count'];
    $completed_transactions = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM transactions WHERE status = 'completed'"))['count'];
    $total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as revenue FROM transactions WHERE status = 'completed'"))['revenue'];
    $low_stock_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM product WHERE stock <= 5"))['count'];
    
    // Query untuk transaksi terbaru
    $recent_transactions = mysqli_query($conn, "
        SELECT t.id, t.code, t.total, t.date, c.name as cashier_name, t.status
        FROM transactions t
        JOIN cashier c ON t.id_cashier = c.id
        ORDER BY t.date DESC
        LIMIT 5
    ");
    
    // Query untuk produk dengan stok rendah
    $low_stock_query = mysqli_query($conn, "
        SELECT name, stock, unit_price
        FROM product
        WHERE stock <= 5
        ORDER BY stock ASC
        LIMIT 5
    ");
    
    // Query untuk produk terlaris (berdasarkan jumlah terjual)
    $best_sellers = mysqli_query($conn, "
        SELECT p.name, SUM(td.qty) as total_sold, p.unit_price
        FROM product p
        JOIN transaction_details td ON p.id = td.id_product
        JOIN transactions t ON td.id_transactions = t.id
        WHERE t.status = 'completed'
        GROUP BY p.id, p.name, p.unit_price
        ORDER BY total_sold DESC
        LIMIT 5
    ");
    ?>
    
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= number_format($total_products) ?></div>
            <div class="stat-label">Total Products</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number"><?= number_format($total_cashiers) ?></div>
            <div class="stat-label">Total Cashiers</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number"><?= number_format($total_transactions) ?></div>
            <div class="stat-label">Total Transactions</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number warning"><?= number_format($low_stock_products) ?></div>
            <div class="stat-label">Low Stock Items</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number"><?= number_format($completed_transactions) ?></div>
            <div class="stat-label">Completed</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number revenue">Rp <?= number_format($total_revenue, 0, ',', '.') ?></div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>
    
    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Recent Transactions -->
        <div class="table-container">
            <div class="table-title">📋 Recent Transactions</div>
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Cashier</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($recent_transactions) > 0): ?>
                        <?php while($transaction = mysqli_fetch_assoc($recent_transactions)): ?>
                        <tr>
                            <td><?= $transaction['code'] ?></td>
                            <td><?= $transaction['cashier_name'] ?></td>
                            <td>Rp <?= number_format($transaction['total'], 0, ',', '.') ?></td>
                            <td>
                                <span class="status-badge <?= $transaction['status'] ?>">
                                    <?= ucfirst($transaction['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="empty-state">No transactions found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Low Stock Alert -->
        <div class="table-container">
            <div class="table-title">⚠️ Low Stock Alert</div>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Stock</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($low_stock_query) > 0): ?>
                        <?php while($product = mysqli_fetch_assoc($low_stock_query)): ?>
                        <tr>
                            <td><?= $product['name'] ?></td>
                            <td class="low-stock"><?= $product['stock'] ?></td>
                            <td>Rp <?= number_format($product['unit_price'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="empty-state">✅ All products have sufficient stock!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Best Sellers -->
    <div class="table-container">
        <div class="table-title">🏆 Best Selling Products</div>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Total Sold</th>
                    <th>Unit Price</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($best_sellers) > 0): ?>
                    <?php while($product = mysqli_fetch_assoc($best_sellers)): ?>
                    <tr>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['total_sold'] ?></td>
                        <td>Rp <?= number_format($product['unit_price'], 0, ',', '.') ?></td>
                        <td class="revenue">Rp <?= number_format($product['total_sold'] * $product['unit_price'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="empty-state">No sales data available yet</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include ROOTPATH . "/includes/footer.php"; ?>