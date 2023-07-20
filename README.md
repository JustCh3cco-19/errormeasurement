# propagazione_errori
Calcolare la propagazione degli errori nelle misure automaticamente

Road map:
- [x] Codice Python per la propagazione errori
- [x] Migliorare gli script Python prendendo l'input della funzione come stringa e trasformarla in una funzione lambda (file creato a parte)
- [x] Creare una schermata di login con username e password (username->email) 
- [x] Login e registrazione funzionante su tutti i dispositivi (mobile, pc, tablet)
- [x] Aggiungere al dato name l'attributo sql UNIQUE in modo che ci siano username tutti differenti e adattare il codice di conseguenza
- [x] Integrare script Python nel codice HTML (da sostituire poi con il codice definitivo)
- [x] Dall'Area Privata andare nella sezione per la propagazione errori
- [x] Integrare HTTPS nel codice e SSL per una connessione sicura al sito
- [x] Trovare modo per non mostrare il codice tramite ispeziona di Chrome (pyscript non mostra il source code)
- [x] Rimuovere estensione .php alla fine di ogni url del sito
- [x] Rimuovere nome della pagina in cui si è stati reindirizzati
- [x] Far funzionare il bottone torna all'area privata dallo script python 
- [ ] Calcolatrice grafica online (idea)
- [ ] Idea di raggruppare tutto in un unico sito (app sbobine, calcolatrice grafica, propagazione errori, assistente google per bus atac (chiedi a google, ad esempio, a che ora passa indicativamente il bus atac in base alla tua posizione alla fermata più vicina e lui ti risponde con orario e posizione indicativi))
- [x] Aggiunto pulsante per download dei dati calcolati e stampati a schermo 
- [x] Inserire PayPal per i pagamenti dei servizi
- [x] Pagamenti con PayPal funzionanti
- [x] Inserire il pagamento dei servizi nel database non appena l'utente effettua la transazione correttamente
- [x] Aggiungere un controllo nel login -> se l'utente non esiste nel database, mostrare un messaggio di errore "Account non esistente"
- [x] Rimuovere il banner "Hosted by 000webhost"
- [x] Sistemare meglio i bottoni paypal (metterli al centro della pagina)
- [x] Allungare il tempo per mostrare i bottoni nella sezione calcola la tua funzione
- [x] Creare una pagina di start su cosa è il sito e quali funzioni troviamo al suo interno
- [x] Aggiunti calcolo integrali definiti
- [x] Aggiungere tasto download dati integrali

Work in Progress...


Link utili:
https://www.wolframalpha.com/widgets/view.jsp?id=8ac60957610e1ee4894b2cd58e753 propagazione di errori da internet

https://nicoco007.github.io/Propagation-of-Uncertainty-Calculator/ altro metodo di propagazione degli errori da internet

https://docs.pyscript.net/latest/ come integrare Python in HTML

https://uiverse.io/ per template schermate HTML

https://thedatafrog.com/en/articles/jupyter-notebooks-web-pages/ integrare juypter notebook all'interno di un sito

https://github.com/paypal/PayPal-PHP-SDK/wiki paypal in php

https://blog.pythonanywhere.com/121/ alternativa all'hosting con php, javascript (solo python, da verificare il funzionamento)

https://github.com/paypal/PayPal-Python-SDK paypal in python (da provare)

Riscrivere il sito da capo con Flask? (Bisogna aggiungere il database, paypal, gli accessi ecc)
