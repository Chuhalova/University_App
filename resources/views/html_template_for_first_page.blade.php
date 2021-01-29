
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
<FONT FACE="Times New Roman, serif"><FONT STYLE="font-size: 14pt">Міністерство освіти і науки України </FONT></FONT>
</P>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">КИЇВСЬКИЙ НАЦІОНАЛЬНИЙ УНІВЕРСИТЕТ</FONT></FONT>
</P>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">ІМЕНІ ТАРАСА ШЕВЧЕНКА</FONT></FONT>
</P>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Кафедра {{$cathedra}} </FONT></FONT>
</P>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt"> {{$sciencework->topic}} </FONT></FONT>
</P>
<br>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Текстова частина до курсової роботи </FONT></FONT>
</P>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">за спеціальністю „{{$student->specialty}}”. </FONT></FONT>
</P>
<br><br>
<P STYLE="text-align: right;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Керівник
курсової роботи </FONT></FONT>
</P>
<P STYLE="text-align: right;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">{{$teacher->science_degree}}, {{$teacher->scientific_rank}} {{$teacher_info->surname}} {{$teacher_name}}. </FONT></FONT>
</P>
<P STYLE="text-align: right;">
“<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">____”
__________ {{now()->year}} р. </FONT></FONT>
</P>
<br><br>
<P STYLE="text-align: right;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Виконав
студент {{$student->specialty_abbr}} - {{$student->year}}{{$student->group}}</FONT></FONT>
</P>
<P STYLE="text-align: right;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">{{$user->surname}} 
{{$user_name}}.</FONT></FONT>
</P>
<P STYLE="text-align: right;">
“<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">____”
__________ {{now()->year}} р. </FONT></FONT>
</P>
<br><br><br><br><br><br>
<P STYLE="text-align:center;">
<FONT FACE="Times New Roman, serif"><FONT  STYLE="font-size: 14pt">Київ-{{now()->year}}</FONT></FONT>
</P>
</BODY>
</HTML> 
