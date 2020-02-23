# Pos_System

1. Modul LOGIN
2. Modul user
3. Modul Customer
4. Modul Category
5. Modul PO
--------------------------
----------------------------
7. Modul Surat Jalan
8. Modul Invoice
9. Modul Report



1. Modul LOGIN :
- login page
- reset password

2. Modul User level user ( owner,admin,sales ) :
- view user ( owner, admin )
- add,edit user  ( owner, admin )
- deactivated user ( no delete ) owner
- notifikasi email ? if no, required password when added. ( tambahin password )
- status : active, non-active
- field mandatory : name,email,password, handphone

3. Modul Customer/Toko : ( salaes embed di level customer)
- view customer ( owner,admin,sales khusus punya dia sendiri)
- add,edit customer ( owner, admin )
- deactivated customer ( no delete ) (owner)
- status : active, non-active, warning
- field mandatory : category,name,mobile,owner, sales
- field optional : address,relation_at,relation_end,comment

4. Modul Category => Config ( + add data supir)
- view category
- add,edit category 
- deactivated category ( no delete )
- status : active, non-active
- field : name

5. Modul PO 
- view PO ( owner,admin,sales khusus punya dia sendiri)
- add,edit PO  ( owner, admin )
- deactivated PO ( no delete ) 
- deactivated customer ( no delete ) (owner)
- status : active,finished,non-active ( buat perhitungan report )
- field mandatory : customer_id,po_date,po_number
- field optional : 


Question :
3. waktu buat surat jalan mau ada verifikasi quantity di PO atau ga ?
4. untuk server perlu minimal RAM 2 GB dengan catatan ga ada applikasi lain yang berjalan. ( perlu install xampp dll)
5. printer dah ready ?









-----------------------
1. penulisan SJ gmn ?
2. penulisan INV gmn ?
3. inv selalu di buat bareng sj atau gmn ? kalau bareng penomoran,date dan info2 lainnya gmn ?
4. 

----------------------
1. Sales dari role sales/owner.
2. Category pindah ke level PO.
3. Tempo Pembayaran -> di isi di level PO : CASH,30D,60D ( Otomatis kwitnasi dari sini)
4. no po = 1
   no sj == no. kwitansi -> no/"00000"id-customer/BulanRomawi/Tahun -> 290/0300/IX/2019
5. ada validasinya quantity di Delivery Order, 
6. PO ada status = in-
7. 
-- 5. pas buat PO baru


1. ubah UI -> 1 mggu -> done
2. full fitur semua -> 2 minggu -> done
3. category pindah ke po -> 3 hari ->done
4. tempo pembayaran -> 2 hari -> done
5. patern no surat jalan sama kwitansi - 3 hari ->done 
6. validasi di surat jalan ke po - 3 hari -> done
7. report 1 mgu
8. print + siapin fitur nya -> 2 minggu
9. aut + role ->  1minggu -> done



- tambahan pcs,set / lembar di PO page (Done)
- bug di delivery order PO success/failed (Done)
- patern name PO, Delivery Order & Invoice
- report PO
- tambah modul listing price
- tambah kolom maker -> di delivery order buat internal note (Done)