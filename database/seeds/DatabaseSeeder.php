<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Baseinfo;
use App\Student;
use App\Teacher;
use App\Cathedra;
use App\Sciencework;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $cathedra1 = new Cathedra();
        $cathedra1->id = 1;
        $cathedra1->name = 'Program systems and technologies';
        $cathedra1->save();

        $cathedra2 = new Cathedra();
        $cathedra2->id = 2;
        $cathedra2->name = 'networking and internet technology';
        $cathedra2->save();

        $rolestudent = Role::create(['name' => 'student']);
        $roleteacher = Role::create(['name' => 'teacher']);
        $roleteacher = Role::create(['name' => 'cathedraworker']);
        $roleteacher = Role::create(['name' => 'superadmin']);

        $baseinfost1 = new Baseinfo();
        $baseinfost1->id = 1;
        $baseinfost1->name = 'Veronika';
        $baseinfost1->surname = 'Chuhalova';
        $baseinfost1->cathedra_id = 1;
        $baseinfost1->save();

        $baseinfost2 = new Baseinfo();
        $baseinfost2->id = 2;
        $baseinfost2->name = 'Maryna';
        $baseinfost2->surname = 'Budyshevska';
        $baseinfost2->cathedra_id = 1;
        $baseinfost2->save();

        $baseinfost3 = new Baseinfo();
        $baseinfost3->id = 3;
        $baseinfost3->name = 'Denys';
        $baseinfost3->surname = 'Starostyuk';
        $baseinfost3->cathedra_id = 2;
        $baseinfost3->save();

        $baseinfost4 = new Baseinfo();
        $baseinfost4->id = 4;
        $baseinfost4->name = 'May';
        $baseinfost4->surname = 'Komarova';
        $baseinfost4->cathedra_id = 2;
        $baseinfost4->save();

        $baseinfot1 = new Baseinfo();
        $baseinfot1->id = 11;
        $baseinfot1->name = 'Evgen';
        $baseinfot1->surname = 'Franchuk';
        $baseinfot1->cathedra_id = 1;
        $baseinfot1->save();

        $baseinfot2 = new Baseinfo();
        $baseinfot2->id = 12;
        $baseinfot2->name = 'Katerina';
        $baseinfot2->surname = 'Vovk';
        $baseinfot2->cathedra_id = 2;
        $baseinfot2->save();

        $baseinfot3 = new Baseinfo();
        $baseinfot3->id = 13;
        $baseinfot3->name = 'Tetyana';
        $baseinfot3->surname = 'Kyryenko';
        $baseinfot3->cathedra_id = 1;
        $baseinfot3->save();

        $baseinfot4 = new Baseinfo();
        $baseinfot4->id = 14;
        $baseinfot4->name = 'Volodymyr';
        $baseinfot4->surname = 'Trygub';
        $baseinfot4->cathedra_id = 2;
        $baseinfot4->save();

        $baseinfocw1 = new Baseinfo();
        $baseinfocw1->id = 21;
        $baseinfocw1->name = 'Laura';
        $baseinfocw1->surname = 'Stecenko';
        $baseinfocw1->cathedra_id = 2;
        $baseinfocw1->save();

        $baseinfocw2 = new Baseinfo();
        $baseinfocw2->id = 22;
        $baseinfocw2->name = 'Volodymyr';
        $baseinfocw2->surname = 'Illonko';
        $baseinfocw2->cathedra_id = 2;
        $baseinfocw2->save();

        $baseinfosa = new Baseinfo();
        $baseinfosa->id = 31;
        $baseinfosa->name = 'Nika';
        $baseinfosa->surname = 'Ch';
        $baseinfosa->cathedra_id = 2;
        $baseinfosa->save();

        $userst1 = new User();
        $userst1->id = 1;
        $userst1->email = 'veronikachuhalova@i.ua';
        $userst1->password = Hash::make('123456');
        $userst1->baseinfo_id = 1;
        $userst1->assignRole('student');
        $userst1->save();

        $userst2 = new User();
        $userst2->id = 2;
        $userst2->email = 'mbudy@i.ua';
        $userst2->password = Hash::make('123456');
        $userst2->baseinfo_id = 2;
        $userst2->assignRole('student');
        $userst2->save();

        $usert1 = new User();
        $usert1->id = 11;
        $usert1->email = 'franchuk@i.ua';
        $usert1->password = Hash::make('123456');
        $usert1->baseinfo_id = 11;
        $usert1->assignRole('teacher');
        $usert1->save();

        $usert2 = new User();
        $usert2->id = 12;
        $usert2->email = 'vovk@i.ua';
        $usert2->password = Hash::make('123456');
        $usert2->baseinfo_id = 12;
        $usert2->assignRole('teacher');
        $usert2->save();

        $usercw1 = new User();
        $usercw1->id = 21;
        $usercw1->email = 'stecenko@i.ua';
        $usercw1->password = Hash::make('123456');
        $usercw1->baseinfo_id = 21;
        $usercw1->assignRole('cathedraworker');
        $usercw1->save();

        $usercw2 = new User();
        $usercw2->id = 22;
        $usercw2->email = 'illonko@i.ua';
        $usercw2->password = Hash::make('123456');
        $usercw2->baseinfo_id = 22;
        $usercw2->assignRole('cathedraworker');
        $usercw2->save();

        $usersa = new User();
        $usersa->id = 31;
        $usersa->email = 'ch@i.ua';
        $usersa->password = Hash::make('123456');
        $usersa->baseinfo_id = 31;
        $usersa->assignRole('superadmin');
        $usersa->save();

        $student1 = new Student();
        $student1->id = 1;
        $student1->baseinfo_id_for_student = 1;
        $student1->studnumber = 'KV12312123';
        $student1->entry_date='2014-09-01';
        $student1->planned_grad_date='2018-06-01';
        $student1->specialty='Software ingeneering';
        $student1->degree = 'bachelor';
        $student1->group = 1;
        $student1->save();

        $student2 = new Student();
        $student2->id = 2;
        $student2->baseinfo_id_for_student = 2;
        $student2->studnumber = 'KV23423234';
        $student2->entry_date='2017-09-01';
        $student2->planned_grad_date='2021-06-01';
        $student2->specialty='Software ingeneering';
        $student2->degree = 'master';
        $student2->group = 2;
        $student2->save();

        $student3 = new Student();
        $student3->id = 3;
        $student3->baseinfo_id_for_student = 3;
        $student3->studnumber = 'KV34534345';
        $student3->entry_date='2010-09-01';
        $student3->planned_grad_date='2014-06-01';
        $student3->real_grad_date='2016-06-01';
        $student3->specialty='Software ingeneering';
        $student3->degree = 'bachelor';
        $student3->group = 3;
        $student3->save();

        $student4 = new Student();
        $student4->id = 4;
        $student4->baseinfo_id_for_student = 4;
        $student4->studnumber = 'KV45645456';
        $student4->entry_date='2015-09-01';
        $student4->planned_grad_date='2019-06-01';
        $student4->real_grad_date='2019-06-01';
        $student4->specialty='Software ingeneering';
        $student4->degree = 'master';
        $student4->group = 4;
        $student4->save();

        $teacher1 = new Teacher();
        $teacher1->id = 11;
        $teacher1->workbooknumber = 'AA111123';
        $teacher1->baseinfo_id_for_teacher = 11;
        $teacher1->science_degree = 'кандидат наук';
        $teacher1->scientific_rank= 'професор';
        $teacher1->position= 'викладач';
        $teacher1->start_date= '2011-01-01';
        $teacher1->save();

        $teacher2 = new Teacher();
        $teacher2->id = 12;
        $teacher2->workbooknumber = 'AA234234';
        $teacher2->baseinfo_id_for_teacher =  12;
        $teacher2->science_degree = 'кандидат наук';
        $teacher2->scientific_rank= 'професор';
        $teacher2->position= 'викладач';
        $teacher2->start_date= '2019-01-01';
        $teacher2->end_of_work_date='2019-04-01';
        $teacher2->save();

        $teacher3 = new Teacher();
        $teacher3->id = 13;
        $teacher3->workbooknumber = 'AA345345';
        $teacher3->baseinfo_id_for_teacher =  13;
        $teacher3->science_degree = 'доктор наук';
        $teacher3->scientific_rank= 'доцент';
        $teacher3->position= 'викладач';
        $teacher3->start_date= '2001-01-01';
        $teacher3->save();

        $teacher4 = new Teacher();
        $teacher4->id = 14;
        $teacher4->workbooknumber = 'AA456456';
        $teacher4->baseinfo_id_for_teacher =  14;
        $teacher4->science_degree = 'доктор наук';
        $teacher4->scientific_rank= 'доцент';
        $teacher4->position= 'викладач';
        $teacher4->start_date= '2017-01-01';
        $teacher4->end_of_work_date='2019-01-01';
        $teacher4->save();
        
        $sciencework1 = new Sciencework();
        $sciencework1 -> id = 1;
        $sciencework1 -> topic = 'Розробка інформаційної системи';
        $sciencework1 -> type = 'bachaelor coursework';
        $sciencework1 -> presenting_date = '2019-06-01';
        $sciencework1 -> status = 'active';
        $sciencework1 -> student_id = 1;
        $sciencework1 -> teacher_id = 11;
        $sciencework1 -> cathedra_id = 1;
        $sciencework1 -> application = false;
        $sciencework1 -> save();

        $sciencework2 = new Sciencework();
        $sciencework2 -> id = 2;
        $sciencework2 -> topic = 'Розробка алгоритму';
        $sciencework2 -> type = 'bachaelor dyploma';
        $sciencework2 -> presenting_date = '2019-06-01';
        $sciencework2 -> status = 'active';
        $sciencework2 -> student_id = 2;
        $sciencework2 -> teacher_id = 11;
        $sciencework2 -> cathedra_id = 1;
        $sciencework2 -> application = false;
        $sciencework2 -> save();
        
        $sciencework22 = new Sciencework();
        $sciencework22 -> id = 22;
        $sciencework22 -> topic = 'Розробка алгоритму';
        $sciencework22 -> type = 'bachaelor dyploma';
        $sciencework22 -> presenting_date = '2019-06-01';
        $sciencework22 -> status = 'disapproved_for_student';
        $sciencework22 -> student_id = 2;
        $sciencework22 -> teacher_id = 11;
        $sciencework22 -> cathedra_id = 1;
        $sciencework22 -> application = false;
        $sciencework22 -> save();

        $sciencework222 = new Sciencework();
        $sciencework222 -> id = 222;
        $sciencework222 -> topic = 'Розробка алгоритму';
        $sciencework222 -> type = 'bachaelor dyploma';
        $sciencework222 -> presenting_date = '2019-06-01';
        $sciencework222 -> status = 'disapproved_for_teacher';
        $sciencework222 -> student_id = 2;
        $sciencework222 -> teacher_id = 11;
        $sciencework222 -> cathedra_id = 1;
        $sciencework222 -> application = false;
        $sciencework222 -> save();

        $sciencework2222 = new Sciencework();
        $sciencework2222 -> id = 2222;
        $sciencework2222 -> topic = 'Розробка алгоритму';
        $sciencework2222 -> type = 'bachaelor dyploma';
        $sciencework2222 -> presenting_date = '2019-06-01';
        $sciencework2222 -> status = 'inactive';
        $sciencework2222 -> student_id = 2;
        $sciencework2222 -> teacher_id = 11;
        $sciencework2222 -> cathedra_id = 1;
        $sciencework2222 -> application = false;
        $sciencework2222 -> save();

        $sciencework22222 = new Sciencework();
        $sciencework22222 -> id = 22222;
        $sciencework22222 -> topic = 'Розробка алгоритму';
        $sciencework22222 -> type = 'bachaelor dyploma';
        $sciencework22222 -> presenting_date = '2019-06-01';
        $sciencework22222 -> status = 'approved_by_teacher';
        $sciencework22222 -> student_id = 2;
        $sciencework22222 -> teacher_id = 11;
        $sciencework22222 -> cathedra_id = 1;
        $sciencework22222 -> application = false;
        $sciencework22222 -> save();

        $sciencework3 = new Sciencework();
        $sciencework3 -> id = 3;
        $sciencework3 -> topic = 'Розробка боту';
        $sciencework3 -> type = 'major coursework';
        $sciencework3 -> presenting_date = '2019-06-01';
        $sciencework3 -> status = 'active';
        $sciencework3 -> student_id = 3;
        $sciencework3 -> teacher_id = 12;
        $sciencework3 -> cathedra_id = 2;
        $sciencework3 -> application = false;
        $sciencework3 -> save();
    }
}
