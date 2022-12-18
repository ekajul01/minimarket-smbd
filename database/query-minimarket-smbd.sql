CREATE VIEW v_barang AS
SELECT a.*, b.nama_kategori FROM barang a, kategori b 
WHERE a.id_kategori = b.id_kategori;
SELECT * FROM v_barang;

CREATE VIEW v_laporan2 AS
SELECT a.id_barang AS ID_Barang, 
	nama_barang AS Nama_Barang, 
	a.jumlah AS Jumlah,
	harga_beli*a.jumlah AS Modal,
	total AS Total,
	nm_member AS Nama_Kasir, 
	tanggal_input AS Tanggal_Input, 
	periode AS Periode
FROM nota a, barang b, MEMBER c
WHERE a.id_barang = b.id_barang AND a.id_member = c.id_member;

DELIMITER //
CREATE PROCEDURE sp_upktgr (
IN id INT(5),
IN nama VARCHAR(20))
	BEGIN
		UPDATE kategori SET
		nama_kategori = nama
		WHERE id_kategori = id;
	END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE sp_countStok (OUT stok1 INT(11))
	BEGIN
		SELECT SUM(stok) INTO stok1 FROM barang;
	END //
DELIMITER ;

CALL sp_countStok(@stok1);
SELECT @stok1

DELIMITER //
CREATE PROCEDURE sp_countTerjual(OUT jmljual INT(11))
	BEGIN
		SELECT SUM(jumlah) INTO jmljual FROM nota;
	END //
DELIMITER ;

CALL sp_countTerjual(@jmljual);
SELECT @jmljual

DELIMITER //
CREATE PROCEDURE sp_countIDBarang (OUT jumlahbrg INT(11))
	BEGIN
		SELECT COUNT(id_barang) INTO jumlahbrg FROM barang;
	END //
DELIMITER ;

CALL sp_countIDBarang(@jumlahbrg);
SELECT @jumlahbrg

DELIMITER //
CREATE TRIGGER updateStok
AFTER INSERT ON nota FOR EACH ROW
	BEGIN
		UPDATE barang SET stok = stok - NEW.jumlah 
		WHERE id_barang = NEW.id_barang;
	END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE jumlahKtgr (
	INOUT ktgrList INT(11)
)
BEGIN
	DECLARE finished INTEGER DEFAULT 0;
	DECLARE idKategori VARCHAR(100) DEFAULT "";

	-- declare cursor nama kategori
	DECLARE curKategori 
		CURSOR FOR 
			SELECT COUNT(id_kategori) FROM kategori;

	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished = 1;

	OPEN curKategori;

	getKategori: LOOP
		FETCH curKategori INTO idKategori;
		IF finished = 1 THEN 
			LEAVE getKategori;
		END IF;
		-- build nama kategori list
		SET ktgrList = CONCAT(idKategori);
	END LOOP getKategori;
	
	CLOSE curKategori;

END //
DELIMITER ;

CALL jumlahKtgr(@ktgrList); 
SELECT @ktgrList;