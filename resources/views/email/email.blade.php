<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Simple Transactional Email</title>
    <link rel="stylesheet" href="{{asset("assets/css/email.css")}}">
  </head>
  <body class="">
    <div class="content">
        <p>Hello {{$name}},</p>
        <p>Today {{$regitered_per_day}} out of {{$total_customers}} customers has registered.
            The average of customers regisered today is {{$average_registered}}%.</p>
        <p>Sincerely,</p>
        <p>Basma</p>
    </div>
  </body>
</html>
