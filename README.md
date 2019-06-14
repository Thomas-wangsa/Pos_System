# Pos_System

List Pembahasan :

1. Modul LOGIN
2. Modul user
3. Modul Customer
4. Modul Category
5. Modul PO
--------------------------
6. Modul Sales
----------------------------
7. Modul Surat Jalan
8. Modul Invoice
9. Modul Report



1. Modul LOGIN :
- login page
- reset password

2. Modul User level user ( owner,admin,staff ) :
- view user
- add,edit user 
- deactivated user ( no delete )
- updated level
- notifikasi email ? if no, required password when added.
- status : active, non-active
- field mandatory : name,email
- field optional : ? 
note : rekomendasi no_telp,foto

3. Modul Customer/Toko : 
- view customer
- add,edit customer 
- deactivated customer ( no delete )
- status : active, non-active
- field mandatory : category,name,mobile,owner
- field optional : address,relation_at,relation_end,comment

4. Modul Category
- view category
- add,edit category 
- deactivated category ( no delete )
- status : active, non-active
- field : name

5. Modul PO
- view PO
- add,edit PO 
- deactivated PO ( no delete )
- status : active,finished,non-active ( buat perhitungan report )
- field mandatory : customer_id,po_date
- field optional : internal_code,external_code


Question :
1. soal modul sales, mau dibuat modul sendiri atau embed ke list user ?
2. sales langsung di embed di level customer atau level PO ?
3. waktu buat surat jalan mau ada verifikasi quantity di PO atau ga ?
4. untuk server perlu minimal RAM 2 GB dengan catatan ga ada applikasi lain yang berjalan. ( perlu install xampp dll)
5. printer dah ready ?


