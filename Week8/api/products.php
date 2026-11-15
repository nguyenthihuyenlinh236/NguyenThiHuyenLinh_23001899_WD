        header('Allow: GET, POST, PUT, DELETE');
        fail(405, 'Phương thức không được hỗ trợ.');
        }
        if ($method === 'PUT' || $method === 'DELETE') {
        $id = productId();
        }
        if ($method === 'POST' || $method === 'PUT') {
        $product = readProduct();
        }

        // Đổi tài khoản và mật khẩu theo cấu hình MySQL của em.
        $pdo = new PDO('mysql:host=localhost;dbname=shopping_cart;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        // UPDATE đếm dòng khớp ID, kể cả khi gửi lại dữ liệu cũ.
        PDO::MYSQL_ATTR_FOUND_ROWS => true
        ]);

        switch ($method) {
        case 'GET':
        $stmt = $pdo->query('SELECT id, name, price, stock FROM products ORDER BY id');
        respond(200, ['success' => true, 'data' => $stmt->fetchAll()]);

        case 'POST':
        $stmt = $pdo->prepare(
        'INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)'
        );
        $stmt->execute($product);
        respond(201, ['success' => true, 'id' => (int) $pdo->lastInsertId()]);

        case 'PUT':
        $stmt = $pdo->prepare(
        'UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id'
        );
        $product['id'] = $id;
        $stmt->execute($product);
        if ($stmt->rowCount() === 0) {
        fail(404, 'Không tìm thấy sản phẩm.');
        }
        respond(200, ['success' => true, 'message' => 'Đã cập nhật sản phẩm.']);

        case 'DELETE':
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        if ($stmt->rowCount() === 0) {
        fail(404, 'Không tìm thấy sản phẩm.');
        }
        respond(200, ['success' => true, 'message' => 'Đã xóa sản phẩm.']);
        }
        } catch (Throwable $e) {
        error_log($e->getMessage());
        fail(500, 'Không thể xử lý yêu cầu trên máy chủ.');
        }