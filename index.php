<?php
$db = new SQLite3('test.db');
$db->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, name TEXT, email TEXT)");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['action']) && $_POST['action'] === 'insert') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    if ($name && $email) {
      $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
      $stmt->bindValue(':name', $name, SQLITE3_TEXT);
      $stmt->bindValue(':email', $email, SQLITE3_TEXT);
      $stmt->execute();
    }
    exit;
  }

  if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $db->exec("DELETE FROM users");
    exit;
  }

  if (isset($_POST['action']) && $_POST['action'] === 'fetch') {
    $result = $db->query("SELECT * FROM users ORDER BY id DESC");
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      echo "<p>{$row['id']}. <strong>{$row['name']}</strong> - {$row['email']}</p>";
    }
    exit;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>YANDRA</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 20px;
      background-color: #111;
      color: #fff;
    }
    #welcome {
      animation: fadeOut 3s ease forwards;
      animation-delay: 2s;
    }
    #welcome h1 {
      font-size: 48px;
      margin-top: 20%;
      animation: glow 2s infinite alternate;
    }
    @keyframes glow {
      from { color: #fff; text-shadow: 0 0 10px #00f; }
      to { color: #0ff; text-shadow: 0 0 20px #0ff; }
    }
    @keyframes fadeOut {
      to { opacity: 0; visibility: hidden; }
    }
    #app {
      margin-top: 40px;
      display: none;
    }
    input, button {
      margin: 10px;
      padding: 10px;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <div id="welcome">
    <h1>WELCOME YANDRA</h1>
  </div>

  <div id="app">
    <h2>tambah data</h2>
    <form id="dataForm">
      <input type="text" name="name" placeholder="Nama" required>
      <input type="email" name="email" placeholder="Email" required>
      <button type="submit">Tambah</button>
    </form>

    <button onclick="loadData()">Lihat Data</button>
    <button onclick="deleteData()">Hapus Semua</button>

    <div id="result"></div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
        document.getElementById('welcome').style.display = 'none';
        document.getElementById('app').style.display = 'block';
        loadData();
      }, 5000);
    });

    document.getElementById('dataForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      formData.append('action', 'insert');
      await fetch('', { method: 'POST', body: formData });
      this.reset();
      loadData();
    });

    async function loadData() {
      const formData = new FormData();
      formData.append('action', 'fetch');
      const res = await fetch('', { method: 'POST', body: formData });
      const data = await res.text();
      document.getElementById('result').innerHTML = data;
    }

    async function deleteData() {
      if (confirm('Yakin hapus semua data?')) {
        const formData = new FormData();
        formData.append('action', 'delete');
        await fetch('', { method: 'POST', body: formData });
        loadData();
      }
    }
  </script>
</body>
</html>
