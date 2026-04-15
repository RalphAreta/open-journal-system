<?php

namespace Database\Seeders;

use App\Models\EditorialBoardMember;
use Illuminate\Database\Seeder;

class EditorialBoardSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['title'=>'Dr.','name'=>'Mark L. Sibag','role'=>'editor_in_chief','affiliation'=>'BatStateU The NEU','location'=>'Batangas City, Philippines','sort_order'=>1],
            ['title'=>'Dr.','name'=>'Bryan John A. Magoling','role'=>'guest_editor','affiliation'=>'BatStateU The NEU','location'=>'Batangas City, Philippines','sort_order'=>2],
            ['title'=>'Dr.','name'=>'Eleazer L. Vivas','role'=>'guest_editor','affiliation'=>'BatStateU The NEU','location'=>'Batangas City, Philippines','sort_order'=>3],
            ['title'=>'Dr.','name'=>'Rex Victor O. Cruz','role'=>'editor','affiliation'=>'University of the Philippines Los Baños','location'=>'Los Baños, Philippines','sort_order'=>4],
            ['title'=>'Dr.','name'=>'Mario R. Rebosura, Jr.','role'=>'editor','affiliation'=>'UQ Australian Centre for Water and Environmental Biotechnology','location'=>'Brisbane, Australia','sort_order'=>5],
            ['title'=>'Dr.','name'=>'Tahir Maqbool','role'=>'editor','affiliation'=>'Tsinghua University','location'=>'Beijing, China','sort_order'=>6],
            ['title'=>'Dr.','name'=>'Elmer-Rico E. Mojica','role'=>'editor','affiliation'=>'Pace University','location'=>'New York City, USA','sort_order'=>7],
            ['title'=>'Asst. Prof. Dr.','name'=>'Sommai Pivsa-Art','role'=>'editor','affiliation'=>'Rajamangala University of Technology','location'=>'Thanyaburi, Thailand','sort_order'=>8],
            ['title'=>'Dr.','name'=>'Jey-R S. Ventura','role'=>'editor','affiliation'=>'University of the Philippines Los Baños','location'=>'Los Baños, Philippines','sort_order'=>9],
            ['title'=>'Dr.','name'=>'Reymark D. Maalihan','role'=>'editor','affiliation'=>'North Dakota State University','location'=>'North Dakota, USA','sort_order'=>10],
            ['title'=>'Dr.','name'=>'Shirley G. Cabrera','role'=>'editor','affiliation'=>'SJ Fine Foods Ltd.','location'=>'Saskatoon, SK, Canada','sort_order'=>11],
            ['title'=>'Engr.','name'=>'Maria Ana C. Bergonio','role'=>'managing_editor','affiliation'=>'BatStateU The NEU','location'=>'Batangas City, Philippines','sort_order'=>12],
            ['title'=>'Mr.','name'=>'Marvin M. Beredo','role'=>'layout_editor','affiliation'=>'BatStateU The NEU','location'=>'Batangas City, Philippines','sort_order'=>13],
            ['title'=>'Dr.','name'=>'Tirso A. Ronquillo','role'=>'editorial_advisor','affiliation'=>'BatStateU The NEU','location'=>'Batangas City, Philippines','sort_order'=>14],
            ['title'=>'Engr.','name'=>'Albertson D. Amante','role'=>'editorial_advisor','affiliation'=>'BatStateU The NEU','location'=>'Batangas City, Philippines','sort_order'=>15],
            ['title'=>'Dr.','name'=>'Elisa D. Gutierrez','role'=>'editorial_advisor','affiliation'=>'BatStateU The NEU','location'=>'Batangas City, Philippines','sort_order'=>16],
            ['title'=>'Dr.','name'=>'Rosenda A. Bronce','role'=>'editorial_advisor','affiliation'=>'BatStateU The NEU','location'=>'Batangas City, Philippines','sort_order'=>17],
        ];

        foreach ($members as $m) {
            EditorialBoardMember::create(array_merge($m, ['is_active' => true]));
        }
    }
}