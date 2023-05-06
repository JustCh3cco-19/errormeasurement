import math

stringa_funzione = input("Inserisci la tua funzione matematica: ")

# funzione lambda come parametro di eval()
funzione_lambda = eval("lambda x: " + stringa_funzione)

#funzione lambda come input
valore_input = float(input("Inserisci il valore di input: "))
risultato = funzione_lambda(valore_input)
print("Il risultato è:", risultato)
