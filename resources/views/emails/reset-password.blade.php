<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Reset Password</title>
</head>

<body style="margin:0;padding:0;background:#f4f6fb;font-family:Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 15px;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,0.08);">

<!-- HEADER -->
<tr>
<td align="center" style="padding:35px;background:linear-gradient(135deg,#4f46e5,#9333ea);">

<img src="{{ asset('storage/logo.png') }}" width="70" style="margin-bottom:15px;">

<h1 style="margin:0;color:#ffffff;font-size:26px;">
SILS Library System
</h1>

<p style="margin:8px 0 0;color:#e0e7ff;font-size:14px;">
Smart Integrated Library System
</p>

</td>
</tr>

<!-- BODY -->
<tr>
<td style="padding:40px;">

<h2 style="margin-top:0;color:#111827;">
Hello, {{ $user->first_name }} 👋
</h2>

<p style="font-size:16px;color:#4b5563;line-height:1.7;">
Kami menerima permintaan untuk mereset password akun Anda.
Klik tombol di bawah ini untuk membuat password baru.
</p>

<div style="text-align:center;margin:35px 0;">

<a href="{{ $url }}"
style="
background:linear-gradient(135deg,#4f46e5,#9333ea);
color:#ffffff;
padding:14px 35px;
text-decoration:none;
border-radius:12px;
font-weight:bold;
display:inline-block;
font-size:16px;
">
Reset Password
</a>

</div>

<p style="font-size:14px;color:#6b7280;line-height:1.6;">
Link ini akan kadaluarsa dalam <b>60 menit</b>.
Jika Anda tidak meminta reset password, abaikan email ini.
</p>

<p style="font-size:14px;color:#9ca3af;word-break:break-all;margin-top:25px;">
{{ $url }}
</p>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td align="center" style="padding:25px;background:#f9fafb;color:#9ca3af;font-size:13px;">

© {{ date('Y') }} SILS Library System  
<br>
Secure Access & Smart Library Experience

</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>