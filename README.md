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


