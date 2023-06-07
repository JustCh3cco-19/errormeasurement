<!DOCTYPE html>
<html>

<head>
    <title>Pagamento effettuato</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/stile2.css" />
</head>

<body>
    <div class="card">
        <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
            <i class="checkmark">✓</i>
        </div>
        <h1>Acquisto effettuato</h1>
        <p style="margin-bottom: 20px;">Abbiamo ricevuto il tuo pagamento!<br />Ti reindirizziamo alla pagina di login per accedere al servizio!</p>
        <p>Se non funziona il redirect clicca il tasto qui sotto:</p>
        <button class="login-button" onclick="redirectToLogin()">Accedi alla pagina di login</button>
    </div>
    <script src="redirect.js"></script>
</body>

</html>