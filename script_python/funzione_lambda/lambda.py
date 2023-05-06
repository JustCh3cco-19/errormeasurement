import math

stringa_funzione = input("Inserisci una funzione: ") #prendi in input la funzione di cui vuoi calcolarne un x valore

funzione_lambda = eval("lambda x: " + stringa_funzione) #conversione della stringa in una funzione lambda tramite la funzione eval

valore_input = float(input("Inserisci un valore per calcolare la funzione: ")) #funzione lambda come input
risultato = funzione_lambda(valore_input) #assegna a risultato la funzione lambda calcolata con la variabile "valore_input"
print("Il risultato è:", risultato) #stampa a schermo il risultato
