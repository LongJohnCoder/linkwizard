<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forget Password Link Mail</title>
    <body>
      <p>
        Hi, {{ $name }}
      </p>
      <p>
          You have requested for reset your password. please click on below link to reset your password.
      </p>
      <p>
        <a href='{{$url}}'> Click here to reset password </a>
      </p>
      <p>
        For any queries please send mail : @ <a href="mailto:{{ $email }}"> {{ $email }} </a>
      </p>
    </body>
  </head>
</html>
