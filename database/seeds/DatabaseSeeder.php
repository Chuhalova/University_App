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
        $cathedra1->name = 'Програмних систем і технологій';
        $cathedra1->save();

        $cathedra2 = new Cathedra();
        $cathedra2->id = 2;
        $cathedra2->name = 'Інтелектуальних технологій';
        $cathedra2->save();


        $rolestudent = Role::create(['name' => 'student']);
        $roleteacher = Role::create(['name' => 'teacher']);
        $roleteacher = Role::create(['name' => 'cathedraworker']);
        $roleteacher = Role::create(['name' => 'superadmin']);

        $baseinfost1 = new Baseinfo();
        $baseinfost1->id = 1;
        $baseinfost1->name = 'Ігор';
        $baseinfost1->surname = 'Кондро';
        $baseinfost1->cathedra_id = 1;
        $baseinfost1->save();

        $student1 = new Student();
        $student1->id = 1;
        $student1->year = 1;
        $student1->baseinfo_id_for_student = 1;
        $student1->studnumber = 'IK122211';
        $student1->entry_date = '2019-09-01';
        $student1->real_grad_date = '2023-09-19';
        $student1->specialty = 'Програмно - інформаційні системи';
        $student1->specialty_abbr = 'ПІС';
        $student1->degree = 'bachelor';
        $student1->group = 1;
        $student1->save();



        $userst1 = new User();
        $userst1->id = 1;
        $userst1->email = 'igorkondro@gmail.com';
        $userst1->password = Hash::make('123456');
        $userst1->baseinfo_id = 1;
        $userst1->assignRole('student');
        $userst1->save();

        $baseinfost2 = new Baseinfo();
        $baseinfost2->id = 2;
        $baseinfost2->name = 'Руслан';
        $baseinfost2->surname = 'Ганюк';
        $baseinfost2->cathedra_id = 1;
        $baseinfost2->save();

        $student2 = new Student();
        $student2->id = 2;
        $student2->year = 2;
        $student2->baseinfo_id_for_student = 2;
        $student2->studnumber = 'RG223222';
        $student2->entry_date = '2018-09-01';
        $student2->specialty = 'Програмно - інформаційні системи';
        $student2->specialty_abbr = 'ПІС';
        $student2->degree = 'bachelor';
        $student2->group = 2;
        $student2->save();

        $baseinfost3 = new Baseinfo();
        $baseinfost3->id = 3;
        $baseinfost3->name = 'Олег';
        $baseinfost3->surname = 'Стельмащук';
        $baseinfost3->cathedra_id = 1;
        $baseinfost3->save();

        $student3 = new Student();
        $student3->id = 3;
        $student3->year = 3;
        $student3->baseinfo_id_for_student = 3;
        $student3->studnumber = 'OS553333';
        $student3->entry_date = '2017-09-01';
        $student3->specialty = 'Програмно - інформаційні системи';
        $student3->specialty_abbr = 'ПІС';
        $student3->degree = 'bachelor';
        $student3->group = 3;
        $student3->save();



        $baseinfost4 = new Baseinfo();
        $baseinfost4->id = 4;
        $baseinfost4->name = 'Василь';
        $baseinfost4->surname = 'Кресяк';
        $baseinfost4->cathedra_id = 1;
        $baseinfost4->save();

        $student4 = new Student();
        $student4->id = 4;
        $student4->year = 4;
        $student4->baseinfo_id_for_student = 4;
        $student4->studnumber = 'VK447644';
        $student4->entry_date = '2016-09-01';
        $student4->specialty = 'Програмно - інформаційні системи';
        $student4->specialty_abbr = 'ПІС';
        $student4->degree = 'bachelor';
        $student4->group = 4;
        $student4->save();



        $baseinfost5 = new Baseinfo();
        $baseinfost5->id = 5;
        $baseinfost5->name = 'Руслана';
        $baseinfost5->surname = 'Яремчук';
        $baseinfost5->cathedra_id = 1;
        $baseinfost5->save();

        $student5 = new Student();
        $student5->id = 5;
        $student5->year = 1;
        $student5->baseinfo_id_for_student = 5;
        $student5->studnumber = 'RY565555';
        $student5->entry_date = '2015-09-01';
        $student5->specialty = 'Програмно - інформаційні системи';
        $student5->specialty_abbr = 'ПІС';
        $student5->degree = 'master';
        $student5->group = 1;
        $student5->save();



        $baseinfost6 = new Baseinfo();
        $baseinfost6->id = 6;
        $baseinfost6->name = 'Наталія';
        $baseinfost6->surname = 'Жолудєва';
        $baseinfost6->cathedra_id = 1;
        $baseinfost6->save();

        $student6 = new Student();
        $student6->id = 6;
        $student6->year = 2;
        $student6->baseinfo_id_for_student = 6;
        $student6->studnumber = 'NJ693666';
        $student6->entry_date = '2014-09-01';
        $student6->specialty = 'Програмно - інформаційні системи';
        $student6->specialty_abbr = 'ПІС';
        $student6->degree = 'master';
        $student6->group = 2;
        $student6->save();



        $baseinfost7 = new Baseinfo();
        $baseinfost7->id = 7;
        $baseinfost7->name = 'Тетяна';
        $baseinfost7->surname = 'Ризванюк';
        $baseinfost7->cathedra_id = 1;
        $baseinfost7->save();

        $student7 = new Student();
        $student7->id = 7;
        $student7->year = 2;
        $student7->baseinfo_id_for_student = 7;
        $student7->studnumber = 'TR709777';
        $student7->entry_date = '2014-09-01';
        $student7->real_grad_date = '2016-09-01';
        $student7->specialty = 'Програмно - інформаційні системи';
        $student7->specialty_abbr = 'ПІС';
        $student7->degree = 'master';
        $student7->group = 2;
        $student7->save();

        $baseinfost8 = new Baseinfo();
        $baseinfost8->id = 8;
        $baseinfost8->name = 'Ярослав';
        $baseinfost8->surname = 'Карпин';
        $baseinfost8->cathedra_id = 1;
        $baseinfost8->save();

        $student8 = new Student();
        $student8->id = 8;
        $student8->year = 2;
        $student8->baseinfo_id_for_student = 8;
        $student8->studnumber = 'YK886288';
        $student8->entry_date = '2014-09-01';
        $student8->real_grad_date = '2018-09-01';
        $student8->specialty = 'Програмно - інформаційні системи';
        $student8->specialty_abbr = 'ПІС';
        $student8->degree = 'bachelor';
        $student8->group = 3;
        $student8->save();

        $baseinfost9 = new Baseinfo();
        $baseinfost9->id = 9;
        $baseinfost9->name = 'Ярослав';
        $baseinfost9->surname = 'Карпин';
        $baseinfost9->cathedra_id = 1;
        $baseinfost9->save();

        $student9 = new Student();
        $student9->id = 9;
        $student9->year = 3;
        $student9->baseinfo_id_for_student = 9;
        $student9->studnumber = 'YK987999';
        $student9->entry_date = '2014-09-01';
        $student9->real_grad_date = '2022-09-01';
        $student9->specialty = 'Теорія інформаційних систем';
        $student9->specialty_abbr = 'ТІС';
        $student9->degree = 'bachelor';
        $student9->group = 3;
        $student9->save();


        $baseinfost10 = new Baseinfo();
        $baseinfost10->id = 10;
        $baseinfost10->name = 'Елеонора';
        $baseinfost10->surname = 'Матюшко';
        $baseinfost10->cathedra_id = 1;
        $baseinfost10->save();

        $student10 = new Student();
        $student10->id = 10;
        $student10->year = 4;
        $student10->baseinfo_id_for_student = 10;
        $student10->studnumber = 'YK090000';
        $student10->entry_date = '2019-010-01';
        $student10->specialty = 'Теорія інформаційних систем';
        $student10->specialty_abbr = 'ТІС';
        $student10->degree = 'bachelor';
        $student10->group = 4;
        $student10->save();


        $baseinfost11 = new Baseinfo();
        $baseinfost11->id = 11;
        $baseinfost11->name = 'Володимир';
        $baseinfost11->surname = 'Коваль';
        $baseinfost11->cathedra_id = 1;
        $baseinfost11->save();

        $student11 = new Student();
        $student11->id = 11;
        $student11->year = 2;
        $student11->baseinfo_id_for_student = 11;
        $student11->studnumber = 'YK004300';
        $student11->entry_date = '2017-011-01';
        $student11->specialty = 'Теорія інформаційних систем';
        $student11->specialty_abbr = 'ТІС';
        $student11->degree = 'master';
        $student11->group = 2;
        $student11->save();

        $baseinfost12 = new Baseinfo();
        $baseinfost12->id = 12;
        $baseinfost12->name = 'Ірина';
        $baseinfost12->surname = 'Герега';
        $baseinfost12->cathedra_id = 1;
        $baseinfost12->save();

        $student12 = new Student();
        $student12->id = 12;
        $student12->year = 1;
        $student12->baseinfo_id_for_student = 12;
        $student12->studnumber = 'IG001200';
        $student12->entry_date = '2020-012-01';
        $student12->specialty = 'Теорія інформаційних систем';
        $student12->specialty_abbr = 'ТІС';
        $student12->degree = 'master';
        $student12->group = 2;
        $student12->save();

        $baseinfost13 = new Baseinfo();
        $baseinfost13->id = 13;
        $baseinfost13->name = 'Сергій';
        $baseinfost13->surname = 'Михальчук';
        $baseinfost13->cathedra_id = 1;
        $baseinfost13->save();

        $student13 = new Student();
        $student13->id = 13;
        $student13->year = 1;
        $student13->baseinfo_id_for_student = 13;
        $student13->studnumber = 'SM044200';
        $student13->entry_date = '2020-03-01';
        $student13->specialty = 'Теорія інформаційних систем';
        $student13->specialty_abbr = 'ТІС';
        $student13->degree = 'master';
        $student13->group = 5;
        $student13->save();

        $baseinfost14 = new Baseinfo();
        $baseinfost14->id = 14;
        $baseinfost14->name = 'Любомир';
        $baseinfost14->surname = 'Лоневський';
        $baseinfost14->cathedra_id = 1;
        $baseinfost14->save();

        $student14 = new Student();
        $student14->id = 14;
        $student14->year = 3;
        $student14->baseinfo_id_for_student = 14;
        $student14->studnumber = 'LL008870';
        $student14->entry_date = '2017-04-01';
        $student14->specialty = 'Теорія інформаційних систем';
        $student14->specialty_abbr = 'ТІС';
        $student14->degree = 'bachelor';
        $student14->group = 2;
        $student14->save();

        $baseinfost15 = new Baseinfo();
        $baseinfost15->id = 15;
        $baseinfost15->name = 'Андрій';
        $baseinfost15->surname = 'Магдяк';
        $baseinfost15->cathedra_id = 1;
        $baseinfost15->save();

        $student15 = new Student();
        $student15->id = 15;
        $student15->year = 4;
        $student15->baseinfo_id_for_student = 15;
        $student15->studnumber = 'AM852700';
        $student15->entry_date = '2015-05-01';
        $student15->specialty = 'Теорія інформаційних систем';
        $student15->specialty_abbr = 'ТІС';
        $student15->degree = 'bachelor';
        $student15->group = 1;
        $student15->save();

        $baseinfost16 = new Baseinfo();
        $baseinfost16->id = 16;
        $baseinfost16->name = 'Анжеліка';
        $baseinfost16->surname = 'Любченко';
        $baseinfost16->cathedra_id = 1;
        $baseinfost16->save();

        $student16 = new Student();
        $student16->id = 16;
        $student16->year = 3;
        $student16->baseinfo_id_for_student = 16;
        $student16->studnumber = 'AL009870';
        $student16->entry_date = '2016-06-01';
        $student16->specialty = 'Теорія інформаційних систем';
        $student16->specialty_abbr = 'ТІС';
        $student16->degree = 'bachelor';
        $student16->group = 2;
        $student16->save();

        $baseinfot1 = new Baseinfo();
        $baseinfot1->id = 21;
        $baseinfot1->name = 'Володимир';
        $baseinfot1->surname = 'Скиба';
        $baseinfot1->cathedra_id = 1;
        $baseinfot1->save();

        $teacher1 = new Teacher();
        $teacher1->id = 1;
        $teacher1->workbooknumber = 'VS111111';
        $teacher1->baseinfo_id_for_teacher = 21;
        $teacher1->science_degree = 'кандидат наук';
        $teacher1->scientific_rank = 'професор';
        $teacher1->position = 'асистент';
        $teacher1->start_date = '2011-01-01';
        $teacher1->save();

        $sciencework1 = new Sciencework();
        $sciencework1->id = 1;
        $sciencework1->topic = 'Доведення задач теорії графів методом резолюцій.';
        $sciencework1->type = 'bachaelor coursework';
        $sciencework1->presenting_date = '2019-06-01';
        $sciencework1->status = 'inactive';
        $sciencework1->student_id = 3;
        $sciencework1->teacher_id = 1;
        $sciencework1->cathedra_id = 1;
        $sciencework1->application = false;
        $sciencework1->save();


        $usert1 = new User();
        $usert1->id = 3;
        $usert1->email = 'skiba@i.ua';
        $usert1->password = Hash::make('123456');
        $usert1->baseinfo_id = 21;
        $usert1->assignRole('teacher');
        $usert1->save();

        $baseinfot2 = new Baseinfo();
        $baseinfot2->id = 22;
        $baseinfot2->name = 'Орест';
        $baseinfot2->surname = 'Вітик';
        $baseinfot2->cathedra_id = 1;
        $baseinfot2->save();

        $teacher2 = new Teacher();
        $teacher2->id = 2;
        $teacher2->workbooknumber = 'OV222222';
        $teacher2->baseinfo_id_for_teacher = 22;
        $teacher2->science_degree = 'доктор наук';
        $teacher2->scientific_rank = 'професор';
        $teacher2->position = 'старший викладач';
        $teacher2->start_date = '2013-02-02';
        $teacher2->save();

        $sciencework2 = new Sciencework();
        $sciencework2->id = 2;
        $sciencework2->topic = 'Фрактальне стиснення зображень.';
        $sciencework2->type = 'bachaelor dyploma';
        $sciencework2->presenting_date = '2019-06-01';
        $sciencework2->status = 'approved_by_teacher';
        $sciencework2->student_id = 4;
        $sciencework2->teacher_id = 2;
        $sciencework2->cathedra_id = 1;
        $sciencework2->application = false;
        $sciencework2->save();

        $baseinfot3 = new Baseinfo();
        $baseinfot3->id = 23;
        $baseinfot3->name = 'Любов';
        $baseinfot3->surname = 'Шахрайчук';
        $baseinfot3->cathedra_id = 1;
        $baseinfot3->save();

        $teacher3 = new Teacher();
        $teacher3->id = 3;
        $teacher3->workbooknumber = 'LS333333';
        $teacher3->baseinfo_id_for_teacher = 23;
        $teacher3->science_degree = 'кандидат наук';
        $teacher3->scientific_rank = 'доцент';
        $teacher3->position = 'доцент';
        $teacher3->start_date = '2014-03-03';
        $teacher3->save();

        $sciencework3 = new Sciencework();
        $sciencework3->id = 3;
        $sciencework3->topic = 'Доведення деяких результатів теорії формальних систем категорними методами.';
        $sciencework3->type = 'major coursework';
        $sciencework3->presenting_date = '2019-06-01';
        $sciencework3->status = 'active';
        $sciencework3->student_id = 5;
        $sciencework3->teacher_id = 3;
        $sciencework3->cathedra_id = 1;
        $sciencework3->application = false;
        $sciencework3->save();

        $baseinfot4 = new Baseinfo();
        $baseinfot4->id = 24;
        $baseinfot4->name = 'Вадим';
        $baseinfot4->surname = 'Хижняк';
        $baseinfot4->cathedra_id = 1;
        $baseinfot4->save();


        $teacher4 = new Teacher();
        $teacher4->id = 4;
        $teacher4->workbooknumber = 'VH444444';
        $teacher4->baseinfo_id_for_teacher = 24;
        $teacher4->science_degree = 'доктор наук';
        $teacher4->scientific_rank = 'професор';
        $teacher4->position = 'професор';
        $teacher4->start_date = '2019-04-04';
        $teacher4->save();

        $sciencework4 = new Sciencework();
        $sciencework4->id = 4;
        $sciencework4->topic = 'Побудова категорної арифметики.';
        $sciencework4->type = 'major dyploma';
        $sciencework4->presenting_date = '2019-06-01';
        $sciencework4->status = 'disapproved_for_teacher';
        $sciencework4->comment = "Розтлучате тему детальніше.";
        $sciencework4->student_id = 6;
        $sciencework4->teacher_id = 4;
        $sciencework4->cathedra_id = 1;
        $sciencework4->application = false;
        $sciencework4->save();

        $baseinfot5 = new Baseinfo();
        $baseinfot5->id = 25;
        $baseinfot5->name = 'Августин';
        $baseinfot5->surname = 'Хитрий';
        $baseinfot5->cathedra_id = 1;
        $baseinfot5->save();


        $teacher5 = new Teacher();
        $teacher5->id = 5;
        $teacher5->workbooknumber = 'VS555555';
        $teacher5->baseinfo_id_for_teacher = 25;
        $teacher5->science_degree = 'кандидат наук';
        $teacher5->scientific_rank = 'професор';
        $teacher5->position = 'асистент';
        $teacher5->start_date = '2015-05-05';
        $teacher5->save();

        $sciencework5 = new Sciencework();
        $sciencework5->id = 5;
        $sciencework5->topic = 'Моделі та методи біоінформатики.';
        $sciencework5->type = 'bachaelor coursework';
        $sciencework5->presenting_date = '2019-06-01';
        $sciencework5->status = 'disapproved_for_student';
        $sciencework5->comment = "Обговоріть тему з керівником ще раз.";
        $sciencework5->student_id = 9;
        $sciencework5->teacher_id = 5;
        $sciencework5->cathedra_id = 1;
        $sciencework5->application = false;
        $sciencework5->save();

        $baseinfot6 = new Baseinfo();
        $baseinfot6->id = 26;
        $baseinfot6->name = 'Адам';
        $baseinfot6->surname = 'Холод';
        $baseinfot6->cathedra_id = 1;
        $baseinfot6->save();


        $teacher6 = new Teacher();
        $teacher6->id = 6;
        $teacher6->workbooknumber = 'AH666666';
        $teacher6->baseinfo_id_for_teacher = 26;
        $teacher6->science_degree = 'доктор наук';
        $teacher6->scientific_rank = 'професор';
        $teacher6->position = 'старший викладач';
        $teacher6->start_date = '2016-06-06';
        $teacher6->save();

        $sciencework6 = new Sciencework();
        $sciencework6->id = 6;
        $sciencework6->topic = 'Нанотехнології, інформаційна медицина.';
        $sciencework6->type = 'bachaelor dyploma';
        $sciencework6->presenting_date = '2019-06-01';
        $sciencework6->status = 'active';
        $sciencework6->student_id = 10;
        $sciencework6->teacher_id = 6;
        $sciencework6->cathedra_id = 1;
        $sciencework6->application = true;
        $sciencework6->save();

        $baseinfot7 = new Baseinfo();
        $baseinfot7->id = 27;
        $baseinfot7->name = 'Альберт';
        $baseinfot7->surname = 'Романов';
        $baseinfot7->cathedra_id = 1;
        $baseinfot7->save();


        $teacher7 = new Teacher();
        $teacher7->id = 7;
        $teacher7->workbooknumber = 'AR777777';
        $teacher7->baseinfo_id_for_teacher = 27;
        $teacher7->science_degree = 'кандидат наук';
        $teacher7->scientific_rank = 'доцент';
        $teacher7->position = 'доцент';
        $teacher7->start_date = '2014-09-09';
        $teacher7->end_of_work_date = '2022-09-09';
        $teacher7->save();

        $baseinfot8 = new Baseinfo();
        $baseinfot8->id = 28;
        $baseinfot8->name = 'Антон';
        $baseinfot8->surname = 'Рудик';
        $baseinfot8->cathedra_id = 1;
        $baseinfot8->save();


        $teacher8 = new Teacher();
        $teacher8->id = 8;
        $teacher8->workbooknumber = 'AR888888';
        $teacher8->baseinfo_id_for_teacher = 28;
        $teacher8->science_degree = 'доктор наук';
        $teacher8->scientific_rank = 'професор';
        $teacher8->position = 'професор';
        $teacher8->start_date = '2014-09-09';
        $teacher8->end_of_work_date = '2015-09-09';
        $teacher8->save();

        $baseinfot9 = new Baseinfo();
        $baseinfot9->id = 29;
        $baseinfot9->name = 'Артем';
        $baseinfot9->surname = 'Рудь';
        $baseinfot9->cathedra_id = 1;
        $baseinfot9->save();


        $teacher9 = new Teacher();
        $teacher9->id = 9;
        $teacher9->workbooknumber = 'AR999999';
        $teacher9->baseinfo_id_for_teacher = 29;
        $teacher9->science_degree = 'кандидат наук';
        $teacher9->scientific_rank = 'професор';
        $teacher9->position = 'асистент';
        $teacher9->start_date = '2014-09-09';
        $teacher9->end_of_work_date = '2019-09-09';
        $teacher9->save();

        $baseinfocw1 = new Baseinfo();
        $baseinfocw1->id = 31;
        $baseinfocw1->name = 'Боголюб';
        $baseinfocw1->surname = 'Попіль';
        $baseinfocw1->cathedra_id = 1;
        $baseinfocw1->save();

        $usercw1 = new User();
        $usercw1->id = 5;
        $usercw1->email = 'popil@i.ua';
        $usercw1->password = Hash::make('123456');
        $usercw1->baseinfo_id = 31;
        $usercw1->assignRole('cathedraworker');
        $usercw1->save();

        $baseinfocw2 = new Baseinfo();
        $baseinfocw2->id = 32;
        $baseinfocw2->name = 'Борис';
        $baseinfocw2->surname = 'Кузьменко';
        $baseinfocw2->cathedra_id = 1;
        $baseinfocw2->save();

        $baseinfost21 = new Baseinfo();
        $baseinfost21->id = 201;
        $baseinfost21->name = 'Єгор';
        $baseinfost21->surname = 'Кондро';
        $baseinfost21->cathedra_id = 2;
        $baseinfost21->save();

        $student21 = new Student();
        $student21->id = 21;
        $student21->year = 3;
        $student21->baseinfo_id_for_student = 201;
        $student21->studnumber = 'AL202270';
        $student21->entry_date = '2017-06-01';
        $student21->specialty = 'Компютерні науки';
        $student21->specialty_abbr = 'КН';
        $student21->degree = 'bachelor';
        $student21->group = 2;
        $student21->save();



        $userst2 = new User();
        $userst2->id = 2;
        $userst2->email = 'egorkondro@gmail.com';
        $userst2->password = Hash::make('123456');
        $userst2->baseinfo_id = 201;
        $userst2->assignRole('student');
        $userst2->save();

        $baseinfost22 = new Baseinfo();
        $baseinfost22->id = 202;
        $baseinfost22->name = 'Оксана';
        $baseinfost22->surname = 'Наганюк';
        $baseinfost22->cathedra_id = 2;
        $baseinfost22->save();

        $student22 = new Student();
        $student22->id = 22;
        $student22->year = 3;
        $student22->baseinfo_id_for_student = 202;
        $student22->studnumber = 'ON202270';
        $student22->entry_date = '2018-06-01';
        $student22->specialty = 'Компютерні науки';
        $student22->specialty_abbr = 'КН';
        $student22->degree = 'bachelor';
        $student22->group = 3;
        $student22->save();


        $baseinfost23 = new Baseinfo();
        $baseinfost23->id = 203;
        $baseinfost23->name = 'Тимофій';
        $baseinfost23->surname = 'Пастельмащук';
        $baseinfost23->cathedra_id = 2;
        $baseinfost23->save();

        $student23 = new Student();
        $student23->id = 23;
        $student23->year = 3;
        $student23->baseinfo_id_for_student = 203;
        $student23->studnumber = 'TP202834';
        $student23->entry_date = '2019-06-01';
        $student23->specialty = 'Аналітика даних';
        $student23->specialty_abbr = 'АД';
        $student23->degree = 'bachelor';
        $student23->group = 4;
        $student23->save();



        $baseinfost24 = new Baseinfo();
        $baseinfost24->id = 204;
        $baseinfost24->name = 'Василь';
        $baseinfost24->surname = 'Хресяк';
        $baseinfost24->cathedra_id = 2;
        $baseinfost24->save();

        $student24 = new Student();
        $student24->id = 24;
        $student24->year = 2;
        $student24->baseinfo_id_for_student = 204;
        $student24->studnumber = 'VH202834';
        $student24->entry_date = '2019-06-01';
        $student24->specialty = 'Аналітика даних';
        $student24->specialty_abbr = 'АД';
        $student24->degree = 'bachelor';
        $student24->group = 4;
        $student24->save();

        $baseinfost25 = new Baseinfo();
        $baseinfost25->id = 205;
        $baseinfost25->name = 'Оксанаа';
        $baseinfost25->surname = 'Кармецицюк';
        $baseinfost25->cathedra_id = 2;
        $baseinfost25->save();

        $student25 = new Student();
        $student25->id = 25;
        $student25->year = 1;
        $student25->baseinfo_id_for_student = 205;
        $student25->studnumber = 'OK202333';
        $student25->entry_date = '2019-06-01';
        $student25->specialty = 'Аналітика даних';
        $student25->specialty_abbr = 'АД';
        $student25->degree = 'bachelor';
        $student25->group = 2;
        $student25->save();

        $baseinfost26 = new Baseinfo();
        $baseinfost26->id = 206;
        $baseinfost26->name = 'Роксолана';
        $baseinfost26->surname = 'Хохлушєва';
        $baseinfost26->cathedra_id = 2;
        $baseinfost26->save();

        $student26 = new Student();
        $student26->id = 26;
        $student26->year = 4;
        $student26->baseinfo_id_for_student = 206;
        $student26->studnumber = 'RH122333';
        $student26->entry_date = '2015-06-01';
        $student26->real_grad_date = '2019-06-01';
        $student26->specialty = 'Аналітика даних';
        $student26->specialty_abbr = 'АД';
        $student26->degree = 'bachelor';
        $student26->group = 4;
        $student26->save();

        $baseinfost27 = new Baseinfo();
        $baseinfost27->id = 207;
        $baseinfost27->name = 'Роксолана';
        $baseinfost27->surname = 'Коливанюк';
        $baseinfost27->cathedra_id = 2;
        $baseinfost27->save();

        $student27 = new Student();
        $student27->id = 27;
        $student27->year = 4;
        $student27->baseinfo_id_for_student = 207;
        $student27->studnumber = 'RK129833';
        $student27->entry_date = '2018-06-01';
        $student27->specialty = 'Аналітика даних';
        $student27->specialty_abbr = 'АД';
        $student27->degree = 'bachelor';
        $student27->group = 6;
        $student27->save();


        $baseinfost28 = new Baseinfo();
        $baseinfost28->id = 208;
        $baseinfost28->name = 'Світлана';
        $baseinfost28->surname = 'Сарпиненко';
        $baseinfost28->cathedra_id = 2;
        $baseinfost28->save();

        $student28 = new Student();
        $student28->id = 28;
        $student28->year = 1;
        $student28->baseinfo_id_for_student = 208;
        $student28->studnumber = 'SS181133';
        $student28->entry_date = '2018-06-01';
        $student28->specialty = 'Аналітика даних';
        $student28->specialty_abbr = 'АД';
        $student28->degree = 'master';
        $student28->group = 6;
        $student28->save();




        $baseinfost29 = new Baseinfo();
        $baseinfost29->id = 209;
        $baseinfost29->name = 'Оксана';
        $baseinfost29->surname = 'Сарпин';
        $baseinfost29->cathedra_id = 2;
        $baseinfost29->save();

        $student29 = new Student();
        $student29->id = 29;
        $student29->year = 2;
        $student29->baseinfo_id_for_student = 209;
        $student29->studnumber = 'OS199133';
        $student29->entry_date = '2018-06-01';
        $student29->specialty = 'Аналітика даних';
        $student29->specialty_abbr = 'АД';
        $student29->degree = 'master';
        $student29->group = 2;
        $student29->save();


        $baseinfost210 = new Baseinfo();
        $baseinfost210->id = 2010;
        $baseinfost210->name = 'Елеонора';
        $baseinfost210->surname = 'Сатюшко';
        $baseinfost210->cathedra_id = 2;
        $baseinfost210->save();

        $student210 = new Student();
        $student210->id = 2010;
        $student210->year = 2;
        $student210->baseinfo_id_for_student = 2010;
        $student210->studnumber = 'ES199098';
        $student210->entry_date = '2015-06-01';
        $student210->real_grad_date = '2017-06-01';
        $student210->specialty = 'Аналітика даних';
        $student210->specialty_abbr = 'АД';
        $student210->degree = 'master';
        $student210->group = 2;
        $student210->save();

        $baseinfost211 = new Baseinfo();
        $baseinfost211->id = 2011;
        $baseinfost211->name = 'Володимир';
        $baseinfost211->surname = 'Коваленко';
        $baseinfost211->cathedra_id = 2;
        $baseinfost211->save();

        $student211 = new Student();
        $student211->id = 2011;
        $student211->year = 2;
        $student211->baseinfo_id_for_student = 2011;
        $student211->studnumber = 'VK765098';
        $student211->entry_date = '2015-06-01';
        $student211->real_grad_date = '2017-06-01';
        $student211->specialty = 'Технології штучного інтелекту';
        $student211->specialty_abbr = 'ТШІ';
        $student211->degree = 'master';
        $student211->group = 4;
        $student211->save();

        $baseinfost212 = new Baseinfo();
        $baseinfost212->id = 2012;
        $baseinfost212->name = 'Ірина';
        $baseinfost212->surname = 'Герега';
        $baseinfost212->cathedra_id = 2;
        $baseinfost212->save();

        $student212 = new Student();
        $student212->id = 2012;
        $student212->year = 1;
        $student212->baseinfo_id_for_student = 2012;
        $student212->studnumber = 'IG760598';
        $student212->entry_date = '2016-06-01';
        $student212->specialty = 'Технології штучного інтелекту';
        $student212->specialty_abbr = 'ТШІ';
        $student212->degree = 'master';
        $student212->group = 4;
        $student212->save();

        $baseinfost213 = new Baseinfo();
        $baseinfost213->id = 2013;
        $baseinfost213->name = 'Сергій';
        $baseinfost213->surname = 'Михацицюк';
        $baseinfost213->cathedra_id = 2;
        $baseinfost213->save();

        $student213 = new Student();
        $student213->id = 2013;
        $student213->year = 3;
        $student213->baseinfo_id_for_student = 2013;
        $student213->studnumber = 'SM000598';
        $student213->entry_date = '2016-06-01';
        $student213->specialty = 'Технології штучного інтелекту';
        $student213->specialty_abbr = 'ТШІ';
        $student213->degree = 'bachelor';
        $student213->group = 4;
        $student213->save();


        $baseinfost214 = new Baseinfo();
        $baseinfost214->id = 2014;
        $baseinfost214->name = 'Залюбомир';
        $baseinfost214->surname = 'Лоневський';
        $baseinfost214->cathedra_id = 2;
        $baseinfost214->save();

        $student214 = new Student();
        $student214->id = 2014;
        $student214->year = 4;
        $student214->baseinfo_id_for_student = 2014;
        $student214->studnumber = 'ZL009508';
        $student214->entry_date = '2017-06-01';
        $student214->specialty = 'Технології штучного інтелекту';
        $student214->specialty_abbr = 'ТШІ';
        $student214->degree = 'bachelor';
        $student214->group = 2;
        $student214->save();

        $baseinfost215 = new Baseinfo();
        $baseinfost215->id = 2015;
        $baseinfost215->name = 'Андрій';
        $baseinfost215->surname = 'Марак';
        $baseinfost215->cathedra_id = 2;
        $baseinfost215->save();

        $student215 = new Student();
        $student215->id = 2015;
        $student215->year = 3;
        $student215->baseinfo_id_for_student = 2015;
        $student215->studnumber = 'AM833598';
        $student215->entry_date = '2018-06-01';
        $student215->specialty = 'Технології штучного інтелекту';
        $student215->specialty_abbr = 'ТШІ';
        $student215->degree = 'bachelor';
        $student215->group = 4;
        $student215->save();

        $baseinfost216 = new Baseinfo();
        $baseinfost216->id = 2016;
        $baseinfost216->name = 'Анжеліка';
        $baseinfost216->surname = 'Залюбченко';
        $baseinfost216->cathedra_id = 2;
        $baseinfost216->save();

        $student216 = new Student();
        $student216->id = 2016;
        $student216->year = 4;
        $student216->baseinfo_id_for_student = 2016;
        $student216->studnumber = 'AZ000598';
        $student216->entry_date = '2019-06-01';
        $student216->specialty = 'Технології штучного інтелекту';
        $student216->specialty_abbr = 'ТШІ';
        $student216->degree = 'bachelor';
        $student216->group = 6;
        $student216->save();

        $baseinfot21 = new Baseinfo();
        $baseinfot21->id = 2021;
        $baseinfot21->name = 'Володимир';
        $baseinfot21->surname = 'Риба';
        $baseinfot21->cathedra_id = 2;
        $baseinfot21->save();

        $teacher21 = new Teacher();
        $teacher21->id = 21;
        $teacher21->workbooknumber = 'AR212121';
        $teacher21->baseinfo_id_for_teacher = 2021;
        $teacher21->science_degree = 'доктор наук';
        $teacher21->scientific_rank = 'професор';
        $teacher21->position = 'старший викладач';
        $teacher21->start_date = '2014-01-01';
        $teacher21->end_of_work_date = '2021-01-01';
        $teacher21->save();

        $usert2 = new User();
        $usert2->id = 4;
        $usert2->email = 'riba@i.ua';
        $usert2->password = Hash::make('123456');
        $usert2->baseinfo_id = 2021;
        $usert2->assignRole('teacher');
        $usert2->save();


        $baseinfot22 = new Baseinfo();
        $baseinfot22->id = 2022;
        $baseinfot22->name = 'Орест';
        $baseinfot22->surname = 'Квітик';
        $baseinfot22->cathedra_id = 2;
        $baseinfot22->save();

        $teacher22 = new Teacher();
        $teacher22->id = 22;
        $teacher22->workbooknumber = 'AR222222';
        $teacher22->baseinfo_id_for_teacher = 2022;
        $teacher22->science_degree = 'кандидат наук';
        $teacher22->scientific_rank = 'доцент';
        $teacher22->position = 'доцент';
        $teacher22->start_date = '2014-01-01';
        $teacher22->end_of_work_date = '2017-01-01';
        $teacher22->save();

        $baseinfot23 = new Baseinfo();
        $baseinfot23->id = 2023;
        $baseinfot23->name = 'Залюбов';
        $baseinfot23->surname = 'Мосійчук';
        $baseinfot23->cathedra_id = 2;
        $baseinfot23->save();

        $teacher23 = new Teacher();
        $teacher23->id = 23;
        $teacher23->workbooknumber = 'AR232323';
        $teacher23->baseinfo_id_for_teacher = 2023;
        $teacher23->science_degree = 'доктор наук';
        $teacher23->scientific_rank = 'професор';
        $teacher23->position = 'професор';
        $teacher23->start_date = '2015-01-01';
        $teacher23->end_of_work_date = '2018-01-01';
        $teacher23->save();

        $baseinfot24 = new Baseinfo();
        $baseinfot24->id = 2024;
        $baseinfot24->name = 'Вадим';
        $baseinfot24->surname = 'Хижак';
        $baseinfot24->cathedra_id = 2;
        $baseinfot24->save();

        $teacher24 = new Teacher();
        $teacher24->id = 24;
        $teacher24->workbooknumber = 'AR242424';
        $teacher24->baseinfo_id_for_teacher = 2024;
        $teacher24->science_degree = 'кандидат наук';
        $teacher24->scientific_rank = 'професор';
        $teacher24->position = 'асистент';
        $teacher24->start_date = '2011-01-01';
        $teacher24->save();

        $baseinfot25 = new Baseinfo();
        $baseinfot25->id = 2025;
        $baseinfot25->name = 'Орест';
        $baseinfot25->surname = 'Ситий';
        $baseinfot25->cathedra_id = 2;
        $baseinfot25->save();

        $teacher25 = new Teacher();
        $teacher25->id = 25;
        $teacher25->workbooknumber = 'AR252525';
        $teacher25->baseinfo_id_for_teacher = 2025;
        $teacher25->science_degree = 'доктор наук';
        $teacher25->scientific_rank = 'професор';
        $teacher25->position = 'старший викладач';
        $teacher25->start_date = '2010-01-01';
        $teacher25->save();


        $baseinfot26 = new Baseinfo();
        $baseinfot26->id = 2026;
        $baseinfot26->name = 'Адам';
        $baseinfot26->surname = 'Голод';
        $baseinfot26->cathedra_id = 2;
        $baseinfot26->save();

        $teacher26 = new Teacher();
        $teacher26->id = 26;
        $teacher26->workbooknumber = 'AR262626';
        $teacher26->baseinfo_id_for_teacher = 2026;
        $teacher26->science_degree = 'кандидат наук';
        $teacher26->scientific_rank = 'доцент';
        $teacher26->position = 'доцент';
        $teacher26->start_date = '2016-01-01';
        $teacher26->save();


        $baseinfot27 = new Baseinfo();
        $baseinfot27->id = 2027;
        $baseinfot27->name = 'Альберт';
        $baseinfot27->surname = 'Оксаманов';
        $baseinfot27->cathedra_id = 2;
        $baseinfot27->save();

        $teacher27 = new Teacher();
        $teacher27->id = 27;
        $teacher27->workbooknumber = 'AR272727';
        $teacher27->baseinfo_id_for_teacher = 2027;
        $teacher27->science_degree = 'доктор наук';
        $teacher27->scientific_rank = 'професор';
        $teacher27->position = 'професор';
        $teacher27->start_date = '2018-01-01';
        $teacher27->save();


        $baseinfot28 = new Baseinfo();
        $baseinfot28->id = 2028;
        $baseinfot28->name = 'Антон';
        $baseinfot28->surname = 'Рудик';
        $baseinfot28->cathedra_id = 2;
        $baseinfot28->save();

        $teacher28 = new Teacher();
        $teacher28->id = 28;
        $teacher28->workbooknumber = 'AR282828';
        $teacher28->baseinfo_id_for_teacher = 2028;
        $teacher28->science_degree = 'кандидат наук';
        $teacher28->scientific_rank = 'професор';
        $teacher28->position = 'асистент';
        $teacher28->start_date = '2018-01-01';
        $teacher28->save();


        $baseinfot29 = new Baseinfo();
        $baseinfot29->id = 2029;
        $baseinfot29->name = 'Артем';
        $baseinfot29->surname = 'Рудь';
        $baseinfot29->cathedra_id = 2;
        $baseinfot29->save();

        $teacher29 = new Teacher();
        $teacher29->id = 29;
        $teacher29->workbooknumber = 'AR292929';
        $teacher29->baseinfo_id_for_teacher = 2029;
        $teacher29->science_degree = 'доктор наук';
        $teacher29->scientific_rank = 'професор';
        $teacher29->position = 'старший викладач';
        $teacher29->start_date = '2010-01-01';
        $teacher29->save();


        $sciencework21 = new Sciencework();
        $sciencework21->id = 21;
        $sciencework21->topic = 'Використання МаtLab для побудови контролерів.';
        $sciencework21->type = 'bachaelor coursework';
        $sciencework21->presenting_date = '2021-06-01';
        $sciencework21->status = 'active';
        $sciencework21->student_id = 21;
        $sciencework21->teacher_id = 21;
        $sciencework21->cathedra_id = 2;
        $sciencework21->application = false;
        $sciencework21->save();

        $sciencework22 = new Sciencework();
        $sciencework22->id = 22;
        $sciencework22->topic = 'Нова парадигма обчислень – ДНК-обчислення. Обчислення базових функцій і операторів.';
        $sciencework22->type = 'bachaelor coursework';
        $sciencework22->presenting_date = '2019-06-01';
        $sciencework22->status = 'approved_by_teacher';
        $sciencework22->student_id = 22;
        $sciencework22->teacher_id = 25;
        $sciencework22->cathedra_id = 2;
        $sciencework22->application = false;
        $sciencework22->save();

        $sciencework23 = new Sciencework();
        $sciencework23->id = 23;
        $sciencework23->topic = 'Узагальнені булеві функції. Аксіоматика, алгоритмізація.';
        $sciencework23->type = 'bachaelor coursework';
        $sciencework23->presenting_date = '2021-06-01';
        $sciencework23->status = 'active';
        $sciencework23->student_id = 23;
        $sciencework23->teacher_id = 24;
        $sciencework23->cathedra_id = 2;
        $sciencework23->application = false;
        $sciencework23->save();


        $sciencework27 = new Sciencework();
        $sciencework27->id = 27;
        $sciencework27->topic = 'Розробка та реалізація алгоритмів на нечітких моделях.';
        $sciencework27->type = 'bachaelor dyploma';
        $sciencework27->presenting_date = '2021-06-01';
        $sciencework27->status = 'disapproved_for_teacher';
        $sciencework27->comment = 'Перевірте дату захисту.';
        $sciencework27->student_id = 27;
        $sciencework27->teacher_id = 27;
        $sciencework27->cathedra_id = 2;
        $sciencework27->application = false;
        $sciencework27->save();

        $sciencework28 = new Sciencework();
        $sciencework28->id = 28;
        $sciencework28->topic = 'Реалізація автоматних методів арифметики натуральних та цілих чисел.';
        $sciencework28->type = 'major coursework';
        $sciencework28->presenting_date = '2021-06-01';
        $sciencework28->status = 'disapproved_for_student';
        $sciencework28->comment = 'Невірна дату захисту.';
        $sciencework28->student_id = 28;
        $sciencework28->teacher_id = 28;
        $sciencework28->cathedra_id = 2;
        $sciencework28->application = false;
        $sciencework28->save();

        $sciencework29 = new Sciencework();
        $sciencework29->id = 29;
        $sciencework29->topic = 'Реалізація алгоритмів синтезу та аналізу автоматів Бюхі.';
        $sciencework29->type = 'major dyploma';
        $sciencework29->presenting_date = '2021-06-01';
        $sciencework29->status = 'active';
        $sciencework29->student_id = 29;
        $sciencework29->teacher_id = 29;
        $sciencework29->cathedra_id = 2;
        $sciencework29->application = true;
        $sciencework29->save();

        $sciencework30 = new Sciencework();
        $sciencework30->id = 30;
        $sciencework30->topic = 'Реалізація алгоритмів синтезу та аналізу автоматів Мюлера.';
        $sciencework30->type = 'major dyploma';
        $sciencework30->status = 'created_by_teacher';
        $sciencework30->teacher_id = 1;
        $sciencework30->cathedra_id = 1;
        $sciencework30->save();

        $sciencework31 = new Sciencework();
        $sciencework31->id = 31;
        $sciencework31->topic = 'Реалізація алгоритму мінімізації детермінованих автоматів Мюлера.';
        $sciencework31->type = 'major coursework';
        $sciencework31->status = 'created_by_teacher';
        $sciencework31->teacher_id = 1;
        $sciencework31->cathedra_id = 1;
        $sciencework31->save();

        $sciencework32 = new Sciencework();
        $sciencework32->id = 32;
        $sciencework32->topic = 'Програмування з розподільними змінними. Аналіз сучасних підходів.';
        $sciencework32->type = 'bachaelor coursework';
        $sciencework32->status = 'created_by_teacher';
        $sciencework32->teacher_id = 1;
        $sciencework32->cathedra_id = 1;
        $sciencework32->save();

        $sciencework33 = new Sciencework();
        $sciencework33->id = 33;
        $sciencework33->topic = 'Розподільне програмування. Аналіз сучасних підходів.';
        $sciencework33->type = 'bachaelor dyploma';
        $sciencework33->status = 'created_by_teacher';
        $sciencework33->teacher_id = 1;
        $sciencework33->cathedra_id = 1;
        $sciencework33->save();

        $sciencework40 = new Sciencework();
        $sciencework40->id = 40;
        $sciencework40->topic = 'Створення корпоративних проектів на Java2Enterprise.';
        $sciencework40->type = 'major dyploma';
        $sciencework40->status = 'created_by_teacher';
        $sciencework40->teacher_id = 21;
        $sciencework40->cathedra_id = 2;
        $sciencework40->save();

        $sciencework41 = new Sciencework();
        $sciencework41->id = 41;
        $sciencework41->topic = 'Створення модулей і драйверів під ядро Linux 2.6.xx.';
        $sciencework41->type = 'major coursework';
        $sciencework41->status = 'created_by_teacher';
        $sciencework41->teacher_id = 21;
        $sciencework41->cathedra_id = 2;
        $sciencework41->save();

        $sciencework42 = new Sciencework();
        $sciencework42->id = 42;
        $sciencework42->topic = 'Квантові алгебри.';
        $sciencework42->type = 'bachaelor coursework';
        $sciencework42->status = 'created_by_teacher';
        $sciencework42->teacher_id = 21;
        $sciencework42->cathedra_id = 2;
        $sciencework42->save();

        $sciencework44 = new Sciencework();
        $sciencework44->id = 44;
        $sciencework44->topic = 'Градійовані алгебри і супералгебри Лі.';
        $sciencework44->type = 'bachaelor dyploma';
        $sciencework44->status = 'created_by_teacher';
        $sciencework44->teacher_id = 21;
        $sciencework44->cathedra_id = 2;
        $sciencework44->save();

        $baseinfocw21 = new Baseinfo();
        $baseinfocw21->id = 2031;
        $baseinfocw21->name = 'Вадим';
        $baseinfocw21->surname = 'Артемійчук';
        $baseinfocw21->cathedra_id = 2;
        $baseinfocw21->save();

        $usercw2 = new User();
        $usercw2->id = 6;
        $usercw2->email = 'artemiychuk@i.ua';
        $usercw2->password = Hash::make('123456');
        $usercw2->baseinfo_id = 2031;
        $usercw2->assignRole('cathedraworker');
        $usercw2->save();

        $baseinfocw22 = new Baseinfo();
        $baseinfocw22->id = 2032;
        $baseinfocw22->name = 'Ангеліна';
        $baseinfocw22->surname = 'Шульменко';
        $baseinfocw22->cathedra_id = 2;
        $baseinfocw22->save();

        $baseinfosa = new Baseinfo();
        $baseinfosa->id = 41;
        $baseinfosa->name = 'Вероніка';
        $baseinfosa->surname = 'Чухалова';
        $baseinfosa->cathedra_id = 2;
        $baseinfosa->save();

        $usersa = new User();
        $usersa->id = 7;
        $usersa->email = 'admin@i.ua';
        $usersa->password = Hash::make('123456');
        $usersa->baseinfo_id = 41;
        $usersa->assignRole('superadmin');
        $usersa->save();
    }
}
