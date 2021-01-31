
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<TITLE></TITLE>
	<META NAME="GENERATOR" CONTENT="LibreOffice 4.1.6.2 (Linux)">
	<META NAME="CREATED" CONTENT="0;0">
	<META NAME="CHANGED" CONTENT="0;0">
	<STYLE TYPE="text/css">
		@page { size: 8.5in 11in; margin: 1in }
		P { margin-bottom: 0.08in }
	</STYLE>
</HEAD>
<BODY LANG="en" DIR="LTR">
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT STYLE="font-size: 14pt">Міністерство освіти і науки України</FONT></FONT>
</P>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Київський національний університет імені Тараса Шевченка</FONT></FONT>
</P>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Кафедра {{$cathedra}}</FONT></FONT>
</P>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt"> {{$sciencework->topic}}</FONT></FONT>
</P>
<br>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Курсова робота</FONT></FONT>
</P>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Пояснювальна записка</FONT></FONT>
</P>
<br><br>
<P STYLE="text-align:left;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Виконавець</FONT></FONT>
</P>
@if($user->gender=="female")
<P STYLE="text-align:left;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">студентка групи {{$student->specialty_abbr}} - {{$student->year}}{{$student->group}}</FONT></FONT>
</P>
@else
<P STYLE="text-align:left;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">студент групи {{$student->specialty_abbr}} - {{$student->year}}{{$student->group}}</FONT></FONT>
</P>
@endif
<P STYLE="text-align:left;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">________________________ {{$user_name}}. {{$user_fathername}}. {{$user->surname}}</FONT></FONT>
</P>
<P STYLE="text-align:left;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">(підпис, дата)</FONT></FONT>
</P>
<br>
<P STYLE="text-align:left;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Керівник</FONT></FONT>
</P>
<P STYLE="text-align:left;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">{{$teacher->scientific_rank}}</FONT></FONT>
</P>
<P STYLE="text-align:left;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">________________________ {{$teacher->science_degree}} {{$teacher_name}}. {{$teacher_fathername}}. {{$teacher_info->surname}}</FONT></FONT>
</P>
<P STYLE="text-align:left;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">(підпис, дата)</FONT></FONT>
</P>
<br><br><br>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Київ-{{now()->year}}</FONT></FONT>
</P>
</BODY>
</HTML> 
