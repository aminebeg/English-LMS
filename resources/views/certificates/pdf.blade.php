<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate of Completion</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            text-align: center;
            padding: 40px;
            border: 10px solid #787878;
        }
        .container {
            padding: 20px;
        }
        .header {
            font-size: 50px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .subheader {
            font-size: 25px;
            color: #555;
            margin-bottom: 40px;
        }
        .name {
            font-size: 40px;
            font-weight: bold;
            color: #2c3e50;
            border-bottom: 2px solid #2c3e50;
            display: inline-block;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .course-title {
            font-size: 30px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
        }
        .date {
            font-size: 18px;
            color: #555;
            margin-top: 40px;
        }
        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        .footer {
            margin-top: 50px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Certificate of Completion</div>
        
        <div class="subheader">This is to certify that</div>
        
        <div class="name">{{ $user->name }}</div>
        
        <div class="subheader">has successfully completed the course</div>
        
        <div class="course-title">{{ $course->title }}</div>
        
        <div class="date">Date: {{ $date }}</div>
        
        <div class="footer">
            Certificate ID: {{ $id }} <br>
            English LMS Platform
        </div>
    </div>
</body>
</html>
