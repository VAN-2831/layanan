===LAYANAN===

isc-dhcp-server  
  → /etc/dhcp/dhcpd.conf           # konfigurasi utama DHCP  
  → /etc/default/isc-dhcp-server  # set interface yang dipakai (misal: eth0)  
  → **Cek status:** `systemctl status isc-dhcp-server` → harus *active (running)*  

vsftpd  
  → /etc/vsftpd.conf              # konfigurasi utama FTP server  
  → **Cek status:** `systemctl status vsftpd` → harus *active (running)*  

apache2  
  → /etc/apache2/apache2.conf     # konfigurasi global  
  → /etc/apache2/sites-available/000-default.conf  # konfigurasi virtual host default  
  → /var/www/html/                # lokasi file web  
  → **Cek status:** `systemctl status apache2` → harus *active (running)*  

php  
  → done                          # ikut jalan otomatis bareng Apache (via mod-php)  
  → **Cek:** Buat file `info.php` di `/var/www/html/` isi:  
    ```php
    <?php phpinfo(); ?>
    ```  
    Akses di browser: `http://IP_SERVER/info.php` → muncul halaman info PHP  

libapache2-mod-php  
  → done                          # modul PHP Apache, aktif otomatis setelah install  

php-sqlite3  
  → done                          # extension PHP untuk SQLite, langsung jalan  
  → **Cek:** Lihat di halaman `phpinfo()` ada bagian `SQLite3 support`  

sqlite3  
  → done                          # CLI database SQLite, gak perlu config  
  → **Cek:** Jalankan `sqlite3` di terminal → muncul prompt `sqlite>`  

postfix  
  → /etc/postfix/main.cf          # konfigurasi utama mail server  
  → Pilih "Local only" saat instalasi (bisa reconfig: `sudo dpkg-reconfigure postfix`)  
  → **Cek status:** `systemctl status postfix` → harus *active (running)*  

mailutils  
  → done                          # mail client (CLI), langsung bisa dipakai setelah install  
  → **Cek:** Kirim email lokal:  
    ```bash
    echo "test mail" | mail -s "percobaan" namauser
    ```  
    Lalu cek isi inbox: `mail`

===LAYANAN===
