CREATE TABLE pesanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  paket VARCHAR(100),
  nama VARCHAR(100),
  hp VARCHAR(20),
  tanggal DATE,
  hari INT,
  peserta INT,
  harga INT,
  total INT
);
