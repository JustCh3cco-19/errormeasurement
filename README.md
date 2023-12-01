# propagazione_errori
## Calcolo della varianza di una funzione

Questo codice consente di calcolare la varianza di una funzione matematica. La varianza è una misura della variabilità dei valori assunti da una funzione.

### Come funziona

L'utente deve inserire le seguenti informazioni:

* Il numero di incognite della funzione
* La funzione matematica
* I valori delle incognite
* Le varianze delle incognite
* Le covarianza delle incognite

Il codice calcola quindi la varianza della funzione utilizzando la seguente formula:
var = Σ(xi * xj * cov_mat[i,j])

dove:

xi è la derivata prima di f() rispetto alla variabile i
xj è la derivata prima di f() rispetto alla variabile j
cov_mat[i,j] è la covarianza tra le variabili i e j
La derivata prima di f() rispetto a ciascuna variabile è calcolata utilizzando il modulo SymPy.

La covarianza tra due variabili è calcolata come media dei prodotti dei valori delle variabili, elevati al quadrato.

Output
Il codice stampa i seguenti risultati:

- La funzione matematica inserita dall'utente
- I valori delle incognite inseriti dall'utente
- Le varianze inserite dall'utente
- Le covarianza inserite dall'utente
- La varianza calcolata della funzione
- La deviazione standard della funzione

#### Download dei dati
Il codice fornisce anche un'opzione per scaricare i dati inseriti dall'utente. Per farlo, l'utente deve fare clic sul pulsante Scarica dati. Il codice crea un file di testo con i dati inseriti dall'utente e lo scarica sul computer dell'utente.

##### Requisiti
Il codice richiede i seguenti requisiti:

- Python 3.6 o superiore
- Il modulo NumPy
- Il modulo SymPy

###### Esempio
Ecco un esempio di utilizzo del codice:

Inserisci numero incognite (max 10): 2
Inserisci funzione: a + b
Valore incognita "a" ==> 1
Valore incognita "b" ==> 2
Sicuro di aver messo le varianze? (Rispondi si per continuare, altrimenti ricarica la pagina per ricominciare): si
Varianza "a" ==> 1
Varianza "b" ==> 4
Covarianza "a-b" ==> 3

Funzione: a + b
Valori delle incognite:
a: 1
b: 2
Varianze:
a: 1
b: 4
Covarianze:
a-b: 3

Varianza = 10
Deviazione standard = 3.162277660168379
