<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('Atsauksmes')->truncate();
        DB::table('PasutijumaMateriali')->truncate();
        DB::table('Pasutijumi')->truncate();
        DB::table('Apavi')->truncate();
        DB::table('Klienti')->truncate();
        DB::table('Meistari')->truncate();
        DB::table('FilialuKrajumi')->truncate();
        DB::table('Materiali')->truncate();
        DB::table('Filiales')->truncate();
        DB::table('users')->truncate();

        Schema::enableForeignKeyConstraints();

        $users = [
            ['id' => 1, 'name' => 'Artūrs Administrators', 'email' => 'admin@archileja.lv', 'password' => 'AdminPilnaPiekluve2026', 'role' => 'administrators'],
            // 8 Meistari (ID 2 - 9)
            ['id' => 2, 'name' => 'Jānis Meistars', 'email' => 'janis.m@archileja.lv', 'password' => 'janisParole1', 'role' => 'meistars'],
            ['id' => 3, 'name' => 'Andris Meistars', 'email' => 'andris.m@archileja.lv', 'password' => 'andrisParole2', 'role' => 'meistars'],
            ['id' => 4, 'name' => 'Juris Meistars', 'email' => 'juris.m@archileja.lv', 'password' => 'jurisParole3', 'role' => 'meistars'],
            ['id' => 5, 'name' => 'Edgars Meistars', 'email' => 'edgars.m@archileja.lv', 'password' => 'edgarsParole4', 'role' => 'meistars'],
            ['id' => 6, 'name' => 'Kaspars Meistars', 'email' => 'kaspars.m@archileja.lv', 'password' => 'kasparsParole5', 'role' => 'meistars'],
            ['id' => 7, 'name' => 'Mārtiņš Meistars', 'email' => 'martins.m@archileja.lv', 'password' => 'martinsParole6', 'role' => 'meistars'],
            ['id' => 8, 'name' => 'Oskars Meistars', 'email' => 'oskars.m@archileja.lv', 'password' => 'oskarsParole7', 'role' => 'meistars'],
            ['id' => 9, 'name' => 'Valdis Meistars', 'email' => 'valdis.m@archileja.lv', 'password' => 'valdisParole8', 'role' => 'meistars'],
            // 11 Klienti (ID 10 - 20)
            ['id' => 10, 'name' => 'Teo Justs Holcmanis', 'email' => 'teo@gmail.com', 'password' => 'teoManaParole', 'role' => 'klients'],
            ['id' => 11, 'name' => 'Emīls Magone', 'email' => 'emils@gmail.com', 'password' => 'emilsAparavi', 'role' => 'klients'],
            ['id' => 12, 'name' => 'Kristaps Bērziņš', 'email' => 'kristaps@gmail.com', 'password' => 'kristaps123', 'role' => 'klients'],
            ['id' => 13, 'name' => 'Laura Ozoliņa', 'email' => 'laura@gmail.com', 'password' => 'lauraDrosa', 'role' => 'klients'],
            ['id' => 14, 'name' => 'Anna Kalniņa', 'email' => 'anna@gmail.com', 'password' => 'annaAnna99', 'role' => 'klients'],
            ['id' => 15, 'name' => 'Māris Zariņš', 'email' => 'maris@gmail.com', 'password' => 'marisZ88', 'role' => 'klients'],
            ['id' => 16, 'name' => 'Inese Krūmiņa', 'email' => 'inese@gmail.com', 'password' => 'ineseKrumi', 'role' => 'klients'],
            ['id' => 17, 'name' => 'Jānis Liepiņš', 'email' => 'janis.l@gmail.com', 'password' => 'liepinsJ', 'role' => 'klients'],
            ['id' => 18, 'name' => 'Dace Paula', 'email' => 'dace@gmail.com', 'password' => 'daceP2026', 'role' => 'klients'],
            ['id' => 19, 'name' => 'Gints Balodis', 'email' => 'gints@gmail.com', 'password' => 'gintsGints', 'role' => 'klients'],
            ['id' => 20, 'name' => 'Zane Kļaviņa', 'email' => 'zane@gmail.com', 'password' => 'zaneKlava', 'role' => 'klients'],
        ];

        foreach ($users as &$u) {
            $u['password'] = Hash::make($u['password']);
        }

        DB::table('users')->insert($users);


        DB::table('Filiales')->insert([
            ['Filiales_ID' => 1, 'Nosaukums' => 'Centra darbnīca', 'Adrese' => 'Brīvības iela 45', 'Pilseta' => 'Rīga'],
            ['Filiales_ID' => 2, 'Nosaukums' => 'Kurzemes filiāle', 'Adrese' => 'Lielā iela 12', 'Pilseta' => 'Liepāja'],
            ['Filiales_ID' => 3, 'Nosaukums' => 'Vidzemes filiāle', 'Adrese' => 'Rīgas iela 7', 'Pilseta' => 'Valmiera'],
        ]);


        DB::table('Meistari')->insert([
            ['Meistari_ID' => 1, 'Filiales_ID' => 1, 'user_id' => 2, 'Vards' => 'Jānis', 'Uzvards' => 'Meistars', 'TelNr' => '20000002'],
            ['Meistari_ID' => 2, 'Filiales_ID' => 1, 'user_id' => 3, 'Vards' => 'Andris', 'Uzvards' => 'Meistars', 'TelNr' => '20000003'],
            ['Meistari_ID' => 3, 'Filiales_ID' => 1, 'user_id' => 4, 'Vards' => 'Juris', 'Uzvards' => 'Meistars', 'TelNr' => '20000004'],
            ['Meistari_ID' => 4, 'Filiales_ID' => 2, 'user_id' => 5, 'Vards' => 'Edgars', 'Uzvards' => 'Meistars', 'TelNr' => '20000005'],
            ['Meistari_ID' => 5, 'Filiales_ID' => 2, 'user_id' => 6, 'Vards' => 'Kaspars', 'Uzvards' => 'Meistars', 'TelNr' => '20000006'],
            ['Meistari_ID' => 6, 'Filiales_ID' => 3, 'user_id' => 7, 'Vards' => 'Mārtiņš', 'Uzvards' => 'Meistars', 'TelNr' => '20000007'],
            ['Meistari_ID' => 7, 'Filiales_ID' => 3, 'user_id' => 8, 'Vards' => 'Oskars', 'Uzvards' => 'Meistars', 'TelNr' => '20000008'],
            ['Meistari_ID' => 8, 'Filiales_ID' => 3, 'user_id' => 9, 'Vards' => 'Valdis', 'Uzvards' => 'Meistars', 'TelNr' => '20000009'],
        ]);


        DB::table('Klienti')->insert([
            ['Klienti_ID' => 1, 'user_id' => 10, 'Vards' => 'Teo Justs', 'Uzvards' => 'Holcmanis', 'TelNr' => '21111110'],
            ['Klienti_ID' => 2, 'user_id' => 11, 'Vards' => 'Emīls', 'Uzvards' => 'Magone', 'TelNr' => '21111111'],
            ['Klienti_ID' => 3, 'user_id' => 12, 'Vards' => 'Kristaps', 'Uzvards' => 'Bērziņš', 'TelNr' => '21111112'],
            ['Klienti_ID' => 4, 'user_id' => 13, 'Vards' => 'Laura', 'Uzvards' => 'Ozoliņa', 'TelNr' => '21111113'],
            ['Klienti_ID' => 5, 'user_id' => 14, 'Vards' => 'Anna', 'Uzvards' => 'Kalniņa', 'TelNr' => '21111114'],
            ['Klienti_ID' => 6, 'user_id' => 15, 'Vards' => 'Māris', 'Uzvards' => 'Zariņš', 'TelNr' => '21111115'],
            ['Klienti_ID' => 7, 'user_id' => 16, 'Vards' => 'Inese', 'Uzvards' => 'Krūmiņa', 'TelNr' => '21111116'],
            ['Klienti_ID' => 8, 'user_id' => 17, 'Vards' => 'Jānis', 'Uzvards' => 'Liepiņš', 'TelNr' => '21111117'],
            ['Klienti_ID' => 9, 'user_id' => 18, 'Vards' => 'Dace', 'Uzvards' => 'Paula', 'TelNr' => '21111118'],
            ['Klienti_ID' => 10, 'user_id' => 19, 'Vards' => 'Gints', 'Uzvards' => 'Balodis', 'TelNr' => '21111119'],
            ['Klienti_ID' => 11, 'user_id' => 20, 'Vards' => 'Zane', 'Uzvards' => 'Kļaviņa', 'TelNr' => '21111120'],
        ]);


        DB::table('Materiali')->insert([
            ['Materiali_ID' => 1, 'Nosaukums' => 'Gumijas zole Vibram', 'Mervieniba' => 'gab', 'Cena' => 15.00],
            ['Materiali_ID' => 2, 'Nosaukums' => 'Ādas ielāps (melns)', 'Mervieniba' => 'cm2', 'Cena' => 0.10],
            ['Materiali_ID' => 3, 'Nosaukums' => 'Kurpju auklas 120cm', 'Mervieniba' => 'pāris', 'Cena' => 2.50],
            ['Materiali_ID' => 4, 'Nosaukums' => 'Papēžu kluči', 'Mervieniba' => 'pāris', 'Cena' => 7.00],
            ['Materiali_ID' => 5, 'Nosaukums' => 'Profesionālā superlīme', 'Mervieniba' => 'ml', 'Cena' => 0.50],
        ]);


        DB::table('FilialuKrajumi')->insert([
            ['Filiales_ID' => 1, 'Materiali_ID' => 1, 'Apjoms' => 50],
            ['Filiales_ID' => 1, 'Materiali_ID' => 2, 'Apjoms' => 500],
            ['Filiales_ID' => 1, 'Materiali_ID' => 3, 'Apjoms' => 30],
            ['Filiales_ID' => 1, 'Materiali_ID' => 4, 'Apjoms' => 40],
            ['Filiales_ID' => 1, 'Materiali_ID' => 5, 'Apjoms' => 200],
            ['Filiales_ID' => 2, 'Materiali_ID' => 1, 'Apjoms' => 20],
            ['Filiales_ID' => 2, 'Materiali_ID' => 2, 'Apjoms' => 300],
            ['Filiales_ID' => 2, 'Materiali_ID' => 3, 'Apjoms' => 15],
            ['Filiales_ID' => 2, 'Materiali_ID' => 4, 'Apjoms' => 15],
            ['Filiales_ID' => 2, 'Materiali_ID' => 5, 'Apjoms' => 100],
            ['Filiales_ID' => 3, 'Materiali_ID' => 1, 'Apjoms' => 15],
            ['Filiales_ID' => 3, 'Materiali_ID' => 2, 'Apjoms' => 200],
            ['Filiales_ID' => 3, 'Materiali_ID' => 3, 'Apjoms' => 10],
            ['Filiales_ID' => 3, 'Materiali_ID' => 4, 'Apjoms' => 10],
            ['Filiales_ID' => 3, 'Materiali_ID' => 5, 'Apjoms' => 80],
        ]);


        DB::table('Apavi')->insert([
            ['Apavi_ID' => 1, 'Klienta_ID' => 1, 'Zimols' => 'Nike', 'Tips' => 'Sporta apavi', 'ApavuMaterials' => 'Tekstils'],
            ['Apavi_ID' => 2, 'Klienta_ID' => 1, 'Zimols' => 'Dr. Martens', 'Tips' => 'Zābaki', 'ApavuMaterials' => 'Āda'],
            ['Apavi_ID' => 3, 'Klienta_ID' => 2, 'Zimols' => 'Adidas', 'Tips' => 'Sporta apavi', 'ApavuMaterials' => 'Sintētika'],
            ['Apavi_ID' => 4, 'Klienta_ID' => 3, 'Zimols' => 'Ecco', 'Tips' => 'Klasiskie apavi', 'ApavuMaterials' => 'Āda'],
            ['Apavi_ID' => 5, 'Klienta_ID' => 4, 'Zimols' => 'Timberland', 'Tips' => 'Zābaki', 'ApavuMaterials' => 'Nūbuks'],
            ['Apavi_ID' => 6, 'Klienta_ID' => 5, 'Zimols' => 'Vans', 'Tips' => 'Kedas', 'ApavuMaterials' => 'Audums'],
            ['Apavi_ID' => 7, 'Klienta_ID' => 6, 'Zimols' => 'Clarks', 'Tips' => 'Kurpes', 'ApavuMaterials' => 'Zamšāda'],
            ['Apavi_ID' => 8, 'Klienta_ID' => 7, 'Zimols' => 'Rieker', 'Tips' => 'Ziemas zābaki', 'ApavuMaterials' => 'Āda'],
            ['Apavi_ID' => 9, 'Klienta_ID' => 8, 'Zimols' => 'Puma', 'Tips' => 'Sporta apavi', 'ApavuMaterials' => 'Tekstils'],
            ['Apavi_ID' => 10, 'Klienta_ID' => 9, 'Zimols' => 'New Balance', 'Tips' => 'Sporta apavi', 'ApavuMaterials' => 'Zamšāda'],
            ['Apavi_ID' => 11, 'Klienta_ID' => 10, 'Zimols' => 'Salamander', 'Tips' => 'Kurpes', 'ApavuMaterials' => 'Āda'],
            ['Apavi_ID' => 12, 'Klienta_ID' => 11, 'Zimols' => 'Converse', 'Tips' => 'Kedas', 'ApavuMaterials' => 'Audums'],
        ]);

        DB::table('Pasutijumi')->insert([
            ['Pasutijumi_ID' => 1, 'Apavu_ID' => 2, 'Meistara_ID' => 1, 'Pienemsanas_Datums' => '2026-05-01', 'Termins' => '2026-05-05', 'RemontaVeids' => 'Zoles maiņa un papēžu atjaunošana', 'Statuss' => 'Gatavs', 'Cena' => 45.00, 'Garantijas_Termins' => '2026-11-05'],
            ['Pasutijumi_ID' => 2, 'Apavu_ID' => 4, 'Meistara_ID' => 4, 'Pienemsanas_Datums' => '2026-05-10', 'Termins' => '2026-05-12', 'RemontaVeids' => 'Papēžu kluču maiņa', 'Statuss' => 'Gatavs', 'Cena' => 20.00, 'Garantijas_Termins' => '2026-11-12'],
            ['Pasutijumi_ID' => 3, 'Apavu_ID' => 5, 'Meistara_ID' => 6, 'Pienemsanas_Datums' => '2026-05-15', 'Termins' => '2026-05-20', 'RemontaVeids' => 'Sānu vīles šūšana un ielāps', 'Statuss' => 'Gatavs', 'Cena' => 25.00, 'Garantijas_Termins' => '2026-11-20'],
            ['Pasutijumi_ID' => 4, 'Apavu_ID' => 1, 'Meistara_ID' => 1, 'Pienemsanas_Datums' => '2026-06-01', 'Termins' => '2026-06-12', 'RemontaVeids' => 'Zoles līmēšana', 'Statuss' => 'Procesā', 'Cena' => 15.00, 'Garantijas_Termins' => null],
            ['Pasutijumi_ID' => 5, 'Apavu_ID' => 3, 'Meistara_ID' => 2, 'Pienemsanas_Datums' => '2026-06-02', 'Termins' => '2026-06-14', 'RemontaVeids' => 'Iekšzoles restaurācija', 'Statuss' => 'Procesā', 'Cena' => 18.00, 'Garantijas_Termins' => null],
            ['Pasutijumi_ID' => 6, 'Apavu_ID' => 7, 'Meistara_ID' => 5, 'Pienemsanas_Datums' => '2026-06-04', 'Termins' => '2026-06-15', 'RemontaVeids' => 'Zamšādas tīrīšana un krāsošana', 'Statuss' => 'Procesā', 'Cena' => 30.00, 'Garantijas_Termins' => null],
            ['Pasutijumi_ID' => 7, 'Apavu_ID' => 8, 'Meistara_ID' => 7, 'Pienemsanas_Datums' => '2026-06-05', 'Termins' => '2026-06-16', 'RemontaVeids' => 'Rāvējslēdzēja maiņa', 'Statuss' => 'Procesā', 'Cena' => 22.00, 'Garantijas_Termins' => null],
            ['Pasutijumi_ID' => 8, 'Apavu_ID' => 6, 'Meistara_ID' => null, 'Pienemsanas_Datums' => '2026-06-08', 'Termins' => '2026-06-20', 'RemontaVeids' => 'Aizmugurīšu nostiprināšana', 'Statuss' => 'Jauns', 'Cena' => 12.00, 'Garantijas_Termins' => null],
            ['Pasutijumi_ID' => 9, 'Apavu_ID' => 9, 'Meistara_ID' => null, 'Pienemsanas_Datums' => '2026-06-09', 'Termins' => '2026-06-22', 'RemontaVeids' => 'Auklu maiņa un profilakse', 'Statuss' => 'Jauns', 'Cena' => 8.00, 'Garantijas_Termins' => null],
            ['Pasutijumi_ID' => 10, 'Apavu_ID' => 10, 'Meistara_ID' => 3, 'Pienemsanas_Datums' => '2026-06-09', 'Termins' => '2026-06-23', 'RemontaVeids' => 'Papēžu kalšana', 'Statuss' => 'Jauns', 'Cena' => 15.00, 'Garantijas_Termins' => null],
            ['Pasutijumi_ID' => 11, 'Apavu_ID' => 11, 'Meistara_ID' => 2, 'Pienemsanas_Datums' => '2026-05-20', 'Termins' => '2026-05-22', 'RemontaVeids' => 'Pilna restaurācija', 'Statuss' => 'Atcelts', 'Cena' => 0.00, 'Garantijas_Termins' => null],
            ['Pasutijumi_ID' => 12, 'Apavu_ID' => 12, 'Meistara_ID' => 8, 'Pienemsanas_Datums' => '2026-05-25', 'Termins' => '2026-05-28', 'RemontaVeids' => 'Kedu purngalu līmēšana', 'Statuss' => 'Gatavs', 'Cena' => 10.00, 'Garantijas_Termins' => '2026-11-28'],
        ]);


        DB::table('PasutijumaMateriali')->insert([
            ['Pasutijuma_ID' => 1, 'Materiali_ID' => 1, 'Daudzums' => 2],
            ['Pasutijuma_ID' => 1, 'Materiali_ID' => 2, 'Daudzums' => 50],
            ['Pasutijuma_ID' => 1, 'Materiali_ID' => 5, 'Daudzums' => 10],
            ['Pasutijuma_ID' => 2, 'Materiali_ID' => 4, 'Daudzums' => 1],
            ['Pasutijuma_ID' => 4, 'Materiali_ID' => 5, 'Daudzums' => 15],
            ['Pasutijuma_ID' => 12, 'Materiali_ID' => 5, 'Daudzums' => 5],
            ['Pasutijuma_ID' => 12, 'Materiali_ID' => 3, 'Daudzums' => 1],
        ]);

   
        DB::table('Atsauksmes')->insert([
            ['Atsauksmes_ID' => 1, 'Pasutijuma_ID' => 1, 'Vertejums' => 5, 'Komentars' => 'Izcils darbs, zābaki izskatās kā jauni! Paldies meistaram Jānim.'],
            ['Atsauksmes_ID' => 2, 'Pasutijuma_ID' => 2, 'Vertejums' => 4, 'Komentars' => 'Ātrs remonts, bet cena varēja būt nedaudz zemāka.'],
            ['Atsauksmes_ID' => 3, 'Pasutijuma_ID' => 3, 'Vertejums' => 5, 'Komentars' => 'Ļoti rūpīgi sašūts, ielāpu gandrīz nevar pamanīt.'],
            ['Atsauksmes_ID' => 4, 'Pasutijuma_ID' => 12, 'Vertejums' => 3, 'Komentars' => 'Salīmēja labi, bet aizkavējās par vienu dienu.'],
        ]);
    }
}