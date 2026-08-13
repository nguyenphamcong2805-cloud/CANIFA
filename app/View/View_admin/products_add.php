<?php include "header.php"; ?>
<style>
    
nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    color: #ecf0f1;
    text-decoration: none;
    font-weight: bold;
    padding: 10px 15px;
    display: inline-block;
    transition: 0.3s;
}

nav ul li a:hover {
    background-color: #1abc9c;
    border-radius: 5px;
    color: #fff;
}

.container {
    max-width: 800px;
    margin: 40px auto;
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #2c3e50;
}

form.form-admin label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #34495e;
}

form.form-admin input[type="text"],
form.form-admin input[type="number"],
form.form-admin input[type="file"],
form.form-admin textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    border: 1px solid #bdc3c7;
    font-size: 16px;
}

form.form-admin textarea {
    min-height: 100px;
    resize: vertical;
}

form.form-admin button {
    display: block;
    width: 100%;
    padding: 12px;
    background-color: gray;
    border: none;
    color: #fff;
    font-size: 18px;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

form.form-admin button:hover {
    background-color: #16a085;
}



</style>
<div class="container">
    <h2>Thêm Sản Phẩm Mới</h2>

    <form action="" method="POST" enctype="multipart/form-data" class="form-admin">
        <label for="ten_san_pham">Tên sản phẩm:</label>
        <input type="text" name="ten_san_pham" id="ten_san_pham" required>

        <label for="danh_muc_id">Danh mục:</label>
        <select name="danh_muc_id" id="danh_muc_id" required>
            <option value="1">Áo</option>
            <option value="2">Quần</option>
        </select>

        <label for="mo_ta">Mô tả:</label>
        <textarea name="mo_ta" id="mo_ta" required></textarea>

        <label for="hinh_anh">Hình ảnh:</label>
        <input type="file" name="hinh_anh" id="hinh_anh" required>

        <button type="submit">Thêm sản phẩm</button>
    </form>
</div>
<?php include "footer.php"; ?>
